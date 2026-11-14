<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('customer')->latest()->paginate(10);
        return view('crm_emanager.backend.admin.sales.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::where('status', 'active')->get();
        return view('crm_emanager.backend.admin.sales.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:sales,invoice_number',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'payment_status' => 'required|in:unpaid,partial,paid',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated) {

            $totalAmount = 0;
            $totalCost = 0;

            foreach ($validated['products'] as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'products' => "Insufficient stock for {$product->name}.",
                    ]);
                }

                $subtotal = $item['quantity'] * $item['unit_price'];

                $totalAmount += $subtotal;
                $totalCost += $item['quantity'] * $product->purchase_price;
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;

            $sale = Sale::create([
                'customer_id' => $validated['customer_id'],
                'invoice_number' => $validated['invoice_number'],
                'created_by' => auth()->id(),
                'total_amount' => $totalAmount - $discount + $tax,
                'total_cost' => $totalCost,
                'discount' => $discount,
                'tax' => $tax,
                'status' => 'completed',
                'payment_status' => $validated['payment_status'],
                'sold_at' => now(),
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['products'] as $item) {

                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                $subtotal = $item['quantity'] * $item['unit_price'];

                $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'unit_cost' => $product->purchase_price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
            }
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load([
            'customer',
            'saleItems.product',
            'creator',
            'payments.receiver'
        ]);

        return view('crm_emanager.backend.admin.sales.view', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        $sale->load('saleItems');
        $customers = Customer::all();
        $products = Product::all();

        return view('crm_emanager.backend.admin.sales.edit', compact('sale', 'customers', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Sale $sale)
    {
        if ($sale->status === 'cancelled') {
            return redirect()->route('sales.index')
                ->with('error', 'Cancelled sale cannot be updated.');
        }
        $validated = $request->validate([
            'invoice_number' => 'required|string|unique:sales,invoice_number,' . $sale->id,
            'customer_id' => 'required|exists:customers,id',
            'sold_at' => 'required|date',
            'status' => 'required|in:pending,completed,cancelled',
            'payment_status' => 'required|in:unpaid,partial,paid',
            'discount' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',

            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($validated, $sale) {

            // Return previous quantities to stock
            foreach ($sale->saleItems as $oldItem) {
                $product = Product::whereKey($oldItem->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->increment('stock_quantity', $oldItem->quantity);
            }

            // Remove previous sale items
            $sale->saleItems()->delete();

            $totalAmount = 0;
            $totalCost = 0;

            foreach ($validated['products'] as $item) {

                $product = Product::whereKey($item['product_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($product->stock_quantity < $item['quantity']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'products' => $product->name . ' Stock Out।',
                    ]);
                }

                $quantity = $item['quantity'];
                $unitPrice = $item['unit_price'];

                $subtotal = $quantity * $unitPrice;

                $totalAmount += $subtotal;
                $totalCost += $quantity * $product->purchase_price;

                $sale->saleItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'unit_cost' => $product->purchase_price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $quantity);
            }

            $discount = $validated['discount'] ?? 0;
            $tax = $validated['tax'] ?? 0;

            $sale->update([
                'invoice_number' => $validated['invoice_number'],
                'customer_id' => $validated['customer_id'],
                'sold_at' => $validated['sold_at'],
                'total_amount' => max(0, $totalAmount - $discount + $tax),
                'total_cost' => $totalCost,
                'discount' => $discount,
                'tax' => $tax,
                'status' => $validated['status'],
                'payment_status' => $validated['payment_status'],
                'notes' => $validated['notes'] ?? null,
            ]);
        });

        return redirect()->route('sales.index')
            ->with('success', 'Sale updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Sale $sale)
    {
        $alreadyCancelled = DB::transaction(function () use ($sale) {

            $sale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Already cancelled hole stock ar barbe na!
            if ($sale->status === 'cancelled') {
                return true;
            }

            // Previous products- er stcok e firot jabe
            foreach ($sale->saleItems as $item) {

                $product = Product::withTrashed()
                    ->whereKey($item->product_id)
                    ->lockForUpdate()
                    ->first();

                if ($product) {
                    $product->increment('stock_quantity', $item->quantity);
                }
            }

            // Sale Delete na kore cancel kora
            $sale->update([
                'status' => 'cancelled',
            ]);

            return false;
        });

        if ($alreadyCancelled) {
            return redirect()->route('sales.index')
                ->with('error', 'This sale is already cancelled.');
        }

        return redirect()->route('sales.index')
            ->with('success', 'Sale cancelled successfully.');
    }
    public function invoice($id)
    {
        $sale = Sale::with([
            'saleItems.product',
            'payments',
            'creator'
        ])->findOrFail($id);

        $paidAmount = $sale->payments->sum('amount');
        $dueAmount = $sale->total_amount - $paidAmount;
         $setting = Setting::first();
         $customer = Customer::all();

        return view(
            'crm_emanager.backend.admin.sales.invoice',
            compact('sale', 'paidAmount', 'dueAmount', 'setting', 'customer')
        );
    }
}

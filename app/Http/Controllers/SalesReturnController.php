<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalesReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class SalesReturnController extends Controller
{
    public function index()
    {
        $returns = SalesReturn::with(['sale', 'customer', 'receiver'])
            ->latest()
            ->paginate(10);

        return view('crm_emanager.backend.admin.sales_return.index', compact('returns'));
    }
    public function create()
    {
        $sale = Sale::with(['customer', 'saleItems.product', 'returns.items'])
            ->findOrFail(request('sale_id'));

        if ($sale->status !== 'completed') {
            return redirect()->route('sales.show', ['sale' => $sale->id])
                ->with('error', 'Only completed sales can be returned.');
        }

        return view('crm_emanager.backend.admin.sales_return.create', compact('sale'));
    }
   
public function store(Request $request)
{
    $validated = $request->validate([
        'sale_id' => 'required|exists:sales,id',

        'items' => 'required|array|min:1',
        'items.*.sale_item_id' => 'required|distinct|exists:sale_items,id',
        'items.*.quantity' => 'nullable|integer|min:1',

        'refund_method' => 'required|in:cash,bank,mobile_banking,card',
        'refund_transaction_id' => 'nullable|string|max:255',
        'returned_at' => 'required|date',
        'refunded_at' => 'required|date',
        'reason' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {

        $sale = Sale::whereKey($validated['sale_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if ($sale->status !== 'completed') {
            throw ValidationException::withMessages([
                'sale_id' => 'Only completed sales can be returned.',
            ]);
        }

        $totalAmount = 0;
        $returnItems = [];

        foreach ($validated['items'] as $item) {

            if (empty($item['quantity'])) {
                continue;
            }

            $saleItem = SaleItem::where('sale_id', $sale->id)
                ->whereKey($item['sale_item_id'])
                ->lockForUpdate()
                ->first();

            if (!$saleItem) {
                throw ValidationException::withMessages([
                    'items' => 'Invalid sale item selected.',
                ]);
            }

            $alreadyReturned = $saleItem->returnItems()
                ->whereHas('salesReturn', function ($query) {
                    $query->where('status', 'completed');
                })
                ->sum('quantity');

            $availableQuantity = $saleItem->quantity - $alreadyReturned;

            if ($item['quantity'] > $availableQuantity) {
                throw ValidationException::withMessages([
                    'items' => 'Return quantity cannot exceed available quantity.',
                ]);
            }

            $subtotal = round(
                $item['quantity'] * $saleItem->unit_price,
                2
            );

            $totalAmount += $subtotal;

            $returnItems[] = [
                'sale_item_id' => $saleItem->id,
                'product_id' => $saleItem->product_id,
                'quantity' => $item['quantity'],
                'unit_price' => $saleItem->unit_price,
                'subtotal' => $subtotal,
            ];
        }

        // Prevent empty return
        if (empty($returnItems)) {
            throw ValidationException::withMessages([
                'items' => 'Please enter return quantity for at least one product.',
            ]);
        }

        // Check available refundable amount
        $totalPaid = $sale->payments()->sum('amount');

        $alreadyRefunded = $sale->returns()
            ->where('status', 'completed')
            ->sum('total_amount');

        $availableRefund = $totalPaid - $alreadyRefunded;

        if ($totalAmount > $availableRefund) {
            throw ValidationException::withMessages([
                'items' => 'Refund amount cannot exceed available paid amount: '
                    . number_format(max(0, $availableRefund), 2),
            ]);
        }

        // Create return record
        $return = SalesReturn::create([
            'return_number' => 'RET-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
            'sale_id' => $sale->id,
            'customer_id' => $sale->customer_id,
            'received_by' => auth()->id(),
            'total_amount' => $totalAmount,
            'status' => 'completed',
            'returned_at' => $validated['returned_at'],
            'reason' => $validated['reason'] ?? null,
            'refund_method' => $validated['refund_method'],
            'refund_transaction_id' => $validated['refund_transaction_id'] ?? null,
            'refunded_at' => $validated['refunded_at'],
        ]);

        // Create return items and restore stock
        foreach ($returnItems as $item) {

            $return->items()->create($item);

            Product::whereKey($item['product_id'])
                ->lockForUpdate()
                ->firstOrFail()
                ->increment('stock_quantity', $item['quantity']);
        }
    });

    return redirect()
        ->route('sales.show', ['sale' => $validated['sale_id']])
        ->with('success', 'Sales return and refund completed successfully.');
}

}

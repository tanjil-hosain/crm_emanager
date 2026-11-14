<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $payments = Payment::with(['sale', 'receiver'])
        ->latest()
        ->paginate(10);
        return view('crm_emanager.backend.admin.payment.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function create()
{
    $sale = Sale::with('payments')->findOrFail(request('sale_id'));

    $paidAmount = $sale->payments->sum('amount');
    $dueAmount = $sale->total_amount - $paidAmount;

    if ($sale->status !== 'completed' || $dueAmount <= 0) {
        return redirect()->route('sales.show', ['sale' => $sale->id])
            ->with('error', 'No payment due for this sale.');
    }

    return view('crm_emanager.backend.admin.payment.create', compact(
        'sale',
        'paidAmount',
        'dueAmount'
    ));
}

    /**
     * Store a newly created resource in storage.
     */
 public function store(Request $request)
{
    $validated = $request->validate([
        'sale_id' => 'required|exists:sales,id',
        'amount' => 'required|numeric|min:0.01',
        'payment_method' => 'required|in:cash,bank,mobile_banking,card',
        'transaction_id' => 'nullable|string|max:255',
        'paid_at' => 'required|date',
        'notes' => 'nullable|string',
    ]);

    DB::transaction(function () use ($validated) {

        $sale = Sale::whereKey($validated['sale_id'])
            ->lockForUpdate()
            ->firstOrFail();

        if ($sale->status !== 'completed') {
            throw ValidationException::withMessages([
                'sale_id' => 'Payment is only allowed for completed sales.',
            ]);
        }

        $totalPaid = $sale->payments()->sum('amount');

        $dueAmount = $sale->total_amount - $totalPaid;

        if ($dueAmount <= 0) {
            throw ValidationException::withMessages([
                'amount' => 'This sale is already fully paid.',
            ]);
        }

        if ($validated['amount'] > $dueAmount) {
            throw ValidationException::withMessages([
                'amount' => 'Amount cannot exceed due amount: ' . number_format($dueAmount, 2),
            ]);
        }

        Payment::create([
            'sale_id' => $sale->id,
            'received_by' => auth()->id(),
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'] ?? null,
            'paid_at' => $validated['paid_at'],
            'notes' => $validated['notes'] ?? null,
        ]);

        $totalPaid += $validated['amount'];

        $sale->update([
            'payment_status' => $totalPaid >= $sale->total_amount
                ? 'paid'
                : 'partial',
        ]);
    });

    return redirect()->route('sales.show', $validated['sale_id'])
        ->with('success', 'Payment received successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}

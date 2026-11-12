@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container-fluid py-4">

        @php
            $paidAmount = $sale->payments->sum('amount');
            $dueAmount = $sale->total_amount - $paidAmount;
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Sale Details</h4>

            <div>
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    Back
                </a>

                @if ($sale->status == 'pending')
                    <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">
                        Edit Sale
                    </a>
                @endif

                @if ($sale->status == 'completed' && $dueAmount > 0)
                    <a href="{{ route('payments.create', ['sale_id' => $sale->id]) }}" class="btn  btn-success">
                        Recived Payment
                    </a>
                @endif
            </div>
        </div>

        {{-- Sale Information --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Sale Information</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Invoice Number:</strong>
                        <p>{{ $sale->invoice_number }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Customer:</strong>
                        <p>{{ $sale->customer->name ?? 'N/A' }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Sold At:</strong>
                        <p>{{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}</p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Sale Status:</strong>
                        <p>
                            <span
                                class="badge bg-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'cancelled' ? 'danger' : 'warning') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Payment Status:</strong>
                        <p>
                            <span
                                class="badge bg-{{ $sale->payment_status == 'paid' ? 'success' : ($sale->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                {{ ucfirst($sale->payment_status) }}
                            </span>
                        </p>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Created By:</strong>
                        <p>{{ $sale->creator->name ?? 'N/A' }}</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- Product Information --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Sale Products</h5>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Unit Cost</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($sale->saleItems as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ number_format($item->unit_cost, 2) }}</td>
                                    <td>{{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Payment Summary --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment Summary</h5>
            </div>

            <div class="card-body">

                <div class="row justify-content-end">
                    <div class="col-md-5">

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Total Cost:</strong>
                            <span>{{ number_format($sale->total_cost, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Discount:</strong>
                            <span>{{ number_format($sale->discount, 2) }}</span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Tax:</strong>
                            <span>{{ number_format($sale->tax, 2) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-2">
                            <strong>Grand Total:</strong>
                            <strong>{{ number_format($sale->total_amount, 2) }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-success">
                            <strong>Total Paid:</strong>
                            <strong>{{ number_format($paidAmount, 2) }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2 text-danger">
                            <strong>Due Amount:</strong>
                            <strong>{{ number_format($dueAmount, 2) }}</strong>
                        </div>

                    </div>
                </div>

                @if ($sale->notes)
                    <hr>
                    <strong>Notes:</strong>
                    <p>{{ $sale->notes }}</p>
                @endif

            </div>
        </div>

        {{-- Payment History --}}
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment History</h5>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Amount</th>
                            <th>Payment Method</th>
                            <th>Transaction ID</th>
                            <th>Received By</th>
                            <th>Payment Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($sale->payments as $key => $payment)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td>{{ $payment->transaction_id ?? 'N/A' }}</td>
                                <td>{{ $payment->receiver->name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, h:i A') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    No payment records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection

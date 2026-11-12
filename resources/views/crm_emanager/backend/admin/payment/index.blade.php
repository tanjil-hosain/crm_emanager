
@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Payment History</h4>

        <a href="{{ route('payments.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Receive Payment
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Invoice Number</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Transaction ID</th>
                        <th>Received By</th>
                        <th>Payment Date</th>
                        <th>Notes</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($payments as $payment)
                        <tr>
                            <td>{{ $payments->firstItem() + $loop->index }}</td>

                            <td>
                                {{ $payment->sale->invoice_number ?? 'N/A' }}
                            </td>

                            <td>
                                {{ number_format($payment->amount, 2) }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                                </span>
                            </td>

                            <td>
                                {{ $payment->transaction_id ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $payment->receiver->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, h:i A') }}
                            </td>

                            <td>
                                {{ $payment->notes ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                No payment records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $payments->links() }}
            </div>

        </div>
    </div>

</div>
@endsection

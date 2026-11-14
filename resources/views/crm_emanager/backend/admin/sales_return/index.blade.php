
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Sales Returns</h4>

        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            Back to Sales
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

        <div class="card-header">
            <h5 class="mb-0">Return History</h5>
        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Return Number</th>
                        <th>Invoice Number</th>
                        <th>Customer</th>
                        <th>Refund Amount</th>
                        <th>Refund Method</th>
                        <th>Status</th>
                        <th>Return Date</th>
                        <th>Received By</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($returns as $index => $return)

                        <tr>
                            <td>
                                {{ $returns->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $return->return_number }}
                            </td>

                            <td>
                                {{ $return->sale->invoice_number ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $return->customer->name ?? 'N/A' }}
                            </td>

                            <td>
                                {{ number_format($return->total_amount, 2) }}
                            </td>

                            <td>
                                {{ ucwords(str_replace('_', ' ', $return->refund_method)) }}
                            </td>

                            <td>
                                @if ($return->status == 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($return->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">
                                        {{ ucfirst($return->status) }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $return->returned_at
                                    ? \Carbon\Carbon::parse($return->returned_at)->format('d M Y, h:i A')
                                    : 'N/A' }}
                            </td>

                            <td>
                                {{ $return->receiver->name ?? 'N/A' }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No sales returns found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

            <div class="mt-3">
                {{ $returns->links() }}
            </div>

        </div>
    </div>

</div>

@endsection

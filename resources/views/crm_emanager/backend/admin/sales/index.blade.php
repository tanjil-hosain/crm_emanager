@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Sales List</h4>

            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                Add New Sale
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Invoice Number</th>
                                <th>Customer</th>
                                <th>Total Amount</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th>Payment Status</th>
                                <th>Sale Status</th>
                                <th>Sold At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($sales as $key => $sale)
                                <tr>
                                    <td>{{ $sales->firstItem() + $key }}</td>

                                    <td>{{ $sale->invoice_number }}</td>

                                    <td>{{ $sale->customer->name ?? 'N/A' }}</td>

                                    <td>{{ number_format($sale->total_amount, 2) }}</td>

                                    <td>{{ number_format($sale->discount, 2) }}</td>

                                    <td>{{ number_format($sale->tax, 2) }}</td>

                                    <td>
                                        <span class="badge bg-info">
                                            {{ ucfirst($sale->payment_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-success">
                                            {{ ucfirst($sale->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y, h:i A') }}
                                    </td>

                                    <td>
                                        <div class="d-flex gap-1" style="white-space: nowrap;">
                                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <a href="{{ route('payments.create', ['sale_id' => $sale->id]) }}"
                                                class="btn btn-sm btn-success">
                                                Payment
                                            </a>


                                            @if ($sale->status !== 'cancelled')
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to cancel this sale?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">
                                        No Sales Found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="mt-3">
                    {{ $sales->links() }}
                </div>

            </div>
        </div>
    </div>
@endsection

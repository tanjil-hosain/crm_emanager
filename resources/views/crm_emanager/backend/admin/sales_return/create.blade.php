@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Sales Return</h4>

        <a href="{{ route('sales.show', ['sale' => $sale->id]) }}"
            class="btn btn-secondary">
            Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales-returns.store') }}" method="POST">
        @csrf

        <input type="hidden" name="sale_id" value="{{ $sale->id }}">

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Sale Information</h5>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Invoice:</strong>
                        {{ $sale->invoice_number }}
                    </div>

                    <div class="col-md-4">
                        <strong>Customer:</strong>
                        {{ $sale->customer->name }}
                    </div>

                    <div class="col-md-4">
                        <strong>Total Amount:</strong>
                        {{ number_format($sale->total_amount, 2) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Select Return Products</h5>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Sold Quantity</th>
                            <th>Already Returned</th>
                            <th>Available Quantity</th>
                            <th>Return Quantity</th>
                            <th>Unit Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($sale->saleItems as $index => $item)

                            @php
                                $alreadyReturned = $sale->returns
                                    ->where('status', 'completed')
                                    ->flatMap->items
                                    ->where('sale_item_id', $item->id)
                                    ->sum('quantity');

                                $availableQuantity = $item->quantity - $alreadyReturned;
                            @endphp

                            @if ($availableQuantity > 0)
                                <tr>
                                    <td>{{ $item->product->name }}</td>

                                    <td>{{ $item->quantity }}</td>

                                    <td>{{ $alreadyReturned }}</td>

                                    <td>{{ $availableQuantity }}</td>

                                    <td>
                                        <input type="hidden"
                                            name="items[{{ $index }}][sale_item_id]"
                                            value="{{ $item->id }}">

                                        <input type="number"
                                            name="items[{{ $index }}][quantity]"
                                            class="form-control"
                                            min="1"
                                            max="{{ $availableQuantity }}"
                                            placeholder="Quantity">
                                    </td>

                                    <td>
                                        {{ number_format($item->unit_price, 2) }}
                                    </td>
                                </tr>
                            @endif

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Refund Information</h5>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Refund Method</label>

                        <select name="refund_method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="mobile_banking">Mobile Banking</option>
                            <option value="card">Card</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Transaction ID</label>

                        <input type="text"
                            name="refund_transaction_id"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Return Date</label>

                        <input type="datetime-local"
                            name="returned_at"
                            class="form-control"
                            value="{{ now()->format('Y-m-d\TH:i') }}"
                            required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Refund Date</label>

                        <input type="datetime-local"
                            name="refunded_at"
                            class="form-control"
                            value="{{ now()->format('Y-m-d\TH:i') }}"
                            required>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Return Reason</label>

                        <textarea name="reason"
                            class="form-control"
                            rows="3"></textarea>
                    </div>

                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">
            Confirm Return & Refund
        </button>

    </form>

</div>
@endsection

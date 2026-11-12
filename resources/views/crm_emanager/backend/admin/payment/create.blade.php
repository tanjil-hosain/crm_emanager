
@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container py-4">

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Receive Payment</h4>
        </div>

        <div class="card-body">

            <div class="row mb-4">

                <div class="col-md-6 mb-3">
                    <label class="form-label">Invoice Number</label>
                    <input type="text" class="form-control"
                        value="{{ $sale->invoice_number }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Customer</label>
                    <input type="text" class="form-control"
                        value="{{ $sale->customer->name }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($sale->total_amount, 2) }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Already Paid</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($paidAmount, 2) }}" readonly>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Due Amount</label>
                    <input type="text" class="form-control"
                        value="{{ number_format($dueAmount, 2) }}" readonly>
                </div>

            </div>

            <hr>

            <form action="{{ route('payments.store') }}" method="POST">
                @csrf

                <input type="hidden" name="sale_id" value="{{ $sale->id }}">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Amount</label>
                        <input type="number" name="amount"
                            class="form-control"
                            step="0.01"
                            min="0.01"
                            max="{{ $dueAmount }}"
                            value="{{ old('amount') }}"
                            placeholder="Enter payment amount"
                            required>

                        @error('amount')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">Select Method</option>
                            <option value="cash">Cash</option>
                            <option value="bank">Bank</option>
                            <option value="mobile_banking">Mobile Banking</option>
                            <option value="card">Card</option>
                        </select>

                        @error('payment_method')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Transaction ID</label>
                        <input type="text" name="transaction_id"
                            class="form-control"
                            value="{{ old('transaction_id') }}"
                            placeholder="Optional">

                        @error('transaction_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Payment Date</label>
                        <input type="datetime-local" name="paid_at"
                            class="form-control"
                            value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}"
                            required>

                        @error('paid_at')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"
                            rows="3"
                            placeholder="Optional">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    Receive Payment
                </button>

                <a href="{{ route('sales.show', ['sale' => $sale->id]) }}"
                    class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>

</div>
@endsection


@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container-fluid py-4">

    <h4 class="mb-4">Edit Sale</h4>

    <div class="card">
        <div class="card-body">

            <form action="{{ route('sales.update', $sale->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Invoice Number</label>
                        <input type="text" name="invoice_number"
                            class="form-control"
                            value="{{ old('invoice_number', $sale->invoice_number) }}">
                        @error('invoice_number')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Customer</label>
                        <select name="customer_id" class="form-select">
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sold At</label>
                        <input type="datetime-local" name="sold_at"
                            class="form-control"
                            value="{{ old('sold_at', \Carbon\Carbon::parse($sale->sold_at)->format('Y-m-d\TH:i')) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Payment Status</label>
                        <select name="payment_status" class="form-select">
                            @foreach (['unpaid', 'partial', 'paid'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('payment_status', $sale->payment_status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Sale Status</label>
                        <select name="status" class="form-select">
                            @foreach (['pending', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $sale->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Discount</label>
                        <input type="number" step="0.01" min="0"
                            name="discount" class="form-control"
                            value="{{ old('discount', $sale->discount) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Tax</label>
                        <input type="number" step="0.01" min="0"
                            name="tax" class="form-control"
                            value="{{ old('tax', $sale->tax) }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Notes</label>
                        <textarea name="notes" class="form-control"
                            rows="3">{{ old('notes', $sale->notes) }}</textarea>
                    </div>

                </div>

                <hr>

                <h5 class="mb-3">Sale Products</h5>

                @foreach ($sale->saleItems as $key => $item)

                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label>Product</label>
                            <select name="products[{{ $key }}][product_id]"
                                class="form-select">

                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}"
                                        {{ old("products.$key.product_id", $item->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Quantity</label>
                            <input type="number" min="1"
                                name="products[{{ $key }}][quantity]"
                                class="form-control"
                                value="{{ old("products.$key.quantity", $item->quantity) }}">
                        </div>

                        <div class="col-md-4">
                            <label>Unit Price</label>
                            <input type="number" step="0.01" min="0"
                                name="products[{{ $key }}][unit_price]"
                                class="form-control"
                                value="{{ old("products.$key.unit_price", $item->unit_price) }}">
                        </div>

                    </div>

                @endforeach

                <button type="submit" class="btn btn-primary">
                    Update Sale
                </button>

                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>
</div>
@endsection

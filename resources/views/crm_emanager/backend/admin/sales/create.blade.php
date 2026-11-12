@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container py-4">

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Create New Sale</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('sales.store') }}" method="POST">
                    @csrf

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer</label>
                            <select name="customer_id" class="form-select" required>
                                <option value="">Select Customer</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->id }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Invoice Number</label>
                            <input type="text" name="invoice_number" class="form-control"
                                value="{{ old('invoice_number', 'INV-' . date('YmdHis')) }}" required>
                            @error('invoice_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sale Date</label>
                            <input type="datetime-local" name="sold_at" class="form-control"
                                value="{{ now()->format('Y-m-d\TH:i') }}">
                                @error('sold_at')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                        </div>

                    </div>

                    <hr>

                    <h5 class="mb-3">Product Information</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="productTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="120">Quantity</th>
                                    <th width="150">Unit Price</th>
                                    <th width="150">Subtotal</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>

                            <tbody id="productRows">
                                <tr>
                                    <td>
                                        <select name="products[0][product_id]" class="form-select product-select" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    data-price="{{ $product->selling_price }}"
                                                    data-stock="{{ $product->stock_quantity }}">
                                                    {{ $product->name }} (Stock: {{ $product->stock_quantity }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input type="number" name="products[0][quantity]" class="form-control quantity"
                                            min="1" value="1" required>
                                    </td>

                                    <td>
                                        <input type="number" name="products[0][unit_price]" class="form-control unit-price"
                                            min="0" step="0.01" value="0" required>
                                    </td>

                                    <td>
                                        <input type="text" class="form-control subtotal" value="0.00" readonly>
                                    </td>

                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <button type="button" id="addProduct" class="btn btn-success btn-sm mb-3">
                        <i class="bi bi-plus-circle"></i> Add Product
                    </button>

                    <hr>

                    <div class="row justify-content-end">

                        <div class="col-md-5">

                            <div class="mb-3">
                                <label class="form-label">Subtotal</label>
                                <input type="text" id="grandSubtotal" class="form-control" value="0.00" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Discount</label>
                                <input type="number" name="discount" id="discount" class="form-control" min="0"
                                    step="0.01" value="{{ old('discount', 0) }}">
                                @error('discount')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tax</label>
                                <input type="number" name="tax" id="tax" class="form-control" min="0"
                                    step="0.01" value="{{ old('tax', 0) }}">
                                @error('tax')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Grand Total</label>
                                <input type="text" id="grandTotal" class="form-control fw-bold" value="0.00" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Payment Status</label>
                                <select name="payment_status" class="form-select" required>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="partial">Partial</option>
                                    <option value="paid">Paid</option>
                                </select>
                                @error('payment_status')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Save Sale
                    </button>

                    <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                        Back
                    </a>

                </form>

            </div>
        </div>

    </div>

    <script>
        let rowIndex = 1;

        const productOptions = `
        <option value="">Select Product</option>
        @foreach ($products as $product)
            <option value="{{ $product->id }}"
                data-price="{{ $product->selling_price }}"
                data-stock="{{ $product->stock_quantity }}">
                {{ $product->name }} (Stock: {{ $product->stock_quantity }})
            </option>
        @endforeach
    `;

        document.getElementById('addProduct').addEventListener('click', function() {
            const row = `
            <tr>
                <td>
                    <select name="products[${rowIndex}][product_id]"
                        class="form-select product-select" required>
                        ${productOptions}
                    </select>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][quantity]"
                        class="form-control quantity" min="1" value="1" required>
                </td>
                <td>
                    <input type="number" name="products[${rowIndex}][unit_price]"
                        class="form-control unit-price" min="0"
                        step="0.01" value="0" required>
                </td>
                <td>
                    <input type="text" class="form-control subtotal"
                        value="0.00" readonly>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove-row">
                        <i class="bi bi-trash"></i>
                    </button>
                </td>
            </tr>
        `;

            document.getElementById('productRows').insertAdjacentHTML('beforeend', row);
            rowIndex++;
        });

        document.getElementById('productRows').addEventListener('change', function(e) {
            if (e.target.classList.contains('product-select')) {
                const row = e.target.closest('tr');
                const price = e.target.selectedOptions[0].dataset.price || 0;
                row.querySelector('.unit-price').value = price;
                calculateTotal();
            }
        });

        document.getElementById('productRows').addEventListener('input', function() {
            calculateTotal();
        });

        document.getElementById('productRows').addEventListener('click', function(e) {
            if (e.target.closest('.remove-row')) {
                const rows = document.querySelectorAll('#productRows tr');
                if (rows.length > 1) {
                    e.target.closest('tr').remove();
                    calculateTotal();
                }
            }
        });

        document.getElementById('discount').addEventListener('input', calculateTotal);
        document.getElementById('tax').addEventListener('input', calculateTotal);

        function calculateTotal() {
            let subtotal = 0;

            document.querySelectorAll('#productRows tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
                const price = parseFloat(row.querySelector('.unit-price').value) || 0;

                // Fix: Quantity er sathe price gun korte hobe (*)
                const rowTotal = quantity * price;

                row.querySelector('.subtotal').value = rowTotal.toFixed(2);
                subtotal += rowTotal;
            });

            const discount = parseFloat(document.getElementById('discount').value) || 0;
            const tax = parseFloat(document.getElementById('tax').value) || 0;

            document.getElementById('grandSubtotal').value = subtotal.toFixed(2);

            // Fix: Subtotal theke discount biyog (-) kore tax jog (+) korte hobe
            document.getElementById('grandTotal').value = (subtotal - discount + tax).toFixed(2);
        }

        calculateTotal();
    </script>
@endsection

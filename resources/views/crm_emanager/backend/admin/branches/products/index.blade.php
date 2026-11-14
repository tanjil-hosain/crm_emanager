@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $branch->branch_name }} - Products</h4>
            <p class="text-muted mb-0">Manage branch-wise products, pricing and stock</p>
        </div>

        <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-light">
            <i class="bi bi-arrow-left me-1"></i> Back to Branch
        </a>
    </div>
    {{-- Assign Product --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0">
                <i class="bi bi-plus-circle me-2"></i>Assign New Product
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('branches.products.store', $branch->id) }}" method="POST">
                @csrf

                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Select Product *</label>
                        <select name="product_id"
                                class="form-select @error('product_id') is-invalid @enderror"
                                required>
                            <option value="">Choose Product</option>

                            @foreach($availableProducts as $product)
                                <option value="{{ $product->id }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->sku }})
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Purchase Price *</label>
                        <input type="number" step="0.01" min="0"
                               name="purchase_price"
                               class="form-control"
                               value="{{ old('purchase_price') }}"
                               required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Selling Price *</label>
                        <input type="number" step="0.01" min="0"
                               name="selling_price"
                               class="form-control"
                               value="{{ old('selling_price') }}"
                               required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Initial Stock *</label>
                        <input type="number" min="0"
                               name="stock_quantity"
                               class="form-control"
                               value="{{ old('stock_quantity', 0) }}"
                               required>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Alert Quantity</label>
                        <input type="number" min="0"
                               name="alert_quantity"
                               class="form-control"
                               value="{{ old('alert_quantity', 5) }}"
                               required>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Assign Product
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Assigned Products --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0">Assigned Products</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Purchase Price</th>
                            <th>Selling Price</th>
                            <th>Stock</th>
                            <th>Alert Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($branch->products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <strong>{{ $product->name }}</strong>
                                </td>

                                <td>{{ $product->sku }}</td>

                                <td>
                                    <form id="update-{{ $product->id }}"
                                          action="{{ route('branches.products.update', [$branch->id, $product->id]) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="number" step="0.01" min="0"
                                               name="purchase_price"
                                               class="form-control form-control-sm"
                                               value="{{ $product->pivot->purchase_price }}"
                                               required>
                                </td>

                                <td>
                                        <input type="number" step="0.01" min="0"
                                               name="selling_price"
                                               class="form-control form-control-sm"
                                               value="{{ $product->pivot->selling_price }}"
                                               required>
                                </td>

                                <td>
                                        <input type="number" min="0"
                                               name="stock_quantity"
                                               class="form-control form-control-sm"
                                               value="{{ $product->pivot->stock_quantity }}"
                                               required>
                                </td>

                                <td>
                                        <input type="number" min="0"
                                               name="alert_quantity"
                                               class="form-control form-control-sm"
                                               value="{{ $product->pivot->alert_quantity }}"
                                               required>
                                </td>

                                <td>
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="active"
                                                {{ $product->pivot->status == 'active' ? 'selected' : '' }}>
                                                Active
                                            </option>
                                            <option value="inactive"
                                                {{ $product->pivot->status == 'inactive' ? 'selected' : '' }}>
                                                Inactive
                                            </option>
                                        </select>
                                </td>

                                <td>
                                        <button type="submit" form="update-{{ $product->id }}"
                                                class="btn btn-sm btn-success mb-1">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('branches.products.destroy', [$branch->id, $product->id]) }}"
                                          method="POST"
                                          onsubmit="return confirm('Remove this product from this branch?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No products assigned to this branch yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

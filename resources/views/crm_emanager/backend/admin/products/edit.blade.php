
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Edit Product</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('products.update', $product->id) }}"
                method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Select Category</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Category</label>
                        <select name="subcategory_id" class="form-select">
                            <option value="">Select Sub Category</option>

                            @foreach ($subcategories as $subCategory)
                                <option value="{{ $subCategory->id }}"
                                    {{ old('subcategory_id', $product->subcategory_id) == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('subcategory_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Name</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">SKU</label>
                        <input type="text" name="sku" class="form-control"
                            value="{{ old('sku', $product->sku) }}" required>
                        @error('sku')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Purchase Price</label>
                        <input type="number" step="0.01" min="0" name="purchase_price"
                            class="form-control"
                            value="{{ old('purchase_price', $product->purchase_price) }}" required>
                        @error('purchase_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Selling Price</label>
                        <input type="number" step="0.01" min="0" name="selling_price"
                            class="form-control"
                            value="{{ old('selling_price', $product->selling_price) }}" required>
                        @error('selling_price')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock Quantity</label>
                        <input type="number" min="0" name="stock_quantity"
                            class="form-control"
                            value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                        @error('stock_quantity')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Unit</label>
                        <input type="text" name="unit" class="form-control"
                            value="{{ old('unit', $product->unit) }}" required>
                        @error('unit')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control">

                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                width="70" class="mt-2">
                        @endif

                        @error('image')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active"
                                {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="deactive"
                                {{ old('status', $product->status) == 'deactive' ? 'selected' : '' }}>
                                Deactive
                            </option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Update Product
                </button>

                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>

</div>

@endsection

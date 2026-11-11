
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Product Details</h4>

        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ $product->name }}</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-4">
                    <label class="fw-bold">Product Image</label>
                    <div class="mt-2">
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                width="200" height="200"
                                style="object-fit: cover; border-radius: 8px;">
                        @else
                            <p>No Image Available</p>
                        @endif
                    </div>
                </div>

                <div class="col-md-8">
                    <table class="table table-bordered">
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $product->name }}</td>
                        </tr>

                        <tr>
                            <th>SKU</th>
                            <td>{{ $product->sku }}</td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td>{{ $product->category->name }}</td>
                        </tr>

                        <tr>
                            <th>Sub Category</th>
                            <td>{{ $product->subcategory?->name ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Purchase Price</th>
                            <td>{{ number_format($product->purchase_price, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Selling Price</th>
                            <td>{{ number_format($product->selling_price, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Stock Quantity</th>
                            <td>{{ $product->stock_quantity }} {{ $product->unit }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td>{{ $product->description ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $product->created_at->format('d M Y, h:i A') }}</td>
                        </tr>

                    </table>
                </div>

            </div>

            <a href="{{ route('products.edit', $product->id) }}"
                class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Product
            </a>

        </div>
    </div>

</div>
@endsection

@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Products</h4>

        <a href="{{ route('products.create') }}" class="btn btn-primary">
            Add Product
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Purchase Price</th>
                        <th>Selling Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $key => $product)
                        <tr>
                            <td>{{ $key + 1 }}</td>

                            <td>
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        width="50" height="50" style="object-fit: cover;">
                                @else
                                    No Image
                                @endif
                            </td>

                            <td>{{ $product->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->subCategory?->name ?? 'N/A' }}</td>
                            <td>{{ $product->purchase_price }}</td>
                            <td>{{ $product->selling_price }}</td>
                            <td>{{ $product->stock_quantity }} {{ $product->unit }}</td>
                            <td>
                                <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <td style="white-space: nowrap; min-width: 120px;">
                                <a href="{{ route('products.show', $product->id) }}"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                    method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">
                                No Products Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection


@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container py-4">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Category List</h5>

            <a href="{{ route('category.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add Category
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="70">#</th>
                            <th>Category Name</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th width="160">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $key => $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $key }}</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>{{ $category->description ?? 'N/A' }}</td>

                                <td>
                                    <a href="{{ route('category.edit', $category->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('category.destroy', $category->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this category?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $categories->links() }}
            </div>

        </div>
    </div>
</div>
@endsection

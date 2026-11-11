
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Sub Categories</h4>

        <a href="{{ route('subcategory.create') }}" class="btn btn-primary">
            Add Sub Category
        </a>
    </div>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Sub Category</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($subCategories as $key => $subCategory)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $subCategory->category->name }}</td>
                            <td>{{ $subCategory->name }}</td>
                            <td>
                                <a href="{{ route('subcategory.edit', $subCategory->id) }}"
                                    class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('subcategory.destroy', $subCategory->id) }}"
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
                            <td colspan="4" class="text-center">
                                No Sub Categories Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection

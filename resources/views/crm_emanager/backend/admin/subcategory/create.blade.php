
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="card">
        <div class="card-header">
            <h4 class="mb-0">Create Sub Category</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('subcategory.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                    @error('category_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Sub Category Name</label>
                    <input type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name') }}"
                        placeholder="Enter sub category name"
                        required>

                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Save Sub Category
                </button>

                <a href="{{ route('subcategory.index') }}"
                    class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>

</div>
@endsection

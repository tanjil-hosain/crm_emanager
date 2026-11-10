@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container py-5">

    <div class="card shadow">
        <div class="card-header">
            Create New Permission
        </div>

        <div class="card-body">

            <form action="{{ route('permission.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Permission Name</label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Example: view, create, manage">

                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    Create Permission
                </button>

            </form>

        </div>
    </div>

</div>


@endsection
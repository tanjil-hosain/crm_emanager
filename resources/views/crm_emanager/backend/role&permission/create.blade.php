@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-end mb-4">

            <div class="dropdown">

                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

                    <i class="fas fa-plus me-1"></i> Add New

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <a class="dropdown-item" href="{{ route('role.create') }}">
                            <i class="fas fa-user-tag me-2"></i>
                            Add Role
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="{{ route('permission.create') }}">
                            <i class="fas fa-key me-2"></i>
                            Add Permission
                        </a>
                    </li>

                </ul>

            </div>

        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="card border-0 shadow">

                    <div class="card-header bg-primary text-white py-3">
                        <h5 class="mb-0">Assign Permissions to Role</h5>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('role.permission.store') }}" method="POST">
                            @csrf

                            {{-- Select Role --}}
                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    Select Role
                                </label>

                                <select name="role" class="form-select" required>
                                    <option value="">-- Select Role --</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            {{-- Select Permissions --}}
                            <div class="mb-4">

                                <label class="form-label fw-semibold mb-3">
                                    Select Permissions
                                </label>

                                <div class="border rounded p-3">

                                    <div class="row">

                                        @foreach ($permissions as $permission)
                                            <div class="col-md-6 mb-3">

                                                <div class="form-check">
                                                    <input type="checkbox" name="permissions[]"
                                                        value="{{ $permission->id }}" class="form-check-input"
                                                        id="permission{{ $permission->id }}"
                                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>

                                                    <label class="form-check-label" for="permission{{ $permission->id }}">
                                                        {{ ucfirst($permission->name) }}
                                                    </label>
                                                </div>

                                            </div>
                                        @endforeach

                                    </div>

                                </div>

                            </div>

                            {{-- Submit Button --}}
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">
                                    Assign Permissions
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

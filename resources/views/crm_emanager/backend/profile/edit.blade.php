@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">

                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">Update User</h4>
                    </div>

                    <div class="card-body p-4">

                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">

                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter full name"
                                    value="{{ $user->name }}">

                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter email"
                                    value="{{ $user->email }}">

                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <select name="role" class="form-select">
                                    <option value="">Select Role</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ old('role', $user->getRoleNames()->first()) == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" placeholder="Enter mobile number"
                                    value="{{ $user->mobile }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="Enter address">{{ $user->address }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Profile Photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/png,image/jpeg">
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">
                                    Back
                                </a>

                                <button type="submit" class="btn btn-primary px-4">
                                    Update User
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection

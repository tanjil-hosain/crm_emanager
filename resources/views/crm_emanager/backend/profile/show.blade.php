@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">User Details</h4>

        <div>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>

            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> Edit User
            </a>
        </div>
    </div>

    <div class="row">

        {{-- Profile Information --}}
        <div class="col-lg-4 mb-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body text-center p-4">

                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                             class="rounded-circle mb-3"
                             width="120"
                             height="120"
                             style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3"
                             style="width:120px;height:120px;">
                            <i class="fas fa-user fa-4x text-secondary"></i>
                        </div>
                    @endif

                    <h5 class="mb-1">{{ $user->name }}</h5>

                    <p class="text-muted mb-3">
                        {{ $user->email }}
                    </p>

                    @foreach($user->roles as $role)
                        <span class="badge bg-primary">
                            {{ ucfirst($role->name) }}
                        </span>
                    @endforeach

                </div>
            </div>

        </div>

        {{-- User Details --}}
        <div class="col-lg-8 mb-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Personal Information</h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Full Name</div>
                        <div class="col-md-8 fw-semibold">
                            {{ $user->name }}
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Email Address</div>
                        <div class="col-md-8">
                            {{ $user->email }}
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Mobile</div>
                        <div class="col-md-8">
                            {{ $user->mobile ?? 'N/A' }}
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Address</div>
                        <div class="col-md-8">
                            {{ $user->address ?? 'N/A' }}
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Created At</div>
                        <div class="col-md-8">
                            {{ $user->created_at?->format('d M Y, h:i A') }}
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-4 text-muted">Last Updated</div>
                        <div class="col-md-8">
                            {{ $user->updated_at?->format('d M Y, h:i A') }}
                        </div>
                    </div>

                </div>
            </div>

        </div>

        {{-- Assigned Permissions --}}
        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">Assigned Permissions</h5>
                </div>

                <div class="card-body">

                    @php
                        $permissions = $user->getAllPermissions();
                    @endphp

                    @forelse($permissions as $permission)

                        <span class="badge bg-light text-dark border me-2 mb-2 p-2">
                            {{ ucfirst($permission->name) }}
                        </span>

                    @empty

                        <p class="text-muted mb-0">
                            No permissions assigned to this user.
                        </p>

                    @endforelse

                </div>
            </div>

        </div>

    </div>

</div>
@endsection

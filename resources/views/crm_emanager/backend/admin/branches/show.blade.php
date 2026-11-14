@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Branch Details</h4>
            <p class="text-muted mb-0">View branch information and summary</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('branches.edit', $branch->id) }}"
               class="btn btn-primary">
                <i class="bi bi-pencil-square me-1"></i> Edit Branch
            </a>
            <a href="{{ route('branches.products.index', $branch->id) }}"
   class="btn btn-success">
    <i class="bi bi-box-seam me-1"></i> Manage Products
</a>

            <a href="{{ route('branches.index') }}"
               class="btn btn-light">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    {{-- Branch Overview --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-2">{{ $branch->branch_name }}</h4>

                    <span class="badge bg-light text-dark">
                        {{ $branch->branch_code }}
                    </span>
                </div>

                @if($branch->status === 'active')
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </div>

            <hr>

            <div class="row g-3">
                <div class="col-md-6">
                    <small class="text-muted">Phone Number</small>
                    <p class="mb-0">{{ $branch->phone ?? 'Not provided' }}</p>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Address</small>
                    <p class="mb-0">{{ $branch->address ?? 'Not provided' }}</p>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Created At</small>
                    <p class="mb-0">{{ $branch->created_at?->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="row g-3">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Assigned Products</small>
                            <h3 class="mb-0">{{ $branch->products_count }}</h3>
                        </div>
                        <i class="bi bi-box-seam fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Employees</small>
                            <h3 class="mb-0">{{ $branch->users_count }}</h3>
                        </div>
                        <i class="bi bi-people fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted">Total Sales</small>
                            <h3 class="mb-0">{{ $branch->sales_count }}</h3>
                        </div>
                        <i class="bi bi-receipt fs-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

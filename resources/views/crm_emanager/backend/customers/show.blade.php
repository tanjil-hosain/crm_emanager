@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="mb-1">Customer Details</h4>
            <p class="text-muted mb-0">View customer information</p>
        </div>

        <div>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                Back
            </a>

            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                Edit Customer
            </a>
        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Customer Information</h5>
        </div>

        <div class="card-body p-4">

            <div class="row">

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Customer Name</label>
                    <h6>{{ $customer->name }}</h6>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Email Address</label>
                    <h6>{{ $customer->email ?? 'N/A' }}</h6>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Phone Number</label>
                    <h6>{{ $customer->phone }}</h6>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Company Name</label>
                    <h6>{{ $customer->company_name ?? 'N/A' }}</h6>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Customer Type</label>
                    <h6>
                        <span class="badge bg-info">
                            {{ ucfirst($customer->customer_type) }}
                        </span>
                    </h6>
                </div>

                <div class="col-md-6 mb-4">
                    <label class="text-muted">Status</label>
                    <h6>
                        @if($customer->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </h6>
                </div>

                <div class="col-12 mb-4">
                    <label class="text-muted">Address</label>
                    <h6>{{ $customer->address ?? 'N/A' }}</h6>
                </div>

                <div class="col-12 mb-4">
                    <label class="text-muted">Notes</label>
                    <p>{{ $customer->notes ?? 'No notes available.' }}</p>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Created At</label>
                    <h6>{{ $customer->created_at->format('d M Y, h:i A') }}</h6>
                </div>

                <div class="col-md-6">
                    <label class="text-muted">Last Updated</label>
                    <h6>{{ $customer->updated_at->format('d M Y, h:i A') }}</h6>
                </div>

            </div>

        </div>
    </div>

</div>

@endsection

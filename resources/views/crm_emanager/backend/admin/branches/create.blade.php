@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Add New Branch</h4>

        <a href="{{ route('branches.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('branches.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch Name *</label>
                        <input type="text" name="branch_name"
                               class="form-control @error('branch_name') is-invalid @enderror"
                               value="{{ old('branch_name') }}"
                               placeholder="Enter branch name">

                        @error('branch_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch Code *</label>
                        <input type="text" name="branch_code"
                               class="form-control @error('branch_code') is-invalid @enderror"
                               value="{{ old('branch_code') }}"
                               placeholder="Example: DHAKA-01">

                        @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone') }}"
                               placeholder="Enter phone number">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3"
                                  class="form-control"
                                  placeholder="Enter branch address">{{ old('address') }}</textarea>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-1"></i> Save Branch
                    </button>

                    <a href="{{ route('branches.index') }}" class="btn btn-light">
                        Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

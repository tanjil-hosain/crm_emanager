
@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit Branch</h4>

        <a href="{{ route('branches.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form action="{{ route('branches.update', $branch->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch Name *</label>
                        <input type="text" name="branch_name"
                               class="form-control @error('branch_name') is-invalid @enderror"
                               value="{{ old('branch_name', $branch->branch_name) }}">

                        @error('branch_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Branch Code *</label>
                        <input type="text" name="branch_code"
                               class="form-control @error('branch_code') is-invalid @enderror"
                               value="{{ old('branch_code', $branch->branch_code) }}">

                        @error('branch_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone', $branch->phone) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select">
                            <option value="active"
                                {{ old('status', $branch->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $branch->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="3"
                                  class="form-control">{{ old('address', $branch->address) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-1"></i> Update Branch
                </button>
            </form>

        </div>
    </div>
</div>
@endsection

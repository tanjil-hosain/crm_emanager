```blade
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit Customer</h4>

        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning">
            <h5 class="mb-0">Update Customer Information</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Name *</label>
                        <input type="text" name="name"
                            class="form-control"
                            value="{{ old('name', $customer->name) }}">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                            class="form-control"
                            value="{{ old('email', $customer->email) }}">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone"
                            class="form-control"
                            value="{{ old('phone', $customer->phone) }}">

                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name"
                            class="form-control"
                            value="{{ old('company_name', $customer->company_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Type</label>
                        <select name="customer_type" class="form-select">

                            <option value="individual"
                                {{ old('customer_type', $customer->customer_type) == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>

                            <option value="company"
                                {{ old('customer_type', $customer->customer_type) == 'company' ? 'selected' : '' }}>
                                Company
                            </option>

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">

                            <option value="active"
                                {{ old('status', $customer->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="inactive"
                                {{ old('status', $customer->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control" rows="3">{{ old('address', $customer->address) }}</textarea>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes', $customer->notes) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('customers.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Update Customer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
```
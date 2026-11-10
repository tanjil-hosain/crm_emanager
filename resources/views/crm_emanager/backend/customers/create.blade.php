```blade
@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Add New Customer</h4>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            Customer Information
        </div>

        <div class="card-body p-4">

            <form action="{{ route('customers.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Name *</label>
                        <input type="text" name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Enter customer name">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                            class="form-control"
                            value="{{ old('email') }}"
                            placeholder="Enter email">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone"
                            class="form-control"
                            value="{{ old('phone') }}"
                            placeholder="Enter phone number">

                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name"
                            class="form-control"
                            value="{{ old('company_name') }}"
                            placeholder="Enter company name">

                        @error('company_name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Customer Type *</label>
                        <select name="customer_type" class="form-select">
                            <option value="individual" {{ old('customer_type') == 'individual' ? 'selected' : '' }}>
                                Individual
                            </option>
                            <option value="company" {{ old('customer_type') == 'company' ? 'selected' : '' }}>
                                Company
                            </option>
                        </select>

                        @error('customer_type')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status *</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>

                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control"
                            rows="3"
                            placeholder="Enter address">{{ old('address') }}</textarea>

                        @error('address')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"
                            rows="3"
                            placeholder="Additional information">{{ old('notes') }}</textarea>

                        @error('notes')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('customers.index') }}"
                        class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Save Customer
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection
```
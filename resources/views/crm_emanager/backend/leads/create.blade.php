@extends('crm_emanager.backend.layout.master')
@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Add New Lead</h4>

        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Lead Information</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('leads.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Name *</label>
                        <input type="text" name="name"
                            class="form-control"
                            value="{{ old('name') }}"
                            placeholder="Enter lead name">

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
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Source</label>
                        <select name="source" class="form-select">
                            <option value="">Select Source</option>
                            <option value="Website" {{ old('source') == 'Website' ? 'selected' : '' }}>Website</option>
                            <option value="Facebook" {{ old('source') == 'Facebook' ? 'selected' : '' }}>Facebook</option>
                            <option value="Referral" {{ old('source') == 'Referral' ? 'selected' : '' }}>Referral</option>
                            <option value="Phone" {{ old('source') == 'Phone' ? 'selected' : '' }}>Phone</option>
                            <option value="Other" {{ old('source') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Status</label>
                        <select name="status" class="form-select">
                            <option value="new" {{ old('status', 'new') == 'new' ? 'selected' : '' }}>New</option>
                            <option value="contacted" {{ old('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                            <option value="qualified" {{ old('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                            <option value="converted" {{ old('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                            <option value="lost" {{ old('status') == 'lost' ? 'selected' : '' }}>Lost</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assign To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Select Employee</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control"
                            rows="4"
                            placeholder="Enter additional information">{{ old('notes') }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('leads.index') }}"
                        class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary">
                        Save Lead
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection

@extends('crm_emanager.backend.layout.master')
@section('content')

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Edit Lead</h4>

        <a href="{{ route('leads.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="card shadow-sm border-0">

        <div class="card-header bg-warning">
            <h5 class="mb-0">Update Lead Information</h5>
        </div>

        <div class="card-body p-4">

            <form action="{{ route('leads.update', $lead->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Name *</label>
                        <input type="text" name="name" class="form-control"
                            value="{{ old('name', $lead->name) }}">

                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $lead->email) }}">

                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone *</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $lead->phone) }}">

                        @error('phone')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company Name</label>
                        <input type="text" name="company_name" class="form-control"
                            value="{{ old('company_name', $lead->company_name) }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Source</label>
                        <select name="source" class="form-select">
                            <option value="">Select Source</option>

                            @foreach(['Website', 'Facebook', 'Referral', 'Phone', 'Other'] as $source)
                                <option value="{{ $source }}"
                                    {{ old('source', $lead->source) == $source ? 'selected' : '' }}>
                                    {{ $source }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Lead Status</label>
                        <select name="status" class="form-select">

                            @foreach(['new', 'contacted', 'qualified', 'converted', 'lost'] as $status)
                                <option value="{{ $status }}"
                                    {{ old('status', $lead->status) == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Assign To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">Select Employee</option>

                            @foreach($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to', $lead->assigned_to) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="4">{{ old('notes', $lead->notes) }}</textarea>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('leads.index') }}" class="btn btn-light border">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-warning">
                        Update Lead
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection

@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Lead Details</h4>

        <div>
            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('leads.index') }}" class="btn btn-secondary">
                Back
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            Lead Information
        </div>

        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p>{{ $lead->name }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Email:</strong>
                    <p>{{ $lead->email ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Phone:</strong>
                    <p>{{ $lead->phone }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Company:</strong>
                    <p>{{ $lead->company_name ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Source:</strong>
                    <p>{{ $lead->source ?? 'N/A' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>
                        <span class="badge bg-info">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Assigned To:</strong>
                    <p>{{ $lead->assignedUser?->name ?? 'Unassigned' }}</p>
                </div>

                <div class="col-md-12 mb-3">
                    <strong>Notes:</strong>
                    <p>{{ $lead->notes ?? 'No notes available' }}</p>
                </div>

                <div class="col-md-6 mb-3">
                    <strong>Created At:</strong>
                    <p>{{ $lead->created_at->format('d M Y, h:i A') }}</p>
                </div>

            </div>
        </div>
    </div>

</div>
@endsection
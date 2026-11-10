@extends('crm_emanager.backend.layout.master')
@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Lead Management</h4>
            <p class="text-muted mb-0">Manage your potential customers.</p>
        </div>

        <a href="{{ route('leads.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New Lead
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Lead List</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Source</th>
                            <th>Status</th>
                            <th>Assigned To</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($leads as $lead)

                            <tr>
                                <td>{{ $lead->id }}</td>

                                <td class="fw-semibold">
                                    {{ $lead->name }}
                                </td>

                                <td>{{ $lead->email ?? 'N/A' }}</td>

                                <td>{{ $lead->phone }}</td>

                                <td>{{ $lead->company_name ?? 'N/A' }}</td>

                                <td>{{ $lead->source ?? 'N/A' }}</td>

                                <td>
                                    @php
                                        $statusColors = [
                                            'new' => 'primary',
                                            'contacted' => 'info',
                                            'qualified' => 'warning',
                                            'converted' => 'success',
                                            'lost' => 'danger',
                                        ];
                                    @endphp

                                    <span class="badge bg-{{ $statusColors[$lead->status] ?? 'secondary' }}">
                                        {{ ucfirst($lead->status) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $lead->assignedUser->name ?? 'Unassigned' }}
                                </td>

                                <td>
                                    <a href="{{ route('leads.show', $lead->id) }}"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('leads.edit', $lead->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('leads.destroy', $lead->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this lead?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No leads found!
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $leads->links() }}
            </div>

        </div>
    </div>

</div>

@endsection

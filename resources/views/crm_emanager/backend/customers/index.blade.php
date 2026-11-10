@extends('crm_emanager.backend.layout.master')
@section('content')

<div class="container py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">Customer Management</h4>
            <p class="text-muted mb-0">Manage all your customers here.</p>
        </div>

        <a href="{{ route('customers.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add Customer
        </a>
    </div>

    {{-- Customer Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Customer List</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($customers as  $customer)

                            <tr>
                                <td>{{ $customer->id}}</td>

                                <td class="fw-semibold">
                                    {{ $customer->name }}
                                </td>

                                <td>{{ $customer->email ?? 'N/A' }}</td>

                                <td>{{ $customer->phone }}</td>

                                <td>{{ $customer->company_name ?? 'N/A' }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($customer->customer_type) }}
                                    </span>
                                </td>

                                <td>
                                    @if($customer->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    <a href="{{ route('customers.show', $customer->id) }}"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                        class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer->id) }}"
                                        method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this customer?')">

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
                                <td colspan="8" class="text-center py-4 text-muted">
                                    No customers found!
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- Pagination --}}
            {{-- <div class="d-flex justify-content-end mt-3">
                {{ $customers->links() }}
            </div> --}}

        </div>
    </div>

</div>

@endsection

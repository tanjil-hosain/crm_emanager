@extends('crm_emanager.backend.layout.master')

@section('content')
    <div class="container-fluid py-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1">Branch Management</h4>
                <p class="text-muted mb-0">Manage all business branches</p>
            </div>

            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Add New Branch
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0">All Branches</h6>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Branch Name</th>
                                <th>Code</th>
                                <th>Phone</th>
                                <th>Products</th>
                                <th>Users</th>
                                <th>Sales</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ $branches->firstItem() + $loop->index }}</td>

                                    <td>
                                        <strong>{{ $branch->branch_name }}</strong>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $branch->branch_code }}
                                        </span>
                                    </td>

                                    <td>{{ $branch->phone ?? 'N/A' }}</td>
                                    <td>{{ $branch->products_count }}</td>
                                    <td>{{ $branch->users_count }}</td>
                                    <td>{{ $branch->sales_count }}</td>

                                    <td>
                                        @if ($branch->status === 'active')
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>

                                    <td>
                                        <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('branches.edit', $branch->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        No branches found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $branches->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

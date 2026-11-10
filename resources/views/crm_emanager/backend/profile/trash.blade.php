@extends('crm_emanager.backend.layout.master')

@section('content')
<div class="container-fluid p-4">
{{-- <div class="container mt-5"> --}}

    <h3>Trash Users</h3>

    <table class="table table-bordered table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            @forelse($users as $user)

            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>

                <td>

                    {{-- Restore --}}
                    <form action="{{ route('users.restore', $user->id) }}"
                          method="POST" class="d-inline">

                        @csrf
                        @method('PUT')

                        <button class="btn btn-success btn-sm">
                            Restore
                        </button>

                    </form>

                    {{-- Permanent Delete --}}
                    <form action="{{ route('users.forceDelete', $user->id) }}"
                          method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure permanently delete?')">

                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">
                            Delete Permanently
                        </button>

                    </form>

                </td>
            </tr>

            @empty

            <tr>
                <td colspan="4" class="text-center">
                    Trash is empty!
                </td>
            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection
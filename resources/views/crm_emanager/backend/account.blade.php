@extends('crm_emanager.backend.layout.master');

@section('content')
    <div class="container-fluid p-4">
        <h2 class="mb-4">Accounts Money Overview</h2>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="card bg-primary text-white p-3 shadow-sm">
                    <h5>Bkash</h5>
                    <h3>{{ $bkash }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white p-3 shadow-sm">
                    <h5>Nagad</h5>
                    <h3>{{ $nagad }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white p-3 shadow-sm">
                    <h5>Cash</h5>
                    <h3>{{ $cash }}</h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white p-3 shadow-sm">
                    <h5>Bank</h5>
                    <h3>{{ $bank}}</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

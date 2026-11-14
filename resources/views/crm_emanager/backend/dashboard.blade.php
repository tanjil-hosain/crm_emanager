@extends('crm_emanager.backend.layout.master')

@section('content')

<div class="container-fluid py-4">

    {{-- Dashboard Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Dashboard</h3>
            <p class="text-muted mb-0">Welcome to your E-Manager Dashboard</p>
        </div>

        <span class="badge bg-primary p-2">
            {{ now()->format('d M, Y') }}
        </span>
    </div>


    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Total Customers</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalCustomers) }}
                            </h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-people text-primary fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Total Leads</p>
                            <h3 class="fw-bold mb-0">
                                {{ number_format($totalLeads) }}
                            </h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-person-plus text-info fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Today's Revenue</p>
                            <h3 class="fw-bold mb-0">
                                ৳{{ number_format($todayRevenue, 2) }}
                            </h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-currency-dollar text-success fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@if(auth()->user()->hasAnyRole(['admin', 'manager']))

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p class="text-muted mb-1">Today Profit</p>
                            <h3 class="fw-bold mb-0">
                                ৳{{ number_format($todayProfit, 2) }}
                            </h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="bi bi-graph-up-arrow text-warning fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- Second Row Cards --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <p class="text-muted mb-1">Total Sales Cost</p>
                    <h4 class="fw-bold">
                        ৳{{ number_format($totalSalesCost, 2) }}
                    </h4>
                    <i class="bi bi-wallet2 text-danger fs-4"></i>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <p class="text-muted mb-1">This Month Revenue</p>
                    <h4 class="fw-bold">
                        ৳{{ number_format($thisMonthRevenue, 2) }}
                    </h4>
                    <i class="bi bi-calendar-check text-success fs-4"></i>
                </div>
            </div>
        </div>


        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <p class="text-muted mb-1">This Month Profit</p>
                    <h4 class="fw-bold">
                        ৳{{ number_format($monthlyProfit, 2) }}
                    </h4>
                    <i class="bi bi-piggy-bank text-primary fs-4"></i>
                </div>
            </div>
        </div>
         @endif

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <p class="text-muted mb-1">New Leads</p>
                    <h4 class="fw-bold">
                        {{ number_format($newLeads) }}
                    </h4>
                    <i class="bi bi-person-add text-info fs-4"></i>
                </div>
            </div>
        </div>
       

    </div>


    {{-- Charts --}}
    <div class="row g-3 mb-4">
@if(auth()->user()->hasAnyRole(['admin', 'manager']))
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">Monthly Revenue & Cost</h5>
                </div>

                <div class="card-body">
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>
@endif

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-3 h-100">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">Leads Overview</h5>
                </div>

                <div class="card-body">
                    <canvas id="leadChart"></canvas>
                </div>
            </div>
        </div>

    </div>

@if(auth()->user()->hasAnyRole(['admin', 'manager']))
    <div class="row g-3 mb-4">

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">Monthly Profit</h5>
                </div>

                <div class="card-body">
                    <canvas id="profitChart" height="150"></canvas>
                </div>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-header bg-white border-0 pt-3">
                    <h5 class="fw-bold">Sales Cost vs Revenue</h5>
                </div>

                <div class="card-body">
                    <canvas id="salesChart" height="150"></canvas>
                </div>
            </div>
        </div>

    </div>
    @endif

</div>


{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    const monthLabels = @json($monthLabels);

    const monthlyRevenue = @json($monthlyRevenue);
    const monthlyCost = @json($monthlyCost);
    const monthlyProfits = @json($monthlyProfits);

    const leadData = @json($leadsState);

    const yearRevenue = @json($yearRevenueTotal);
    const yearCost = @json($yearCostTotal);


    // Monthly Revenue & Cost
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',

        data: {
            labels: monthLabels,

            datasets: [
                {
                    label: 'Revenue',
                    data: monthlyRevenue,
                    backgroundColor: '#0d6efd'
                },
                {
                    label: 'Cost',
                    data: monthlyCost,
                    backgroundColor: '#ffc107'
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });


    // Leads Overview
    new Chart(document.getElementById('leadChart'), {
        type: 'doughnut',

        data: {
            labels: ['New', 'Contacted', 'Qualified', 'Converted', 'Lost'],

            datasets: [{
                data: leadData,

                backgroundColor: [
                    '#0d6efd',
                    '#0dcaf0',
                    '#ffc107',
                    '#198754',
                    '#dc3545'
                ]
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });


    // Monthly Profit
    new Chart(document.getElementById('profitChart'), {
        type: 'line',

        data: {
            labels: monthLabels,

            datasets: [{
                label: 'Profit',
                data: monthlyProfits,
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });


    // Sales Cost vs Revenue
    new Chart(document.getElementById('salesChart'), {
        type: 'doughnut',

        data: {
            labels: ['Revenue', 'Cost'],

            datasets: [{
                data: [yearRevenue, yearCost],

                backgroundColor: [
                    '#198754',
                    '#ffc107'
                ]
            }]
        },

        options: {
            responsive: true,
            maintainAspectRatio: true
        }
    });

</script>

@endsection
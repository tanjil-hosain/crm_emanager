
@extends('crm_emanager.backend.layout.master')
@section('content')
<style>
    .invoice {
        max-width: 850px;
        margin: auto;
        background: #fff;
        padding: 30px;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid #333;
        padding-bottom: 20px;
    }

    .invoice-header h2,
    .invoice-header h3 {
        margin-bottom: 8px;
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 25px;
    }

    .invoice th,
    .invoice td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: left;
    }

    .invoice th {
        background: #f2f2f2;
    }

    .summary {
        width: 350px;
        max-width: 100%;
        margin-left: auto;
        margin-top: 25px;
    }

    .summary div {
        display: flex;
        justify-content: space-between;
        padding: 7px 0;
    }

    .print-btn {
        padding: 10px 20px;
        background: #198754;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 20px;
    }

    .invoice-footer {
        text-align: center;
        margin-top: 60px;
    }

    @media print {

        body * {
            visibility: hidden !important;
        }

        #invoice-content,
        #invoice-content * {
            visibility: visible !important;
        }

        #invoice-content {
            position: absolute !important;
            left: 0 !important;
            top: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #fff !important;
        }

        .print-btn,
        .d-print-none {
            display: none !important;
        }

        .invoice {
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .invoice th {
            background: #eee !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .invoice table {
            page-break-inside: auto;
        }

        .invoice tr {
            page-break-inside: avoid;
        }

        @page {
            size: A4;
            margin: 10mm;
        }
    }
</style>

<div class="container-fluid py-4">

    <div id="invoice-content">

        <div class="invoice">

            {{-- Print Button --}}
            <div class="d-print-none">
                <a href="{{ route('sales.show', $sale->id) }}"
                   class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>

                <button class="print-btn"
                        onclick="window.print()">
                    <i class="bi bi-printer"></i> Print Invoice
                </button>
            </div>

            {{-- Invoice Header --}}
            <div class="invoice-header">

                <div>
                    @if ($setting && $setting->logo)
                        <img src="{{ Storage::url($setting->logo) }}"
                             alt="Company Logo"
                             width="200"
                             height="60"
                             style="object-fit: contain;">
                    @else
                        <h2 class="fw-bold">
                            {{ $setting->site_name ?? config('app.name') }}
                        </h2>
                    @endif

                    <p class="text-muted mb-0">Sales Invoice</p>
                </div>

                <div class="text-end">
                    <h3>INVOICE</h3>

                    <strong>{{ $sale->invoice_number }}</strong>

                    <p class="mb-0">
                        {{ \Carbon\Carbon::parse($sale->sold_at)->format('d M Y') }}
                    </p>
                </div>

            </div>

            {{-- Customer Information --}}
            <div class="mt-4 mb-4">

                <h5 class="fw-bold">Bill To:</h5>

                <p class="mb-1">
                    <strong>{{ $sale->customer->name ?? 'N/A' }}</strong>
                </p>

                <p class="mb-1">
                    {{ $sale->customer->phone ?? '' }}
                </p>

                <p class="mb-0">
                    {{ $sale->customer->address ?? '' }}
                </p>

            </div>

            {{-- Product Table --}}
            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach ($sale->saleItems as $key => $item)

                            <tr>
                                <td>{{ $key + 1 }}</td>

                                <td>
                                    {{ $item->product->name ?? 'N/A' }}
                                </td>

                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <td>
                                    {{ number_format($item->unit_price, 2) }}
                                </td>

                                <td>
                                    {{ number_format($item->subtotal, 2) }}
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- Payment Summary --}}
            <div class="summary">

                <div>
                    <strong>Discount:</strong>
                    <span>{{ number_format($sale->discount, 2) }}</span>
                </div>

                <div>
                    <strong>Tax:</strong>
                    <span>{{ number_format($sale->tax, 2) }}</span>
                </div>

                <hr>

                <div>
                    <strong>Grand Total:</strong>
                    <strong>
                        {{ number_format($sale->total_amount, 2) }}
                    </strong>
                </div>

                <div class="text-success">
                    <strong>Paid Amount:</strong>
                    <strong>
                        {{ number_format($paidAmount, 2) }}
                    </strong>
                </div>

                <div class="text-danger">
                    <strong>Due Amount:</strong>
                    <strong>
                        {{ number_format($dueAmount, 2) }}
                    </strong>
                </div>

            </div>

            {{-- Notes --}}
            @if ($sale->notes)

                <div class="mt-4">
                    <strong>Notes:</strong>
                    <p>{{ $sale->notes }}</p>
                </div>

            @endif

            {{-- Invoice Footer --}}
            <div class="invoice-footer">

                <p>Thank you for your business!</p>

                <br><br>

                <p>_______________________</p>

                <p>Authorized Signature</p>

            </div>

        </div>

    </div>

</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Load #{{ $invoice->load_number }} (Inv #{{ $invoice->invoice_number }})</title>

    <style>
        @page {
            size: A4;
            margin: 20px;
        }
		* {
			page-break-before: avoid;
			page-break-after: avoid;
			page-break-inside: avoid;
		}
        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }
        a {
            text-decoration: none;
            color: inherit;
        }

        .invoice-content {
            width: 100%;
        }

        .logo {
            width: 200px;
            margin-bottom: 15px;
        }

        .header-section, .bill-to, .shipper-block, .consignee-block, .rates-block, .bank-block, .footer-block {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        .header-table, .info-table, .rates-table {
            width: 100%;
            border-collapse: collapse;
        }
        .header-table td, .info-table td, .rates-table td {
            padding: 5px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .section-title {
            font-size: 16px;
            color: #399f07;
            font-weight: 500;
            margin-bottom: 5px;
        }
        .sub-title {
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .detail-box {
            border: 1px solid #cccc;
            background: #f7f7f7;
            padding: 8px 15px;
            margin-bottom: 10px;
        }
        .detail-box p {
            margin: 3px 0;
            font-size: 12px;
        }

        .text-sm {
            font-size: 11px;
        }

        .footer-block {
            text-align: center;
            font-size: 11px;
        }
            /* Watermark */
    #invoice_wrapper {
        position: relative;
        z-index: 5;
    }

    #invoice_wrapper::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 800px;
        height: 800px;
        background: url('https://cargoconvoy.co/wp-content/uploads/2026/02/cargo.png') no-repeat center;
        background-size: contain;
        opacity: 0.1;
        /* control watermark lightness */
        transform: translate(-50%, -50%);
        z-index: 0;
        pointer-events: none;
    }

    /* Keep content above watermark */
    #invoice_wrapper>* {
        position: relative;
        z-index: 2;
    }
    </style>
</head>

<body>
    <div class="invoice-content">
        <div class="header-section">
            <img src="{{ asset('public/images/invoice-logo.png') }}" alt="Logo" class="logo">
            <div style="float: right; width: 48%;">
                <h2 class="section-title">Invoice</h2>
                <table class="header-table">
                    <tr>
                        <td><b>Load Number:</b> #{{ $invoice->load_number }}</td>
                        <td><b>Invoice Number:</b> {{ $invoice->invoice_number }}</td>
                    </tr>
                    <tr>
                        <td><b>Invoice Date:</b> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('m-d-Y') }}</td>
                        <td><b>Terms:</b> {{ $invoice->invoicing_payment_terms ?? 'Net 30' }}</td>
                    </tr>
                    <tr>
                        <td><b>W/O:</b> {{ $invoice->load_workorder }}</td>
                        <td><b>C.r/f #:</b> {{ $invoice->customer_refrence_number }}</td>
                    </tr>
                </table>
            </div>
            <div style="clear: both;"></div>
        </div>

        <div class="bill-to">
            <div class="sub-title">Bill To</div>
            <p>{{ $invoice->load_bill_to }}</p>
            <p class="text-sm">
                {{ $invoice->customer_address }}<br>
                {{ $invoice->customer_city }}, {{ $invoice->customer_state }} {{ preg_replace('/^\d+\s*/', '', $invoice->customer_country) }}, {{ $invoice->customer_zip }}
            </p>
        </div>

        {{-- Shipper Section --}}
        @php
            $counter = 1;
            $shippers = json_decode($invoice->load_shipperr, true);
            $ship_qty = json_decode($invoice->load_shipper_qty, true);
            $ship_wt = json_decode($invoice->load_shipper_weight, true);
            $ship_type = json_decode($invoice->load_shipper_commodity_type, true);
            $ship_po = json_decode($invoice->load_shipper_po_numbers, true);
            $ship_appt = json_decode($invoice->load_shipper_appointment, true);
            $ship_loc = json_decode($invoice->load_shipper_location, true);
        @endphp

        @foreach ($shippers as $key => $shp)
        <div class="shipper-block">
            <div class="sub-title">Shipper {{ $counter++ }}</div>
            <div class="detail-box">
                <p><b>Shipper Name:</b> {{ $shp['name'] ?? '' }}</p>
                <p><b>Type:</b> {{ $ship_type[$key]['commodity_type'] ?? '' }}</p>
                <p><b>PO Number:</b> {{ $ship_po[$key]['shipping_po_numbers'] ?? '' }}</p>
                <p><b>Address:</b> {{ $ship_loc[$key]['location'] ?? '' }}</p>
                <p><b>Quantity:</b> {{ $ship_qty[$key]['shipper_qty'] ?? '' }}</p>
                <p><b>Date:</b> {{ isset($ship_appt[$key]['appointment']) ? \Carbon\Carbon::parse($ship_appt[$key]['appointment'])->format('m-d-Y') : '' }}</p>
                <p><b>Weight:</b> {{ $ship_wt[$key]['shipper_weight'] ?? '' }} lbs</p>
            </div>
        </div>
        @endforeach

        {{-- Consignee Section --}}
        @php
            $counter2 = 1;
            $cons = json_decode($invoice->load_consignee, true);
            $con_qty = json_decode($invoice->load_consignee_qty, true);
            $con_wt = json_decode($invoice->load_consignee_weight, true);
            $con_type = json_decode($invoice->load_consignee_type, true);
            $con_po = json_decode($invoice->load_consignee_po_numbers, true);
            $con_appt = json_decode($invoice->load_consignee_appointment, true);
            $con_loc = json_decode($invoice->load_consignee_location, true);
        @endphp

        @foreach ($cons as $k => $c)
        <div class="consignee-block">
            <div class="sub-title">Consignee {{ $counter2++ }}</div>
            <div class="detail-box">
                <p><b>Consignee Name:</b> {{ $c['name'] ?? '' }}</p>
                <p><b>Type:</b> {{ $con_type[$k]['consignee_type'] ?? '' }}</p>
                <p><b>PO Number:</b> {{ $con_po[$k]['consignee_po_number'] ?? '' }}</p>
                <p><b>Address:</b> {{ $con_loc[$k]['location'] ?? '' }}</p>
                <p><b>Quantity:</b> {{ $con_qty[$k]['consignee_qty'] ?? '' }}</p>
                <p><b>Date:</b> {{ isset($con_appt[$k]['appointment']) ? \Carbon\Carbon::parse($con_appt[$k]['appointment'])->format('m-d-Y') : '' }}</p>
                <p><b>Weight:</b> {{ $con_wt[$k]['consignee_weight'] ?? '' }} lbs</p>
            </div>
        </div>
        @endforeach

        {{-- Rates & Charges --}}
        @php
            $otherCharges = json_decode($invoice->shipper_load_other_charge, true);
        @endphp
        <div class="rates-block">
            <div class="sub-title">Rates and Charges</div>
            <table class="rates-table">
                <tr>
                    <td>Line Haul</td>
                    <td>${{ $invoice->load_shipper_rate }}</td>
                </tr>
                <tr>
                    <td>FSC Rate</td>
                    <td>{{ $invoice->load_fsc_rate }}%</td>
                </tr>
                @if (!empty($otherCharges))
                    @foreach ($otherCharges as $chg)
                        @if (!empty($chg['type']) && !empty($chg['amount']))
                        <tr>
                            <td>{{ $chg['type'] }}</td>
                            <td>${{ $chg['amount'] }}</td>
                        </tr>
                        @endif
                    @endforeach
                @endif
                <tr>
                    <td><strong>Total Rate</strong></td>
                    <td><strong>${{ $invoice->shipper_load_final_rate }}</strong></td>
                </tr>
            </table>
        </div>

        {{-- Banking Info --}}
        <div class="bank-block">
            <div class="sub-title">Account Details</div>
            <p><b>Account Name:</b> Cargo Convoy Inc.</p>
            <p><b>Bank Name:</b> Chase Bank</p>
            <p><b>Account Number:</b> 672578880</p>
            <p><b>Bank Address:</b> 3604 West Chester Pike, Newtown Square, PA 19073, USA</p>
            <p><b>Type:</b> Checking</p>
            <p><b>Routing Number:</b> 083000137</p>
            <p><b>Wire Routing Number:</b> 021000021</p>
        </div>

        <div class="footer-block">
            <p><strong>Important Notice:</strong> Our banking information has changed — please update your records and send remittances to <strong>ar@cargoconvoy.co</strong>.</p>
            <p>If you have feedback or suggestions, email <strong>feedback@cargoconvoy.co</strong>.</p>
        </div>
    </div>
</body>
</html>

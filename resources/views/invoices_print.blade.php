<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Load #{{ $invoice->load_number }}(Inv #{{ $invoice->invoice_number }})</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .invoice-content {
        font-family: 'Poppins', sans-serif;
        color: #000;
        font-size: 14px;
    }

    .invoice-content a {
        text-decoration: none;
    }

    .invoice-content .img-fluid {
        max-width: 100% !important;
        height: auto;
    }

    .invoice-content .form-control:focus {
        box-shadow: none;
    }

    .invoice-content h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    .h1,
    .h2,
    .h3,
    .h4,
    .h5,
    .h6 {
        font-family: 'Poppins', sans-serif;
        color: #000;
    }


    /** BTN LG **/
    .btn-lg {
        font-size: 14px;
        height: 50px;
        padding: 0 30px;
        line-height: 50px;
        border-radius: 3px;
        color: #ffffff;
        border: none;
        margin: 0 3px 3px;
        display: inline-block;
        vertical-align: middle;
        -webkit-appearance: none;
        text-transform: capitalize;
        transition: all 0.3s linear;
        z-index: 1;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .btn-lg:hover {
        color: #ffffff;
    }

    .btn-lg:hover:after {
        transform: perspective(200px) scaleX(1.05) rotateX(0deg) translateZ(0);
        transition: transform 0.9s linear, transform 0.4s linear;
    }

    .btn-lg:after {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        content: "";
        transform: perspective(200px) scaleX(0.1) rotateX(90deg) translateZ(-10px);
        transform-origin: bottom center;
        transition: transform 0.9s linear, transform 0.4s linear;
        z-index: -1;
    }

    .btn-check:focus+.btn,
    .btn:focus {
        outline: 0;
        box-shadow: none;
    }


    .btn-download {
        background: #399f07;
    }

    .btn-download:after {
        background: #46ca04;
    }

    .btn-print {
        background: #3a3939;
    }

    .btn-print:after {
        background: #1d1c1c;
    }


    /** Invoice 2 Start **/
    .invoice-2 {
        padding: 30px 0;
    }

    .invoice-2 .mb-30 {
        margin-bottom: 13px;
    }

    .invoice-2 .invoice-info {
        background: #fff;
        position: relative;
    }

    .invoice-2 .name {
        font-size: 12px;
        margin-bottom: 4px;
        text-transform: uppercase;
        color: #262525;
        font-weight: 700;
    }

    .invoice-top h6 {
        font-size: 12px;
    }

    .invoice-2 .invoice-number-inner {
        max-width: 200px;
        margin-left: auto;
    }

    .invoice-2 .payment-method-list-1 {
        padding: 0;
    }

    .invoice-2 .item-desc-1 span {
        font-size: 14px;
        font-weight: 500;
    }

    .invoice-2 .payment-method ul {
        list-style: none;
    }

    .invoice-2 .payment-method ul li strong {
        font-weight: 500;
    }


    .invoice-2 .invoice-top {
        font-size: 15px;
    }

    p {
        font-size: 12px;
        margin: 3px 0;
    }

    td {
        padding: 2px 10px !important;
    }

    .invoice-top .detail {
        padding: 8px 22px;
        margin-bottom: 19px;
        border-radius: 7px;
        /* background: #f7f7f7; */
        border: 1px solid #cccc;
    }

    .invoice-top .detail b {
        margin-right: 11px;
    }

    .invoice-2 .inv-title-1 {
        color: #399f07;
        margin-bottom: 5px;
        font-weight: 500;
        font-size: 17px;
    }


    .invoice-2 img {
        width: 50%;
        margin-bottom: 17px;

    }

    .invoice-2 .invoice-id .info {
        max-width: 100%;
    }





    .invoice-2 .invoice-bottom {
        padding: 0 50px 10px;
    }


    .invoice-2 .invoice-contact {
        padding: 20px 0 20px;
        background-image: linear-gradient(to bottom, #a3ca40, #527200);
    }

    .invoice-2 .contact-info a {
        margin: 0 30px 10px 0;
        color: #fff;
        font-size: 14px;
        line-height: 50px;
    }

    .invoice-2 .contact-info a i {
        width: 50px;
        height: 50px;
        background: #ffffff;
        text-align: center;
        font-size: 20px;
        line-height: 50px;
        margin-right: 10px;
        color: #399f07;
        border-radius: 60px;
    }

    .invoice-2 .invoice-contact h3 {
        font-size: 20px;
    }

    .invoice-2 .contact-info .mr-0 {
        margin-right: 0;
    }

    .invoice-2 .inv-header-1 {
        font-weight: 600;
        color: #399f07;
        font-size: 18px;
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


    /** MEDIA **/
    @media (max-width: 992px) {}

    @media (max-width: 768px) {}

    @media (max-width: 580px) {}
</style>

<body>

    <!-- Invoice 2 start -->
    <div class="invoice-2 invoice-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-inner clearfix">
                        <div class="invoice-info clearfix" id="invoice_wrapper">
                            <div class="invoice-headar">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="logo">
                                            <img src="{{ asset('public/images/invoice-logo.png') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="invoice-id">
                                            <div class="info">
                                                <h1 class="inv-header-1">Invoice</h1>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td style="width:40%">
                                                            <p class="mb-1"><b>Load Number:</b> <span>#
                                                                    {{ $invoice->load_number }}</span></p>
                                                        </td>
                                                        <td style="width:60%">
                                                            <p class="mb-1"><b>Invoice Number:</b>
                                                                <span>{{ $invoice->invoice_number }}</span></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <p class="mb-0"><b>Invoice
                                                                    Date:</b><span>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('m-d-Y') }}</span>
                                                            </p>
                                                        </td>

                                                        <td style="width:60%">
                                                            <p class="mb-0">
                                                                <b>Terms:</b>
                                                                <span>
                                                                    {{ $invoice->adv_customer_payment_terms ?? $invoice->invoicing_payment_terms ?? 'Net30' }}

                                                                </span>
                                                            </p>
                                                        </td>


                                                    </tr>
                                                    <tr>
                                                        <td style="width:40%">
                                                            <p class="mb-0"><b>W/O:</b>
                                                                <span>{{ $invoice->load_workorder }}</span></p>
                                                        </td>
                                                        <td style="width:60%">
                                                            <p class="mb-0"><b> C.r/f
                                                                    #:</b><span>{{ $invoice->customer_refrence_number }}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-top">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="invoice-number mb-30">
                                            <h4 class="inv-title-1">Bill To</h4>
                                            <h2 class="name">{{ $invoice->load_bill_to }}</h2>
                                            <p class="invo-addr-1">
                                                {{ $invoice->customer_address }}<br>
                                                {{ $invoice->customer_city }},
                                                {{ $invoice->customer_state }}
                                                {{ preg_replace('/^\d+\s*/', '', $invoice->customer_country) }},
                                                {{ $invoice->customer_zip }}
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="invoice-top">

                                @php
                                $counter = 1;
                                $shipper = json_decode($invoice->load_shipperr, true);
                                $shipper_qty = json_decode($invoice->load_shipper_qty, true);
                                $shipper_weight = json_decode($invoice->load_shipper_weight, true);
                                $shipper_discription = json_decode($invoice->load_shipper_discription, true);
                                $shipper_type = json_decode($invoice->load_shipper_commodity_type, true);
                                $sipper_po_number = json_decode($invoice->load_shipper_po_numbers, true);
                                $shipper_appointment_date = json_decode($invoice->load_shipper_appointment, true);
                                $shipperLocation = json_decode($invoice->load_shipper_location, true);

                                @endphp

                                @foreach ($shipper as $key => $shipperInfo)
                                <div class="detail">
                                    <h3 class="inv-title-1 text-center">Shipper {{ $counter++ }}</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><b>Shipper Name:</b>
                                                {{ isset($shipperInfo['name']) ? $shipperInfo['name'] : '' }}</p>
                                            <p><b>Type:</b>
                                                {{ isset($shipper_type[$key]['commodity_type']) ? $shipper_type[$key]['commodity_type'] : '' }}
                                            </p>
                                            <!-- <p><b>Description:</b> {{ isset($shipper_discription[$key]['description']) ? $shipper_discription[$key]['description'] : '' }}</p> -->
                                            <p><b>PO Number:</b>
                                                {{ isset($sipper_po_number[$key]['shipping_po_numbers']) ? $sipper_po_number[$key]['shipping_po_numbers'] : '' }}
                                            </p>
                                            <p><b>Shipper Address:</b>
                                                {{ isset($shipperLocation[$key]['location']) ? $shipperLocation[$key]['location'] : 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><b>Quantity:</b>
                                                {{ isset($shipper_qty[$key]['shipper_qty']) ? $shipper_qty[$key]['shipper_qty'] : '' }}
                                            </p>
                                            <p><b>Date:</b>
                                                {{ isset($shipper_appointment_date[$key]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment_date[$key]['appointment'])->setTimezone('America/New_York')->format('m-d-Y') : '' }}
                                            </p>
                                            <p><b>Weight:</b>
                                                {{ isset($shipper_weight[$key]['shipper_weight']) ? $shipper_weight[$key]['shipper_weight'] : '' }}
                                                lbs</p>

                                        </div>
                                    </div>
                                </div>
                                @endforeach


                                @php
                                // Decode JSON strings for consignee details
                                $consignees = json_decode($invoice->load_consignee, true);
                                $consignees_qty = json_decode($invoice->load_consignee_qty, true);
                                $consignees_weight = json_decode($invoice->load_consignee_weight, true);
                                $consignees_delivery_notes = json_decode($invoice->load_consignee_delivery_notes, true);
                                $consignees_type = json_decode($invoice->load_consignee_type, true);
                                $load_consignee_po_numbers = json_decode($invoice->load_consignee_po_numbers, true);
                                $consignee_appointment = json_decode($invoice->load_consignee_appointment, true);
                                $consigneesLocation = json_decode($invoice->load_consignee_location, true);
                                $consigneeDescription = json_decode($invoice->load_consignee_discription, true) ?? [];

                                @endphp

                                @php
                                $counter = 1;
                                @endphp

                                @foreach ($consignees as $key => $consigneeName)
                                <div class="detail">
                                    <h3 class="inv-title-1 text-center">Consignee {{ $counter++ }}</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><b>Consignee Name:</b> {{ $consigneeName['name'] }}</p>
                                            <p><b>Type:</b>
                                                {{ isset($consignees_type[$key]['consignee_type']) ? $consignees_type[$key]['consignee_type'] : '' }}
                                            </p>
                                            <!-- <p><b>Description:</b> {{ isset($consigneeDescription[$key]['description']) ? $consigneeDescription[$key]['description'] : '' }}</p> -->
                                            <p><b>PO Number:</b>
                                                {{ isset($load_consignee_po_numbers[$key]['consignee_po_number']) ? $load_consignee_po_numbers[$key]['consignee_po_number'] : '' }}
                                            </p>
                                            <p><b>Consignee Address:</b>
                                                {{ isset($consigneesLocation[$key]['location']) ? $consigneesLocation[$key]['location'] : '' }}
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><b>Quantity:</b>
                                                {{ isset($consignees_qty[$key]['consignee_qty']) ? $consignees_qty[$key]['consignee_qty'] : '' }}
                                            </p>
                                            <p><b>Date:</b>
                                                {{ isset($consignee_appointment[$key]['appointment']) ? date('m-d-Y', strtotime($consignee_appointment[$key]['appointment'])) : '' }}
                                            </p>
                                            <p><b>Weight:</b>
                                                {{ isset($consignees_weight[$key]['consignee_weight']) ? $consignees_weight[$key]['consignee_weight'] : '' }}
                                                lbs</p>

                                        </div>
                                    </div>
                                </div>
                                @endforeach


                                @php
                                $otherCharges = json_decode($invoice->shipper_load_other_charge, true);

                                @endphp
                                <h6><b>RATES AND CHARGES</b></h6>
                                <div class="col-sm-12">
                                    <div class="invoice-id">
                                        <div class="info">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <td style="width:80%">
                                                        <p class="mb-1"><b>Line Haul</b></span></p>
                                                    </td>
                                                    <td style="width:20%">
                                                        <p class="mb-1"><b>${{ $invoice->load_shipper_rate }}</b>
                                                            </span></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width:80%">
                                                        <p class="mb-1"><b>FSC Rate</b></span></p>
                                                    </td>
                                                    <td style="width:20%">
                                                        <p class="mb-1"><b>{{ $invoice->load_fsc_rate }}%</b> </span>
                                                        </p>
                                                    </td>
                                                </tr>

                                                @if (!empty($otherCharges))
                                                @php $srNo = 1; @endphp
                                                @foreach ($otherCharges as $charge)

                                                <tr>
                                                    <td style="width:80%">
                                                        <p class="mb-1"><b>{{ $charge['type'] }}</b></span></p>
                                                    </td>
                                                    <td style="width:20%">
                                                        <p class="mb-1"><b>{{$charge['amount'] }}</b> </span></p>
                                                    </td>
                                                </tr>

                                                @endforeach
                                                @endif
                                                <tr>
                                                    <td style="width:80%">
                                                        <p class="mb-1"><b>Total Rate</b></span></p>
                                                    </td>
                                                    <td style="width:20%">
                                                        <p class="mb-1"><b>${{ $invoice->shipper_load_final_rate }}</b>
                                                            </span></p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr style="margin: 5px 0">

                                <div class="d-flex justify-content-between">
                                    <p class="m-0"><span style="color:red;">*</span><span
                                            style="color:red;margin-right: 10px;">*</span><strong>Important
                                            Notice:</strong> Our banking information has been updated. Please update
                                        your records with the new details below and share all the payment remittances at
                                        <strong> ar@cargoconvoy.co</strong></p>

                                </div>
                            </div>
                            <div class="payment-method mb-30" style=" padding-top: 20px;">
                                <h3 class="inv-title-1">Account Details:</h3>
                                <p class="m-1"><strong>Account Name:</strong> Cargo Convoy Inc.</p>
                                <p class="m-1"><strong>Bank Name:</strong> Chase Bank</p>
                                <p class="m-1"><strong>Account Number:</strong> 672578880</p>
                                <p class="m-1"><strong>Bank Address:</strong> 3604 West Chester Pike, Newtown Square, PA
                                    19073, United States</p>
                                <p class="m-1"><strong>Type:</strong> Checking</p>
                                <p class="m-1"><strong>Routing Number:</strong> 083000137</p>
                                <p class="m-1"><strong>For Wire transfer: </strong>Use Routing Number: 021000021</p>
                            </div>
                            <p class="text-left" style="padding-bottom: 28px !important;"><strong>Your insights and
                                experiences are invaluable to us. If you have any feedback, suggestions, or concerns,
                                please don’t hesitate to reach out to us at <a href="#">feedback@cargoconvoy.co</strong></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Invoice 2 end -->
</body>

</html>
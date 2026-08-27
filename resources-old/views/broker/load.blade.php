@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
    ul#navTabs,
    ul#navTabs1 {
        background: #a6ce3a;
        padding: 10px;
        margin-bottom: 10px;
    }

    button.close.close-modal-btn {
        background: red;
        color: #fff;
        border: navajowhite;
        border-radius: 10px;
        padding: 0px 10px;
    }
#mc-success-message{
    padding: 10px;
    background-color: rgb(212, 237, 218);
    color: rgb(21, 87, 36);
    margin-bottom: 10px;
    border: 1px solid rgb(195, 230, 203);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}

#mc-error-message{
    padding: 10px;
    background-color: rgb(243, 118, 129);
    color: rgb(87, 21, 26);
    margin-bottom: 10px;
    border: 1px solid rgb(243, 118, 129);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}
</style>

<div id="mc-success-message" style="display: none;"></div>
<div id="mc-error-message" style="display: none;"></div>

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Load</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Load</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">Load</h4>

                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#all" role="tab"
                                    aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">All</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#open" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Open</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#delivered" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Delivered</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#complete" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Complete</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#invoice" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Invoice</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#paid" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Invoice / Paid</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active show" id="all" role="tabpanel">

                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>

                                <table id="datatable-buttons-all"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>Agent Name</th>
                                            <th>W/O #</th>
                                            <th>Customer Refrence #</th>
                                            <th>Customer Name</th>
                                            <th>Load Creation Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Actual Del Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>Aging</th>
                                            <th>CPR Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="all_search">
                                        @include('broker.loads.all_loads')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $all_load->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="open" role="tabpanel">
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>
                                <table id="datatable-buttons-open"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>W/O #</th>
                                            <th>Customer Refrence #</th>
                                            <th>Customer #</th>
                                            <th>Load Create Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>CPR Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>


                                    <tbody id="open_search">

                                        @include('broker.loads.open')

                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $open->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="delivered" role="tabpanel">
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>
                                <table id="datatable-buttons-delivered"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>W/O #</th>
                                            <th>Customer Refrence #</th>
                                            <th>Customer #</th>
                                            <th>Load Create Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Actual Del Date</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>CPR Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="delivered_search">
                                        @include('broker.loads.delivered')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $delivered->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="complete" role="tabpanel">
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>
                                <table id="datatable-buttons-complete"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>W/O #</th>
                                            <th>Customer #</th>
                                            <th>Load Create Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Actual Del Date</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>Aging</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="complete_search">
                                        @include('broker.loads.complete')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $complete->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="invoice" role="tabpanel">
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>
                                <table id="datatable-buttons-invoice"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>W/O #</th>
                                            <th>Customer #</th>
                                            <th>Load Create Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Actual Del Date</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>Aging</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="invoice_search">
                                        @include('broker.loads.invoice')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $invoice->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="paid" role="tabpanel">
                                <div class="my-4">
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Load</button>
                                </div>
                                <table id="datatable-buttons-paid"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>W/O #</th>
                                            <th>Customer #</th>
                                            <th>Load Create Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Actual Del Date</th>
                                            <th>Load Status</th>
                                            <th>Cus Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Aging</th>
                                            <th>Margin</th>
                                            <th>Margin %</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>


                                    <tbody id="paid_search">
                                        @include('broker.loads.invoice_paid')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $invoice_paid->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- End Page-content -->



    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width:90% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('load.create') }}" id="myFormLoad"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title"
                                style="font-size: 18px;text-align: left;font-weight: 700;margin-left: 0;">Add Load</h3>
                        </div>
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Load Number
                                        </label>
                                        <input class="form-control" name="load_number"
                                            title="Load number generated automatically" disabled style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Bill To <code>*</code></label>
                                        <select id="load_bill_to" class="form-control mySelect2" name="load_bill_to">
                                            <option value="">Select Customer</option>
                                            @foreach($customer as $cust)
                                            <option value="{{$cust->id}}">{{$cust->customer_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Dispatcher <code>*</code></label>
                                        @php
                                        $adminUserData = session('user', []);

                                        @endphp
                                        <input class="form-control" name="load_dispatcher" value="" required readonly
                                            style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="form-control" name="load_status" id="load_status" value="Open"
                                            readonly style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>W/O # </label>
                                        <input class="form-control" name="load_workorder" style="width: 100%;"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Customer r/f# </label>
                                        <input class="form-control" name="customer_refrence_number" style="width: 100%;"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Payment Type
                                            <code>*</code></label>
                                        <select class="form-control" required name="load_payment_type"
                                            style="width: 100%;">
                                            <option value="">Select Status</option>
                                            <option>Prepaid</option>
                                            <option>Postpaid</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Load type<code>*</code></label>
                                        <div class="purple">
                                            <select class="form-control" required name="load_type_two"
                                                style="width: 100%;">
                                                <option value="">
                                                    Select Status
                                                </option>
                                                <option>OTR</option>
                                                <option>DRAYAGE</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Shipment Type<code>*</code></label>
                                        <select class="form-control" required name="load_type" style="width: 100%;">
                                            <option value="">Select Shipment Type</option>
                                            @foreach($shipmentType as $shipment)
                                            <option value="{{$shipment->id}}">{{$shipment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group" id="shipper_rate_div">
                                        <label>Shipper Rate
                                            <code>*</code></label>
                                        <input type="number" class="form-control number value" name="load_shipper_rate"
                                            autocomplete="off" id="load_shipper_rate" required readonly style="width: 100%;">
                                        <!-- <input type="text" class="form-control number value" id="load_shipper_rate" name="load_shipper_rate"> -->
                                        <span id="error_load_shipper_rate"
                                            style="color: red; font-size: 9px !important; display: none;">Only numbers
                                            and decimals allowed</span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>F.S.C Rate % <input hidden type="checkbox"
                                                name="calculate_fsc_percentage" id="calculate_fsc_percentage"></label>
                                        <input class="form-control number percent" name="load_fsc_rate"
                                            autocomplete="off" id="load_fsc_rate" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label class="other_charge d-flex">Customer Other Charges &nbsp; <i
                                                class="fa fa-plus" style="color: #0c7ce6;" data-toggle="modal"
                                                data-target="#myModal" id="load_shipper_other_charges"></i>
                                        </label>
                                        <input id="totalChargeAmount" class="form-control number percent"
                                            style="width: 100%;" readonly>
                                    </div>

                                    <div class="modal close_shipper_other_charges_form p-0" id="myModal">
                                        <div class="modal-dialog" style="max-width: 700px;">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="card-header"
                                                        style="font-size: 17px;text-align: left;font-weight: 700;">
                                                        Customer Other Charges</h4>
                                                    <button type="button" class="close close-modal-btn"
                                                        style="font-size: 23px;top: 30px;">&times;</button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="modal-body pt-0">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="shipperchargeType"> Charge Type:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="shipperchargeType[]"
                                                                        placeholder="Enter Charge Type">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label> Amount:</label>
                                                                    <input type="number" class="form-control"
                                                                        name="shipperchargeAmount[]"
                                                                        placeholder="Enter Amount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" style="margin-top: 27px;">
                                                                <a type="button" class="remove-charge"
                                                                    name="shipperchargeAmountdelete[]">
                                                                    <i class="fa fa-trash"
                                                                        style="color:red;margin-top: 19px;"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="row" id="chargeRowTemplate" style="display: none;">
                                                            <div class="col-md-6" style="margin-top:20px;">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="shipperchargeType[]"
                                                                        placeholder="Enter Charge Type">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5" style="margin-top:20px;">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control"
                                                                        name="shipperchargeAmount[]"
                                                                        placeholder="Enter Amount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" style="margin-top: 17px;">
                                                                <a type="button" class="remove-charge"
                                                                    name="shipperchargeAmountdelete[]">
                                                                    <i class="fa fa-trash"
                                                                        style="color:red;margin-top: 19px;"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center mb-2 mt-2">
                                                    <button type="button" class="btn btn-success" id="addChargeBtn">Add
                                                        More Charges</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Final Shipper Rate <code>*</code></label>
                                        <input type="text" class="readonly form-control" name="shipper_load_final_rate"
                                            autocomplete="off" id="shipper_load_final_rate"
                                            style="background-color:#e9ecef;" required/>
                                        <p id="creditlimitcheck"></p>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier <code>*</code></label>
                                        <input type="text" id="load_carrier" name="load_carrier" class="form-control"
                                            style="width: 100%;" autocomplete="off" placeholder="Select carrier">
                                        <input type="text" hidden name="carrier_id" id="carrier_id">
                                        <!-- Dropdown to show the carrier suggestions -->
                                        <ul id="carrier-list" class="list-group"
                                            style="position: absolute; z-index: 1000; width: 100%; display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>MC No <code>*</code></label>
                                        <input class="form-control" required name="load_mc_no" id="carrier_mc_ff_input"
                                            style="width: 100%;" placeholder="Enter MC Number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>DOT No</label>
                                        <input class="form-control" name="carrier_dot" id="carrier_dot"
                                            style="width: 100%;" placeholder="Enter DOT Number" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Phone<code>*</code></label>
                                        <input type="text" id="load_carrier_phone" name="load_carrier_phone"
                                            class="form-control" style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Advance Payment</label>
                                        <input type="number" class="form-control" name="load_advance_payment"
                                            autocomplete="off" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Billing Type</label>
                                        <select class="form-control" name="load_billing_type" style="width: 100%;">
                                            <option selected="selected">Select
                                                Billing
                                            </option>
                                            <option>Factoring</option>
                                            <option>Direct Billing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Fee
                                            <code>*</code></label>
                                        <!-- <input class="form-control" type="number" name="load_carrier_fee"
                                    id="load_carrier_fee" required style="width: 100%;"> -->
                                        <input type="text" class="form-control" id="load_carrier_fee"
                                            name="load_carrier_fee" required autocomplete="off">
                                        <span id="error_load_carrier_fee"
                                            style="color: red;font-size: 9px !important; display: none;">Only numbers
                                            and decimals allowed</span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>FSC Rate %</label>
                                        <input type="number" name="load_billing_fsc_rate" id="load_billing_fsc_rate"
                                            class="form-control" autocomplete="off" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label class="other_charge">Carrier Other Charges <i class="fa fa-plus"
                                                style="color: #0c7ce6;" id="load_other_charges" data-toggle="modal"
                                                data-target="#otherChargesModal"></i></label>
                                        <input class="form-control" type="number" readonly name="load_other_charge"
                                            style="width: 100%;">
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal" id="otherChargesModal">
                                        <div class="modal-dialog" style="max-width: 700px;">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 style="font-size: 17px;text-align: left;font-weight: 700;">
                                                        Carrier Other Charges</h4>
                                                    <button type="button" class="close close-modal-btn"
                                                        style="font-size: 23px;top: 30px;">&times;</button>
                                                </div>
                                                <div class="modal-body pt-0">
                                                    <div id="inputs">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="shipperchargeType">Charge Type:</label>
                                                                    <input class="w-100 form-control" type="text"
                                                                        name="shipper_type_charge[]"
                                                                        placeholder="Enter Charges Type">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group">
                                                                    <label>Amount:</label>
                                                                    <input class="w-100 form-control" type="number"
                                                                        name="shipper_other_charge[]"
                                                                        placeholder="Enter Amount" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1" style="margin-top: 27px;">
                                                                <button type="button"
                                                                    style="color:red;border: none;background: unset;"
                                                                    class="remove-charge"
                                                                    name="shipperchargeAmountdelete[]">
                                                                    <i class="fa fa-trash"
                                                                        style="color:red;margin-top: 19px;"
                                                                        aria-hidden="true"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="text-center mb-2 mt-2">
                                                        <button class='create-input btn btn-success'>Add More
                                                            Charges</button>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Final Carrier Fee</label>
                                        <input class="form-control" readonly name="load_final_carrier_fee"
                                            id="load_final_carrier_fee" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select class="form-control" name="load_currency" style="width: 100%;">
                                            <option selected="selected">Select
                                                Currency
                                            </option>
                                            <option>$</option>
                                            <option>CAD</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Equipment Type
                                            <code>*</code></label>
                                        <select class="form-control mySelect2" name="load_equipment_type"
                                            id="load_equipment_type" style="width: 100%;" required>

                                            <option value="">Select Equipment </option>
                                            @foreach($equipmentType as $equipment)
                                            <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title"
                                style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Shipper <i id="addBtn" class="fa fa-plus"></i></h3>
                        </div>
                        <div class="card-body" id="shipperForms">
                            <ul class="nav nav-tabs" id="navTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#shipperForm1" role="tab"
                                        aria-controls="shipperForm1" aria-selected="true">Shipper 1</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tabContent">
                                <div class="tab-pane fade show active" id="shipperForm1" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="row shipper-form">
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipper <code>*</code>
                                                    <!-- <a href="" target="blank" style="background: none; border: none;">
                                                        <i class="fa fa-plus"></i>Add New
                                                    </a> -->
                                                </label>
                                                <input class="form-control" name="load_shipper" id="load_shipper"
                                                    required autocomplete="off" style="width: 100%;">
                                                <span class="customerErrorMessage"
                                                    style="color: red; display: none;">Select Shipper From the
                                                    List</span>
                                                <div id="shipperList" class="form-control" style="display: none;"
                                                    readonly></div>

                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipper Location</label>
                                                <input class="form-control" readonly name="load_shipper_location"
                                                    id="load_shipper_location" autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Appointment</label>
                                                <input class="form-control" type="datetime-local"
                                                    name="load_shipper_appointment" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input class="form-control" name="load_shipper_description"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Type</label>
                                                <input class="form-control" name="load_shipper_commodity_type"
                                                    style="width: 100%;" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Name <code>*</code></label>
                                                <input class="form-control" id="load_shipper_commodity"
                                                    name="load_shipper_commodity" autocomplete="off" type="text"
                                                    required style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input type="number" class="form-control" autocomplete="off"
                                                    name="load_shipper_qty" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                <input class="form-control" type="number" autocomplete="off"
                                                    name="load_shipper_weight" id="load_shipper_weight"
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                <input type="number" class="form-control" id="load_shipper_value"
                                                    autocomplete="off" name="load_shipper_value" required
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipping Notes</label>
                                                <input class="form-control" name="load_shipper_shipping_notes"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>PO Numbers</label>
                                                <input class="form-control" name="load_shipper_po_numbers"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input class="form-control" type="number" autocomplete="off"
                                                    name="load_shipper_contact" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header pb-0">
                            <h3 class="card-title"
                                style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Consignee <i id="addBtnconsignee" class="fa fa-plus"></i>
                            </h3>
                        </div>
                        <div class="card-body1" id="consigneeSections">
                            <ul class="nav nav-tabs" id="navTabs1">
                                <li class="nav-item">
                                    <a class="nav-link active" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#consigneeSections1" role="tab"
                                        aria-controls="consigneeSections1" aria-selected="true">Consignee 1</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tabContent1">
                                <div class="tab-pane fade show active" id="consigneeSections1" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="consignee-section mt-3">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee <code>*</code>
                                                        <!-- <a href="" target="blank"
                                                            style="background: none; border: none; font-size:13px;">
                                                            <i class="fa fa-plus"></i>Add New
                                                        </a> -->
                                                    </label>
                                                    <input class="form-control" name="load_consignee" autocomplete="off"
                                                        id="load_consignee" required style="width: 100%;">
                                                    <span class="customerErrorMessage"
                                                        style="color: red; display: none;">Select Consignee From the
                                                        List</span>
                                                    <div id="consigneeList" class="form-control" style="display: none;"
                                                        readonly></div>

                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee Location</label>
                                                    <input class="form-control" name="load_consignee_location"
                                                        autocomplete="off" id="load_consignee_location"
                                                        style="width: 100%;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Appointment</label>
                                                    <input class="form-control" type="datetime-local"
                                                        name="load_consignee_appointment" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input class="form-control" autocomplete="off"
                                                        name="load_consignee_description" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Type </label>
                                                    <input class="form-control" name="load_consignee_type"
                                                        autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Name <code>*</code></label>
                                                    <input class="form-control" name="load_consignee_commodity"
                                                        id="load_consignee_commodity" autocomplete="off" type="text"
                                                        required style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="load_consignee_qty"
                                                        autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Weight (lbs)</label>
                                                    <input class="form-control" type="number" id="load_consignee_weight"
                                                        autocomplete="off" name="load_consignee_weight"
                                                        style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Value($)<code>*</code></label>
                                                    <input type="number" class="form-control"
                                                        name="load_consignee_value" autocomplete="off"
                                                        id="load_consignee_value" required style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee
                                                        Notes</label>
                                                    <textarea class="form-control" name="load_consignee_notes"
                                                        autocomplete="off"
                                                        style="width: 100%; height: 31px !important;font-size: 12px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>PO Numbers</label>
                                                    <input class="form-control" name="load_consignee_po_numbers"
                                                        autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Contact Number</label>
                                                    <input class="form-control" type="number" autocomplete="off"
                                                        name="load_consignee_contact" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info" value="Save">
                            <input type="button" style="font-size:14px !important;" class="btn btn-warning"
                                id="clearFormButton" Value="Clear Form">
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <script>

        $('#load_bill_to').on('change', function() {
            $('#load_shipper_rate').prop('readonly', false);
            $('#load_shipper_rate').val(0);
        });
        $(document).ready(function () {

            $('#load_shipper_other_charges').on('click', function () {
                $('#myModal').show();
            });

            $('#myModal .close-modal-btn').on('click', function () {
                $('#myModal').hide();
            });


        });


        $(document).ready(function () {

            $('#load_other_charges').on('click', function () {
                $('#otherChargesModal').show();
            });

            $('#otherChargesModal .close-modal-btn').on('click', function () {
                $('#otherChargesModal').hide();
            });


        });



        /*****************shipper************************/
        $(document).ready(function () {
            $('#addBtn').on('click', function (e) {
                e.preventDefault();

                const liCount = $('#navTabs li').length;
                const nextcount = liCount + 1;

                // 1. Add new tab
                const newTab = `
            <li class="nav-item" role="presentation">
                <a class="nav-link" style="padding: 1px 11px; border-radius: 10px;" 
                   id="formTab${nextcount}" data-bs-toggle="tab" href="#shipperForm${nextcount}" 
                   role="tab" aria-controls="shipperForm${nextcount}" aria-selected="false">
                   Shipper ${nextcount}
                </a>
            </li>
        `;
                $('#navTabs').append(newTab);

                // 2. Clone the first form and update IDs, names
                const newContent = $('#shipperForm1').clone();
                newContent.attr('id', `shipperForm${nextcount}`);
                newContent.attr('aria-labelledby', `formTab${nextcount}`);
                newContent.removeClass('show active'); // Ensure new tab pane is hidden by default

                // Update input field names and ids to prevent duplication
                newContent.find('input, select, textarea, div[id]').each(function () {
                    let name = $(this).attr('name');
                    let id = $(this).attr('id');
                    if (name) {
                        $(this).attr('name', name + '_' + nextcount);
                    }
                    if (id) {
                        $(this).attr('id', id + '_' + nextcount);
                    }
                });

                $('#tabContent').append(newContent);
            });
        });



        /*****************consignee************************/
        $(document).ready(function () {
            $('#addBtnconsignee').on('click', function (e) {
                e.preventDefault();

                const liCount = $('#navTabs1 li').length;
                const nextcounts = liCount + 1;

                // 1. Add new tab
                const newTab = `
                <li class="nav-item" role="presentation">
                    <a class="nav-link" style="padding: 1px 11px; border-radius: 10px;" 
                    id="formTab${nextcounts}" data-bs-toggle="tab" href="#consigneeSections${nextcounts}" 
                    role="tab" aria-controls="consigneeSections${nextcounts}" aria-selected="false">
                    Consignee ${nextcounts}
                    </a>
                </li>`;
                $('#navTabs1').append(newTab);

                // 2. Clone the first form and update IDs, names
                const newContent = $('#consigneeSections1').clone();
                newContent.attr('id', `consigneeSections${nextcounts}`);
                newContent.attr('aria-labelledby', `formTab${nextcounts}`);
                newContent.removeClass('show active'); // Ensure new tab pane is hidden by default

                // Update input field names and ids to prevent duplication
                newContent.find('input, select, textarea, div[id]').each(function () {
                    let name = $(this).attr('name');
                    let id = $(this).attr('id');
                    if (name) {
                        $(this).attr('name', name + '_' + nextcounts);
                    }
                    if (id) {
                        $(this).attr('id', id + '_' + nextcounts);
                    }
                });

                $('#tabContent1').append(newContent);
            });
        });
   
</script>
<script>

    $(document).ready(function () {
        $('#shipper_load_final_rate').on('keydown paste input', function (e) {
            e.preventDefault();
        });
    });


        $(document).ready(function () {
            function updateTotalshipper() {
                var total = 0;

                $('[name="shipperchargeAmount[]"]').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });

                var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
                total += loadShipperRate;

                var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
                total += (loadFscRate / 100) * loadShipperRate;

                $('#shipper_load_final_rate').val(total.toFixed(2));

                var customer_id = $('#load_bill_to').val();
                
                 $.ajax({
                        url: '{{ route('check.remaing.limit') }}',
                        method: 'GET',
                        data: {
                            customer_id: customer_id,
                            finalrate: total,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                          
                            if (response.success) {

                                 $('#mc-error-message').text(response.message).fadeIn();

                                // Hide after 10 seconds
                                setTimeout(function() {
                                    $('#mc-error-message').text('').fadeOut();
                                }, 2000); 
                               
                                 $('#shipper_load_final_rate').val(''); 
                            }
                               
                        },
                        
                    });

            }

            $(document).on('input', '[name="shipperchargeAmount[]"], #load_shipper_rate, #load_fsc_rate',
                function () {
                    updateTotalshipper();
                });

        });
    </script>
    <script>
        $(document).ready(function () {


            // Function to calculate and update the total amount
            function updateTotalcarrier() {

                var total = 0;

                // Iterate through each charge input box
                $('[name="inputBox2[]"], [name="shipper_other_charge[]"]').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });

                // Add load_carrier_fee to the total
                var loadCarrierFee = parseFloat($('#load_carrier_fee').val()) || 0;
                total += loadCarrierFee;

                // Get the billing FSC rate
                var billingFSCRate = parseFloat($('#load_billing_fsc_rate').val()) || 0;

                // Calculate the percentage of load_carrier_fee based on billing FSC rate
                var fscAmount = (loadCarrierFee * billingFSCRate) / 100;

                // Add the calculated FSC amount to the total
                total += fscAmount;

                // Set the sum in load_final_carrier_fee
                $('#load_final_carrier_fee').val(total.toFixed(2));
                
            }

            // Handle input changes to update the total
            $(document).on('input',
                '[name="inputBox2[]"], [name="shipper_other_charge[]"], #load_carrier_fee, #load_billing_fsc_rate',
                function () {
                   
                    updateTotalcarrier();
                });
        });
</script>
<script>
    $(document).ready(function () {
    // Function to fetch carrier suggestions based on any input (name, MC number, DOT number)
    function fetchCarrierSuggestions(field, inputValue) {
        $.ajax({
            url: '{{ route('fetch.carrier.suggestions') }}',
            method: 'POST',
            data: {
                field: field,          // Specify the field (name, MC, DOT)
                inputValue: inputValue, // User input
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                let carrierList = $('#carrier-list');
                carrierList.empty(); 

                if (response.length > 0) {
                    response.forEach(function (carrier) {
                        carrierList.append('<li class="list-group-item carrier-item" data-id="' + carrier.id + '">' + carrier.carrier_name + ' - MC: ' + carrier.mcNumber + ', DOT: ' + carrier.dotNumber + '</li>');
                    });
                    carrierList.show();
                } else {
                    carrierList.hide();
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching carrier suggestions: ", error);
            }
        });
    }


    // Function to fetch full carrier details once a carrier is selected
    function fetchCarrierDetails(carrierId) {
        $.ajax({
            url: '{{ route('fetch.carrier.details') }}',
            method: 'POST',
            data: {
                carrierId: carrierId, 
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                if (response) {
                    $('#carrier_id').val(response.id);
                    $('#load_carrier').val(response.carrier_name);
                    $('#carrier_mc_ff_input').val(response.mcNumber);
                    $('#carrier_dot').val(response.dotNumber);
                    $('#load_carrier_phone').val(response.phone);
                }
                $('#carrier-list').hide(); 
            },
            error: function (xhr, status, error) {
                console.error("Error fetching carrier details: ", error);
            }
        });
    }


    // Event handler for input fields to trigger carrier suggestions
    function handleInputChange() {
        let inputValue = $(this).val();
        let field = $(this).attr('id');

        if (inputValue.length >= 3) {
            fetchCarrierSuggestions(field, inputValue);
        } else {
            $('#carrier-list').hide();
        }
    }

    // Attach the event to all relevant fields (carrier name, MC number, DOT number)
    $('#load_carrier, #carrier_mc_ff_input, #carrier_dot').on('input', handleInputChange);

    // Handle selection of a carrier from the suggestion list
    $(document).on('click', '.carrier-item', function () {
        let carrierId = $(this).data('id');
        fetchCarrierDetails(carrierId); // Fetch the full carrier details
    });

    // Hide the suggestion list when clicking outside the input fields
    $(document).click(function (e) {
        if (!$(e.target).closest('#load_carrier, #carrier_mc_ff_input, #carrier_dot, #carrier-list').length) {
            $('#carrier-list').hide();
        }
    });
});
</script>

<script>
    $(document).ready(function() {
        function fetchShipperNames(query) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.shipper.details') }}",
                    method: "GET",
                    data: { query: query },
                    dataType: "json",
                    success: function(response) {
                        var html = '';
                        if (response.error) {
                            html = '<div class="item dropdown-item" style="border: none;padding: 4px 0;">' + response.error + '</div>';
                        } else {
                            response.forEach(function(shipper) {
                                html += '<div class="item dropdown-item" style="border: none;padding: 4px 0;" ' +
                                    'data-name="' + shipper.shipper_name + '" ' +
                                    'data-address="' + shipper.shipper_address + '" ' +
                                    'data-city="' + shipper.shipper_city + '" ' +
                                    'data-state="' + shipper.shipper_state + '" ' +
                                    'data-country="' + shipper.shipper_country + '" ' +
                                    'data-zip="' + shipper.shipper_zip + '">' +
                                    shipper.shipper_name + '</div>';
                            });
                        }
                        $('#shipperList').html(html).show();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#shipperList').html('').hide();
            }
        }

        $('#load_shipper').on('keyup', function() {
            var query = $(this).val();
            fetchShipperNames(query);

            // Clear the location field if shipper name is empty
            if (query.trim() === '') {
                $('#load_shipper_location').val('');
            }
        });

        // Listen for click event on shipper list items
        $(document).on('click', '#shipperList .item', function() {
            var selectedShipperName = $(this).data('name');
            var selectedShipperAddress = $(this).data('address');
            var selectedShipperCity = $(this).data('city');
            var selectedShipperState = $(this).data('state');
            var selectedShipperCountry = $(this).data('country');
            var selectedShipperZip = $(this).data('zip');

            // Extract only the country name from the 'selectedShipperCountry' attribute
            var countryParts = selectedShipperCountry.split(' ');
            var countryName = countryParts.slice(1).join(' ');

            // Format the full address as "address, city, state, zip, country"
            var fullAddress = selectedShipperAddress + ', ' + selectedShipperCity + ', ' +
                selectedShipperState + ', ' + selectedShipperZip + ', ' + countryName;

            $('#load_shipper').val(selectedShipperName);
            $('#load_shipper_location').val(fullAddress);
            $('#shipperList').html('').hide(); // Clear the list
        });

        // Hide the dropdown when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#shipperList, #load_shipper').length) {
                $('#shipperList').html('').hide();
            }
        });
    });
</script>

<script>
$(document).ready(function () {
        function fetchConsigneeNames(query) {
            if (query.trim() !== '') {
                $.ajax({
                    url: "{{ route('fetch.consignee.details') }}",
                    method: "GET",
                    data: {
                        query: query
                    },
                    dataType: "json",
                    success: function (response) {
                        var html = '';
                        response.forEach(function (consignee) {
                            html +=
                                '<div class="item dropdown-item" style="border: none;padding: 4px 0;" data-name="' +
                                consignee.consignee_name + '" data-address="' + consignee
                                .consignee_address + '" data-city="' + consignee
                                .consignee_city + '" data-state="' + consignee
                                .consignee_state + '" data-country="' + consignee
                                .consignee_country + '" data-zip="' + consignee
                                .consignee_zip + '">' + consignee.consignee_name + '</div>';
                        });
                        $('#consigneeList').html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#consigneeList').html('').hide();
            }
        }

        $('input[name="load_consignee"]').on('keyup', function () {
            var query = $(this).val();
            fetchConsigneeNames(query);

            // Clear the location field if consignee name is empty
            if (query.trim() === '') {
                $('input[name="load_consignee_location"]').val('');
            }
        });

        // Listen for click event on consignee list items
        $(document).on('click', '#consigneeList .item', function () {
            var selectedConsigneeName = $(this).data('name');
            var selectedConsigneeAddress = $(this).data('address');
            var selectedConsigneeCity = $(this).data('city');
            var selectedConsigneeState = $(this).data('state');
            var selectedConsigneeCountry = $(this).data('country');
            var selectedConsigneeZip = $(this).data('zip');

            // Extract only the country name from the 'selectedConsigneeCountry' attribute
            var countryParts = selectedConsigneeCountry.split(' ');
            var countryName = countryParts.slice(1).join(' ');

            var fullAddress = selectedConsigneeAddress + ', ' + selectedConsigneeCity + ', ' +
                selectedConsigneeState + ', ' + selectedConsigneeZip + ', ' + countryName;

            $('input[name="load_consignee"]').val(selectedConsigneeName);
            $('input[name="load_consignee_location"]').val(fullAddress);
            $('#consigneeList').html('').hide(); // Clear the list
        });


        // Hide the dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('#consigneeList, input[name="load_consignee"]').length) {
                $('#consigneeList').html('').hide();
            }
        });
    });
</script>
<script>
$(document).ready(function () {
    // Set initial ID for the search form (fallback)
    $('form.app-search .position-relative').attr('id', 'alls');

    let initializedTabs = {};

    function initializeTab(target) {
        let inputSelector = '';
        let ajaxUrl = '';
        let resultContainer = '';
        let tableSelector = '';

        if (target === '#all') {
            $('form.app-search .position-relative').attr('id', 'alls');
            inputSelector = '#alls input[name="query"]';
            ajaxUrl = '/broker_all_load';
            resultContainer = '#all_search';
            tableSelector = '#datatable-buttons-all';
        } else if (target === '#open') {
            $('form.app-search .position-relative').attr('id', 'opens');
            inputSelector = '#opens input[name="query"]';
            ajaxUrl = '/broker_open_load';
            resultContainer = '#open_search';
            tableSelector = '#datatable-buttons-open';
        } else if (target === '#delivered') {
            $('form.app-search .position-relative').attr('id', 'delivereds');
            inputSelector = '#delivereds input[name="query"]';
            ajaxUrl = '/broker_delivered_load';
            resultContainer = '#delivered_search';
            tableSelector = '#datatable-buttons-delivered';
        } else if (target === '#complete') {
            $('form.app-search .position-relative').attr('id', 'completes');
            inputSelector = '#completes input[name="query"]';
            ajaxUrl = '/broker_complete_load';
            resultContainer = '#complete_search';
            tableSelector = '#datatable-buttons-complete';
        } else if (target === '#invoice') {
            $('form.app-search .position-relative').attr('id', 'invoices');
            inputSelector = '#invoices input[name="query"]';
            ajaxUrl = '/broker_invoice_load';
            resultContainer = '#invoice_search';
            tableSelector = '#datatable-buttons-invoice';
        } else if (target === '#paid') {
            $('form.app-search .position-relative').attr('id', 'paids');
            inputSelector = '#paids input[name="query"]';
            ajaxUrl = '/broker_paid_load';
            resultContainer = '#paid_search';
            tableSelector = '#datatable-buttons-paid';
        } else {
            return; // Exit if it's not one of the expected tabs
        }

        $(inputSelector).on('keyup', function () {
            let query = $(this).val().trim();

            clearTimeout($.data(this, 'timer'));
            let wait = setTimeout(() => {
                if (query.length > 0) {
                    $('.loader-container').removeClass('hide');

                    $.ajax({
                        url: ajaxUrl,
                        type: 'GET',
                        data: { query: query },
                        success: function (response) {
                            if ($.fn.DataTable.isDataTable(tableSelector)) {
                                $(tableSelector).DataTable().destroy();
                            }

                            $(resultContainer).html(response);

                            $(tableSelector).DataTable({
                                responsive: true,
                                dom: 'Bfrtip',
                                buttons: ['copy', 'excel', 'pdf', 'colvis'],
                            });

                            $('.loader-container').addClass('hide');
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            $('.loader-container').addClass('hide');
                        }
                    });
                } else {
                    $(resultContainer).html('');
                }
            }, 300);

            $(this).data('timer', wait);
        });

        initializedTabs[target] = true;
    }

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        const target = $(e.target).attr("href");
        if (!initializedTabs[target]) {
            initializeTab(target);
        }
    });

    // --- Trigger initialization for default active tab on page load ---
    const activeTabLink = $('a[data-bs-toggle="tab"].active');
    if (activeTabLink.length > 0) {
        const activeTabTarget = activeTabLink.attr("href");
        initializeTab(activeTabTarget);
    }
});



$(document).ready(function() {
    const tables = {
        '#all': { selector: '#datatable-buttons-all', initialized: false },
        '#open': { selector: '#datatable-buttons-open', initialized: false },
        '#delivered': { selector: '#datatable-buttons-delivered', initialized: false },
        '#complete': { selector: '#datatable-buttons-complete', initialized: false },
        '#invoice': { selector: '#datatable-buttons-invoice', initialized: false },
        '#paid': { selector: '#datatable-buttons-paid', initialized: false }
    };

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
        const target = $(e.target).attr('href');
        if (tables[target] && !tables[target].initialized) {
            $(tables[target].selector).DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'colvis']
            });
            tables[target].initialized = true;
        }
    });

    const activeTab = $('a[data-bs-toggle="tab"].active').attr('href');
    if (tables[activeTab] && !tables[activeTab].initialized) {
        $(tables[activeTab].selector).DataTable({
            responsive: true,
            dom: 'Bfrtip',
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });
        tables[activeTab].initialized = true;
    }
});


</script>

    @endsection

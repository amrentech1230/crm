@extends('layout.compact.app')
@section('content')
<style>
    #submitLoadButton.disabled,
    #submitLoadButton:disabled,
    input[type="submit"].disabled,
    input[type="submit"]:disabled {
        background-color: #b8b8b8 !important;
        border-color: #b8b8b8 !important;
        color: #ffffff !important;
        cursor: not-allowed !important;
        opacity: 1 !important;
    }

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

    /* The other-charges pop-ups are toggled with jQuery .show(), so Bootstrap never adds a
       .modal-backdrop. Dim the overlay on the modal element itself instead. */
    #myModal,
    #otherChargesModal {
        background-color: rgba(0, 0, 0, 0.5);
    }
    #shipperForms {
        padding: 0;
    }
    #load_shipper_commodity.field-error,
    #load_consignee_commodity.field-error {
        border: 1px solid red !important;
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

/* Pinned below the fixed topbar so it stays in view while the load form scrolls.
   position: sticky cannot be used here: .main-content has overflow:hidden. */
#credit-limit-message {
    position: fixed;
    top: 82px;
    left: 50%;
    right: auto;
    transform: translateX(-50%);
    width: min(90vw, 1180px);
    max-width: calc(100vw - 48px);
    min-height: 38px;
    display: flex;
    align-items: center;
    border-radius: 4px;
    background-color: #fff3cd;
    border-color: #ffecb5;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    box-sizing: border-box;
    overflow-wrap: anywhere;
    white-space: normal;
}
#credit-limit-message.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c2c7;
    color: #842029;
}
body.vertical-collpsed #credit-limit-message {
    left: 50%;
}
@media (max-width: 991.98px) {
    #credit-limit-message {
        width: min(96vw, 1180px);
        left: 50%;
    }
}
</style>

<div id="mc-success-message" style="display: none;"></div>
<div id="mc-error-message" style="display: none;"></div>

<div class="page-content">
    <div class="container-fluid">
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
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Load</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Edit Load</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ route('load.create') }}" id="myFormLoad"
                        enctype="multipart/form-data" novalidate>
                        @csrf
                        <div id="credit-limit-message" class="alert alert-warning d-none mb-3"></div>
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
                                        <select id="load_bill_to" class="form-control mySelect2" name="load_bill_to" data-placeholder="Select Customer">
                                            <option value="">Select Customer</option>
                                            @foreach($customer as $cust)
                                            <option value="{{$cust->id}}"
                                                data-available-credit="{{ (float) get_customer_available_credit_limit($cust) }}"
                                                data-remaining-credit="{{ (float) ($cust->remaining_credit ?? 0) }}"
                                                data-invoice-credit-limit="{{ (float) ($cust->invoice_credit_limit ?? 0) }}">
                                                {{$cust->customer_name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" id="customer_id" name="customer_id" value="" >
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Dispatcher <code>*</code></label>
                                        
                                            <!-- Show select normally -->
                                            <select class="form-control mySelect2" id="load_dispatcher" name="load_dispatcher" required style="width: 100%;">
                                                <option value="">Select a Broker</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->name }}" >
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="dispatcher_user_id" name="dispatcher_user_id" value="{{ $user->user_id }}">

                                    </div>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="form-control" name="load_status" id="load_status" value="Open"
                                             style="width: 100%;">
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
                                            id="load_equipment_type" style="width: 100%;" required data-placeholder="Select Equipment">

                                            <option value="">Select Equipment </option>
                                            @foreach($equipmentType as $equipment)
                                            <option value="{{$equipment->id}}">{{$equipment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>CMT Agent</label>
                                        <select class="form-control" name="cmt_agent" required readonly
                                            style="width: 100%;">
                                            <option value="None">None</option>
                                            <option value="Rachel">Rachel</option>
                                            <option value="Amelia">Amelia</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-header">
                            <h3 class="card-title" style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Shipper/Customer </h3>
                        </div>
                         <div class="card-body row" id="customers">
                            <div class="col-md-3 mb-2">
                                    <div class="form-group" id="shipper_rate_div">
                                        <label>Shipper Rate
                                            <code>*</code></label>
                                        <input type="number" class="form-control number value" name="load_shipper_rate"
                                            autocomplete="off" id="load_shipper_rate" required  style="width: 100%;">
                                        <!-- <input type="text" class="form-control number value" id="load_shipper_rate" name="load_shipper_rate"> -->
                                        <span id="error_load_shipper_rate"
                                            style="color: red; font-size: 9px !important; display: none;">Only numbers
                                            and decimals allowed</span>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>F.S.C Rate % <input hidden type="checkbox"
                                                name="calculate_fsc_percentage" id="calculate_fsc_percentage"></label>
                                        <input class="form-control number percent" name="load_fsc_rate"
                                            autocomplete="off" id="load_fsc_rate" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label class="other_charge d-flex">Customer Other Charges &nbsp; <i
                                                class="fa fa-plus" style="color: #0c7ce6;" data-toggle="modal"
                                                data-target="#myModal" id="load_shipper_other_charges"></i>
                                        </label>
                                        <input id="totalChargeAmount" class="form-control number percent"
                                            style="width: 100%;" >
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
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="shipperchargeType"> Charge Type:</label>
                                                                    <input type="text" class="form-control"
                                                                        name="shipperchargeType[]"
                                                                        placeholder="Enter Charge Type">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mt-3">
                                                                    <label>For Invoice:</label><br>
                                                                    <input type="checkbox"
                                                                        class="form-check-input for_invoice"
                                                                        name="for_invoice[]"
                                                                        value="on">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label> Amount:</label>
                                                                    <input type="number" class="form-control shipperchargeAmount"
                                                                        name="shipperchargeAmount[]"
                                                                        placeholder="Enter Amount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="margin-top: 27px;">
                                                                <a type="button" class="remove-charge"
                                                                    name="shipperchargeAmountdelete[]">
                                                                    <i class="fa fa-trash"
                                                                        style="color:red;margin-top: 19px;"
                                                                        aria-hidden="true"></i>
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <div class="row" id="chargeRowTemplate" style="display: none;">
                                                            <div class="col-md-4" style="margin-top:20px;">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="shipperchargeType[]"
                                                                        placeholder="Enter Charge Type">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="margin-top:20px;">
                                                                <div class="form-group">
                                                                    <input type="checkbox"
                                                                        class="form-check-input for_invoice"
                                                                        name="for_invoice[]"
                                                                        value="on">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" style="margin-top:20px;">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control shipper_other_charge"
                                                                        name="shipperchargeAmount[]"
                                                                        placeholder="Enter Amount">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="margin-top: 17px;">
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
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Final Shipper Rate <code>*</code></label>
                                        <input type="text" class="readonly form-control" name="shipper_load_final_rate" readonly
                                            autocomplete="off" id="shipper_load_final_rate"
                                            style="background-color:#e9ecef;" required/>
                                        <p id="creditlimitcheck"></p>
                                    </div>
                                </div>
                        </div>
                         <div class="card-header">
                            <h3 class="card-title" style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Carrier </h3>
                        </div>
                         <div class="card-body row" id="carrier">
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
                                            class="form-control" style="width: 100%;">
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
                                        <input class="form-control" type="number" id="totalShipperOtherChgarges" readonly name="load_other_charge"
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
                                                                    <input class="w-100 form-control shipper_other_charge" type="number"
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
                                                        <button type="button" class='create-input btn btn-success'>Add More
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
                                                <input class="form-control load_shipper" name="load_shipper" id="load_shipper"
                                                    required autocomplete="off" style="width: 100%;">
                                                <span class="customerErrorMessage"
                                                    style="color: red; display: none;">Select Shipper From the
                                                    List</span>
                                                <div id="shipperList" class="form-control shipperList" style="display: none;"
                                                    readonly></div>

                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipper Location</label>
                                                <input class="form-control load_shipper_location" readonly name="load_shipper_location"
                                                    id="load_shipper_location" autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Appointment</label>
                                                <input class="form-control load_shipper_appointment" type="datetime-local"
                                                    name="load_shipper_appointment" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input class="form-control load_shipper_description" name="load_shipper_description"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Type</label>
                                                <input class="form-control load_shipper_commodity_type" name="load_shipper_commodity_type"
                                                    style="width: 100%;" autocomplete="off">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Name <code>*</code></label>
                                                <input class="form-control load_shipper_commodity" id="load_shipper_commodity"
                                                    name="load_shipper_commodity" autocomplete="off" type="text"
                                                    required style="width: 100%;">
                                                <div id="error_load_shipper_commodity" style="color:red; font-size:11px; display:none;">Please fill Commodity Name *</div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input type="number load_shipper_qty" class="form-control" autocomplete="off"
                                                    name="load_shipper_qty" id="load_shipper_qty" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                <input class="form-control load_shipper_weight" type="number" autocomplete="off"
                                                    name="load_shipper_weight" id="load_shipper_weight"
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                <input type="number" class="form-control load_shipper_value" id="load_shipper_value"
                                                    autocomplete="off" name="load_shipper_value" required
                                                    style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipping Notes</label>
                                                <input class="form-control load_shipper_shipping_notes" name="load_shipper_shipping_notes"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>PO Numbers</label>
                                                <input class="form-control load_shipper_po_numbers" name="load_shipper_po_numbers"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input class="form-control load_shipper_contact" type="number" autocomplete="off"
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
                                                    <input class="form-control load_consignee" name="load_consignee" autocomplete="off"
                                                        id="load_consignee" required style="width: 100%;">
                                                    <span class="customerErrorMessage"
                                                        style="color: red; display: none;">Select Consignee From the
                                                        List</span>
                                                    <div id="consigneeList" class="form-control consigneeList" style="display: none;"
                                                        readonly></div>

                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee Location</label>
                                                    <input class="form-control load_consignee_location" name="load_consignee_location"
                                                        autocomplete="off" id="load_consignee_location"
                                                        style="width: 100%;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Appointment</label>
                                                    <input class="form-control load_consignee_appointment" type="datetime-local"
                                                        name="load_consignee_appointment" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input class="form-control load_consignee_description" autocomplete="off"
                                                        name="load_consignee_description" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Type </label>
                                                    <input class="form-control load_consignee_type" name="load_consignee_type"
                                                        autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Name <code>*</code></label>
                                                    <input class="form-control load_consignee_commodity" name="load_consignee_commodity"
                                                        id="load_consignee_commodity" autocomplete="off" type="text" required style="width: 100%;">
                                                    <div id="error_load_consignee_commodity" style="color:red; font-size:11px; display:none;">Please fill Commodity Name *</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control load_consignee_qty" name="load_consignee_qty"
                                                       id="load_consignee_qty"  autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Weight (lbs)</label>
                                                    <input class="form-control load_consignee_weight" type="number" id="load_consignee_weight"
                                                        autocomplete="off" name="load_consignee_weight"
                                                        style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Value($)<code>*</code></label>
                                                    <input type="number" class="form-control load_consignee_value"
                                                        name="load_consignee_value" autocomplete="off"
                                                        id="load_consignee_value" required style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee
                                                        Notes</label>
                                                    <textarea class="form-control load_consignee_notes" name="load_consignee_notes"
                                                        autocomplete="off"
                                                        style="width: 100%; height: 31px !important;font-size: 12px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>PO Numbers</label>
                                                    <input class="form-control load_consignee_po_numbers" name="load_consignee_po_numbers"
                                                        autocomplete="off" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Contact Number</label>
                                                    <input class="form-control load_consignee_contact" type="number" autocomplete="off"
                                                        name="load_consignee_contact" style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-info" value="Save" id="submitLoadButton" title="Save">
                            <input type="button" style="font-size:14px !important;" class="btn btn-warning"
                                id="clearFormButton" Value="Clear Form">
                            <input type="button" class="btn btn-danger" data-dismiss="modal" value="Cancel">
                        </div>
                    </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        @endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function formatCreditAmount(value) {
        return '$' + parseFloat(value || 0).toFixed(2);
    }

    function zeroRateFields() {
        $('#shipper_load_final_rate').val(0);
        $('#load_shipper_rate').val(0);
        $('#load_fsc_rate').val(0);
        $('[name="shipperchargeAmount[]"]').val(0);
        $('#totalChargeAmount').val(0);
        $('#load_final_carrier_fee').val(0);
        $('#totalShipperOtherChgarges').val(0);
    }

    function getSelectedCustomerCreditLimit() {
        var $select = $('#load_bill_to');
        if (!$select.length) {
            return { remaining: 0, invoice: 0 };
        }

        var selectedOption = $select.find('option:selected');
        var availableCredit = parseFloat(selectedOption.data('available-credit')) || 0;
        var remainingCredit = parseFloat(selectedOption.data('remaining-credit')) || 0;
        var invoiceCreditLimit = parseFloat(selectedOption.data('invoice-credit-limit')) || 0;

        var remaining = availableCredit > 0 ? availableCredit : remainingCredit;

        return { remaining: remaining, invoice: invoiceCreditLimit };
    }

    function getInvoiceChargesTotal() {
        var total = 0;
        var $invoiceChecks = $('[name="for_invoice[]"]');

        if (!$invoiceChecks.length) {
            return 0;
        }

        $invoiceChecks.each(function (index) {
            var amount = parseFloat($('[name="shipperchargeAmount[]"]').eq(index).val()) || 0;
            if ($(this).is(':checked')) {
                total += amount;
            }
        });

        return total;
    }

    function getNonInvoiceChargesTotal() {
        var total = 0;
        var $invoiceChecks = $('[name="for_invoice[]"]');

        if (!$invoiceChecks.length) {
            return 0;
        }

        $invoiceChecks.each(function (index) {
            var amount = parseFloat($('[name="shipperchargeAmount[]"]').eq(index).val()) || 0;
            if (!$(this).is(':checked')) {
                total += amount;
            }
        });

        return total;
    }

    function validateCreditForLoad() {
        var $form = $('#myFormLoad');
        var $select = $('#load_bill_to');
        var $rate = $('#shipper_load_final_rate');
        var $message = $('#credit-limit-message');
        var $submitButton = $('#submitLoadButton');

        if (!$form.length || !$select.length || !$rate.length) {
            return true;
        }

        if (!$select.val()) {
            $message.text('').addClass('d-none');
            $submitButton.prop('disabled', false).removeClass('disabled').prop('title', 'Save');
            $form.data('credit-valid', true);
            return true;
        }

        var credits = getSelectedCustomerCreditLimit();
        var remainingLimit = credits.remaining;
        var invoiceLimit = credits.invoice;
        var enteredAmount = parseFloat($rate.val()) || 0;
        var baseRate = parseFloat($('#load_shipper_rate').val()) || 0;
        var fscRate = parseFloat($('#load_fsc_rate').val()) || 0;
        var fscAmount = (fscRate / 100) * baseRate;
        var nonInvoiceCharges = getNonInvoiceChargesTotal();
        var invoiceCharges = getInvoiceChargesTotal();
        
        // Deduct customer other charges (non-invoice charges) from invoicing limit
        var nonInvoiceChargesFromInvoiceLimit = Math.min(nonInvoiceCharges, invoiceLimit);
        var nonInvoiceChargesFromRemaining = Math.max(0, nonInvoiceCharges - invoiceLimit);
        var remainingUsed = baseRate + fscAmount + nonInvoiceChargesFromRemaining;
        
        // Total invoice usage includes both invoice charges and any non-invoice charges deducted from invoice limit
        var totalInvoiceUsed = invoiceCharges + nonInvoiceChargesFromInvoiceLimit;

        if (enteredAmount < 0) {
            $message
                .removeClass('alert-warning alert-success')
                .addClass('alert-danger')
                .text('Shipper rate cannot be negative.')
                .removeClass('d-none');
            $submitButton.prop('disabled', true).addClass('disabled').prop('title', 'Shipper rate cannot be negative.');
            $rate.val(0);
            $form.data('credit-valid', false);
            return false;
        }

        if (remainingLimit <= 0 && invoiceLimit <= 0) {
            $message
                .removeClass('alert-warning alert-success')
                .addClass('alert-danger')
                .text('You do not have sufficient limit to create this load.')
                .removeClass('d-none');
            $submitButton.prop('disabled', true).addClass('disabled').prop('title', 'Insufficient limit to create this load.');
            zeroRateFields();
            $rate.val(0);
            $form.data('credit-valid', false);
            return false;
        }

        if (remainingUsed > remainingLimit) {
            var shortageAmount = remainingUsed - remainingLimit;
            $message
                .removeClass('alert-warning alert-success')
                .addClass('alert-danger')
                .text('Amount (' + formatCreditAmount(remainingUsed) + ') exceeds remaining credit limit (' + formatCreditAmount(remainingLimit) + ').')
                .removeClass('d-none');
            $submitButton.prop('disabled', true).addClass('disabled').prop('title', 'Insufficient remaining limit.');
            $rate.val(0);
            $form.data('credit-valid', false);
            return false;
        }

        if (totalInvoiceUsed > invoiceLimit) {
            var shortageAmount = totalInvoiceUsed - invoiceLimit;
            $message
                .removeClass('alert-warning alert-success')
                .addClass('alert-danger')
                .text('Insufficient invoicing limit. Your invoicing limit is ' + formatCreditAmount(invoiceLimit) + '. You need ' + formatCreditAmount(shortageAmount) + ' more credits.')
                .removeClass('d-none');
            $submitButton.prop('disabled', true).addClass('disabled').prop('title', 'Insufficient invoicing limit.');
            $rate.val(0);
            $form.data('credit-valid', false);
            return false;
        }

        // Simple visible message, detailed calculations in console
        var deductionSummary = 'Final Deduction: ' + formatCreditAmount(remainingUsed) + ' | Available after: ' + formatCreditAmount(remainingLimit - remainingUsed);

        $message
            .removeClass('alert-danger')
            .addClass('alert-warning')
            .text(deductionSummary)
            .removeClass('d-none');

        // Log detailed calculations to console for background tracking
        console.log('Credit Limit Check:', {
            'Base Rate': formatCreditAmount(baseRate),
            'FSC Rate %': parseFloat(fscRate || 0).toFixed(1) + '%',
            'FSC Amount': formatCreditAmount(fscAmount),
            'Invoice Charges (For Invoice=checked)': formatCreditAmount(invoiceCharges),
            'Non-Invoice Charges (For Invoice=unchecked)': formatCreditAmount(nonInvoiceCharges),
            '  → Deducted from Invoice Limit': formatCreditAmount(nonInvoiceChargesFromInvoiceLimit),
            '  → Deducted from Remaining Limit': formatCreditAmount(nonInvoiceChargesFromRemaining),
            'Total Used from Remaining': formatCreditAmount(remainingUsed),
            'Remaining Available': formatCreditAmount(remainingLimit - remainingUsed),
            'Remaining Limit': formatCreditAmount(remainingLimit),
            'Invoice Limit': formatCreditAmount(invoiceLimit)
        });
        $submitButton.prop('disabled', false).removeClass('disabled').prop('title', 'Save');
        $form.data('credit-valid', true);
        return true;
    }

    $(document).ready(function () {
        $('#load_bill_to').on('change', function() {
            $('#customer_id').val($(this).val() || '');
            $('#load_shipper_rate').prop('readonly', false);
            $('#load_shipper_rate').val(0);
            $('#shipper_load_final_rate').val('');
            validateCreditForLoad();
        });

        $('#shipper_load_final_rate').on('input change', function() {
            validateCreditForLoad();
        });

        $('#myFormLoad').on('submit', function (e) {
            var valid = true;

            if (!$('#load_shipper_commodity').val().trim()) {
                $('#load_shipper_commodity').addClass('field-error');
                $('#error_load_shipper_commodity').show();
                valid = false;
            } else {
                $('#load_shipper_commodity').removeClass('field-error');
                $('#error_load_shipper_commodity').hide();
            }

            if (!$('#load_consignee_commodity').val().trim()) {
                $('#load_consignee_commodity').addClass('field-error');
                $('#error_load_consignee_commodity').show();
                valid = false;
            } else {
                $('#load_consignee_commodity').removeClass('field-error');
                $('#error_load_consignee_commodity').hide();
            }

            if (!valid || !validateCreditForLoad()) {
                e.preventDefault();
            }
        });

        $(document).on('input', '#load_shipper_commodity', function () {
            if ($(this).val().trim()) {
                $(this).removeClass('field-error');
                $('#error_load_shipper_commodity').hide();
            }
        });

        $(document).on('input', '#load_consignee_commodity', function () {
            if ($(this).val().trim()) {
                $(this).removeClass('field-error');
                $('#error_load_consignee_commodity').hide();
            }
        });
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
				   <i class="fa fa-trash remove" data-id="shipperForm${nextcount}" style="margin-top: 1px;margin-left: 4px;"></i>
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
                        $(this).attr('name', name + '' + nextcount).val('');
                    }
                    if (id) {
                        $(this).attr('id', id + '' + nextcount).val('');
                    }
                });

                $('#tabContent').append(newContent);
				
				/****shipper code*****/
				
				function fetchShipperNames(query, parentId) {
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
								$('#'+parentId+' .shipperList').html(html).show();
							},
							error: function(xhr, status, error) {
								console.error(error);
							}
						});
					} else {
						$('#'+parentId+' .shipperList').html('').hide();
					}
				}

				$('.load_shipper').on('keyup', function() {
					var query = $(this).val();
					let parentId = $(this).closest('.tab-pane').attr('id');
					
					fetchShipperNames(query, parentId);

					// Clear the location field if shipper name is empty
					if (query.trim() === '') {
						$('#'+parentId+' .load_shipper_location').val('');
					}
				});

				// Listen for click event on shipper list items
				$(document).on('click', '.shipperList .item', function() {
					let parentId = $(this).closest('.tab-pane').attr('id');
					var selectedShipperName = $(this).data('name');
					var selectedShipperAddress = $(this).data('address');
					var selectedShipperCity = $(this).data('city');
					var selectedShipperState = $(this).data('state');
					var selectedShipperCountry = $(this).data('country');
					var selectedShipperZip = $(this).data('zip');

					var countryName = '';
					if (selectedShipperCountry) {
						var countryParts = selectedShipperCountry.split(' ');
						countryName = countryParts.slice(1).join(' ');
					}

					// Format the full address as "address, city, state, zip, country"
					var fullAddress = selectedShipperAddress + ', ' + selectedShipperCity + ', ' +
						selectedShipperState + ', ' + selectedShipperZip + (countryName ? ', ' + countryName : '');

					$('#'+parentId+' .load_shipper').val(selectedShipperName);
					$('#'+parentId+' .load_shipper_location').val(fullAddress);
					$('#'+parentId+' .shipperList').html('').hide(); // Clear the list
				});

				// Hide the dropdown when clicking outside
				$(document).on('click', function(event) {
					if (!$(event.target).closest('.shipperList, .load_shipper').length) {
						$('.shipperList').html('').hide();
					}
				});
				
				$(document).ready(function () {
					const ids = ['.load_consignee', '.load_shipper'];

					ids.forEach(function (id) {
						// Prevent copy, paste, and cut
						$(id).on('copy paste cut', function (e) {
							e.preventDefault();
							$('#mc-error-message').text('Cut is not allowed').fadeIn();

							  // Hide after 10 seconds
							  setTimeout(function() {
								  $('#mc-error-message').text('').fadeOut();
							  }, 1000);
						});
					});
				});
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
                    <i class="fa fa-trash remove" data-id="consigneeSections${nextcounts}" style="margin-top: 1px;margin-left: 4px;"></i>
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
                        $(this).attr('name', name + '' + nextcounts).val('');
                    }
                    if (id) {
                        $(this).attr('id', id + '' + nextcounts).val('');
                    }
                });

                $('#tabContent1').append(newContent);
				
				/**********consignee add code*************/
				function fetchConsigneeNames(query, parentId) {
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
								$('#'+parentId+' .consigneeList').html(html).show();
							},
							error: function (xhr, status, error) {
								console.error(error);
							}
						});
					} else {
						$('.consigneeList').html('').hide();
					}
				}

				$('.load_consignee').on('keyup', function () {
					var query = $(this).val();
					let parentId = $(this).closest('.tab-pane').attr('id');
					fetchConsigneeNames(query, parentId);

					// Clear the location field if consignee name is empty
					if (query.trim() === '') {
						$('#'+parentId+' .load_consignee_location').val('');
					}
				});

				// Listen for click event on consignee list items
				$(document).on('click', '.consigneeList .item', function () {
					let parentId = $(this).closest('.tab-pane').attr('id');
					
					var selectedConsigneeName = $(this).data('name');
					var selectedConsigneeAddress = $(this).data('address');
					var selectedConsigneeCity = $(this).data('city');
					var selectedConsigneeState = $(this).data('state');
					var selectedConsigneeCountry = $(this).data('country');
					var selectedConsigneeZip = $(this).data('zip');

					var countryName = '';
					if (selectedConsigneeCountry) {
						var countryParts = selectedConsigneeCountry.split(' ');
						countryName = countryParts.slice(1).join(' ');
					}

					var fullAddress = selectedConsigneeAddress + ', ' + selectedConsigneeCity + ', ' +
						selectedConsigneeState + ', ' + selectedConsigneeZip + 
						(countryName ? ', ' + countryName : '');

					$('#'+parentId+' .load_consignee').val(selectedConsigneeName);
					$('#'+parentId+' .load_consignee_location').val(fullAddress);
					$('#'+parentId+' .consigneeList').html('').hide(); // Clear the list
				});



				// Hide the dropdown when clicking outside
				$(document).on('click', function (event) {
					if (!$(event.target).closest('.consigneeList, .load_consignee').length) {
						$('.consigneeList').html('').hide();
					}
				});
				
				$(document).ready(function () {
					const ids = ['.load_consignee', '.load_shipper'];

					ids.forEach(function (id) {
						// Prevent copy, paste, and cut
						$(id).on('copy paste cut', function (e) {
							e.preventDefault();
							$('#mc-error-message').text('Cut is not allowed').fadeIn();

							  // Hide after 10 seconds
							  setTimeout(function() {
								  $('#mc-error-message').text('').fadeOut();
							  }, 1000);
						});
					});
				});
            });
        });
   
$(document).ready(function () {
    setInterval(() => {
        $('.nav-item .remove').on('click', function() {
            var $parentLi = $(this).closest('li');
            var removeId = $(this).data('id');
            
            $parentLi.remove(); // Remove the parent <li>
            $('#' + removeId).remove(); // Remove the element with ID from data-id
        });
    }, 500);
    
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

                $('#totalChargeAmount').val(total.toFixed(2));

                var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
                total += loadShipperRate;

                var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
                total += (loadFscRate / 100) * loadShipperRate;

                    $('#shipper_load_final_rate').val(total.toFixed(2));
                if (!validateCreditForLoad()) {
                    zeroRateFields();
                }

                var customer_id = $('#load_bill_to').val();
                var invoiceAmount = 0;
                $('[name="for_invoice[]"]').each(function (index) {
                    if ($(this).is(':checked')) {
                        invoiceAmount += parseFloat($('[name="shipperchargeAmount[]"]').eq(index).val()) || 0;
                    }
                });
                var remainingAmount = Math.max(0, total - invoiceAmount);

                 $.ajax({
                        url: '{{ route('check.remaing.limit') }}',
                        method: 'GET',
                        data: {
                            customer_id: customer_id,
                            finalrate: total,
                            remaining_amount: remainingAmount,
                            invoice_amount: invoiceAmount,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {

                            if (response.success) {

                                zeroRateFields();
                                validateCreditForLoad();

                                // Show the limit message at the top of the load form
                                $('#credit-limit-message')
                                    .removeClass('alert-warning alert-success')
                                    .addClass('alert-danger')
                                    .text(response.message)
                                    .removeClass('d-none');
                            }

                        },
                        
                    });

            }

            $(document).on('input', '[name="shipperchargeAmount[]"], #load_shipper_rate, #load_fsc_rate',
                function () {
                    updateTotalshipper();
                });

            $(document).on('change', '.for_invoice', function () {
                updateTotalshipper();
                validateCreditForLoad();
            });

        });

        function calculateTotalcustomer() {
            let total = 0;
            $('[name="shipperchargeAmount[]"]').each(function () {
                let value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $('#totalChargeAmount').val(total.toFixed(2));

            var load_shipper_rate = $('#load_shipper_rate').val();

            var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
            total += loadShipperRate;

            var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
            total += (loadFscRate / 100) * loadShipperRate;

            $('#shipper_load_final_rate').val(total.toFixed(2));
            if (!validateCreditForLoad()) {
                zeroRateFields();
            }

            //var final_rate = parseFloat(load_shipper_rate) + parseFloat(total);

            //$('#shipper_load_final_rate').val(final_rate);

        }

        // Bind input event to existing .shipperchargeAmount inputs
        $(document).on('input', '[name="shipperchargeAmount[]"]', function () {
            calculateTotalcustomer();
        });

        // Handle Add Charge button click
        $('#addChargeBtn').on('click', function () {
            const $template = $('#chargeRowTemplate');
            const $clone = $template.clone();

            $clone.removeAttr('id'); // remove id to avoid duplicates
            $clone.css('display', 'flex');

            // Append clone to modal body container
            $('.modal-body .container').append($clone);

            // Attach remove event to the new remove button
            $clone.find('.remove-charge').on('click', function () {
                $clone.remove();
                calculateTotalcustomer();
            });
        });

        // Handle removal of pre-existing charges
        $(document).on('click', '.remove-charge', function () {
            $(this).closest('.row').remove();
            calculateTotalcustomer();
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

                $('#totalShipperOtherChgarges').val(total.toFixed(2));
                

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

                var customer_rate = $('#shipper_load_final_rate').val();
            
                if(total > customer_rate){
                      $('#mc-error-message').text("Final carrier fee should not be more than final customer rate").fadeIn();
                      $('.shipper_other_charge').val(0);
                      $('#totalShipperOtherChgarges').val(0);
                        $('#load_carrier_fee').val(0);
                        $('#load_final_carrier_fee').val(0);
                        // Hide after 10 seconds
                        setTimeout(function() {
                            $('#mc-error-message').text('').fadeOut();
                        }, 2000); 
                }
                
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
        const ids = ['.load_consignee', '.load_shipper'];

        ids.forEach(function (id) {
            // Prevent copy, paste, and cut
            $(id).on('copy paste cut', function (e) {
                e.preventDefault();
                $('#mc-error-message').text('Cut is not allowed').fadeIn();

				  // Hide after 10 seconds
				  setTimeout(function() {
					  $('#mc-error-message').text('').fadeOut();
				  }, 1000);
            });
        });
    });
	
	
    $(document).ready(function () {

        function calculateTotalcarrier() {
            let total = 0;
            $('[name="shipper_other_charge[]"]').each(function () {
                let value = parseFloat($(this).val());
                if (!isNaN(value)) {
                    total += value;
                }
            });
            $('#totalShipperOtherChgarges').val(total.toFixed(2));

            //var load_carrier_fee = $('#load_carrier_fee').val();

            var loadCarrierFee = parseFloat($('#load_carrier_fee').val()) || 0;
            total += loadCarrierFee;

            var billingFSCRate = parseFloat($('#load_billing_fsc_rate').val()) || 0;
            var fscAmount = (loadCarrierFee * billingFSCRate) / 100;
            total += fscAmount;
            $('#load_final_carrier_fee').val(total.toFixed(2));

            //var final_rate_carrier = parseFloat(load_carrier_fee) + parseFloat(total);

            //$('#load_final_carrier_fee').val(final_rate_carrier);

        }

        // Function to add input row
        $('.create-input').click(function (e) {
            e.preventDefault(); // Prevent the default form submission

            var inputRow = $('<div class="row">' +
                '<div class="col-md-6"><div class="form-group"><input class="form-control" style="width:100%;margin-top: 29px;" type="text" name="shipper_type_charge[]" placeholder="Enter Charge Type"></div></div>' +
                '<div class="col-md-5"><div class="form-group"><input class="form-control" style="width:100%;margin-top: 29px;" type="number" name="shipper_other_charge[]" placeholder="Enter Amount" /></div></div>' +
                '<div class="col-md-1"><div class="form-group"><button class="closebtn" style="margin-top: 17px;color:red;border: none;background: unset;"><i class="fa fa-trash"></i></button></div></div>' +
                '</div>');
            $('#inputs').append(inputRow);

            $(document).on('click', '.closebtn', function () {
                $(this).closest('.row').remove();
                calculateTotalcarrier();
            });
        });

        // Function to remove input row
        $(document).on('click', '.closebtn', function () {
            $(this).closest('.row').remove();
            calculateTotalcarrier();
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
        function fetchShipperNames(query, parentId) {
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
                        $('#'+parentId+' .shipperList').html(html).show();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('#'+parentId+' .shipperList').html('').hide();
            }
        }

        $('.load_shipper').on('keyup', function() {
            var query = $(this).val();
			let parentId = $(this).closest('.tab-pane').attr('id');
			
            fetchShipperNames(query, parentId);

            // Clear the location field if shipper name is empty
            if (query.trim() === '') {
                $('#'+parentId+' .load_shipper_location').val('');
            }
        });

        // Listen for click event on shipper list items
        $(document).on('click', '.shipperList .item', function() {
			let parentId = $(this).closest('.tab-pane').attr('id');
            var selectedShipperName = $(this).data('name');
            var selectedShipperAddress = $(this).data('address');
            var selectedShipperCity = $(this).data('city');
            var selectedShipperState = $(this).data('state');
            var selectedShipperCountry = $(this).data('country');
            var selectedShipperZip = $(this).data('zip');

            var countryName = '';
            if (selectedShipperCountry) {
                var countryParts = selectedShipperCountry.split(' ');
                countryName = countryParts.slice(1).join(' ');
            }

            // Format the full address as "address, city, state, zip, country"
            var fullAddress = selectedShipperAddress + ', ' + selectedShipperCity + ', ' +
                selectedShipperState + ', ' + selectedShipperZip + (countryName ? ', ' + countryName : '');

            $('#'+parentId+' .load_shipper').val(selectedShipperName);
            $('#'+parentId+' .load_shipper_location').val(fullAddress);
            $('#'+parentId+' .shipperList').html('').hide(); // Clear the list
        });

        // Hide the dropdown when clicking outside
        $(document).on('click', function(event) {
            if (!$(event.target).closest('.shipperList, .load_shipper').length) {
                $('.shipperList').html('').hide();
            }
        });
    });
</script>

<script>
$(document).ready(function () {
        function fetchConsigneeNames(query, parentId) {
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
                        $('#'+parentId+' .consigneeList').html(html).show();
                    },
                    error: function (xhr, status, error) {
                        console.error(error);
                    }
                });
            } else {
                $('.consigneeList').html('').hide();
            }
        }

        $('input[name="load_consignee"]').on('keyup', function () {
            var query = $(this).val();
			let parentId = $(this).closest('.tab-pane').attr('id');
            fetchConsigneeNames(query, parentId);

            // Clear the location field if consignee name is empty
            if (query.trim() === '') {
                $('#'+parentId+' .load_consignee_location').val('');
            }
        });

        // Listen for click event on consignee list items
        $(document).on('click', '.consigneeList .item', function () {
			let parentId = $(this).closest('.tab-pane').attr('id');
            var selectedConsigneeName = $(this).data('name');
            var selectedConsigneeAddress = $(this).data('address');
            var selectedConsigneeCity = $(this).data('city');
            var selectedConsigneeState = $(this).data('state');
            var selectedConsigneeCountry = $(this).data('country');
            var selectedConsigneeZip = $(this).data('zip');

            var countryName = '';
            if (selectedConsigneeCountry) {
                var countryParts = selectedConsigneeCountry.split(' ');
                countryName = countryParts.slice(1).join(' ');
            }

            var fullAddress = selectedConsigneeAddress + ', ' + selectedConsigneeCity + ', ' +
                selectedConsigneeState + ', ' + selectedConsigneeZip + 
                (countryName ? ', ' + countryName : '');

            $('#'+parentId+' .load_consignee').val(selectedConsigneeName);
            $('#'+parentId+' .load_consignee_location').val(fullAddress);
            $('#'+parentId+' .consigneeList').html('').hide(); // Clear the list
        });



        // Hide the dropdown when clicking outside
        $(document).on('click', function (event) {
            if (!$(event.target).closest('.consigneeList, .load_consignee').length) {
                $('.consigneeList').html('').hide();
            }
        });
    });
</script>
<script>
$(document).ready(function() {
  $('#load_shipper_commodity').on('input', function() {
    $('#load_consignee_commodity').val($(this).val());
  });
  $('#load_shipper_qty').on('input', function() {
    $('#load_consignee_qty').val($(this).val());
  });
  $('#load_shipper_weight').on('input', function() {
    $('#load_consignee_weight').val($(this).val());
  });
  $('#load_shipper_value').on('input', function() {
    $('#load_consignee_value').val($(this).val());
  });
});
</script>



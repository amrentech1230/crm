@extends('layout.compact.app')
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
    #shipperForms {
        padding: 0;
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

                        <form method="POST" action="{{ route('broker.load.update', $post->id) }}" id="myFormLoad" enctype="multipart/form-data">
                        @csrf
                        <div class="card-header">
                            <h3 class="card-title"
                                style="font-size: 18px;text-align: left;font-weight: 700;margin-left: 0;">Edit Load</h3>
                        </div>
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Load Number
                                        </label>
                                        <input class="form-control" name="load_number" value="{{ $post->load_number }}"
                                            title="Load number generated automatically" disabled style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Bill To <code>*</code></label>
                                        <input type="text" id="load_bill_to" name="load_bill_to" class="form-control" value="{{ $post->load_bill_to }}" readonly autocomplete="off" placeholder="Customer name">
                                    </div>
                                </div>


                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Dispatcher <code>*</code></label>
                                        
                                        <input class="form-control" name="load_dispatcher"  value="{{ $post->user->name }}" required readonly
                                            style="width: 100%;">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <input class="form-control" name="load_status" id="load_status" value="Open" value="{{ $post->load_status }}"
                                            readonly style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>W/O # </label>
                                        <input class="form-control" name="load_workorder" style="width: 100%;" value="{{ $post->load_workorder }}" 
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Customer r/f# </label>
                                        <input class="form-control" name="customer_refrence_number" style="width: 100%;" value="{{ $post->customer_refrence_number }}"
                                            autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Payment Type
                                            <code>*</code></label>
                                        <select class="form-control" required name="load_payment_type"
                                            style="width: 100%;">
                                            <option value="">Select payment Type</option>
                                            <option value="Prepaid" {{ $post->load_payment_type == 'Prepaid' ? 'selected' : '' }}>Prepaid</option>
                                                    <option value="Postpaid" {{ $post->load_payment_type == 'Postpaid' ? 'selected' : '' }}>Postpaid</option>
                                                </select>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Load type<code>*</code></label>
                                        <div class="purple">
                                            <select class="form-control" required name="load_type_two"
                                                style="width: 100%;">
                                                <option value="">Selected</option>
                                                <option value="OTR" {{ $post->load_type_two == 'OTR' ? 'selected' : '' }}>OTR</option>
                                                <option value="DRAYAGE" {{ $post->load_type_two == 'DRAYAGE' ? 'selected' : '' }}>DRAYAGE</option>
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
                                            <option value="{{$shipment->id}}" {{ $post->load_type == $shipment->id ? 'selected' : '' }}>{{$shipment->name}}</option>
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
                                            <option value="$" {{ $post->load_currency == '$' ? 'selected' : '' }}>$</option>
                                                    <option value="CAD" {{ $post->load_currency == 'CAD' ? 'selected' : '' }}>CAD</option>
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
                                            <option value="{{$equipment->id}}" {{ $post->load_equipment_type == $equipment->id ? 'selected' : '' }}>{{$equipment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title"
                                style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Customer </h3>
                        </div>
                        <div class="card-body" id="CustomerForms">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="form-group" id="shipper_rate_div">
                                        <label>Customer Base Rate
                                            <code>*</code></label>
                                        <input type="number" class="form-control number value" name="load_shipper_rate" value="{{ $post->load_shipper_rate }}"
                                            autocomplete="off" id="load_shipper_rate" required style="width: 100%;">
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>F.S.C Rate % <input hidden type="checkbox"
                                                name="calculate_fsc_percentage" id="calculate_fsc_percentage"></label>
                                        <input class="form-control number percent" name="load_fsc_rate"
                                            autocomplete="off" id="load_fsc_rate" value="{{ $post->load_fsc_rate }}" style="width: 100%;" @if($post->load_shipper_rate > 0 || !empty($post->load_shipper_rate)) readonly @endif>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
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
                                                <div class="modal-body">
                                                    <div class="container">
                                                        @php
                                                        $shipperCharges =
                                                        json_decode($post->shipper_load_other_charge, true);
                                                        if (json_last_error() !== JSON_ERROR_NONE ||
                                                        !is_array($shipperCharges)) {
                                                        // Handle JSON error or invalid data
                                                        $shipperCharges = [];
                                                        }

                                                        $carrierCharges =
                                                        json_decode($post->carrier_load_other_charge, true);
                                                        if (json_last_error() !== JSON_ERROR_NONE ||
                                                        !is_array($carrierCharges)) {
                                                        // Handle JSON error or invalid data
                                                        $carrierCharges = [];
                                                        }
                                                        @endphp
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="shipperchargeType">Charge Type:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group mt-3">
                                                                    <label>For Invoice:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Amount:</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        @foreach($shipperCharges as $index => $shipperCharge)
                                                                <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control"
                                                                            name="shipperchargeType[{{ $index }}]"
                                                                            value="{{ htmlspecialchars($shipperCharge['type'] ?? '') }}"
                                                                            placeholder="Enter Charge Type">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group mt-3">
                                                                        <input type="checkbox" class="form-check-input for_invoice"
                                                                            name="for_invoice[{{ $index }}]"
                                                                            value="on"
                                                                            {{ isset($shipperCharge['for_invoice']) && $shipperCharge['for_invoice'] === 'on' ? 'checked' : '' }}>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <input type="text" step="0.01" class="form-control shipperchargeAmount"
                                                                            name="shipperchargeAmount[{{ $index }}]"
                                                                            value="{{ $shipperCharge['amount'] ?? 0 }}"
                                                                            placeholder="Enter Amount">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1" style="margin-top: 21px;">
                                                                    <button class="remove-row" type="button" style="background:unset;border:none; color:red;">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach




                                                        <!-- Add a button to dynamically add more rows if needed -->
                                                        <div id="dynamic-field-container">
                                                            <!-- Rows will be dynamically added here -->
                                                        </div>


                                                        <!-- Container for new rows -->
                                                        <div id="chargeRowsContainer"></div>
                                                    </div>
                                                </div>
                                                <div class="text-center mb-2 mt-2">
                                                    <button type="button" class="btn btn-success"
                                                                id="addChargeBtn">Add New Charges</button>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Final Customer Rate <code>*</code></label>
                                        <input type="text" class="readonly form-control" name="shipper_load_final_rate"
                                            autocomplete="off" id="shipper_load_final_rate"
                                            style="background-color:#e9ecef;" value="{{ $post->shipper_load_final_rate }}"  required />
                                        <p id="creditlimitcheck"></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <h3 class="card-title"
                                style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Carrier</h3>
                        </div>
                        <div class="card-body" id="CarrierForms">

                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier <code>*</code></label>
                                        <input type="text" id="load_carrier" name="load_carrier" class="form-control" value="{{ $post->load_carrier }}"
                                            style="width: 100%;" autocomplete="off" placeholder="Select carrier">
                                        <input type="text" hidden name="carrier_id" id="carrier_id" value="">
                                        <!-- Dropdown to show the carrier suggestions -->
                                        <ul id="carrier-list" class="list-group"
                                            style="position: absolute; z-index: 1000; width: 100%; display: none;"></ul>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>MC No <code>*</code></label>
                                        <input class="form-control" required name="load_mc_no" id="carrier_mc_ff_input"
                                            style="width: 100%;" placeholder="Enter MC Number" autocomplete="off"  value="{{ $post->load_mc_no }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>DOT No</label>
                                        <input class="form-control" name="carrier_dot" id="carrier_dot"
                                            style="width: 100%;" placeholder="Enter DOT Number" autocomplete="off" value="{{ $post->carrier_dot }}" >
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Phone<code>*</code></label>
                                        <input type="text" id="load_carrier_phone" name="load_carrier_phone" value="{{ $post->load_carrier_phone }}"
                                            class="form-control" style="width: 100%;" readonly>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Advance Payment</label>
                                        <input type="number" class="form-control" name="load_advance_payment"  value="{{ $post->load_advance_payment }}" 
                                            autocomplete="off" style="width: 100%;">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Billing Type</label>
                                        <select class="form-control" name="load_billing_type" style="width: 100%;">
                                             <option selected="selected" value="{{ $post->load_billing_type }}">
                                                        {{ $post->load_billing_type }}</option>
                                                    <option>Factoring</option>
                                                    <option>Direct Billing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Rate
                                            <code>*</code></label>
                                        <input type="text" class="form-control" id="load_carrier_fee"
                                            name="load_carrier_fee" required autocomplete="off"  value="{{ $post->load_carrier_fee }}" required>
                                        <span id="error_load_carrier_fee"
                                            style="color: red;font-size: 9px !important; display: none;">Only numbers
                                            and decimals allowed</span>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>FSC Rate %</label>
                                        <input type="number" name="load_billing_fsc_rate" id="load_billing_fsc_rate"
                                            class="form-control" autocomplete="off" value="{{ $post->load_billing_fsc_rate }}" style="width: 100%;" required>
                                    </div>
                                </div>
                                @php
                                    $carrierCharges = json_decode($post->carrier_load_other_charge, true);
                                    @endphp
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label class="other_charge">Carrier Other Charges <i class="fa fa-plus"
                                        data-toggle="modal" data-target="#otherChargesModal"></i></label>
                                        <input type="text" class="form-control" style="width: 100%;"
                                            name="carrier_total_other_charge" id="carrier_total_other_charge"
                                            readonly>
                                    </div>

                                    <!-- Modal -->
                                    <div class="modal" id="otherChargesModal">
                                        <div class="modal-dialog" style="max-width: 840px;">
                                            <div class="modal-content" id="model_content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="font-size: 17px;text-align: left;margin-left: 9px;font-weight: 700;">Carrier Other Charges</h5>
                                                    <button type="button" class="close" data-dismiss="modal" style="font-size: 23px;top: 30px;">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container">
                                                        @php
                                                        // Decode the JSON data and check for errors
                                                        $carrierCharges =
                                                        json_decode($post->carrier_load_other_charge, true);
                                                        if (json_last_error() !== JSON_ERROR_NONE ||
                                                        !is_array($carrierCharges)) {
                                                        // Handle JSON error or invalid data
                                                        $carrierCharges = [];
                                                        }
                                                        @endphp
                                                        <div class="row charge-row">
                                                            <div class="col-md-6">
                                                                <div class="form-group mt-3">
                                                                    <label>Charge Type:</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="form-group mt-3">
                                                                    <label>Amount:</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- Fetched fields with values from the database -->
                                                        @foreach($carrierCharges as $index => $carrierCharge)
                                                            <div class="row charge-row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group mt-3">
                                                                        <input type="text"
                                                                            class="form-control typeofcharge"
                                                                            placeholder="Enter Charges Type"
                                                                            name="shipper_type_charge[]"
                                                                            value="{{ htmlspecialchars($carrierCharge['type'] ?? '') }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group mt-3">
                                                                        <input type="text" step="0.01"
                                                                            class="form-control otheramount"
                                                                            placeholder="Enter Amount"
                                                                            name="shipper_other_charge[]"
                                                                            value="{{ number_format((float)($carrierCharge['amount'] ?? 0), 2) }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-1" style="margin-top: 8px;">
                                                                    <button type="button"
                                                                        style="background:unset;border:none"
                                                                        class="remove-charge">
                                                                        <i class="fa fa-trash"
                                                                            style="margin-top: 15px; color:red;"
                                                                            aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endforeach


                                                        <!-- Container for dynamically added fields -->
                                                        <div id="inputs"></div>
                                                    </div>

                                                    <div class="modal-footer mt-3">
                                                        <button type="button"
                                                            class="btn btn-success create-input">Add New Charges</button>
                                                    </div>
                                                </div>

                                                <!-- Hidden template row for cloning -->
                                                <div id="chargeRowTemplatecarrier" style="display:none;">
                                                    <div class="row charge-row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                    class="form-control typeofcharge"
                                                                    placeholder="Enter Charges Type"
                                                                    name="shipper_type_charge[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text"
                                                                    class="form-control otheramount"
                                                                    placeholder="Enter Amount"
                                                                    name="shipper_other_charge[]">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1" style="margin-top: 21px;">
                                                            <button class="closebtn"
                                                                style="border: none; background: unset; color:red;">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
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
                                            id="load_final_carrier_fee"  value="{{ $post->load_final_carrier_fee }}" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                         @php
                            // Decode and initialize Shipper data with fallbacks
                            $shipperallData = json_decode($post->load_shipperr, true) ?? [];
                            $shipperQty = json_decode($post->load_shipper_qty, true) ?? [];
                            $shipperWeight = json_decode($post->load_shipper_weight, true) ?? [];
                            $shipperDescription = json_decode($post->load_shipper_discription, true) ?? [];
                            $shipperType = json_decode($post->load_shipper_commodity_type, true) ?? [];
                            $shipperNotes = json_decode($post->load_shipper_shipping_notes, true) ?? [];
                            $shipperContact = json_decode($post->load_shipper_contact, true) ?? [];
                            $shipperLocation = json_decode($post->load_shipper_location, true) ?? [];
                            $shipperAppointment = json_decode($post->load_shipper_appointment, true) ?? [];
                            $shipperCommodity = json_decode($post->load_shipper_commodity, true) ?? [];
                            $shipperValue = json_decode($post->load_shipper_value, true) ?? [];
                            $shipperPoNumber = json_decode($post->load_shipper_po_numbers, true) ?? [];
                            $shipperCounter = count($shipperallData) + 1;
                        @endphp

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
                                @foreach ($shipperallData as $key => $shipper)
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
                                                <select class="form-control load_shipper" name="load_shipper_{{ $key + 1 }}" id="load_shipper_{{ $key + 1 }}"
                                                    required autocomplete="off" style="width: 100%;">
                                                    <option value="">Select shipper</option>
                                                    @foreach($shipperdata as $shippers)
                                                        <option value="{{$shippers->shipper_name}}"  data-name="{{$shippers->shipper_name}}" data-address="{{$shippers->shipper_address}}" data-city="{{$shippers->shipper_state}}" data-state="{{$shippers->shipper_state}}" data-country="{{$shippers->shipper_country}}" data-zip="{{$shippers->shipper_zip}}"  @if($shipper['name'] == $shippers->shipper_name) selected @endif >{{$shippers->shipper_name}}</option>
                                                    @endforeach
                                                </select>
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
                                                <input class="form-control load_shipper_location" readonly name="load_shipper_location_{{ $key + 1 }}"  value="{{ $shipperLocation[$key]['location'] ?? '' }}" id="load_shipper_location_{{ $key + 1 }}" autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Appointment</label>
                                                <input class="form-control" type="datetime-local"
                                                    name="load_shipper_appointment_{{ $key + 1 }}" style="width: 100%;" value="{{ $shipperAppointment[$key]['appointment'] ?? '' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <input class="form-control"  name="load_shipper_description_{{ $key + 1 }}" value="{{ $shipperDescription[$key]['description'] ?? 'NA' }}"
                                                    autocomplete="off" style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Type</label>
                                                <input class="form-control" name="load_shipper_commodity_type_{{ $key + 1 }}"
                                                    style="width: 100%;" autocomplete="off" value="{{ isset($shipperType[$key]['commodity_type']) ? $shipperType[$key]['commodity_type'] : ($shipperType[$key]['type'] ?? '') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Commodity Name <code>*</code></label>
                                                <input class="form-control" id="load_shipper_commodity_{{ $key + 1 }}"
                                                    name="load_shipper_commodity_{{ $key + 1 }}" autocomplete="off" type="text" value="{{ isset($shipperCommodity[$key]['commodity_name']) ? $shipperCommodity[$key]['commodity_name'] : ($shipperCommodity[$key]['commodity'] ?? '') }}" 
                                                    required style="width: 100%;">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input type="number" class="form-control" autocomplete="off"
                                                    name="load_shipper_qty_{{ $key + 1 }}" style="width: 100%;"  value="{{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '0') }}" >
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Weight (lbs)</label>
                                                <input class="form-control" type="number" autocomplete="off"
                                                    name="load_shipper_weight_{{ $key + 1 }}" id="load_shipper_weight_{{ $key + 1 }}"
                                                    style="width: 100%;"  value="{{ isset($shipperWeight[$key]['shipper_weight']) ? $shipperWeight[$key]['shipper_weight'] : ($shipperWeight[$key]['weight'] ?? '0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Value($)<code>*</code></label>
                                                <input type="number" class="form-control" id="load_shipper_value_{{ $key + 1 }}"
                                                    autocomplete="off" name="load_shipper_value_{{ $key + 1 }}" required
                                                    style="width: 100%;" value="{{ isset($shipperValue[$key]['shipper_value']) ? $shipperValue[$key]['shipper_value'] : ($shipperValue[$key]['value'] ?? '0') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipping Notes</label>
                                                <input class="form-control" name="load_shipper_shipping_notes_{{ $key + 1 }}"
                                                    autocomplete="off" style="width: 100%;" value="{{ $shipperNotes[$key]['load_shipper_shipping_notes'] ?? 'NA' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>PO Numbers</label>
                                                <input class="form-control" name="load_shipper_po_numbers_{{ $key + 1 }}"
                                                    autocomplete="off" style="width: 100%;"  value="{{ isset($shipperPoNumber[$key]['shipping_po_numbers']) ? $shipperPoNumber[$key]['shipping_po_numbers'] : $shipperPoNumber[$key]['po_number'] ?? '0' }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Contact Number</label>
                                                <input class="form-control" type="number" autocomplete="off" name="load_shipper_contact_{{ $key + 1 }}" value="{{ $shipperContact[$key]['shipping_contact'] ?? $shipperContact[$key]['contact'] ?? '0' }}" style="width: 100%;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        @php
                            $counter = 1; // Start counter from 1
                            $consigneeallData = json_decode($post->load_consignee, true) ?? [];
                            $consigneeQty = json_decode($post->load_consignee_qty, true) ?? [];
                            $consigneeWeight = json_decode($post->load_consignee_weight, true) ?? [];
                            $consigneeDescription = json_decode($post->load_consignee_discription, true) ?? [];
                            $consigneeType = json_decode($post->load_consignee_type, true) ?? [];
                            $consigneeNotes = json_decode($post->load_consigneer_notes, true) ?? [];
                            $consigneeLocation = json_decode($post->load_consignee_location, true) ?? [];
                            $consigneeAppointment = json_decode($post->load_consignee_appointment, true) ?? [];
                            $consigneeCommodity = json_decode($post->load_consignee_commodity, true) ?? [];
                            $consigneeValue = json_decode($post->load_consignee_value, true) ?? [];
                            $consigneePoNumber = json_decode($post->load_consignee_po_numbers, true) ?? [];
                            $consigneeContact = json_decode($post->load_consigneer_contact, true) ?? [];
                            $consigneeCounter = count($consigneeallData);
                        @endphp
                        <div class="card-header pb-0">
                            
                                <h3 class="card-title"
                                    style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                    Consignee <i id="addBtnconsignee" class="fa fa-plus"></i>
                                </h3>
                            
                        </div>
                        <div class="card-body1" id="consigneeSections">
                            <ul class="nav nav-tabs" id="navTabs1">
                                @foreach ($consigneeallData as $key => $consignee)
                                <li class="nav-item">
                                    <a class="nav-link active" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#consigneeSections1" role="tab"
                                        aria-controls="consigneeSections1" aria-selected="true">Consignee {{$key + 1}}</a>
                                </li>
                                @endforeach
                            </ul>
                            <div class="tab-content" id="tabContent1">
                                 @foreach ($consigneeallData as $key => $consignee)
                                <div class="tab-pane fade show active" id="consigneeSections1" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="consignee-section mt-3">
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee <code>*</code>
                                                      
                                                    </label>
                                                    <select class="form-control load_consignee" name="load_consignee_{{ $key + 1 }}" autocomplete="off"
                                                        id="load_consignee_{{ $key + 1 }}" required style="width: 100%;">
                                                        <option value="">Select Consignee</option>
                                                        @foreach($consigneedata as $consignees)
                                                        <option value="{{$consignees->consignee_name}}" data-name="{{$consignees->consignee_name}}" data-address="{{$consignees->consignee_address}}" data-city="{{$consignees->consignee_state}}" data-state="{{$consignees->consignee_state}}" data-country="{{$consignees->consignee_country}}" data-zip="{{$consignees->consignee_zip}}" @if($consignee['name'] == $consignees->consignee_name) selected @endif >{{$consignees->consignee_name}}</option>
                                                        @endforeach
                                                    </select>
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
                                                    <input class="form-control load_consignee_location" name="load_consignee_location_{{ $key + 1 }}"
                                                        autocomplete="off" id="load_consignee_location_{{ $key + 1 }}" value="{{ $consigneeLocation[$key]['location'] ?? '' }}"
                                                        style="width: 100%;" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Appointment</label>
                                                    <input class="form-control" type="datetime-local" value="{{ $consigneeAppointment[$key]['appointment'] ?? '' }}"
                                                        name="load_consignee_appointment_{{ $key + 1 }}" style="width: 100%;">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <input class="form-control" autocomplete="off"
                                                        name="load_consignee_description_{{ $key + 1 }}" style="width: 100%;" value="{{ $consigneeDescription[$key]['load_consignee_discription'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Type </label>
                                                    <input class="form-control" name="load_consignee_type_{{ $key + 1 }}"
                                                        autocomplete="off" style="width: 100%;" value="{{ $consigneeType[$key]['consignee_type'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Commodity Name <code>*</code></label>
                                                    <input class="form-control" name="load_consignee_commodity_{{ $key + 1 }}"
                                                        id="load_consignee_commodity_{{ $key + 1 }}" value="{{ $consigneeCommodity[$key]['consignee_commodity'] ?? '' }}"  autocomplete="off" type="text"
                                                        required style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="load_consignee_qty_{{ $key + 1 }}"
                                                        autocomplete="off" style="width: 100%;" value="{{ $consigneeQty[$key]['consignee_qty'] ?? '0' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Weight (lbs)</label>
                                                    <input class="form-control" type="number" id="load_consignee_weight_{{ $key + 1 }}"
                                                        autocomplete="off" name="load_consignee_weight_{{ $key + 1 }}"
                                                        style="width: 100%;"  value="{{ $consigneeWeight[$key]['consignee_weight'] ?? '0' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Value($)<code>*</code></label>
                                                    <input type="number" class="form-control"
                                                        name="load_consignee_value_{{ $key + 1 }}" autocomplete="off"
                                                        id="load_consignee_value_{{ $key + 1 }}" required style="width: 100%;" value="{{ $consigneeValue[$key]['consignee_value'] ?? '0' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee
                                                        Notes</label>
                                                    <textarea class="form-control" name="load_consignee_notes_{{ $key + 1 }}"
                                                        autocomplete="off"
                                                        style="width: 100%; height: 31px !important;font-size: 12px;" value="{{ $consigneeNotes[$key]['load_consignee_notes'] ?? '' }}"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>PO Numbers</label>
                                                    <input class="form-control" name="load_consignee_po_numbers_{{ $key + 1 }}"
                                                        autocomplete="off" style="width: 100%;"  value="{{ $consigneePoNumber[$key]['consignee_po_number'] ?? '0' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Contact Number</label>
                                                    <input class="form-control" type="number" autocomplete="off"
                                                        name="load_consignee_contact_{{ $key + 1 }}" style="width: 100%;" value="{{ $consigneeContact[$key]['consignee_contact'] ?? '0' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>
                        <input type="submit" class="btn btn-info" value="update Load">
                       
                    </form>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        @endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

        // 2. Clone form and update
        const newContent = $('#shipperForm1').clone();
        newContent
            .attr({
                id: `shipperForm${nextcount}`,
                'aria-labelledby': `formTab${nextcount}`,
                'data-count': `_${nextcount}`
            })
            .removeClass('show active');

        // Update input/select/textarea IDs and names
        newContent.find('input, select, textarea, div[id]').each(function () {
            let name = $(this).attr('name');
            let id = $(this).attr('id');
            if (name) $(this).attr('name', `${name}_${nextcount}`);
            if (id) $(this).attr('id', `${id}_${nextcount}`);
        });

        $('#tabContent').append(newContent);
    });

    // 🔁 Delegated event for dynamic .load_shipper change
    $(document).on('change', '.load_shipper', function () {
        const parentForm = $(this).closest('.tab-pane'); // more robust
        const selectedOption = $(this).find('option:selected');
        const selectedOptionval = $(this).find('option:selected').val();
        const name = selectedOption.data('name');
        const address = selectedOption.data('address');
        const city = selectedOption.data('city');
        const state = selectedOption.data('state');
        const country = selectedOption.data('country');
        const zip = selectedOption.data('zip');

        const fullAddress = `${address}, ${city}, ${state}, ${zip}, ${country}`;

        if(selectedOptionval !== ''){
            parentForm.find('.load_shipper_location').val(fullAddress);
        }else{
            parentForm.find('.load_shipper_location').val('');
        }
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

                // 2. Clone first form
                const newContent = $('#consigneeSections1').clone();
                newContent
                    .attr({
                        id: `consigneeSections${nextcounts}`,
                        'aria-labelledby': `formTab${nextcounts}`,
                        'data-count': `_${nextcounts}`
                    })
                    .removeClass('show active'); // hide by default

                // 3. Update fields inside the clone
                newContent.find('input, select, textarea, div[id]').each(function () {
                    let name = $(this).attr('name');
                    let id = $(this).attr('id');
                    if (name) $(this).attr('name', `${name}_${nextcounts}`);
                    if (id) $(this).attr('id', `${id}_${nextcounts}`);
                });

                $('#tabContent1').append(newContent);
            });

            // ✅ Delegate change event for dynamically added `.load_consignee`
            $(document).on('change', '.load_consignee', function () {
                const parentForm = $(this).closest('.tab-pane');
                const selectedOption = $(this).find('option:selected');
                const selectedOptionval = $(this).find('option:selected').val();
                const name = selectedOption.data('name');
                const address = selectedOption.data('address');
                const city = selectedOption.data('city');
                const state = selectedOption.data('state');
                const country = selectedOption.data('country');
                const zip = selectedOption.data('zip');

                const fullAddress = `${address}, ${city}, ${state}, ${zip}, ${country}`;
                
                if(selectedOptionval !== ''){
                    parentForm.find('.load_consignee_location').val(fullAddress);
                }else{
                    parentForm.find('.load_consignee_location').val('');
                }
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
                        url: '{{ route('edit.check.remaing.limit') }}',
                        method: 'GET',
                        data: {
                            load_id: customer_id,
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
    $('.load_consignee').on('change', function () {

        var mainid = $(this).parent().parent().parent().parent().parent().attr('id');
        var name = $('#'+mainid+' .load_consignee').find('option:selected').data('name');
        var address = $('#'+mainid+' .load_consignee').find('option:selected').data('address');
        var city = $('#'+mainid+' .load_consignee').find('option:selected').data('city');
        var state = $('#'+mainid+' .load_consignee').find('option:selected').data('state');
        var country = $('#'+mainid+' .load_consignee').find('option:selected').data('country');
        var zip = $('#'+mainid+' .load_consignee').find('option:selected').data('zip');
      
        var countryParts = country.split(' ');
        var countryName = countryParts.slice(1).join(' ');

        var fullAddress = address + ', ' + city + ', ' +
            state + ', ' + zip + ', ' + country;

        //$('#'+mainid+' input[name="load_consignee"]').val(name);
        $('#'+mainid+' .load_consignee_location').val(fullAddress);
    });
});

$(document).ready(function () {
    $('.load_shipper').on('change', function () {
        var mainid = $(this).parent().parent().parent().parent().parent().attr('id');
        var name = $('#'+mainid+' .load_shipper').find('option:selected').data('name');
        var address = $('#'+mainid+' .load_shipper').find('option:selected').data('address');
        var city = $('#'+mainid+' .load_shipper').find('option:selected').data('city');
        var state = $('#'+mainid+' .load_shipper').find('option:selected').data('state');
        var country = $('#'+mainid+' .load_shipper').find('option:selected').data('country');
        var zip = $('#'+mainid+' .load_shipper').find('option:selected').data('zip');

        var countryParts = country.split(' ');
        var countryName = countryParts.slice(1).join(' ');

        var fullAddress = address + ', ' + city + ', ' +
            state + ', ' + zip + ', ' + country;

        //$('#'+mainid+' input[name="load_shipper"]').val(name);
        $('#'+mainid+' .load_shipper_location').val(fullAddress);
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

                var customer_rate = $('#shipper_load_final_rate').val();
            
                if(total > customer_rate){
                      $('#mc-error-message').text("Final Carrier Fee not graterthe Shipper Final rate").fadeIn();
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



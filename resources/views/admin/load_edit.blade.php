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

 input:invalid {
      border: 2px solid red !important;
    }

    .form-check-input[type=checkbox] {
    border-radius: .25em;
    border: 2px solid;
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

                        <form method="POST" action="{{ route('load.update', $post->id) }}" id="myFormLoad" enctype="multipart/form-data">
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
                                        <label>Bill To <code>*</code> <a type="button" class="btn btn-info" id="customerInfoBtn"><i class="fa fa-info-circle"></i></a></label>
                                        <div class="input-group">
                                            @php
                                                $currentCustomerName = trim((string) ($post->load_bill_to ?? '')) ?: trim((string) ($post->customer?->customer_name ?? ''));
                                                $currentCustomerId = $post->customer_id ?: ($post->customer?->id ?? '');
                                            @endphp
                                            @if(!empty($currentCustomerName) || !empty($currentCustomerId))
                                                <select id="load_bill_to" class="form-control mySelect2" name="load_bill_to" @if(in_array(auth()->id(), [218, 228, 227, 226])) readonly @endif>
                                                    <option value="">Select Customer</option>
                                                    @if(!empty($currentCustomerName))
                                                        @php
                                                            $currentCustomer = collect($allcustomer)->firstWhere('customer_name', $currentCustomerName);
                                                        @endphp
                                                        <option value="{{ $currentCustomerName }}" 
                                                            data-id="{{ $currentCustomerId }}"
                                                            data-available-credit="{{ (float) get_customer_available_credit_limit($currentCustomer) }}"
                                                            data-remaining-credit="{{ (float) ($currentCustomer->remaining_credit ?? 0) }}"
                                                            data-invoice-credit-limit="{{ (float) ($currentCustomer->invoice_credit_limit ?? 0) }}"
                                                            selected>
                                                            {{ $currentCustomerName }}
                                                        </option>
                                                    @endif
                                                    @foreach($allcustomer as $cust)
                                                        @if(trim((string) $cust->customer_name) !== trim((string) $currentCustomerName))
                                                            <option value="{{ $cust->customer_name }}" 
                                                                data-id="{{ $cust->id }}"
                                                                data-available-credit="{{ (float) get_customer_available_credit_limit($cust) }}"
                                                                data-remaining-credit="{{ (float) ($cust->remaining_credit ?? 0) }}"
                                                                data-invoice-credit-limit="{{ (float) ($cust->invoice_credit_limit ?? 0) }}">
                                                                {{ $cust->customer_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" class="form-control" name="load_bill_to" value="{{ $post->load_bill_to }}" readonly>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               <input type="hidden" id="customer_id" name="customer_id" value="{{ $post->customer_id ?? ($post->customer?->id ?? '') }}">





                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Dispatcher <code>*</code></label>
                                        @php
                                            $authUserId = Auth::id(); // currently logged-in user ID
                                        @endphp

                                        @if(in_array($authUserId, [226, 227, 228, 218, 231]))
                                            <!-- Show readonly input for Auth user 226 -->
                                            <input type="text" class="form-control" 
                                                value="{{ $post->user->name ?? '' }}" 
                                                data-id="{{ $post->user->id ?? '' }}" 
                                                readonly>
                                            <input type="hidden" id="load_dispatcher" name="load_dispatcher" 
                                                value="{{ $post->user->id ?? '' }}">
                                        @else
                                            <!-- Show select normally -->
                                            <select class="form-control" id="load_dispatcher" name="load_dispatcher" required style="width: 100%;">
                                                <option value="">Select a Broker</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->name }}" data-id="{{ $user->id }}" 
                                                        @if($user->name == $post->user?->name) selected @endif>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" id="dispatcher_user_id" name="dispatcher_user_id" value="{{ $post->user_id }}">
                                        @endif

                                    </div>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>CMT Agent</label>
                                        <input class="form-control" name="cmt_agent" id="load_cmt_agent" value="{{ $post->cmt_agent }}"
                                            style="width: 100%;" autocomplete="off" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-2 mb-2">
   <div class="form-group">
    <label>Customer Payment Status</label>
    <select class="form-control select2" name="load_status" style="width: 100%;">
        <option value="{{ $post->load_status }}">
            @if($post->invoice_status == 'Paid')
                Invoiced
            @elseif($post->invoice_status == 'Paid Record')
                Paid
            @elseif($post->load_status == 'Completed')
                Completed
            @elseif($post->load_status == 'Open')
                Open
            @elseif($post->load_status == 'Unloading')
                Unloading
            @elseif($post->load_status == 'On Route')
                On Route
            @elseif($post->load_status == 'Delivered')
                Delivered
            @elseif($post->load_status == 'Covered')
                Covered
            @elseif($post->load_status == 'Cancelled')
                Cancelled
            @else
                {{ $post->load_status }}
            @endif
        </option>

        <option value="Open">Open</option>
        <option value="Covered">Covered</option>
        <option value="On Route">On Route</option>
        <option value="Unloading">Unloading</option>
        <option value="Delivered">Delivered</option>
        <option value="Completed">Completed</option>
        <option value="Cancelled">Cancelled</option>
    </select>
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
                                        <label>Load type <code>*</code></label>
                                        <div class="purple">
                                            <select class="form-control" name="load_type_two" required style="width: 100%;">
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
                                            <option value="{{$shipment->name}}" {{ $post->load_type == $shipment->name ? 'selected' : '' }}>{{$shipment->name}}</option>
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
                                @if(in_array(auth()->id(), [312, 222, 221]))

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Paid Date</label>
                                        <input type="date" class="form-control" name="load_carrier_due_date_on" id="load_carrier_due_date_on" value="{{ !empty($post->load_carrier_due_date_on) ? \Carbon\Carbon::parse($post->load_carrier_due_date_on)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                @endif
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Equipment Type
                                            <code>*</code></label>
                                        <select class="form-control mySelect2" name="load_equipment_type"
                                            id="load_equipment_type" style="width: 100%;" required>

                                            <option value="">Select Equipment </option>
                                            @foreach($equipmentType as $equipment)
                                            <option value="{{$equipment->name}}" {{ $post->load_equipment_type == $equipment->name ? 'selected' : '' }}>{{$equipment->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Invoice Number</label>
                                        <input type="text" class="form-control" name="invoice_number" id="invoice_number" value="{{ ($post->invoice_number) }}">

                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Invoice Date</label>
                                        <input type="date" class="form-control" name="invoice_date" id="invoice_date" value="{{ !empty($post->invoice_date) ? \Carbon\Carbon::parse($post->invoice_date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Paper Work Date</label>
                                        <input type="date" class="form-control" name="paper_work_date" id="invoice_date" value="{{ !empty($post->paper_work_date) ? \Carbon\Carbon::parse($post->paper_work_date)->format('Y-m-d') : '' }}">

                                    </div>
                                </div>

                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Payment Receiving Date</label>
                                        <input type="date" class="form-control" name="payment_receiving_date" id="invoice_date" value="{{ !empty($post->payment_receiving_date) ? \Carbon\Carbon::parse($post->payment_receiving_date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
								
								<div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Pre Advance Amount</label>
                                        <input type="number" class="form-control" name="pre_advance" id="invoice_date" value="{{ !empty($post->pre_advance) ? $post->pre_advance : '' }}">
                                    </div>
                                </div>
								
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Customer Payment Terms</label>
                                        <input type="text" 
                                            class="form-control" 
                                            name="invoicing_payment_terms"  
                                            id="invoicing_payment_terms" 
                                            value="{{  $post->invoicing_payment_terms ?? $post->customer?->adv_customer_payment_terms }}">
                                                                            </div>
                                </div>
                                    @if(in_array(auth()->id(), [312, 222, 221]))

                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Customer Paid Date</label>
                                        <input type="date" class="form-control" name="invoice_status_date" id="invoice_status_date" value="{{ !empty($post->invoice_status_date) ? \Carbon\Carbon::parse($post->invoice_status_date)->format('Y-m-d') : '' }}">
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Invoice Status</label>
                                        @php
                                            $selectedValue = !empty($post->customer?->invoice_through) 
                                                            ? $post->customer->invoice_through
                                                            : $post->invoice_through;
                                        @endphp
                                        <input type="text" value="{{ $selectedValue }}" id="invoice_through" class="form-control" readonly>
                                    </div>
                                </div>
								

                            </div>
                        </div>

                        <div class="card-header">

                            <h3 class="card-title"
                                style="font-size:16px;text-align:left;font-weight:700;margin-left:0;font-family:'Poppins';">
                                Customer
                            </h3>
                            <span>
                                <a href="{{ route('shipper.download.pdf', $post->load_number) }}" class="clone-link" target="_blank" rel="noopener noreferrer">
                                    <i class="fas fa-file-pdf dynamic-data" style="margin:0 10px;font-size:20px;"></i>Shipper RC</a>
                            </span>
                        </div>
                        <div class="card-body" id="CustomerForms">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <div class="form-group" id="shipper_rate_div">
                                        <label>Customer Base Rate
                                            <code>*</code></label>
                                        <input type="text" class="form-control number value" name="load_shipper_rate" value="{{ $post->load_shipper_rate }}"
                                            autocomplete="off" id="load_shipper_rate" required style="width: 100%;" @if(in_array(auth()->id(), [228, 227, 226])) readonly title="You do not have access" @endif>
                                        
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>F.S.C Rate % <input hidden type="checkbox"
                                                name="calculate_fsc_percentage" id="calculate_fsc_percentage"></label>
                                        <input class="form-control number percent" name="load_fsc_rate" autocomplete="off" id="load_fsc_rate" value="{{ $post->load_fsc_rate }}">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label class="other_charge d-flex">Customer Other Charges &nbsp; 
                                            @if(!in_array(auth()->id(), [228, 227, 226]))
                                                <i class="fa fa-plus"
                                                style="color:#0c7ce6;"
                                                data-bs-toggle="modal"
                                                data-bs-target="#myModal"
                                                id="load_shipper_other_charges">
                                                </i>
                                            @else
                                                <i class="fa fa-plus"
                                                style="color:#0c7ce6; opacity:0.5; cursor:not-allowed;"
                                                title="You do not have permission">
                                                </i>
                                            @endif
                                        </label>
                                        <input id="totalChargeAmount" class="form-control number percent"
                                            style="width: 100%;" name="shipper_total_other_charge"  readonly>

                                        <input type="hidden" id="old_shipper_load_final_rate" name="old_shipper_load_final_rate" value="{{ $post->shipper_load_final_rate ?? 0 }}">
                                    </div>

                                    <div class="modal close_shipper_other_charges_form p-0" id="myModal">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="card-header"
                                                        style="font-size: 17px;text-align: left;font-weight: 700;">
                                                        Customer Other Charges</h4>
                                                    <button type="button" class="close close-modal-btn"
                                                        style="font-size: 23px;top: 30px;"  data-bs-dismiss="modal" aria-label="Close">&times;</button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <div class="container">
                                                        @php

                                                        $rawData = $post->shipper_load_other_charge;
                                                       
                                                        // Fix missing commas between key-value pairs
                                                        $fixedData = preg_replace('/"([a-zA-Z0-9_]+)":"([^"]*)"(?!,|\})/', '"$1":"$2",', $rawData);

                                                        // Fix missing commas between objects
                                                        $fixedData = str_replace('}{', '},{', $fixedData);
                                                        
                                                        // Remove trailing commas before }
                                                        $fixedData = preg_replace('/,}/', '}', $fixedData);
                                                        $shipperCharges = json_decode($fixedData, true);

                                                       

                                                        

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
                                                        <div class="row mb-3">
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
                                                                <div class="row mb-3">
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
                                                                                value="on" disabled {{ isset($shipperCharge['for_invoice']) && $shipperCharge['for_invoice'] === 'on' ? 'checked' : '' }}>
                                                                        </div>
                                                                    </div>
                                                                    @php
                                                                        $amount = (float) ($shipperCharge['amount'] ?? 0);
                                                                    @endphp
                                                                    <div class="col-md-3">
                                                                        <div class="form-group">
                                                                            <input type="text" step="0.01" class="form-control shipperchargeAmount"
                                                                                name="shipperchargeAmount[{{ $index }}]"
                                                                                value="{{ number_format($amount, 2, '.', '') }}"
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
                                        <label>Final Customer Rate<code>*</code></label>
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
                                Carrier</h3><span><a href="{{route('rc.download.pdf', $post->load_number)}}" target="_blank">
                        <i class="fas fa-file-pdf dynamic-data" style="margin:0 10px; font-size: 20px;"></i>Carrier RC
                    </a></span>
                        </div>
                        <div class="card-body" id="CarrierForms">
                         
                            <div class="row">
                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Carrier<code>*</code> <a type="button" class="btn btn-info" id="carrierInfoBtn"><i class="fa fa-info-circle"></i></a></label>
                                        <input type="text" id="load_carrier" name="load_carrier" class="form-control" value="{{ $post->load_carrier }}"
                                            style="width: 100%;" autocomplete="off" placeholder="Select carrier">
                                        <input type="hidden"  name="carrier_id" id="carrier_id" value="{{ $post->carrier_id }}">
                                        <ul id="carrier-list" class="list-group" style="position: absolute; z-index: 1000; width: 100%; display: none;"></ul>
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
                                        data-bs-toggle="modal" data-bs-target="#otherChargesModal"></i></label>
                                        <input type="text" class="form-control" style="width: 100%;"
                                            name="carrier_total_other_charge" id="carrier_total_other_charge"
                                            readonly>
                                    </div>

                                    <!-- Modal -->
<div class="modal" id="otherChargesModal">
<div class="modal-dialog modal-lg" style="max-width: 840px;">
	<div class="modal-content" id="model_content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel" style="font-size: 17px;text-align: left;margin-left: 9px;font-weight: 700;">Carrier Other Charges</h5>
			<button type="button" class="close" data-bs-dismiss="modal" style="font-size: 23px;top: 30px;">&times;</button>
		</div>
		<div class="modal-body">
			<div class="container">
				@php
				// Decode the JSON data and check for errors
				$carrierCharges =
				json_decode($post->carrier_load_other_charge, true);
				if (json_last_error() !== JSON_ERROR_NONE || !is_array($carrierCharges)) {
				$carrierCharges = [];
				}
				
				@endphp
				<div class="row charge-row mb-3">
					<div class="col-md-6">
						<div class="form-group">
							<label>Charge Type:</label>
						</div>
					</div>
					<div class="col-md-5">
						<div class="form-group">
							<label>Amount:</label>
						</div>
					</div>
				</div>
				<!-- Fetched fields with values from the database -->
				@foreach($carrierCharges as $index => $carrierCharge)
				  
					<div class="row charge-row mb-3">
						<div class="col-md-6">
							<div class="form-group">
								<input type="text"
									class="form-control typeofcharge"
									placeholder="Enter Charges Type"
									name="shipper_type_charge[]"
									value="{{ htmlspecialchars($carrierCharge['type'] ?? '') }}">
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<input type="text" step="0.01"
									class="form-control otheramount"
									placeholder="Enter Amount"
									name="shipper_other_charge[]"
									value="{{ $carrierCharge['amount'] }}">
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
			<div class="row charge-row mb-3">
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

                                <div class="col-md-3 mb-2">
                                    <div class="form-group">
                                        <label>Carrier Payment Status</label>
                                            <select class="form-control" name="carrier_mark_as_paid">
                                                <option value="">Select Carrier Payment Status</option>
                                                <option value="Not Paid" {{ $post->carrier_mark_as_paid == 'Not Paid' ? 'selected' : '' }}>
                                                    Not Paid
                                                </option>
                                                <option value="Paid" {{ $post->carrier_mark_as_paid == 'Paid' ? 'selected' : '' }}>
                                                    Paid
                                                </option>
                                            </select>
                                     
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

                              @php
                                $i = 0;
                              @endphp
                                @if(count($shipperallData)> 0)
                                @foreach ($shipperallData as $shipper)
                                @php
                                    $key = $i++;
                                @endphp
                                
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#shipperForm{{$key + 1}}" role="tab"
                                        aria-controls="shipperForm{{$key + 1}}" aria-selected="true">Shipper {{$key + 1}}
                                        <i class="fa fa-trash remove" data-id="shipperForm{{$key + 1}}" style="margin-top: 1px;margin-left: 4px;"></i>
                                    </a>
                                </li>
                                @endforeach
								@else
								@php
                                    $key = 0;
                                @endphp
                                
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#shipperForm{{$key + 1}}" role="tab"
                                        aria-controls="shipperForm{{$key + 1}}" aria-selected="true">Shipper {{$key + 1}}
                                        <i class="fa fa-trash remove" data-id="shipperForm{{$key + 1}}" style="margin-top: 1px;margin-left: 4px;"></i>
                                    </a>
                                </li>
								@endif
                            </ul>
                            <div class="tab-content" id="tabContent">
                              @php
                                $s = 0;
                              @endphp
							  @if(count($shipperallData)> 0)
                                @foreach ($shipperallData as $shipper)
                                
                                 @php
                                    $key = $s++;
                                @endphp
                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="shipperForm{{$key + 1}}" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="row shipper-form">
                                @php
                                    $authUserId = Auth::id(); // currently logged-in user ID
                                @endphp

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Shipper <code>*</code></label>

                                        @if(in_array($authUserId, [226, 227, 228, 218, 231]))
                                            <!-- Show readonly input for Auth user 226 -->
                                            <input type="text" class="form-control" 
                                                value="{{ $shipper['name'] ?? '' }}" 
                                                data-name="{{ $shipper['name'] ?? '' }}" 
                                                readonly>
                                            <input type="hidden" name="load_shipper_{{ $key + 1 }}" 
                                                value="{{ $shipper['name'] ?? '' }}">
                                        @else
                                            <!-- Show select normally -->
                                            <select class="form-control load_shipper" 
                                                    name="load_shipper_{{ $key + 1 }}" 
                                                    id="load_shipper_{{ $key + 1 }}" 
                                                    required autocomplete="off" style="width: 100%;">
                                                <option value="">Select Shipper</option>
                                                @foreach($shipperdata as $shippers)
                                                    <option value="{{ $shippers->shipper_name }}"  
                                                            data-name="{{ $shippers->shipper_name }}" 
                                                            data-address="{{ $shippers->shipper_address }}" 
                                                            data-city="{{ $shippers->shipper_city }}" 
                                                            data-state="{{ $shippers->shipper_state }}" 
                                                            data-country="{{ $shippers->shipper_country }}" 
                                                            data-zip="{{ $shippers->shipper_zip }}"  
                                                            @if($shipper['name'] == $shippers->shipper_name) selected @endif>
                                                        {{ $shippers->shipper_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="customerErrorMessage" style="color: red; display: none;">
                                                Select Shipper From the List
                                            </span>
                                            <div id="shipperList" class="form-control" style="display: none;" readonly></div>
                                        @endif

                                    </div>
                                </div>

                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipper Location</label>
                                                <input class="form-control load_shipper_location" readonly name="load_shipper_location_{{ $key + 1 }}"  value="{{ $shipperLocation[$key]['location'] ?? '' }}" id="load_shipper_location_{{ $key + 1 }}" autocomplete="off" style="width: 100%;" title="{{ $shipperLocation[$key]['location'] ?? '' }}">
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
                                                    style="width: 100%;"> 
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input type="number" class="form-control" autocomplete="off"
                                                  id="load_shipper_qty_{{ $key + 1 }}"  name="load_shipper_qty_{{ $key + 1 }}" style="width: 100%;"  value="{{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '0') }}" >
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
                                                    autocomplete="off" style="width: 100%;" value="{{ $shipperNotes[$key]['shipping_notes'] ?? 'NA' }}">
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
								@else
								@php
                                    $key = 0;
                                @endphp
                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="shipperForm{{$key + 1}}" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="row shipper-form">
                                @php
                                    $authUserId = Auth::id(); // currently logged-in user ID
                                @endphp

                                <div class="col-md-2 mb-2">
                                    <div class="form-group">
                                        <label>Shipper <code>*</code></label>

                                        @if(in_array($authUserId, [226, 227, 228, 218, 231]))
                                            <!-- Show readonly input for Auth user 226 -->
                                            <input type="text" class="form-control" 
                                                value="{{ $shipper['name'] ?? '' }}" 
                                                data-name="{{ $shipper['name'] ?? '' }}" 
                                                readonly>
                                            <input type="hidden" name="load_shipper_{{ $key + 1 }}" 
                                                value="{{ $shipper['name'] ?? '' }}">
                                        @else
                                            <!-- Show select normally -->
                                            <select class="form-control load_shipper" 
                                                    name="load_shipper_{{ $key + 1 }}" 
                                                    id="load_shipper_{{ $key + 1 }}" 
                                                    required autocomplete="off" style="width: 100%;">
                                                <option value="">Select Shipper</option>
                                                @foreach($shipperdata as $shippers)
                                                    <option value="{{ $shippers->shipper_name }}"  
                                                            data-name="{{ $shippers->shipper_name }}" 
                                                            data-address="{{ $shippers->shipper_address }}" 
                                                            data-city="{{ $shippers->shipper_city }}" 
                                                            data-state="{{ $shippers->shipper_state }}" 
                                                            data-country="{{ $shippers->shipper_country }}" 
                                                            data-zip="{{ $shippers->shipper_zip }}">
                                                        {{ $shippers->shipper_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="customerErrorMessage" style="color: red; display: none;">
                                                Select Shipper From the List
                                            </span>
                                            <div id="shipperList" class="form-control" style="display: none;" readonly></div>
                                        @endif

                                    </div>
                                </div>

                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Shipper Location</label>
                                                <input class="form-control load_shipper_location" readonly name="load_shipper_location_{{ $key + 1 }}"  value="{{ $shipperLocation[$key]['location'] ?? '' }}" id="load_shipper_location_{{ $key + 1 }}" autocomplete="off" style="width: 100%;" title="{{ $shipperLocation[$key]['location'] ?? '' }}">
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
                                                    style="width: 100%;"> 
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <div class="form-group">
                                                <label>Qty</label>
                                                <input type="number" class="form-control" autocomplete="off"
                                                  id="load_shipper_qty_{{ $key + 1 }}"  name="load_shipper_qty_{{ $key + 1 }}" style="width: 100%;"  value="{{ isset($shipperQty[$key]['shipper_qty']) ? $shipperQty[$key]['shipper_qty'] : ($shipperQty[$key]['qty'] ?? '0') }}" >
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
								@endif
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
                                @php
                                $a = 0;
                              @endphp
							  @if(count($consigneeallData)> 0)
                                @foreach ($consigneeallData as $key => $consignee)
                               @php
                                    $key = $a++;
                                @endphp
                                <li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#consigneeSections{{$key + 1}}" role="tab"
                                        aria-controls="consigneeSections{{$key + 1}}" aria-selected="true">Consignee {{$key +1}}
                                    <i class="fa fa-trash remove" data-id="consigneeSections{{$key + 1}}" style="margin-top: 1px;margin-left: 4px;"></i>
                                    </a>
                                </li>
                                @endforeach
								@else
									@php
								$key = 0;
									@endphp
									<li class="nav-item">
                                    <a class="nav-link {{ $key == 0 ? 'active' : '' }}" style="padding: 1px 11px; border-radius: 10px;"
                                        id="formTab1" data-bs-toggle="tab" href="#consigneeSections{{$key + 1}}" role="tab"
                                        aria-controls="consigneeSections{{$key + 1}}" aria-selected="true">Consignee {{$key +1}}
                                    <i class="fa fa-trash remove" data-id="consigneeSections{{$key + 1}}" style="margin-top: 1px;margin-left: 4px;"></i>
                                    </a>
                                </li>
								@endif
                            </ul>
                            <div class="tab-content" id="tabContent1">
                                @php
                                $j = 0;
                              @endphp
							     @if(count($consigneeallData) > 0)
                                 @foreach ($consigneeallData as $key => $consignee)
                                 @php
                                    $key = $j++;
                                @endphp
                                <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="consigneeSections{{$key + 1}}" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="consignee-section mt-3">
                                        <div class="row">
                                            
                                            @php
                                                $authUserId = Auth::id(); // currently logged-in user ID
                                            @endphp

                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee <code>*</code></label>

                                                   @if(in_array($authUserId, [226, 227, 228, 218, 231]))
                                                        <!-- Show readonly input for Auth user 226 -->
                                                        <input type="text" class="form-control" 
                                                            value="{{ $consignee['name'] ?? '' }}" 
                                                            data-name="{{ $consignee['name'] ?? '' }}" 
                                                            readonly>
                                                        <input type="hidden" name="load_consignee_{{ $key + 1 }}" 
                                                            value="{{ $consignee['name'] ?? '' }}">
                                                    @else
                                                        <!-- Show select normally -->
                                                        @if(empty($consigneedata))
                                                            <div class="alert alert-warning" role="alert">
                                                                <strong>No consignees found!</strong> Please add consignees in Consignee Management first.
                                                            </div>
                                                            <input type="text" class="form-control" placeholder="No consignees available" disabled>
                                                        @else
                                                            <select class="form-control load_consignee" 
                                                                    name="load_consignee_{{ $key + 1 }}" 
                                                                    autocomplete="off"
                                                                    id="load_consignee_{{ $key + 1 }}" 
                                                                    required style="width: 100%;">
                                                                <option value="">Select Consignee ({{ count($consigneedata) }} available)</option>
                                                                @foreach($consigneedata as $consignees)
                                                                    <option value="{{ $consignees->consignee_name }}" 
                                                                            data-name="{{ $consignees->consignee_name }}" 
                                                                            data-address="{{ $consignees->consignee_address }}" 
                                                                            data-city="{{ $consignees->consignee_city }}" 
                                                                            data-state="{{ $consignees->consignee_state }}" 
                                                                            data-country="{{ $consignees->consignee_country }}" 
                                                                            data-zip="{{ $consignees->consignee_zip }}" 
                                                                            @if($consignee['name'] == $consignees->consignee_name) selected @endif>
                                                                        {{ $consignees->consignee_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        @endif
                                                        <span class="customerErrorMessage" style="color: red; display: none;">
                                                            Select Consignee From the List
                                                        </span>
                                                        <div id="consigneeList" class="form-control" style="display: none;" readonly></div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee Location</label>
                                                    <input class="form-control load_consignee_location" name="load_consignee_location_{{ $key + 1 }}"
                                                        autocomplete="off" id="load_consignee_location_{{ $key + 1 }}" value="{{ $consigneeLocation[$key]['location'] ?? '' }}"
                                                        style="width: 100%;" title="{{ $consigneeLocation[$key]['location'] ?? '' }}" readonly>
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
                                                        style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="load_consignee_qty_{{ $key + 1 }}" id="load_consignee_qty_{{ $key + 1 }}"
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
                                                        style="width: 100%; height: 31px !important;font-size: 12px;" value="{{ $consigneeNotes[$key]['load_consignee_notes'] ?? '' }}">{{ $consigneeNotes[$key]['load_consignee_notes'] ?? '' }}</textarea>
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
								@else
									@php
                                    $key = 0;
                                @endphp
                                <div class="tab-pane fade show {{ $key == 0 ? 'active' : '' }}" id="consigneeSections{{$key + 1}}" role="tabpanel"
                                    aria-labelledby="formTab1">
                                    <div class="consignee-section mt-3">
                                        <div class="row">
                                            
                                            @php
                                                $authUserId = Auth::id(); // currently logged-in user ID
                                            @endphp

                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee <code>*</code></label>

                                                   @if(in_array($authUserId, [226, 227, 228, 218, 231]))
                                                        <!-- Show readonly input for Auth user 226 -->
                                                        <input type="text" class="form-control" 
                                                            value="{{ $consignee['name'] ?? '' }}" 
                                                            data-name="{{ $consignee['name'] ?? '' }}" 
                                                            readonly>
                                                        <input type="hidden" name="load_consignee_{{ $key + 1 }}" 
                                                            value="{{ $consignee['name'] ?? '' }}">
                                                    @else
                                                        <!-- Show select normally -->
                                                        <select class="form-control load_consignee" 
                                                                name="load_consignee_{{ $key + 1 }}" 
                                                                autocomplete="off"
                                                                id="load_consignee_{{ $key + 1 }}" 
                                                                required style="width: 100%;">
                                                            <option value="">Select Consignee</option>
                                                            @foreach($consigneedata as $consignees)
                                                                <option value="{{ $consignees->consignee_name }}" 
                                                                        data-name="{{ $consignees->consignee_name }}" 
                                                                        data-address="{{ $consignees->consignee_address }}" 
                                                                        data-city="{{ $consignees->consignee_city }}" 
                                                                        data-state="{{ $consignees->consignee_state }}" 
                                                                        data-country="{{ $consignees->consignee_country }}" 
                                                                        data-zip="{{ $consignees->consignee_zip }}" >
                                                {{ $consignees->consignee_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        <span class="customerErrorMessage" style="color: red; display: none;">
                                                            Select Consignee From the List
                                                        </span>
                                                        <div id="consigneeList" class="form-control" style="display: none;" readonly></div>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Consignee Location</label>
                                                    <input class="form-control load_consignee_location" name="load_consignee_location_{{ $key + 1 }}"
                                                        autocomplete="off" id="load_consignee_location_{{ $key + 1 }}" value="{{ $consigneeLocation[$key]['location'] ?? '' }}"
                                                        style="width: 100%;" title="{{ $consigneeLocation[$key]['location'] ?? '' }}" readonly>
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
                                                        style="width: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2 mb-2">
                                                <div class="form-group">
                                                    <label>Qty</label>
                                                    <input type="number" class="form-control" name="load_consignee_qty_{{ $key + 1 }}" id="load_consignee_qty_{{ $key + 1 }}"
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
								@endif
                            </div>

                        </div>
						<div class="card-header">
                            <h3 class="card-title" style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Delivery Load Files </h3>
                        </div>
						<div class="card-body" id="delivered_files">
							<label>Delivery Load Files</label>
							<input class="form-control form-control-lg" name="load_delivery_do_file[]" id="load_delivery_do_file" accept="image/*,application/pdf" type="file" multiple>
						</div>

                        <div class="card-header">
                            <h3 class="card-title" style="font-size: 16px; text-align: left; font-weight: 700; margin-left: 0; font-family: 'Poppins';">
                                Notes </h3>
                        </div>

@php
use Carbon\Carbon;

$notes = json_decode($post->vendorInternalNotes, true);
@endphp

<div class="card-body" id="delivered_files">
    <label class="mb-3 fw-bold d-block">Vendor Notes</label>

    @if(!empty($notes) && is_array($notes))

        <div class="d-flex flex-column gap-2">

            @foreach($notes as $note)

                @php
                    $formattedDate = '';

                    if (!empty($note['date'])) {
                        $formattedDate = Carbon::createFromFormat(
                            'd-m-Y H:i A',
                            $note['date']
                        )->format('m-d-Y h:i A');
                    }
                @endphp

                <div 
                    class="px-3 py-2 rounded-pill border bg-light text-dark d-inline-block"
                    style="font-size: 13px; width: fit-content;"
                >
                    <strong>{{ $note['user'] ?? 'Admin' }}</strong>
                    -
                    <span class="text-muted">
                        {{ $formattedDate }}
                    </span>

                    <span>
                        ({{ $note['note'] ?? '' }})
                    </span>
                </div>

            @endforeach

        </div>

    @else
        <div class="text-muted">No vendor notes available.</div>
    @endif
</div>

                
@php
    $allowedAuthIds = [227, 226, 218, 312, 221, 222];
@endphp

@if(in_array(auth()->id(), $allowedAuthIds))

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"
                style="font-size: 16px;
                       font-weight: 700;
                       font-family: 'Poppins';">
                Vendor Logs
            </h3>
        </div>

        <div class="card-body" id="vendor_logs">

            @if($alllogs->count())

                @foreach($alllogs as $log)

                    @php
                        $formattedDate = format_activity_timestamp($log->created_at ?: $log->updated_at);
                        $changes = getdiffrance($log->old_json, $log->new_json);
                    @endphp

                    <div class="activity-history mb-3 border-bottom pb-3">
                        <div class="d-flex flex-wrap justify-content-between gap-2">
                            <strong class="activity-title">{{ $log->message ?: 'Activity was recorded' }}</strong>
                            <span class="activity-time text-muted">{{ $formattedDate }}</span>
                        </div>
                        <div class="mt-1">Performed by: <strong class="activity-actor">{{ $log->user_name ?: 'System' }}</strong></div>
                        <div class="activity-label text-muted mt-2"><strong>What changed:</strong></div>
                        <div class="mt-1">{!! $changes !!}</div>
                    </div>

                @endforeach

            @else

                <div class="text-muted">
                    No vendor logs available.
                </div>

            @endif

        </div>
    </div>

@endif

<style>
.activity-history {
    font-size: 16px;
}

.activity-history .activity-title {
    font-size: 17px;
}

.activity-history .activity-label,
.activity-history .small {
    font-size: 20px !important;
}

.activity-actor {
    color: #35e950;
}
</style>
        


                        <input type="submit" class="btn btn-info" value="Update Load">
                       
                    </form>
<div class="modal fade" id="customerInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Customer Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <!-- Customer Details -->
        <h5 class="mb-3">Customer Details</h5>
        <div class="row">
         <div class="col-md-6 mb-3">
            <label for="custCity" class="form-label">Customer Name</label>
            <input type="text" class="form-control" id="customer_name" readonly>
          </div>
            <div class="col-md-6 mb-3">
            <label for="custCity" class="form-label">Customer Address</label>
            <input type="text" class="form-control" id="customer_address" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custCity" class="form-label">City</label>
            <input type="text" class="form-control" id="custCity" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custState" class="form-label">State</label>
            <input type="text" class="form-control" id="custState" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custCountry" class="form-label">Country</label>
            <input type="text" class="form-control" id="custCountry" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custZip" class="form-label">Zip</label>
            <input type="text" class="form-control" id="custZip" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custTelephone" class="form-label">Telephone</label>
            <input type="text" class="form-control" id="custTelephone" readonly>
          </div>
        </div>

        <hr>

        <!-- Billing Details -->
        <h5 class="mb-3">Customer Billing Details</h5>
        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="custBillingAddress" class="form-label">Billing Address</label>
            <input type="text" class="form-control" id="custBillingAddress" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custBillingCity" class="form-label">Billing City</label>
            <input type="text" class="form-control" id="custBillingCity" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custBillingState" class="form-label">Billing State</label>
            <input type="text" class="form-control" id="custBillingState" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custBillingCountry" class="form-label">Billing Country</label>
            <input type="text" class="form-control" id="custBillingCountry" readonly>
          </div>
          <div class="col-md-6 mb-3">
            <label for="custBillingZip" class="form-label">Billing Zip</label>
            <input type="text" class="form-control" id="custBillingZip" readonly>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="carrierInfoModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Carrier Info</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6 mb-2">
            <label class="form-label">Carrier Name</label>
            <input type="text" id="carrier_name" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Address</label>
            <input type="text" id="carrier_address_two" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">City</label>
            <input type="text" id="carrierCity" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">State</label>
            <input type="text" id="carrierState" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Country</label>
            <input type="text" id="carrierCountry" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Zip</label>
            <input type="text" id="carrierZip" class="form-control" readonly>
          </div>
          <div class="col-md-6 mb-2">
            <label class="form-label">Telephone</label>
            <input type="text" id="carrierTelephone" class="form-control" readonly>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        @endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function () {

    function checkLoadType() {
        let val = $('select[name="load_type"]:first').val().toLowerCase();
		//alert(val);
        let enable = (val === 'tonu' || val === 'storage');

        $(".for_invoice").prop("disabled", !enable);
    }

    // Run on change
    $(document).on('change', 'select[name="load_type"]', checkLoadType);

    // Run on page load for default selected value
    checkLoadType();
});


    $(document).ready(function() {
        $('#load_dispatcher').on('change', function() {
            var selectedid = $(this).find('option:selected').data('id');
            $('#dispatcher_user_id').val(selectedid);
        });
    });
</script>
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
                   <i class="fa fa-trash remove" data-id="shipperForm${nextcount}" style="margin-top: 1px;margin-left: 4px;"></i>
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
			if (name) {
				let updatedName = name.replace(/_\d+$/, `_${nextcount}`);
				$(this).attr('name', updatedName).val('');
			}
			
			if (id) {
				let updatedName = id.replace(/_\d+$/, `_${nextcount}`);
				$(this).attr('id', updatedName).val('');
			}
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
                            <i class="fa fa-trash remove" data-id="consigneeSections${nextcounts}" style="margin-top: 1px;margin-left: 4px;"></i>
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
					if (name) {
						let updatedName = name.replace(/_\d+$/, `_${nextcounts}`);
						$(this).attr('name', updatedName).val('');
					}
					if (id) {
						let updatedName = id.replace(/_\d+$/, `_${nextcounts}`);
						$(this).attr('id', updatedName).val('');
					}
                   
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
        function syncCustomerSelection() {
            var selectedCustomer = $('#load_bill_to').find('option:selected');
            var customerId = selectedCustomer.data('id');
            $('#customer_id').val(customerId || '');

            if (!customerId && $('#load_bill_to').val()) {
                var customerName = $.trim($('#load_bill_to').val());
                var matches = $('#load_bill_to option').filter(function () {
                    return $.trim($(this).text()) === customerName || $.trim($(this).val()) === customerName;
                });
                if (matches.length) {
                    $('#customer_id').val(matches.first().data('id') || '');
                }
            }
        }

		 $('#load_bill_to').select2(); // Initialize Select2
		$('#load_bill_to').on('change', function() {
			syncCustomerSelection();
            $('#load_shipper_rate').prop('readonly', false);
            $('#load_shipper_rate').val(0);
			$('#shipper_load_final_rate').val(0);
        });

        syncCustomerSelection();
		
        $('#shipper_load_final_rate').on('keydown paste input', function (e) {
            e.preventDefault();
        });

        $('#myFormLoad').on('submit', function () {
            syncCustomerSelection();
        });
    });


        $(document).ready(function () {
            
            updateTotalshipperdata();

             function updateTotalshipperdata() {
                var total = 0;

                $('.shipperchargeAmount').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });

                $('#totalChargeAmount').val(total.toFixed(2));

            }

            function updateTotalshipper() {

                var total = 0;

                $('.shipperchargeAmount').each(function (index, inputBox) {
                    var amount = parseFloat($(inputBox).val()) || 0;
                    total += amount;
                });
                $('#totalChargeAmount').val(total.toFixed(2));

                var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
                total += loadShipperRate;
                var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
                var fscAmount = (loadFscRate / 100) * loadShipperRate;
                total += fscAmount;
                $('#shipper_load_final_rate').val(total.toFixed(2));

                // Display credit deduction breakdown
                displayCreditDeduction(loadShipperRate, fscAmount, total);

                var final_total_rate = parseFloat(total) - parseFloat($('#old_shipper_load_final_rate').val());
                

                var customer_id = $('#load_bill_to').val();
                
                 $.ajax({
                        url: '{{ route('edit.check.remaing.limit') }}',
                        method: 'GET',
                        data: {
                            load_id: "{{$post->load_number}}",
                            customer_id: $('#customer_id').val() || "{{$post->customer_id}}",
                            finalrate: final_total_rate,
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

            function displayCreditDeduction(baseRate, fscAmount, totalDeduction) {
                var $creditDisplay = $('#creditlimitcheck');
                if (!$creditDisplay.length) return;

                // Calculate Non-Invoice Charges (For Invoice unchecked)
                var nonInvoiceCharges = 0;
                $('.shipperchargeAmount').each(function (index) {
                    var amount = parseFloat($(this).val()) || 0;
                    var isInvoice = $('[name="for_invoice[' + index + ']"]').is(':checked');
                    if (!isInvoice && amount > 0) {
                        nonInvoiceCharges += amount;
                    }
                });

                var deductionBreakdown = 'Base: $' + parseFloat(baseRate || 0).toFixed(2);
                if (fscAmount > 0) {
                    deductionBreakdown += ' + F.S.C: $' + parseFloat(fscAmount || 0).toFixed(2);
                }
                if (nonInvoiceCharges > 0) {
                    deductionBreakdown += ' + Charges: $' + parseFloat(nonInvoiceCharges || 0).toFixed(2);
                }
                // var displayText = 'Final Deduction: $' + parseFloat(totalDeduction || 0).toFixed(2) + ' (' + deductionBreakdown + ')';

                $creditDisplay.html('<small style="color: #0066cc; font-weight: 500;">' + displayText + '</small>');

                // Log detailed calculations to console for background tracking
                var fscRate = parseFloat($('#load_fsc_rate').val() || 0);
                console.log('Credit Deduction Breakdown:', {
                    'Base Rate': '$' + parseFloat(baseRate || 0).toFixed(2),
                    'FSC Rate %': fscRate + '%',
                    'FSC Amount': '$' + parseFloat(fscAmount || 0).toFixed(2),
                    'Non-Invoice Charges': '$' + parseFloat(nonInvoiceCharges || 0).toFixed(2),
                    'Total Final Rate': '$' + parseFloat(totalDeduction || 0).toFixed(2)
                });
            }

            $(document).on('input', '.shipperchargeAmount, #load_shipper_rate, #load_fsc_rate',
                function () {
                    updateTotalshipper();
                });

        });

		
        
    </script>

<script>
function initChargeRowValidation() {

    $(document).on("input", "input[name^='shipperchargeType']", function () {
        let row = $(this).closest(".row");
        let amountField = row.find(".shipperchargeAmount");

        if ($(this).val().trim() !== "") {
            amountField.prop("disabled", false);
            row.find(".type-warning").remove(); // remove warning if exists
        } else {
            amountField.prop("disabled", true).val("");
        }
    });

    // When user focuses or tries to type in Amount
    $(document).on("input", ".shipperchargeAmount", function () {
        let row = $(this).closest(".row");
        let typeField = row.find("input[name^='shipperchargeType']");

        if (typeField.val().trim() === "") {
			
            // show warning only once
            if (row.find(".type-warning").length === 0) {
                row.find(".col-md-6").append(
                    '<small class="text-danger type-warning">First enter the type</small>'
                );
				
            }
			$(this).val('');
        }
    });

}

// Call once on page load
$(document).ready(function () {
    initChargeRowValidation();
});

function initOtherChargeValidation() {

    // When user types in Charge Type
    $(document).on("input", ".typeofcharge", function () {

        let row = $(this).closest(".charge-row");
        let amountField = row.find(".otheramount");

        if ($(this).val().trim() !== "") {
            amountField.prop("disabled", false);
            row.find(".type-warning").remove();
        } else {
            amountField.prop("disabled", true).val("");
        }
    });

    // When user types OR focuses in Amount field without entering Type
    $(document).on("input", ".otheramount", function () {

        let row = $(this).closest(".charge-row");
        let typeField = row.find(".typeofcharge");

        if (typeField.val().trim() === "") {

            if (row.find(".type-warning").length === 0) {
                row.find(".col-md-6").append(
                    '<small class="text-danger type-warning">First enter the type</small>'
                );
            }

            $(this).val("");
            //$(this).prop("disabled", true);
        }
    });

    // Disable amount fields initially
    //$(".otheramount").prop("disabled", true);
}

$(document).ready(function () {
    initOtherChargeValidation();
});

let rowIndex = {{ count($shipperCharges) }}; // Start index after existing rows

$(document).ready(function () {
    $('#addChargeBtn').click(function () {
        const newRow = `
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <input type="text" class="form-control" name="shipperchargeType[${rowIndex}]" placeholder="Enter Charge Type">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mt-3">
                    <input type="checkbox" class="form-check-input for_invoice" name="for_invoice[${rowIndex}]" value="on" disabled>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <input type="text" class="form-control shipperchargeAmount" name="shipperchargeAmount[${rowIndex}]" placeholder="Enter Amount">
                </div>
            </div>
            <div class="col-md-1" style="margin-top: 11px;">
                <button class="remove-row" type="button" style="background:unset;border:none">
                    <i style="margin-top: 15px; color:red;" class="fa fa-trash"></i>
                </button>
            </div>
        </div>`;

        $('#chargeRowsContainer').append(newRow);
		initChargeRowValidation();
        rowIndex++; // Increment index for next row
    });

     function removerowcalculateTotalCharge() {
        var total = 0;
        // Loop through all the charge-amount inputs
        $('.shipperchargeAmount').each(function() {

            var value = parseFloat($(this).val()); 
            if (!isNaN(value)) {
                total += value;
            }
        });
       
        // Update the total charge field
        $('#totalChargeAmount').val(total.toFixed(2));

        var loadShipperRate = parseFloat($('#load_shipper_rate').val()) || 0;
        total += loadShipperRate;

        var loadFscRate = parseFloat($('#load_fsc_rate').val()) || 0;
        total += (loadFscRate / 100) * loadShipperRate;

        $('#shipper_load_final_rate').val(total.toFixed(2));
    }
    // Remove row
    $(document).on('click', '.remove-row', function () {
        $(this).closest('.row').remove();
        removerowcalculateTotalCharge();
     
    });
});

</script>
    
<script>
    $(document).ready(function () {
        // Function to calculate total charges
        function calculateTotal() {
            let total = 0;
           $('.otheramount').each(function () {
				let rawValue = $(this).val().replace(/,/g, ''); // remove commas
				let amount = parseFloat(rawValue);

				if (!isNaN(amount)) {
					total += amount;
				}
			});

			
            $('#carrier_total_other_charge').val(total.toFixed(2));

             var loadCarrierFee = parseFloat($('#load_carrier_fee').val()) || 0;
            total += loadCarrierFee;

            var billingFSCRate = parseFloat($('#load_billing_fsc_rate').val()) || 0;
            var fscAmount = (loadCarrierFee * billingFSCRate) / 100;
            total += fscAmount;
            $('#load_final_carrier_fee').val(total.toFixed(2));
        }

        // Function to add a new input row
        $('.create-input').click(function () {
            // Clone the hidden template row
            var inputRow = $('#chargeRowTemplatecarrier').clone();
            // Remove the id attribute and display the row
            inputRow.removeAttr('id').show();
            // Append the new row to the container
            $('#inputs').append(inputRow);
            // Recalculate total amount after adding a new row
            calculateTotal();
        });

        // Function to remove an input row
        $(document).on('click', '.closebtn, .remove-charge', function () {
            $(this).closest('.row').remove();
            // Recalculate total amount after removing a row
            calculateTotal();
        });

        // Recalculate total amount when the page loads or when inputs are changed
        $(document).on('input', '.otheramount', function () {
            calculateTotal();
        });

        // Initial calculation on page load
        calculateTotal();
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
            
                // if(total > customer_rate){
                //       $('#mc-error-message').text("Final Carrier Fee not graterthe Shipper Final rate").fadeIn();
                //         $('#load_carrier_fee').val(0);
                //         $('#load_final_carrier_fee').val(0);
                //         // Hide after 10 seconds
                //         setTimeout(function() {
                //             $('#mc-error-message').text('').fadeOut();
                //         }, 2000); 
                // }
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
  $('#load_shipper_commodity_1').on('input', function() {
    $('#load_consignee_commodity_1').val($(this).val());
  });
  $('#load_shipper_qty_1').on('input', function() {
    $('#load_consignee_qty_1').val($(this).val());
  });
  $('#load_shipper_weight_1').on('input', function() {
    $('#load_consignee_weight_1').val($(this).val());
  });
  $('#load_shipper_value_1').on('input', function() {
    $('#load_consignee_value_1').val($(this).val());
  });
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("myFormLoad");

    if (!form) {
        console.warn("Form with ID 'myFormLoad' not found.");
        return;
    }

    form.addEventListener("submit", function(event) {
        let isValid = true;
        const requiredFields = this.querySelectorAll("[required]");

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add("is-invalid"); // Bootstrap 5 class
            } else {
                field.classList.remove("is-invalid");
            }
        });

        if (!isValid) {
            event.preventDefault(); // stop form submit
            alert("Please fill all required fields.");
        }
    });
});
</script>

<script>
$(document).on('click', '#customerInfoBtn', function() {
    var customerId = $('#customer_id').val(); // ✅ use hidden input

    if (!customerId) {
        alert("Please select a customer first.");
        return;
    }

    $.ajax({
        url: "{{ url('account/customer-info') }}/" + customerId, // now sends ID
        type: 'GET',
        success: function(data) {
            $('#custCity').val(data.city);
            $('#custState').val(data.state);
            $('#custCountry').val(data.country);
            $('#custZip').val(data.zip);
            $('#custTelephone').val(data.customer_telephone);
            $('#custBillingAddress').val(data.customer_billing_address);
            $('#custBillingCity').val(data.customer_billing_city);
            $('#custBillingState').val(data.customer_billing_state);
            $('#custBillingCountry').val(data.customer_billing_country);
            $('#custBillingZip').val(data.customer_billing_zip);
            $('#customer_name').val(data.customer_name);
            $('#customer_address').val(data.customer_address);

            $('#customerInfoModal').modal('show');
        },
        error: function() {
            alert("Unable to fetch customer info.");
        }
    });
});

$(document).ready(function() {
    var $target = $('#load_bill_to');
    var $hidden = $('#customer_id');

    if ($target.is('select')) {
        var initialId = $target.find(':selected').data('id');
        $hidden.val(initialId || '');

        $target.on('change', function() {
            var selectedId = $(this).find(':selected').data('id');
            $hidden.val(selectedId || '');
        });
    } else {
        $hidden.val($hidden.val() || '');
    }
});





</script>

<script>
$(document).on('click', '#carrierInfoBtn', function() {
    var carrierId = $('#carrier_id').val();

    if (!carrierId) {
        alert("Please select a carrier first.");
        return;
    }

    $.ajax({
        url: "/account/carrier-info/" + carrierId,  // ✅ Build URL manually
        type: "GET",
        success: function(data) {
            $('#carrierCity').val(data.city);
            $('#carrierState').val(data.state);
            $('#carrierCountry').val(data.country);
            $('#carrierZip').val(data.zip);
            $('#carrierTelephone').val(data.telephone);
            $('#carrier_address_two').val(data.carrier_address_two);
            $('#carrier_name').val(data.carrier_name);
            $('#carrierInfoModal').modal('show');
        },
        error: function() {
            alert("Unable to fetch carrier info.");
        }
    });
});

</script>

<script>
// Credit Limit Validation for Admin Load Edit
$(document).ready(function() {
    // When customer changes, update and validate credit
    $('#load_bill_to').on('change', function() {
        validateCustomerCredit();
    });

    // When final rate changes, validate credit
    $('#shipper_load_final_rate').on('change', function() {
        validateCustomerCredit();
    });

    function validateCustomerCredit() {
        var selectedOption = $('#load_bill_to').find('option:selected');
        var availableCredit = parseFloat(selectedOption.data('available-credit')) || 0;
        var remainingCredit = parseFloat(selectedOption.data('remaining-credit')) || 0;
        var invoiceCreditLimit = parseFloat(selectedOption.data('invoice-credit-limit')) || 0;
        var finalRate = parseFloat($('#shipper_load_final_rate').val()) || 0;

        var remaining = availableCredit > 0 ? availableCredit : remainingCredit;
        var $message = $('#creditlimitcheck');

        if (!selectedOption.val()) {
            $message.html('').removeClass('alert alert-warning alert-danger');
            return;
        }

        // Calculate needed credit
        if (finalRate > remaining) {
            var shortage = finalRate - remaining;
            $message.html('<div class="alert alert-danger mt-2">⚠️ Insufficient credit! Available: $' + remaining.toFixed(2) + ' | Need: $' + finalRate.toFixed(2) + ' | Shortage: $' + shortage.toFixed(2) + '</div>');
        } else {
            var available = remaining - finalRate;
            $message.html('<div class="alert alert-warning mt-2">✓ Available after this load: $' + available.toFixed(2) + ' | Invoice Limit: $' + invoiceCreditLimit.toFixed(2) + '</div>');
        }
    }

    // Validate on page load
    validateCustomerCredit();
});
</script>

<style>
.is-invalid {
    border: 1px solid red;
    background: #ffe5e5;
}
</style>


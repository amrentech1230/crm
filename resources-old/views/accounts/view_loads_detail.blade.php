@extends('layout.compact.app')
@section('content')

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
                    <h4 class="mb-sm-0">View Load</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">View Load</li>
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

                        <!-- Title -->
                        <h4 class="card-title mb-4">Load Details</h4>

                        <!-- Load Info Grid -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Load #:</strong> {{ $load->load_number }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>W/O #:</strong> {{ $load->load_workorder ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer Reference #:</strong> {{ $load->customer_refrence_number ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer #:</strong> {{ $load->load_bill_to ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Load Create Date:</strong>
                                {{ $load->created_at ? $load->created_at->format('d-m-Y') : '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Carrier:</strong> {{ $load->load_carrier ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Load Status:</strong> {{ $load->load_status ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Customer Rate:</strong> {{ $load->shipper_load_final_rate ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Carrier Rate:</strong> {{ $load->load_final_carrier_fee ?? '-' }}
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>CPR Status:</strong> {{ $load->cpr_check ?? '-' }}
                            </div>
                        </div>

                        <!-- Divider -->
                        <hr class="my-4">

                        <!-- Logs Section -->
                        <h4 class="card-title mb-3">Activity Logs</h4>

                        <div class="accordion accordion-flush" id="accordionLogs">
                            <!-- Log Entry 1 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="logHeadingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#logCollapseOne" aria-expanded="false"
                                        aria-controls="logCollapseOne">
                                        Log Entry #1
                                    </button>
                                </h2>
                                <div id="logCollapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="logHeadingOne" data-bs-parent="#accordionLogs">
                                    <div class="accordion-body">
                                        This is the first log entry. You can describe what happened here in detail.
                                    </div>
                                </div>
                            </div>

                            <!-- Log Entry 2 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="logHeadingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#logCollapseTwo" aria-expanded="false"
                                        aria-controls="logCollapseTwo">
                                        Log Entry #2
                                    </button>
                                </h2>
                                <div id="logCollapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="logHeadingTwo" data-bs-parent="#accordionLogs">
                                    <div class="accordion-body">
                                        This is the second log entry. Provide meaningful tracking info here.
                                    </div>
                                </div>
                            </div>

                            <!-- Log Entry 3 -->
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="logHeadingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#logCollapseThree" aria-expanded="false"
                                        aria-controls="logCollapseThree">
                                        Log Entry #3
                                    </button>
                                </h2>
                                <div id="logCollapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="logHeadingThree" data-bs-parent="#accordionLogs">
                                    <div class="accordion-body">
                                        This is the third log entry. You might include timestamps, users, or status
                                        info.
                                    </div>
                                </div>
                            </div>
                        </div> <!-- End Accordion -->

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->

        @endsection

@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .chart-container {
        width: 90%;
        max-width: 1000px;
        margin: 50px auto;
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        font-family: 'Poppins', sans-serif;
    }

    h2 {
        text-align: center;
        color: #003c9e;
        margin-bottom: 20px;
    }

</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Reporting</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Reporting</li>
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

                        <h4 class="card-title">Reporting</h4>


                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#dashboard" role="tab"
                                    aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#carrier" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Carrier</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#customer" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Customers</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#customer_detail" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Customer details</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#dispatcher" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Dispatchers</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#load" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Loads</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#sales_rep" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Sales Reps</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#load_completed_log" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Load Completed Logs</span>
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#limit" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Limit</span>
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#aging" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Aging</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active show" id="dashboard" role="tabpanel">
                                <div class="container-fluid">
                                    <!-- start page title -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div
                                                class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                <h4 class="mb-sm-0">Dashboard</h4>

                                                <div class="page-title-right">
                                                    <ol class="breadcrumb m-0">
                                                        <li class="breadcrumb-item"><a
                                                                href="javascript: void(0);">Upcube</a></li>
                                                        <li class="breadcrumb-item active">Dashboard</li>
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end page title -->

                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2">Total Revenue</p>
                                                            <h4 class="mb-2">${{ $revenue }}</h4>
                                                            <p class="text-muted mb-0">
                                                                <span class="text-success fw-bold font-size-12 me-2"><i
                                                                        class="ri-arrow-right-up-line me-1 align-middle"></i>9.23%</span>from
                                                                previous period
                                                            </p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                                <i class="ri-shopping-cart-2-line font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end cardbody -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2">Total Margin</p>
                                                            <h4 class="mb-2">${{ $finalTotal }}</h4>
                                                            <p class="text-muted mb-0">
                                                                <span class="text-danger fw-bold font-size-12 me-2"><i
                                                                        class="ri-arrow-right-down-line me-1 align-middle"></i>1.09%</span>from
                                                                previous period
                                                            </p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-success rounded-3">
                                                                <i class="mdi mdi-currency-usd font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end cardbody -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2">Yesterday Loads
                                                            </p>
                                                            <h4 class="mb-2">{{ $loadCount }}</h4>
                                                            <p class="text-muted mb-0">
                                                                <span class="text-success fw-bold font-size-12 me-2"><i
                                                                        class="ri-arrow-right-up-line me-1 align-middle"></i>16.2%</span>from
                                                                previous period
                                                            </p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-primary rounded-3">
                                                                <i class="ri-user-3-line font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end cardbody -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end col -->
                                        <div class="col-xl-3 col-md-6">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex">
                                                        <div class="flex-grow-1">
                                                            <p class="text-truncate font-size-14 mb-2">Total Customer
                                                                Added
                                                            </p>
                                                            <h4 class="mb-2">{{ $newCoustmerAdded }}</h4>
                                                            <p class="text-muted mb-0">
                                                                <span class="text-success fw-bold font-size-12 me-2"><i
                                                                        class="ri-arrow-right-up-line me-1 align-middle"></i>11.7%</span>from
                                                                previous period
                                                            </p>
                                                        </div>
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title bg-light text-success rounded-3">
                                                                <i class="mdi mdi-currency-btc font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- end cardbody -->
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body pb-0">

                                                    <h4 class="card-title mb-4 text-center">Sales</h4>


                                                </div>
                                                <div class="chart-container">
                                                    <h2>Daily Sales</h2>
                                                    <canvas id="salesChart"></canvas>
                                                </div>
                                            </div>
                                            <!-- end card -->
                                        </div>
                                        <!-- end row -->

                                       
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>
                            <div class="tab-pane" id="carrier" role="tabpanel">
                                <table id="datatable-buttons-carrier"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Carrier</th>
                                            <th># of Load</th>
                                            <th>Gross Revenue</th>
                                            <th>Carrier Pay</th>
                                            <th>Profit</th>
                                            <th>Miles</th>
                                            <th>Revenue / Miles</th>
                                            <th>Pay / Miles</th>
                                        </tr>
                                    </thead>

                                    <tbody id="carrier-search">
                                        @include('accounts.reporting.carrier')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="customer" role="tabpanel">
                                <table id="datatable-buttons-customer"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="dynamic-data">Sr No.</th>
                                            <th class="dynamic-data">Customer</th>
                                            <th class="dynamic-data">Gross Revenue</th>
                                            <th class="dynamic-data">Carrier Pay</th>
                                            <th class="dynamic-data">Margin</th>
                                            <th class="dynamic-data">No. Of Loads</th>
                                            <th class="dynamic-data">Open Loads</th>
                                            <th class="dynamic-data">Delivered Loads</th>
                                            <th class="dynamic-data">Completed Loads</th>
                                            <th class="dynamic-data">Approved Limit</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customer-search">
                                        @include('accounts.reporting.customers')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueCustomer->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="customer_detail" role="tabpanel">
                                <table id="datatable-buttons-customer_detail"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th class="dynamic-data">Sr No.</th>
                                            <th>Customer Creation Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Address</th>
                                            <th>Complete Billing Address</th>
                                            <th>Billing Email</th>
                                            <th>Customer Contact</th>
                                            <th>Telephone</th>
                                            <th>Ext.</th>
                                            <th>Fax</th>
                                            <th>Email</th>
                                            <th>Sales Rep (Cargo)</th>
                                            <th>Payment Terms</th>
                                            <th>Remaning Credit Limit</th>
                                            <th>Approved Credit Limit</th>
                                            <th>Customer Status</th>

                                        </tr>
                                    </thead>
                                    <tbody id="customer_detail-search">
                                        @include('accounts.reporting.customer_details')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $get_customers->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="dispatcher" role="tabpanel">
                                <table id="datatable-buttons-dispatcher"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Dispatcher</th>
                                            <th>No of Load</th>
                                            <th>Revenue</th>
                                            <th>Carrier Amount</th>
                                            <th>Margin </th>
                                            <th>Open Loads</th>
                                            <th>Delivered Loads</th>
                                            <th>Invoiced Loads</th>
                                        </tr>
                                    </thead>
                                    <tbody id="dispatcher-search">
                                        @include('accounts.reporting.dispatchers')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="load" role="tabpanel">
                                <table id="datatable-buttons-load"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Action</th>
                                            <th>Load No</th>
                                            <th>Status</th>
                                            <th>Carrier</th>
                                            <th>Created</th>
                                            <th>Dispatcher</th>
                                            <th>Customer</th>
                                            <th>Shipper</th>
                                            <th>Ship Date</th>
                                            <th>Location</th>
                                            <th>Consignee</th>
                                            <th>Delivery Date</th>
                                            <th>Delivery Location</th>
                                            <th>Cpr Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load-search">
                                        @include('accounts.reporting.load')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="sales_rep" role="tabpanel">
                                <table id="datatable-buttons-sales_rep"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Sales Rep</th>
                                            <th>No of Load</th>
                                            <th>Gross Revenue</th>
                                            <th>Carrier Pay</th>
                                            <th>Margin</th>
                                            <th>Open Load</th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_rep-search">
                                        @include('accounts.reporting.sales_reps')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="load_completed_log" role="tabpanel">
                                <table id="datatable-buttons-load_completed_log"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Load #</th>
                                            <th>Agent Name</th>
                                            <th>Load Status</th>
                                            <th>Invoice Status</th>
                                            <th>Customer Reference #</th>
                                            <th>Load Create Date</th>
                                            <th>Customer Name</th>
                                            <th>Carrier Name</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Load Type</th>
                                            <th>Carrier Advance Payment</th>
                                            <th>Delivery Date</th>
                                            <th>Actual Delivery Date</th>
                                            <th>Carrier Due Date</th>
                                            <th>Carrier Mark Payment Date</th>
                                            <th>Carrier Fee</th>
                                            <th>Shipper Rate</th>
                                            <th>Invoice No</th>
                                            <th>Invoice Date</th>
                                            <th>Paper work Received Date</th>
                                            <th>Payment Receiving Date</th>
                                            <th>Customer Payment Received Amount</th>
                                            <th>Customer Payment Mark Date</th>
                                            <th>Customer Rate</th>
                                            <th>Carrier Rate</th>
                                            <th>Margin</th>
                                            <th>Work Order</th>
                                            <th>CPR Check</th>
                                            <th>Macro Sent</th>

                                        </tr>
                                    </thead>
                                    <tbody id="load_completed_log-search">
                                        @include('accounts.reporting.load_completed_logs')
                                    </tbody>

                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="limit" role="tabpanel">
                                <table id="datatable-buttons-limit" class="table table-bordered js-data-table_limit">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Agent</th>
                                            <th>Company</th>
                                            <th>Address</th>
                                            <th>Telephone</th>
                                            <th>Date Added</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <th>Office</th>
                                            <th>Requested Credit</th>
                                            <th>Credit Used</th>
                                            <th>Remaining Limit</th>
                                            <th>Approved Status</th>
                                            <th>Last Load</th>
                                            <th>Customer Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="limit-search">
                                        @include('accounts.reporting.limit')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="aging" role="tabpanel">
                                <table id="datatable-buttons-aging"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Customer Name</th>
                                            <th>Team Lead</th>
                                            <th>Manager</th>
                                            <th>Office</th>
                                            <th>Agent</th>
                                            <th>Total Aging</th>
                                            <th>Aging Above 30 Days</th>
                                        </tr>
                                    </thead>

                                    <tbody id="aging-search">
                                        @include('accounts.reporting.aging')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $totalRevenueloadcarrier->links() }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


<script>
    $(document).ready(function () {
        // Set initial ID for the search form (fallback)
        $('form.app-search .position-relative').attr('id', 'carriers');

        let initializedTabs = {};

        function initializeTab(target) {
            let inputSelector = '';
            let ajaxUrl = '';
            let resultContainer = '';
            let tableSelector = '';

            if (target === '#carrier') {
                $('form.app-search .position-relative').attr('id', 'carriers');
                inputSelector = '#carriers input[name="query"]';
                ajaxUrl = '/report_carrier_search';
                resultContainer = '#carrier-search';
                tableSelector = '#datatable-buttons-carrier';

            } else if (target === '#customer') {
                $('form.app-search .position-relative').attr('id', 'customers');
                inputSelector = '#customers input[name="query"]';
                ajaxUrl = '/report_customer_search';
                resultContainer = '#customer-search';
                tableSelector = '#datatable-buttons-customer';

            } else if (target === '#customer_detail') {
                $('form.app-search .position-relative').attr('id', 'customer_details');
                inputSelector = '#customer_details input[name="query"]';
                ajaxUrl = '/report_customer_detail_search';
                resultContainer = '#customer_detail-search';
                tableSelector = '#datatable-buttons-customer_detail';

            } else if (target === '#dispatcher') {
                $('form.app-search .position-relative').attr('id', 'dispatchers');
                inputSelector = '#dispatchers input[name="query"]';
                ajaxUrl = '/report_dispatcher_search';
                resultContainer = '#dispatcher-search';
                tableSelector = '#datatable-buttons-dispatcher';

            } else if (target === '#load') {
                $('form.app-search .position-relative').attr('id', 'loads');
                inputSelector = '#loads input[name="query"]';
                ajaxUrl = '/report_load_search';
                resultContainer = '#load-search';
                tableSelector = '#datatable-buttons-load';

            } else if (target === '#sales_rep') {
                $('form.app-search .position-relative').attr('id', 'sales_reps');
                inputSelector = '#sales_reps input[name="query"]';
                ajaxUrl = '/report_sales_rep_search';
                resultContainer = '#sales_rep-search';
                tableSelector = '#datatable-buttons-sales_rep';

            } else if (target === '#load_completed_log') {
                $('form.app-search .position-relative').attr('id', 'load_completed_logs');
                inputSelector = '#load_completed_logs input[name="query"]';
                ajaxUrl = '/report_load_completed_log_search';
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            } else if (target === '#limit') {
                $('form.app-search .position-relative').attr('id', 'limits');
                inputSelector = '#limits input[name="query"]';
                ajaxUrl = '/report_limit_search';
                resultContainer = '#limit-search';
                tableSelector = '#datatable-buttons-limit';

            } else if (target === '#aging') {
                $('form.app-search .position-relative').attr('id', 'agings');
                inputSelector = '#agings input[name="query"]';
                ajaxUrl = '/report_aging_search';
                resultContainer = '#aging-search';
                tableSelector = '#datatable-buttons-aging';

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
                            data: {
                                query: query
                            },
                            success: function (response) {
                                if ($.fn.DataTable.isDataTable(tableSelector)) {
                                    $(tableSelector).DataTable().destroy();
                                }

                                $(resultContainer).html(response);

                                $(tableSelector).DataTable({
                                    responsive: true,
                                    dom: 'Bfrtip',
                                    buttons: ['copy', 'excel', 'pdf',
                                        'colvis'
                                    ],
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



    $(document).ready(function () {
        const tables = {
            '#carrier': {
                selector: '#datatable-buttons-carrier',
                initialized: false
            },
            '#customer': {
                selector: '#datatable-buttons-customer',
                initialized: false
            },
            '#customer_detail': {
                selector: '#datatable-buttons-customer_detail',
                initialized: false
            },
            '#dispatcher': {
                selector: '#datatable-buttons-dispatcher',
                initialized: false
            },
            '#load': {
                selector: '#datatable-buttons-load',
                initialized: false
            },
            '#sales_rep': {
                selector: '#datatable-buttons-sales_rep',
                initialized: false
            },
            '#load_completed_log': {
                selector: '#datatable-buttons-load_completed_log',
                initialized: false
            },
            '#limit': {
                selector: '#datatable-buttons-limit',
                initialized: false
            },
            '#aging': {
                selector: '#datatable-buttons-aging',
                initialized: false
            },
        };

        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
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

<script>
    const ctx = document.getElementById('salesChart').getContext('2d');

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),
            datasets: [{
                    label: 'Shipper Rate ($)',
                    data: @json($shipperRates),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    fill: true,
                    tension: 0.3
                },
                {
                    label: 'Carrier Fee ($)',
                    data: @json($carrierFees),
                    borderColor: '#003c9e',
                    backgroundColor: 'rgba(0, 60, 158, 0.1)',
                    fill: true,
                    tension: 0.3
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Amount ($)'
                    },
                    beginAtZero: true
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            },
            plugins: {
                tooltip: {
                    mode: 'index',
                    intersect: false
                },
                legend: {
                    position: 'top'
                }
            }
        }
    });

</script>
@endsection

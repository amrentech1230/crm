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
<style>
    .accordion-item {
        filter: blur(5px);
        transition: filter 0.3s ease;
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
                                <a class="nav-link" data-bs-toggle="tab" href="#aging" role="tab" aria-selected="false"
                                    tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Aging</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active show" id="dashboard" role="tabpanel">
                                @include('accounts.reporting.dashboard')
                            </div>
                            <div class="tab-pane" id="carrier" role="tabpanel">
                                <table id="datatable-buttons-carrier"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('CarrierReportingExcel')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Carrier Excel</button>
										</a>
									</span>
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Carrier</th>
                                            <th>Container No.</th>
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
									<span>
										<a href="{{route('customerReportingExcell')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Customer Excel</button>
										</a>
									</span>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer Name</th>
                                            <th>Status</th>
                                            <th>Total Revenue</th>
                                            <th>Total Carrier Cost</th>
                                            <th>Margin</th>
                                            <th>Total Loads</th>
                                            <th>Open Loads</th>
                                            <th>Delivered Loads</th>
                                            <!-- <th>Completed Loads</th> -->
                                            <th>Remaining Credit Logs</th>
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
									<span>
										<a href="{{route('customerDetailsReportingExcell')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Customer Details Excel</button>
										</a>
									</span>
                                    <thead>
                                        <tr>
                                            <th class="dynamic-data">Sr No.</th>
                                            <th>Customer Creation Date</th>
                                            <th>Customer Name</th>
                                            <th>Customer Address</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Zip</th>
                                            <th>Country</th>
                                            <th>Ext.</th>
                                            <th>Fax</th>
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
                                    
                                </div>
                            </div>
                            <div class="tab-pane" id="dispatcher" role="tabpanel">
                                <table id="datatable-buttons-dispatcher"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('dispatcherReportingExcell')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Dispatcher Excel</button>
										</a>
									</span>
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
                                    {{ $totalRevenueCarrier->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="load" role="tabpanel">
                                <table id="datatable-buttons-load"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('loadsDetailsReportingExcell')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Load Excel</button>
										</a>
									</span>
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
                                    {{ $dashboard->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="sales_rep" role="tabpanel">
                                <table id="datatable-buttons-sales_rep"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('salesReportingExcell')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Sales Rep Excel</button>
										</a>
									</span>
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
                                    {{ $totalRevenueBroker->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="load_completed_log" role="tabpanel">
                                <table id="datatable-buttons-load_completed_log"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('loadCompleteReportingExcel')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All load completed log Excel</button>
										</a>
									</span>
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Load #</th>
                                            <th>Logs Check</th>
                                            <th>Agent Name</th>
                                            <th>CMT Agent</th>
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
                                            <th>Carrier Fsc</th>
                                            <th>Carrier Other Charge</th>
                                            <th>Carrier Final Rate</th>
                                            <th>Shipper fee</th>
                                            <th>Shipper Fsc</th>
                                            <th>Shipper Other</th>
                                            <th>Shipper Final Rate</th>
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
                                            <th>Customer Short Pay</th>
                                            <th>Macro Status</th>
                                            <th>Macro Number</th>
                                            <th>Aging</th>

                                        </tr>
                                    </thead>
                                    <tbody id="load_completed_log-search">
                                        @include('accounts.reporting.load_completed_logs')
                                    </tbody>

                                </table>
                                <div class="custom-pagination">
                                    {{ $dashboard_logs->links() }}
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="aging" role="tabpanel">
                                <table id="datatable-buttons-aging"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('agingReportingExcel')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Aging Excel</button>
										</a>
									</span>
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
                                    {{ $customersData->links() }}
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
   $(document).on('click', '.custom-pagination a', function(e) {
    e.preventDefault();

    let url = $(this).attr('href');

    // Get active tab (without the #)
    let activeTab = $('.nav-link.active').attr('href');
        let resultContainer = '';
            let tableSelector = '';

            if (activeTab === '#carrier') {
                resultContainer = '#carrier-search';
                tableSelector = '#datatable-buttons-carrier';

            } else if (activeTab === '#customer') {
                resultContainer = '#customer-search';
                tableSelector = '#datatable-buttons-customer';

            } else if (activeTab === '#customer_detail') {
                resultContainer = '#customer_detail-search';
                tableSelector = '#datatable-buttons-customer_detail';

            } else if (activeTab === '#dispatcher') {
                resultContainer = '#dispatcher-search';
                tableSelector = '#datatable-buttons-dispatcher';

            } else if (activeTab === '#load') {
                resultContainer = '#load-search';
                tableSelector = '#datatable-buttons-load';

            } else if (activeTab === '#sales_rep') {
                resultContainer = '#sales_rep-search';
                tableSelector = '#datatable-buttons-sales_rep';

            } else if (activeTab === '#load_completed_log') {
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            }else if (activeTab === '#aging') {
                resultContainer = '#aging-search';
                tableSelector = '#datatable-buttons-aging';

            } else {
                return; // Exit if it's not one of the expected tabs
            }
		
    $.ajax({
        url: url,
        type: 'GET',
        data: {
            tab: activeTab 
        },
        success: function(data) {
            if ($.fn.DataTable.isDataTable(tableSelector)) {
                $(tableSelector).DataTable().destroy();
            }

            $(resultContainer).html(data);

            $(tableSelector).DataTable({
                responsive: true,
                dom: 'Bfrtip',
				buttons: ['copy', 'excel', 'pdf', 'colvis'],
				searching: false,
				paging: false
            });

            // Optional: update the browser URL
            window.history.pushState("", "", url);
        }
    });
});

$(document).ready(function() {
$('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
    const target = $(e.target).attr("href");
        let inputSelector = '';
            let ajaxUrl = '';
            let resultContainer = '';
            let tableSelector = '';

            if (target === '#carrier') {
                $('form.app-search .position-relative').attr('id', 'carriers');
                inputSelector = '#carriers input[name="query"]';
                ajaxUrl = '/account/report_carrier_search';
                resultContainer = '#carrier-search';
                tableSelector = '#datatable-buttons-carrier';

            } else if (target === '#customer') {
                $('form.app-search .position-relative').attr('id', 'customers');
                inputSelector = '#customers input[name="query"]';
                ajaxUrl = '/account/report_customer_search';
                resultContainer = '#customer-search';
                tableSelector = '#datatable-buttons-customer';

            } else if (target === '#customer_detail') {
                $('form.app-search .position-relative').attr('id', 'customer_details');
                inputSelector = '#customer_details input[name="query"]';
                ajaxUrl = '/account/report_customer_detail_search';
                resultContainer = '#customer_detail-search';
                tableSelector = '#datatable-buttons-customer_detail';

            } else if (target === '#dispatcher') {
                $('form.app-search .position-relative').attr('id', 'dispatchers');
                inputSelector = '#dispatchers input[name="query"]';
                ajaxUrl = '/account/report_dispatcher_search';
                resultContainer = '#dispatcher-search';
                tableSelector = '#datatable-buttons-dispatcher';

            } else if (target === '#load') {
                $('form.app-search .position-relative').attr('id', 'loads');
                inputSelector = '#loads input[name="query"]';
                ajaxUrl = '/account/report_load_search';
                resultContainer = '#load-search';
                tableSelector = '#datatable-buttons-load';

            } else if (target === '#sales_rep') {
                $('form.app-search .position-relative').attr('id', 'sales_reps');
                inputSelector = '#sales_reps input[name="query"]';
                ajaxUrl = '/account/report_sales_rep_search';
                resultContainer = '#sales_rep-search';
                tableSelector = '#datatable-buttons-sales_rep';

            } else if (target === '#load_completed_log') {
                $('form.app-search .position-relative').attr('id', 'load_completed_logs');
                inputSelector = '#load_completed_logs input[name="query"]';
                ajaxUrl = '/account/report_load_completed_log_search';
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            } else if (target === '#aging') {
                $('form.app-search .position-relative').attr('id', 'agings');
                inputSelector = '#agings input[name="query"]';
                ajaxUrl = '/account/report_aging_search';
                resultContainer = '#aging-search';
                tableSelector = '#datatable-buttons-aging';

            } else {
                return; // Exit if it's not one of the expected tabs
            }
        
        $.ajax({
            url: ajaxUrl,
            type: 'GET',
            data: {
				query: ''
			},
            success: function (response) {
                if ($.fn.DataTable.isDataTable(tableSelector)) {
                    $(tableSelector).DataTable().destroy();
                }

                $(resultContainer).html(response);

                $(tableSelector).DataTable({
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    searching: false,
                    paging: false
                });

                $('.loader-container').addClass('hide');
            },
            // error: function (xhr) {
                // console.error("AJAX error:", xhr.responseText);
                // $('.loader-container').addClass('hide');
            // }
        });
            
    });
});
</script>
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
                ajaxUrl = '/account/report_carrier_search';
                resultContainer = '#carrier-search';
                tableSelector = '#datatable-buttons-carrier';
  
            } else if (target === '#customer') {
                $('form.app-search .position-relative').attr('id', 'customers');
                inputSelector = '#customers input[name="query"]';
                ajaxUrl = '/account/report_customer_search';
                resultContainer = '#customer-search';
                tableSelector = '#datatable-buttons-customer';

            } else if (target === '#customer_detail') {
                $('form.app-search .position-relative').attr('id', 'customer_details');
                inputSelector = '#customer_details input[name="query"]';
                ajaxUrl = '/account/report_customer_detail_search';
                resultContainer = '#customer_detail-search';
                tableSelector = '#datatable-buttons-customer_detail';

            } else if (target === '#dispatcher') {
                $('form.app-search .position-relative').attr('id', 'dispatchers');
                inputSelector = '#dispatchers input[name="query"]';
                ajaxUrl = '/account/report_dispatcher_search';
                resultContainer = '#dispatcher-search';
                tableSelector = '#datatable-buttons-dispatcher';

            } else if (target === '#load') {
                $('form.app-search .position-relative').attr('id', 'loads');
                inputSelector = '#loads input[name="query"]';
                ajaxUrl = '/account/report_load_search';
                resultContainer = '#load-search';
                tableSelector = '#datatable-buttons-load';

            } else if (target === '#sales_rep') {
                $('form.app-search .position-relative').attr('id', 'sales_reps');
                inputSelector = '#sales_reps input[name="query"]';
                ajaxUrl = '/account/report_sales_rep_search';
                resultContainer = '#sales_rep-search';
                tableSelector = '#datatable-buttons-sales_rep';

            } else if (target === '#load_completed_log') {
                $('form.app-search .position-relative').attr('id', 'load_completed_logs');
                inputSelector = '#load_completed_logs input[name="query"]';
                ajaxUrl = '/account/report_load_completed_log_search';
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            }else if (target === '#aging') {
                $('form.app-search .position-relative').attr('id', 'agings');
                inputSelector = '#agings input[name="query"]';
                ajaxUrl = '/account/report_aging_search';
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
                                    buttons: ['copy', 'excel', 'pdf', 'colvis'],
                                    searching: false,
                                    paging: false,
                                    

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
            //if (!initializedTabs[target]) {
                initializeTab(target);
            //}
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
                    buttons: ['copy', 'excel', 'pdf', 'colvis'],
                    searching: false,
                    paging: false
                });
                tables[target].initialized = true;
            }
        });

        const activeTab = $('a[data-bs-toggle="tab"].active').attr('href');
        if (tables[activeTab] && !tables[activeTab].initialized) {
            $(tables[activeTab].selector).DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'colvis'],
                searching: false,
                paging: false
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
                    label: 'Margin ($)',
                    data: @json($margin),
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

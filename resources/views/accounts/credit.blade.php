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
                    <h4 class="mb-sm-0">Credit</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Credit</li>
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

                        <h4 class="card-title">Credit</h4>


                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                           
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#load_completed_log" role="tab"
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

                            
                        </ul>

                        <div class="tab-content p-3 text-muted">
                             
                            <div class="tab-pane active show" id="load_completed_log" role="tabpanel">
                                <table id="datatable-buttons-load_completed_log"
                                    class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
									<span>
										<a href="{{route('loadCompleteReportingExcel')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Load Complete logs Excel</button>
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
                                            <th>Account Receiving Status</th>
                                            <th>Customer Payment Received Amount</th>
                                            <th>Remaining Amount</th>
                                            <th>Excess Amount</th>
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

                                        </tr>
                                    </thead>
                                    <tbody id="load_completed_log-search">
                                        @include('accounts.reporting.load_completed_logs')
                                    </tbody>

                                </table>
                                <div class="custom-pagination" style="display:block;">
                                    {!! render_pagination_links($dashboard_logs->setPageName('logs')) !!}
                                </div>
                            </div>
                            <div class="tab-pane" id="limit" role="tabpanel">
                                <table id="datatable-buttons-limit" class="table table-bordered js-data-table_limit">
									<span>
										<a href="{{route('CreditReportingExcel')}}">
											<button class="btn btn-primary waves-effect waves-light mb-3 exlbtn" >All Limit Excel</button>
										</a>
                                        <a href="{{ route('customers.exportCreditLimitLog') }}" class="btn btn-success">
                                            <i class="fa fa-download"></i> Download Credit Limit Log
                                        </a>
									</span>
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
											<th>Remittance File</th>
                                            <th>View Remittance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="limit-search">
                                        @include('accounts.reporting.limit')
                                    </tbody>
                                </table>
								<div class="custom-pagination" style="display:block;">
                                    {!! render_pagination_links($sortedCustomers->setPageName('limits')) !!}
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

    let href = $(this).attr('href');
    if (!href) return;

    let activeTab = $('.nav-link.active').attr('href');
    let resultContainer = '';
    let tableSelector = '';
    let pageParam = 'page';

    if (activeTab === '#load_completed_log') {
        resultContainer = '#load_completed_log-search';
        tableSelector = '#datatable-buttons-load_completed_log';
        pageParam = 'logs';
    } else if (activeTab === '#limit') {
        resultContainer = '#limit-search';
        tableSelector = '#datatable-buttons-limit';
        pageParam = 'limits';
    } else {
        return;
    }

    const urlObj = new URL(href, window.location.origin);
    const pageNum = urlObj.searchParams.get(pageParam) || urlObj.searchParams.get('page') || '1';

    $.ajax({
        url: href,
        type: 'GET',
        dataType: 'json',
        data: {
            tab: activeTab,
            page: pageNum,
            [pageParam]: pageNum
        },
        success: function(response) {
            if ($.fn.DataTable.isDataTable(tableSelector)) {
                $(tableSelector).DataTable().destroy();
            }

            $(resultContainer).html(response.html || '');

            const paginationContainer = $(resultContainer).closest('.tab-pane').find('.custom-pagination');
            paginationContainer.css('display', 'block');
            paginationContainer.html(response.pagination || '');
            paginationContainer.show();

            $(tableSelector).DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'excel', 'pdf', 'colvis'],
                searching: false,
                paging: false
            });

            const separator = href.includes('?') ? '&' : '?';
            const tabParam = activeTab ? encodeURIComponent(activeTab) : '';
            const finalUrl = tabParam ? href + separator + 'tab=' + tabParam : href;
            window.history.pushState("", "", finalUrl);
        },
        error: function(xhr) {
            console.error('Credit pagination AJAX error:', xhr.responseText);
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

            if (target === '#load_completed_log') {
                $('form.app-search .position-relative').attr('id', 'load_completed_logs');
                inputSelector = '#load_completed_logs input[name="query"]';
                ajaxUrl = '/account/report_load_completed_log_search';
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            } else if (target === '#limit') {
                $('form.app-search .position-relative').attr('id', 'limits');
                inputSelector = '#limits input[name="query"]';
                ajaxUrl = '/account/report_limit_search';
                resultContainer = '#limit-search';
                tableSelector = '#datatable-buttons-limit';

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

            if (target === '#load_completed_log') {
                $('form.app-search .position-relative').attr('id', 'load_completed_logs');
                inputSelector = '#load_completed_logs input[name="query"]';
                ajaxUrl = '/account/report_load_completed_log_search';
                resultContainer = '#load_completed_log-search';
                tableSelector = '#datatable-buttons-load_completed_log';

            } else if (target === '#limit') {
                $('form.app-search .position-relative').attr('id', 'limits');
                inputSelector = '#limits input[name="query"]';
                ajaxUrl = '/account/report_limit_search';
                resultContainer = '#limit-search';
                tableSelector = '#datatable-buttons-limit';

            }else {
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
            
            '#load_completed_log': {
                selector: '#datatable-buttons-load_completed_log',
                initialized: false
            },
            '#limit': {
                selector: '#datatable-buttons-limit',
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
@endsection

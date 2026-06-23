@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Status Data</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Status Data</li>
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
        
                                        <h4 class="card-title">Status Data</h4>
                                       
        
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#all_load" role="tab" aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">All</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#open" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Open</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#delivered" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Delivered</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#completed" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">Completed</span>   
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#invoiced" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                                    <span class="d-none d-sm-block">Invoiced</span>   
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#invoiced_paid" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                                    <span class="d-none d-sm-block">Invoiced / Paid</span>    
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="loader-container hide">
                                            <div class="bouncing-dots">
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                                <div class="dot"></div>
                                            </div>
                                        </div>

                                        <div class="tab-content p-3 text-muted">
                                            <div class="tab-pane active" id="all_load" role="tabpanel">
                                                <table id="datatable-buttons-all_load" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Load #</th>
                                                        <th>Agent</th>
                                                        <th>Invoice #</th>
                                                        <th>Invoice Date</th>
                                                        <th>W/O #</th>
                                                        <th>Customer Name</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Creation Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivered Date</th>
                                                        <th>Actual Del Date</th>
                                                        <th>Carrier Name</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Load Status</th>
                                                        <th>Margin</th>
                                                        <th>Aging</th>
                                                        <th>CPR Status</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="all_load-search">
                                                        @include('admin.home.all_load')
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="open" role="tabpanel">
                                                <table id="datatable-buttons-open" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                       <th>Sr No</th>
                                                        <th>Load #</th>
                                                        <th>Agent</th>
                                                        <th>W/O #</th>
                                                        <th>Customer Name</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Creation Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivered Date</th>
                                                        <th>Carrier Name</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Load Status</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="open-search">
                                                        @include('admin.home.open_load')
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="delivered" role="tabpanel">
                                                <table id="datatable-buttons-delivered" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                         <tr>
                                                            <th>Sr No</th>
                                                            <th>Load #</th>
                                                            <th>Agent </th>
                                                            <th>W/O #</th>
                                                            <th>Customer Name</th>
                                                            <th>Office</th>
                                                            <th>Team Leader</th>
                                                            <th>Manager</th>
                                                            <th>Load Creation Date</th>
                                                            <th>Shipper Date</th>
                                                            <th>Delivered Date</th>
                                                            <th>Actual Del Date</th>
                                                            <th>Carrier Name</th>
                                                            <th>Pickup Location</th>
                                                            <th>Unloading Location</th>
                                                            <th>Load Status</th>
                                                        </tr>
                                                    </thead>


                                                    <tbody id="delivered-search">
                                                      @include('admin.home.delivered')
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="completed" role="tabpanel">
                                                <table id="datatable-buttons-completed" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Load #</th>
                                                        <th>Agent</th>
                                                        <th>W/O #</th>
                                                        <th>Customer Name</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Creation Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivered Date</th>
                                                        <th>Actual Del Date</th>
                                                        <th>Carrier Name</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Load Status</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="completed-search">
                                                        @include('admin.home.completed')
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="invoiced" role="tabpanel">
                                                <table id="datatable-buttons-invoiced" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Load #</th>
                                                        <th>Agent</th>
                                                        <th>Invoice #</th>
                                                        <th>Invoice Date</th>
                                                        <th>W/O #</th>
                                                        <th>Customer Name</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Creation Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivered Date</th>
                                                        <th>Actual Del Date</th>
                                                        <th>Carrier Name</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Load Status</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="invoiced-search">
                                                        @include('admin.home.invoiced')
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="tab-pane" id="invoiced_paid" role="tabpanel">
                                                <table id="datatable-buttons-invoiced_paid" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr No</th>
                                                        <th>Load #</th>
                                                        <th>Agent</th>
                                                        <th>Invoice #</th>
                                                        <th>Invoice Date</th>
                                                        <th>W/O #</th>
                                                        <th>Customer Name</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Creation Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivered Date</th>
                                                        <th>Actual Del Date</th>
                                                        <th>Carrier</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Load Status</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="invoiced_paid-search">
                                                        @include('admin.home.invoiced_paid')
                                                    </tbody>
                                                </table>
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
    $('form.app-search .position-relative').attr('id', 'all_loads');

    let initializedTabs = {};

    function initializeTab(target) {
        let inputSelector = '';
        let ajaxUrl = '';
        let resultContainer = '';
        let tableSelector = '';

        if (target === '#all_load') {
            $('form.app-search .position-relative').attr('id', 'all_loads');
            inputSelector = '#all_loads input[name="query"]';
            ajaxUrl = '/all_search';
            resultContainer = '#all_load-search';
            tableSelector = '#datatable-buttons-all_load';
        } else if (target === '#open') {
            $('form.app-search .position-relative').attr('id', 'opens');
            inputSelector = '#opens input[name="query"]';
            ajaxUrl = '/open_search';
            resultContainer = '#open-search';
            tableSelector = '#datatable-buttons-open';
        } else if (target === '#delivered') {
            $('form.app-search .position-relative').attr('id', 'delivereds');
            inputSelector = '#delivereds input[name="query"]';
            ajaxUrl = '/delivered_search';
            resultContainer = '#delivered-search';
            tableSelector = '#datatable-buttons-delivered';
        } else if (target === '#completed') {
            $('form.app-search .position-relative').attr('id', 'completeds');
            inputSelector = '#completeds input[name="query"]';
            ajaxUrl = '/complete_search';
            resultContainer = '#shipper-search';
            tableSelector = '#datatable-buttons-completed';
        } else if (target === '#invoiced') {
            $('form.app-search .position-relative').attr('id', 'invoiceds');
            inputSelector = '#invoiceds input[name="query"]';
            ajaxUrl = '/invoice_search';
            resultContainer = '#invoiced-search';
            tableSelector = '#datatable-buttons-invoiced';
        } else if (target === '#invoiced_paid') {
            $('form.app-search .position-relative').attr('id', 'invoiced_paids');
            inputSelector = '#invoiced_paids input[name="query"]';
            ajaxUrl = '/invoice_paid_search';
            resultContainer = '#invoiced_paid-search';
            tableSelector = '#datatable-buttons-invoiced_paid';
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
        '#all_load': { selector: '#datatable-buttons-all_load', initialized: false },
        '#open': { selector: '#datatable-buttons-open', initialized: false },
        '#delivered': { selector: '#datatable-buttons-delivered', initialized: false },
        '#completed': { selector: '#datatable-buttons-completed', initialized: false },
        '#invoiced': { selector: '#datatable-buttons-invoiced', initialized: false },
        '#invoiced_paid': { selector: '#datatable-buttons-invoiced_paid', initialized: false }
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
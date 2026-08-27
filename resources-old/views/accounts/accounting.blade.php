@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
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
    background-color: rgb(239 212 214);
    color: rgb(87, 21, 26);
    margin-bottom: 10px;
    border: 1px solid rgb(239 212 214);
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
                    <h4 class="mb-sm-0">Accounting</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Accounting</li>
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

                        <h4 class="card-title">Accounting</h4>


                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#open" role="tab"
                                    aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">Open</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#completed" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">Completed</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#invoiced" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                                    <span class="d-none d-sm-block">Invoiced</span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#invoiced_paid" role="tab"
                                    aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                                    <span class="d-none d-sm-block">Invoiced / Paid</span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="open" role="tabpanel">

                            <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">Multipal Load PI</button>

                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enter PI load number</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('loads-pi')}}" method="post">
                                                @csrf
                                                <input typ="text" name="load_numbers" class="form-control  w-100 mb-3" placeholder="Enter load numbers">
                                                <input type="submit" class="btn btn-primary w-100" name="submit" value="submit">
                                            </form>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>

                               <table id="datatable-buttons-open" class="table table-striped table-bordered dt-responsive nowrap accounts-table"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Load #</th>
                                            <th>W/O #</th>
                                            <th>Customer Name</th>
                                            <th>Customer Final Rate</th>
                                            <th>Agent</th>
                                            <th>Load Creation Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Carrier Final Rate</th>
                                            <th>Load Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="open-search">
                                    @include('accounts.partials.accounting_open')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $open->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="completed" role="tabpanel">
                                <table id="datatable-buttons-completed" class="table table-striped table-bordered dt-responsive nowrap accounts-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                             <th>Actions</th>
                                            <th>Load #</th>
                                            <th>Customer Name</th>
                                            <th>Customer Final Rate</th>
                                            <th>Internal Team Notes</th>
                                            <th>Paper Work Date</th>
                                            <th>Agent</th>
                                             <th>W/O #</th>
                                            <th>Load Creation Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Actual Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Carrier Final Rate</th>
                                            <th>Pickup Location</th>
                                            <th>unloading Location</th>
                                            <th>Load Status</th>
                                            <th>Aging</th>
                                        </tr>
                                    </thead>

                                    <tbody id="completed-search">
                                        @include('accounts.partials.accounting_complete')
                                    </tbody>
                                </table>
                                <div class="custom-pagination" id="completed-search">
                                    {{ $complete->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="invoiced" role="tabpanel">
                               
                               <button type="button" class="btn btn-primary waves-effect waves-light mb-3" data-bs-toggle="modal" data-bs-target="#exampleModalinvoice">Multipal Invoice</button>

                            <div class="modal fade" id="exampleModalinvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enter Invoice load number</h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('loads-multipal-invoice')}}" method="post">
                                                @csrf
                                                <input typ="text" name="load_numbers" class="form-control  w-100 mb-3" placeholder="Enter load numbers">
                                                <input type="submit" class="btn btn-primary w-100" name="submit" value="submit">
                                            </form>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                                <table id="datatable-buttons-invoiced" class="table table-striped table-bordered dt-responsive nowrap accounts-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                       <tr>
                                            <th>Sr No.</th>
                                            <th>Load #</th>
                                            <th>Actions</th>
                                            <th>W/O #</th>
                                            <th>Customer Name</th>
                                            <th>Paper Work Date</th>
                                            <th>Customer Payment Receiving Date</th>
                                            <th>Shipper Final Rate</th>
                                            <th>Shipper Receiving Amount</th>
                                            <th>Shipper Remaining Amount</th>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>Agent Name</th>
                                            <th>Office</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <th>Load Creation Date </th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Actual Del Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Load Status</th>
                                            <th>Aging</th>
                                            
                                        </tr>
                                    </thead>

                                    <tbody id="invoiced-search">
                                       @include('accounts.partials.accounting_invoiced')
                                    </tbody>
                                    
                                </table>
                                <div class="custom-pagination">
                                    {{ $invoiced->links() }}
                                </div>
                            </div>
                            <div class="tab-pane" id="invoiced_paid" role="tabpanel">
                                <button type="button" class="btn btn-primary waves-effect waves-light mb-3">Multipal Invoice</button>
                                <table id="datatable-buttons-invoiced_paid" class="table table-striped table-bordered dt-responsive nowrap accounts-table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Sr No.</th>
                                            <th>Load #</th>
                                            <th>Action</th>
                                            <th>W/O #</th>
                                            <th>Customer Name</th>
                                            <th>Invoice #</th>
                                            <th>Invoice Date</th>
                                            <th>Customer Payment Mark Date</th>
                                            <th>Customer Payment Receiving Date</th>
                                            <th>Paper Work Date</th>
                                            <th>Agent</th>
                                            <th>Office</th>
                                            <th>Team Leader</th>
                                            <th>Manager</th>
                                            <th>Load Creation Date</th>
                                            <th>Shipper Date</th>
                                            <th>Delivered Date</th>
                                            <th>Carrier</th>
                                            <th>Pickup Location</th>
                                            <th>Unloading Location</th>
                                            <th>Shipper Final Amount</th>
                                            <th>Received Amount</th>
                                            <th>Remaining Amount</th>
                                            <th>Advance Amount</th>
                                            <th>Load Status</th>                                           

                                        </tr>
                                    </thead>

                                    <tbody id="invoiced_paid-search">
                                       @include('accounts.partials.accounting_paid')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $paid->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>



<script>
$(document).ready(function () {
    // Set initial ID for the search form (fallback)
    $('form.app-search .position-relative').attr('id', 'opens');

    let initializedTabs = {};

    function initializeTab(target) {
        let inputSelector = '';
        let ajaxUrl = '';
        let resultContainer = '';
        let tableSelector = '';

        if (target === '#open') {
            $('form.app-search .position-relative').attr('id', 'opens');
            inputSelector = '#opens input[name="query"]';
            ajaxUrl = '/accounting_open_search';
            resultContainer = '#open-search';
            tableSelector = '#datatable-buttons-open';

        } else if (target === '#completed') {
            $('form.app-search .position-relative').attr('id', 'completeds');
            inputSelector = '#completeds input[name="query"]';
            ajaxUrl = '/accounting_completed_search';
            resultContainer = '#completed-search';
            tableSelector = '#datatable-buttons-completed';

        } else if (target === '#invoiced') {
            $('form.app-search .position-relative').attr('id', 'invoiceds');
            inputSelector = '#invoiceds input[name="query"]';
            ajaxUrl = '/accounting_invoiced_search';
            resultContainer = '#invoiced-search';
            tableSelector = '#datatable-buttons-invoiced';

        } else if (target === '#invoiced_paid') {
            $('form.app-search .position-relative').attr('id', 'invoiced_paids');
            inputSelector = '#invoiced_paids input[name="query"]';
            ajaxUrl = '/accounting_invoiced_paid_search';
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
        '#open': { selector: '#datatable-buttons-open', initialized: false },
        '#completed': { selector: '#datatable-buttons-completed', initialized: false },
        '#invoiced': { selector: '#datatable-buttons-invoiced', initialized: false },
        '#invoiced_paid': { selector: '#datatable-buttons-invoiced_paid', initialized: false },
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

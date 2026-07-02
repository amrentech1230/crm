@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
<style>
div#datatable-buttons-cpr_filter, ul.pagination.pagination-rounded, div#datatable-buttons_filter{
    display: none;
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
    background-color: rgb(212, 237, 218);
    color: rgb(87, 21, 26);
    margin-bottom: 10px;
    border: 1px solid rgb(195, 230, 203);
    border-radius: 4px;
    position: fixed;
    width: 20%;
    right: 10px;
    z-index: 9999;
    top: 10px;
}
select#rate_check-21291 {
    border: 1px solid #000;
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
                                    <h4 class="mb-sm-0">Compliance</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Compliance</li>
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
        
                                        <h4 class="card-title">Compliance</h4>
                                       
        
                                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" data-bs-toggle="tab" href="#mc" role="tab" aria-selected="true">
                                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                                    <span class="d-none d-sm-block">MC Check</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#cpr" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">CPR Check</span> 
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" data-bs-toggle="tab" href="#block_carrier" role="tab" aria-selected="false" tabindex="-1">
                                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                                    <span class="d-none d-sm-block">Blocked Carrier</span> 
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
                                            <div class="tab-pane active" id="mc" role="tabpanel">
                                               
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<span><a href="{{ route('allcomplianceloadsExcel', 'Mc') }}"><button class="btn btn-primary waves-effect waves-light mb-3 exlbtn">All MC Excel</button></a></span>
                                                    <thead>
                                                    <tr>
                                                        <th>MC No</th>
                                                        <th>DOT</th>
                                                        <th>Carrier Name</th>
                                                        <th>Agent</th>
                                                        <th>Added date</th>
                                                        <th>MC Status</th>
														<th>Setup</th>
                                                        <th>MC Status</th>
														<th>Setup Status</th>
                                                        <th>Blacklisted Carrier</th>
                                                        <th>File Upload</th>
                                                        <th>View File</th>
                                                    </tr>
                                                    </thead>


                                                    <tbody id="compliance-mc-search">
                                                        @include('accounts.partials.compliance_mc_table')
                                                    </tbody>
                                                </table>
                                                 <div class="custom-pagination">
                                                    {{ $carriers->links() }}
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="cpr" role="tabpanel">
                                                <table id="datatable-buttons-cpr" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<span><a href="{{ route('allcomplianceloadsExcel', 'Cpr') }}"><button class="btn btn-primary waves-effect waves-light mb-3 exlbtn">All CPR Excel</button></a></span>
                                                    <thead>
                                                    <tr>
                                                        <th>Load #</th>
                                                        <th>Logs Check</th>
                                                        <th>W/O #</th>
                                                        <th>Agent</th>
                                                        <th>Customer #</th>
                                                        <th>MC Number</th>
                                                        <th>Customer Final Rate</th>
                                                        <th>Office</th>
                                                        <th>Team Leader</th>
                                                        <th>Manager</th>
                                                        <th>Load Create Date</th>
                                                        <th>Shipper Date</th>
                                                        <th>Delivery Date</th>
                                                        <th>Equipment Type</th>
                                                        <th>Carrier Name</th>
                                                        <th>Carrier Final Rate</th>
                                                        <th>Pickup Location</th>
                                                        <th>Unloading Location</th>
                                                        <th>Rate check</th>
                                                        <th>Load Status</th>
                                                        <th>CPR</th>
                                                        <th>Select CPR</th>
                                                        <th>Macro</th>
                                                        <th>No of Macro</th>
                                                        <th>CPR Status</th>
                                                        <th>Documents</th>
                                                    </tr>
                                                    </thead>
                                                    

                                                    <tbody id="compliance-cpr-search">
                                                        @include('accounts.partials.compliance_cpr_table')
                                                    </tbody>
                                                </table>
                                                <div class="custom-pagination">
                                                    {{ $loads->links() }}
                                                </div>
                                            </div>

                                            <div class="tab-pane" id="block_carrier" role="tabpanel">

                                            
                                                <table id="datatable-buttons-cpr" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
												<!-- <span><a href="{{ route('allcomplianceloadsExcel', 'Cpr') }}"><button class="btn btn-primary waves-effect waves-light mb-3 exlbtn">All CPR Excel</button></a></span> -->
                                                    <thead>
                                                    <tr>
                                                       <th>MC No</th>
                                                        <th>DOT</th>
                                                        <th>Carrier Name</th>
                                                        <th>Agent</th>
                                                        <th>Added date</th>
                                                        <th>MC Status</th>
														<th>Setup Status</th>
                                                        <th>Carrier Block</th>
                                                    </tr>
                                                    </thead>
                                                    

                                                    <tbody id="compliance-cpr-search">
                                                       @foreach($carrier_blocked as $blocjked)
                                                      
                                                    <tr>
                                                        <td>{{$blocjked->carrier_mc_ff_input}}</td>
                                                        <td>{{$blocjked->carrier_dot}}</td>
                                                        <td>{{$blocjked->carrier_name}}</td>
                                                        <td>{{$blocjked->user?->name}}</td>
                                                        <td>{{$blocjked->created_at}}</td>
                                                        <td>{{$blocjked->mc_check}}</td>
                                                        <td>{{$blocjked->setup}}</td>
                                                        <td>{{$blocjked->carrier_block }}</td>
                                                    </tr>
                                                    
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <!-- <div class="custom-pagination">
                                                    {{ $loads->links() }}
                                                </div> -->
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
	let resultContainer = '';
    let tableSelector = '';
    // Get active tab (without the #)
    let activeTab = $('.nav-link.active').attr('href');

	if (activeTab === '#cpr') {
		 resultContainer = '#compliance-cpr-search';
         tableSelector = '#datatable-buttons-cpr';
	} else if (activeTab === '#mc') {
		resultContainer = '#compliance-mc-search';
            tableSelector = '#datatable-buttons';
	} else {
		return;
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
                paging: false,
                stateSave: true,
                                        buttons: [
                                    {
                                        extend: 'colvis',
                                        text: 'Select Columns'
                                    }
                                ],
            });

            // Optional: update the browser URL
            window.history.pushState("", "", url);
        }
    });
});
</script>
<script>

$(document).ready(function () {
    $('form.app-search .position-relative').attr('id', 'mcsearch');

    let initializedTabs = {};

    function initializeTab(target) {
        let inputSelector = '';
        let ajaxUrl = '';
        let resultContainer = '';
        let tableSelector = '';

        if (target === '#cpr') {
            $('form.app-search .position-relative').attr('id', 'cprsearch');
            inputSelector = '#cprsearch input[name="query"]';
            ajaxUrl = '/account/compliance-search-cpr';
            resultContainer = '#compliance-cpr-search';
            tableSelector = '#datatable-buttons-cpr';
        } else if (target === '#mc') {
            $('form.app-search .position-relative').attr('id', 'mcsearch');
            inputSelector = '#mcsearch input[name="query"]';
            ajaxUrl = '/account/compliance-search-mc';
            resultContainer = '#compliance-mc-search';
            tableSelector = '#datatable-buttons';
        } else {
            return;
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
                                 stateSave: true,
                                        buttons: [
                                    {
                                        extend: 'colvis',
                                        text: 'Select Columns'
                                    }
                                ],
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

    const activeTabLink = $('a[data-bs-toggle="tab"].active');
    if (activeTabLink.length > 0) {
        const activeTabTarget = activeTabLink.attr("href");
        initializeTab(activeTabTarget);
    }
});


$(document).ready(function() {
    
    // Delay CPR DataTable initialization until tab is shown
    let cprTableInitialized = false;
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href");
        if (target === '#cpr' && !cprTableInitialized) {
            $('#datatable-buttons-cpr').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                stateSave: true,
                                        buttons: [
                                    {
                                        extend: 'colvis',
                                        text: 'Select Columns'
                                    }
                                ],
            });
            cprTableInitialized = true;
        }
    });

});
</script>


@endsection
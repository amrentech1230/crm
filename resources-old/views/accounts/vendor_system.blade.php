@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

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
    background-color: rgb(237, 212, 214);
    color: rgb(206, 10, 27);
    margin-bottom: 10px;
    border: 1px solid rgb(230, 195, 201);
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
                                    <h4 class="mb-sm-0">Vendor System</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Vendor System</li>
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
        
                                        <h4 class="card-title">Vendor System</h4>
                                       
        
                                        <table id="datatable-buttons-vendor" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                            <tr>
                                                 <tr>
                                                    <th>Sr No.</th>
                                                    <th>Load#</th>
                                                    <th>Customer</th>
                                                     <th>Due Date</th>
                                                    <th>Carrier Due Date</th>
                                                    <th>Quick Pay %</th>
                                                    <th>Payment Method</th>
                                                    <th>Ready to Pay</th>
                                                    <th>Carrier Payment</th>
                                                    <th>Carrier Files Upload</th>
                                                    <th>Carrier Files</th>
                                                    <th>W/O #</th>
                                                    <th>Carrier</th>
                                                    <th>Invoice Number</th>
                                                    <th>Invoice Date</th>
                                                    <th>Status</th>
                                                    <th>Load Created</th>
                                                    <th>Dispatcher</th>
                                                    <th>Agent Files</th>
                                                </tr>
                                            </tr>
                                            </thead>
        
                                            <div class="loader-container hide">
                                                <div class="bouncing-dots">
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>
                                                    <div class="dot"></div>
                                                </div>
                                            </div>
                                            <tbody id="vendor-search">
                                                @include('accounts.partials.vendor_system_table')
                                            </tbody>
                                        </table>
                                         <div class="custom-pagination">
                                            {{ $vendormanagement->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->


<script>
$(document).ready(function() {
    $('input[name="query"]').on('keyup', function() {
        let query = $(this).val().trim();

        // Debounce logic
        clearTimeout($.data(this, 'timer'));
        let wait = setTimeout(() => {

            if (query.length > 0) {
                $('.loader-container').removeClass('hide');
                // Perform AJAX search
                $.ajax({
                    url: '/vendor-search',
                    type: 'GET',
                    data: { query: query },
                    success: function(response) {
                        if ($.fn.DataTable.isDataTable('#datatable-buttons-vendor')) {
                            $('#datatable-buttons-vendor').DataTable().destroy();
                        }
                        $('#vendor-search').html(response); // Inject result HTML
                       
                        $('.loader-container').addClass('hide');
                        
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr.responseText);
                    }
                });

            } else {
               
                // Optionally clear the results or reload original data
                $('#vendor-search').html('');
            }

        }, 300);

        $(this).data('timer', wait);
    });
});

</script>


@endsection
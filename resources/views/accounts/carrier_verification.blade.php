@extends('layout.compact.app')

@section('content')

<style>
    div#datatable-buttons-cpr_filter,
    ul.pagination.pagination-rounded,
    div#datatable-buttons_filter {
        display: none;
    }
#search-active .pagination-container{
    display:none !important;
}
    #mc-success-message {
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

    #mc-error-message {
        padding: 10px;
        background-color: rgb(255, 228, 230);
        color: rgb(87, 21, 26);
        margin-bottom: 10px;
        border: 1px solid rgb(248, 215, 218);
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

    .loader-container.hide {
        display: none;
    }
    /* Make Select2 same height as Bootstrap input */
.select2-container .select2-selection--single {
    height: 38px !important;
    padding: 5px 10px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 26px;
    font-size: 14px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

/* Focus effect */
.select2-container--default.select2-container--focus .select2-selection--single {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
}
</style>

<div id="mc-success-message" style="display:none;"></div>
<div id="mc-error-message" style="display:none;"></div>

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Carrier Verification</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Carrier Verification</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                            <div class="tab-pane active"  role="tabpanel">
                                <table id="carrier_verification_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Load No</th>
                                            <th>Customer Name</th>
                                            <th>Carrier Name</th>
                                            <th>Agent</th>
                                            <th>Account Information</th>
                                            <th>Factoring</th>
                                            <th>Status</th>
                                            <th>Carrier Phone Number</th>
                                            <th>Carrier Email</th>
                                            <th>Remarks</th>
                                            <th>File</th>
                                            <th>View Files</th>
                                            <th>Follow Up Note</th>
                                            <th>Logs</th>
                                        </tr>
                                    </thead>
                                    <tbody id="compliance-mc-search">
                                         @include('accounts.partials.carrier_verification_table')
                                    </tbody>

                                </table>

<div class="custom-pagination pagination-container">                                   
     {{ $loads->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
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
                    url: "{{ route('carrier_search') }}",
                    type: 'GET',
                    data: { query: query },
                    success: function(response) {
                        $('#compliance-mc-search').html(response.rows); // Inject result HTML
						$('#modals-container').html(response.modals);
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



<script>
    $(document).on('click', '.delete-doc', function () {
        if (!confirm('Delete this file?')) return;

        let id = $(this).data('id');

        $.ajax({
            url: "{{ url('/carrier-bank-doc') }}/" + id,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function () {
                location.reload();
            }
        });
    });
</script>




@endsection
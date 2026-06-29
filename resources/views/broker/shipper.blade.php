@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
#search-active .pagination-container{
    display:none !important;
}
</style>
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Shipper</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Shipper</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
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

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <h4 class="card-title">Shipper</h4>
                          <span style="float: left;margin-right: 10px;">Filter By Agents</span>
                       <span><select style="width:200px;" name="filterusers" class="form-control" id="filterusers">
						<option value="{{Auth::id()}}">{{Auth::user()->name}}</option>
                            @foreach($userInfos as $key => $user)
                                <option value="{{$key}}">{{$user}}</option>
                            @endforeach
                        </select></span>
                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Shipper</button>
                        </div>

                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Shipper Name</th>
                                    <th>Address</th>
                                    <th>Phone No.</th>
                                    <th>Added Date</th>
                                    <th>Agent</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
									<th>Status</th>
                                </tr>
                            </thead>


                            <tbody id="shipper-data">
                                @include('broker.partials.shipper_table')
                            </tbody>
                        </table>
                        <div class="custom-pagination pagination-container">
                            {{ $shipper->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
    </div>
    <!-- End Page-content -->



    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Shipper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('shipper.insert') }}" id="myForm">
                        @csrf
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Name <code>*</code></label>
                                        <input type="text" class="form-control" name="shipper_name" required="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Address<code>*</code></label>
                                        <input type="text" class="form-control" required="" name="shipper_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="shipper_country" id="country">
                                                <option value="">Choose Country</option>
												<option value="United States" data-id="{{ $allcountry->firstWhere('name', 'United States')->id }}">United States</option>

												@foreach($allcountry as $country)
													@if($country->name !== 'United States')
														<option value="{{ $country->name }}" data-id="{{ $country->id }}">{{ $country->name }}</option>
													@endif
												@endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>State <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="shipper_state"
                                                id="state" disabled="">
                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>City <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="shipper_city"
                                            id="shipper_city" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Zip <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="shipper_zip"
                                            id="shipper_zip" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input type="text" class="form-control" name="shipper_contact_name" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Contact Email</label>
                                        <input type="email" class="form-control" name="shipper_contact_email" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Telephone <code>*</code></label>
                                        <input type="number" class="form-control" required=""
                                            name="shipper_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Ext. </label>
                                        <input type="text" class="form-control" name="shipper_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input type="text" class="form-control" name="shipper_fax" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Appointments</label>
                                        <select class="form-control select2" name="shipper_appointments">
                                            <option selected="selected">Select</option>
                                            <option>Yes</option>
                                            <option>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Status <code>*</code></label>
                                        <select class="form-control select2" name="shipper_status" required="">
                                            <option value="" selected="" disabled="">Select</option>
                                            <option value="Active">Active</option>
                                            <option value="In-Active">In-Active</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3 col-sm-6">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label mr-2">Add as consignee</label>

                                        <input class="form-check-input" type="checkbox" name="same_as_consignee"
                                            id="same_as_consignee" value="1"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Shipping Notes </label>
                                        <textarea class="form-control" name="shipper_shipping_notes"
                                            style="width: 100%; height: 100px !important;"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group mb-3">
                                        <label>Internal Notes </label>
                                        <textarea class="form-control" name="shipper_internal_notes"
                                            style="width: 100%; height: 100px !important;"></textarea>
                                    </div>
                                </div>
                                @if(in_array(Auth::user()->role_id, [1,2,3]))
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label>Assign To </label>
                                            <select class="form-control" required name="user_id"
                                                style="width: 100%;">
                                                <option value="">Select a Broker</option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}" data-id="{{$user->id}}" >{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                @endif
                            </div>
                            <div class="modal-footer mt-4">
                                <input type="submit" class="btn btn-info" value="Save" />
                                <input type="reset" class="btn btn-warning" id="clearFormButton" value="Clear Form" />
                                <input type="button" class="btn btn-danger" data-bs-dismiss="modal" value="Cancel" />
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
<script>
     $(document).on('click', '.custom-pagination a', function(e) {
		//initDataTable();
        e.preventDefault();
        let url = $(this).attr('href');

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
			 if ($.fn.DataTable.isDataTable('#datatable')) {
					$('#datatable').DataTable().destroy();
				}
				$('#shipper-data').html(data);
				$('#datatable').DataTable({
					responsive: true,
					dom: 'frtip',
					 paging: false,
					buttons: false,
				});
                 
                window.history.pushState("", "", url); // optional: update URL
            }
        });
    });
</script>
<script>
$(document).ready(function () {
    // Initialize Select2 once
    $('#country').select2();
    $('#state').select2();

    // Handle change event
    $('#country').on('change', function () {
        let countryId = $(this).find('option:selected').data('id');

        if (countryId) {
            $.ajax({
                url: '/broker/shipper-get-states/' + countryId, // Adjust route if needed
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#state').empty().prop('disabled', false);

                    // Add default placeholder
                    $('#state').append('<option value="">Choose State</option>');

                    // Assuming `data` is an array of objects like [{id: 1, name: 'Texas'}, ...]
                        $('#state').append(
                            $(data)
                        );
                  
                    // Refresh Select2
                    $('#state').trigger('change');
                }
            });
        } else {
            $('#state').empty().append('<option value="">Choose State</option>');
        }
    });
});
	
$(document).ready(function () {
    // Set ID for the search form wrapper
    $('form.app-search .position-relative').attr('id', 'shipper');

    function initializeTab() {
        const inputSelector = 'input[name="query"]';
        const ajaxUrl = '/broker/shipper_search';
        const resultContainer = '#shipper-data';
        const tableSelector = '#datatable';

        // Set up keyup listener with debounce
        $(inputSelector).on('keyup', function () {
            const query = $(this).val().trim();
            clearTimeout($.data(this, 'timer'));

            const wait = setTimeout(() => {
                if (query.length > 0) {
                    $('.loader-container').removeClass('hide');

                    $.ajax({
                        url: ajaxUrl,
                        type: 'GET',
                        data: { query: query },
                        success: function (response) {
                            // Destroy existing DataTable if it exists
                            if ($.fn.DataTable.isDataTable(tableSelector)) {
                                $(tableSelector).DataTable().destroy();
                            }

                            // Inject new table rows
                            $(resultContainer).html(response);

                            // Re-initialize DataTable
                            $(tableSelector).DataTable({
                                responsive: true,
                                dom: 'rtip',
                                buttons: [],            // Set to empty array instead of false
                                pageLength: 50,         // Show 50 rows per page
                                lengthMenu: [10, 25, 50, 100] // Dropdown options
                            });

                            $('.loader-container').addClass('hide');
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            $('.loader-container').addClass('hide');
                        }
                    });
                } else {
                    // Clear results if query is empty
                    $(resultContainer).html('');
                }
            }, 300); // 300ms debounce

            $(this).data('timer', wait);
        });
    }

    initializeTab();
});


$(document).ready(function () {
    // Set ID for the search form wrapper
    $('form.app-search .position-relative').attr('id', 'shipper');

    function initializeTabuser() {
        const inputSelector = '#filterusers';
        const ajaxUrl = '/broker/shipper_search_user';
        const resultContainer = '#shipper-data';
        const tableSelector = '#datatable';

        // Set up keyup listener with debounce
        $(inputSelector).on('change', function () {
            const user_id = $(this).val().trim();
          
                    $.ajax({
                        url: ajaxUrl,
                        type: 'GET',
                        data: { user_id: user_id },
                        success: function (response) {
                            // Destroy existing DataTable if it exists
                            if ($.fn.DataTable.isDataTable(tableSelector)) {
                                $(tableSelector).DataTable().destroy();
                            }

                            // Inject new table rows
                            $(resultContainer).html(response);

                            // Re-initialize DataTable
                            $(tableSelector).DataTable({
                                responsive: true,
                                dom: 'rtip',
                                buttons: [],            // Set to empty array instead of false
                                pageLength: 50,         // Show 50 rows per page
                                lengthMenu: [10, 25, 50, 100] // Dropdown options
                            });

                            $('.loader-container').addClass('hide');
                        },
                        error: function (xhr) {
                            console.error("AJAX error:", xhr.responseText);
                            $('.loader-container').addClass('hide');
                        }
                    });
              
        });
    }

    initializeTabuser();
});
</script>

    @endsection

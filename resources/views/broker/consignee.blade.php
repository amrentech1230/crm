@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Consignee</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Consignee</li>
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

                        <h4 class="card-title">Consignee</h4>
                          <span style="float: left;margin-right: 10px;">Filter By Agents</span>
                         <span><select style="width:200px;" name="filterusers" class="form-control" id="filterusers">
						<option value="{{Auth::id()}}">{{Auth::user()->name}}</option>
                            @foreach($userInfos as $key => $user)
                                <option value="{{$key}}">{{$user}}</option>
                            @endforeach
                        </select></span>
                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Consignee</button>
                        </div>

                        <table id="datatable" class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Action</th>
                                <th>Consignee Name</th>
                                <th>Address</th>
                                <th>Phone No.</th>
                                <th>Added At</th>
                                <th>Agent</th>
                                <th>Team Leader</th>
                                <th>Manager</th>
								<th>Status</th>
                            </tr>
                            </thead>


                            <tbody id="consignee-data">
                                @include('broker.partials.consignee_table')                           
                            </tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $consignees->links() }}
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
</div>
                <!-- End Page-content -->



    <!--  Modal content for the above example -->
    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Consignee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form method="POST" action="{{ route('consignee.store') }}" id="myForm">
                    @csrf
                    <div class="card-body text-left">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Name <code>*</code></label>
                                    <input class="form-control" name="consignee_name" required="" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Address <code>*</code></label>
                                    <input class="form-control" name="consignee_address" required="" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Country <code>*</code></label>
                                    <div>
                                        <select class="form-control select2" required="" name="consignee_country" id="country">
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
                                        <select class="form-control select2" required="" name="consignee_state" id="state" disabled="">
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>City <code>*</code></label>
                                    <input class="form-control" required="" name="consignee_city" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Zip <code>*</code></label>
                                    <input type="text" class="form-control" required="" name="consignee_zip" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Major Intersections</label>
                                    <input class="form-control" name="consignee_major_intersections" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label>Status <code>*</code></label>
                                    <select class="form-control" required="" name="consignee_status" style="width: 100%; height: 35px; padding: 1px;">
                                        <option value="" selected="" disabled="">Select Status</option>
                                        <option value="Active">Active</option>
                                        <option value="In-Active">In-Active</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>POC Name</label>
                                    <input class="form-control" name="consignee_contact_name" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Contact Email</label>
                                    <input class="form-control" name="consignee_contact_email" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Telephone<code>*</code></label>
                                    <input type="number" class="form-control" required="" name="consignee_telephone" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Ext. </label>
                                    <input class="form-control" name="consignee_ext" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Toll Free</label>
                                    <input class="form-control" name="consignee_toll_free" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Fax</label>
                                    <input class="form-control" name="consignee_fax" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Consignee Hours</label>
                                    <input type="time" class="form-control" name="consignee_hours" style="width: 100%;" />
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Appointments</label>
                                    <select class="form-control select2" name="consignee_appointments" style="width: 100%;">
                                        <option selected="selected">Please Select </option>
                                        <option>No</option>
                                        <option>Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px; margin-bottom: 10px;">
                            <div class="col-md-4 col-sm-6">
                                <div class="col-12 col-sm-3">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label mr-2" style="white-space: nowrap;">Add as Shipper</label>
                                        <input class="form-check-input" type="checkbox" name="consignee_add_shippper" id="consignee_add_shippper" value="1" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-31">
                                    <label>Internal Notes </label>
                                    <textarea class="form-control" name="consignee_internal_notes" style="width: 100%; height: 61px;"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-31">
                                    <label>Shipping Notes </label>
                                    <textarea class="form-control" name="consignee_shipping_notes" style="width: 100%; height: 61px;"></textarea>
                                </div>
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
                                        <option value="{{$user->id}}" data-id="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        @endif
                       
                    </div>
                    <div class="modal-footer mt-4">
                        <input type="submit" class="btn btn-info" value="Save" onclick="saveFormData()" />
                        <input type="reset" style="font-size: 14px !important;" class="btn btn-warning" id="clearFormButton" value="Clear Form" />
                        <input type="button" class="btn btn-danger" data-bs-dismiss="modal" value="Cancel" />
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
				$('#consignee-data').html(data);
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
                url: '/broker/consignee-get-states/' + countryId, // Adjust route if needed
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
    $('form.app-search .position-relative').attr('id', 'consignee');

    function initializeTab() {
        const inputSelector = 'input[name="query"]';
        const ajaxUrl = '/broker/consignee_search';
        const resultContainer = '#consignee-data';
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
    
    function initializeTabuser() {
        const inputSelector = '#filterusers';
        const ajaxUrl = '/broker/consignee_search_user';
        const resultContainer = '#consignee-data';
        const tableSelector = '#datatable';

        // Set up keyup listener with debounce
        $(inputSelector).on('change', function () {
            const user_id = $(this).val();
            
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
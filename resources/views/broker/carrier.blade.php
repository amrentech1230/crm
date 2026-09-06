@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
.dt-buttons.btn-group.flex-wrap {
    display: none !important;
}
</style>
@if(session('popup_error'))
<script>
    alert("{{ session('popup_error') }}");
</script>
@endif

<div class="page-content">
    <div class="container-fluid">
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
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">carrier</h4>
                    
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">carrier</li>
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

                        <h4 class="card-title">carrier</h4>
                         
                        
                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add carrier</button>
                        </div>
                        

                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#my-carrier" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block">My Carrier</span> 
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#all-carrier" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block">All Carrier</span> 
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
                            <div class="tab-pane active" id="my-carrier" role="tabpanel">
							<span style="float: left;margin-right: 10px;">Filter By Agents</span>
							<span style="display:inline-block;width:200px;"><select style="width:200px;max-width:200px;" name="filterusers" class="no-select2" id="filterusers">
							<option value="{{Auth::id()}}">{{Auth::user()->name}}</option>
								@foreach($userInfos as $key => $user)
									<option value="{{$key}}">{{$user}}</option>
								@endforeach
							</select></span> 
                                
                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Carrier Name</th>
                                        <th>MC No./FF No.</th>
                                        <th>DOT</th>
                                        <th>Address</th>
                                        <th>Phone No.</th>
                                        <th>Date Added</th>
                                        <th>Agent</th>
                                        <th>Team Leader</th>
                                        <th>Manager</th>
                                        <th>Carrier Status</th>
										<th>Documents</th>
                                    </tr>
                                    </thead>


                                    <tbody id="my-carrier-search-data">
                                        @include('broker.partials.carrier_table')
                                    </tbody>
                                </table>
                                    <div class="custom-pagination">
                                    {{ $carriers->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                            <div class="tab-pane" id="all-carrier" role="tabpanel">
                                <table id="datatable-buttons-all-carrier" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Carrier Name</th>
                                        <th>MC No./FF No.</th>
                                        <th>DOT</th>
                                        <th>Address</th>
                                        <th>Phone No.</th>
                                        <th>Date Added</th>
                                        <th>Agent</th>
                                        <th>Team Leader</th>
                                        <th>Manager</th>
                                        <th>Carrier Status</th>
                                    </tr>
                                    </thead>
                                    

                                    <tbody id="all-carrier-search-data">
                                        @include('broker.partials.all_carrier_table')
                                    </tbody>
                                </table>
                                <div class="custom-pagination">
                                    {{ $allcarriers->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add carrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('carrier.create') }}" id="myForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Carrier Name <code>*</code></label>
                                        <input class="form-control select2" required="" name="carrier_name"
                                            style="width: 100%; ">

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="mr-2">M.C. #/F.F.#
                                            <code>*</code></label>
                                        <div class="d-flex" style="width: 100%;">
                                            <select class="form-control select2 mr-2" required="" name="carrier_mc_ff"
                                                style="width: 35% !important;height:35px ">
                                                <option selected="selected" value="FF">
                                                    FF
                                                </option>
                                                <option selected="MC">MC</option>
                                            </select>
                                            <input type="text" class="form-control select2" required=""
                                                name="carrier_mc_ff_input" id="carrier_mc_ff_input"
                                                style="width: 65%; ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label>D.O.T</label>
                                        <input class="form-control" name="carrier_dot" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label>Address<code>*</code></label>
                                        <input class="form-control" required="" name="carrier_address_two"
                                            style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country<code>*</code></label>
                                        <select required="" class="form-control select2" name="carrier_country"
                                            id="country">
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
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>State<code>*</code></label>
                                        <div>
                                            <select class="form-control select2" name="carrier_state" id="state"
                                                required="" disabled="">
                                              
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>City<code>*</code></label>
                                        <input class="form-control" name="carrier_city" required=""
                                            style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Zip<code>*</code></label>
                                        <input class="form-control" type="text" name="carrier_zip" required=""
                                            id="carrier_zip" style="width: 100%;  ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input class="form-control" name="carrier_contact_name" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Email</label>
                                        <input class="form-control" name="carrier_email" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Phone No<code>*</code></label>
                                        <input type="number" class="form-control" name="carrier_telephone" required=""
                                            id="carrier_telephone" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Extn. </label>
                                        <input class="form-control" name="carrier_extn" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input class="form-control" name="carrier_fax" style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Status <code>*</code></label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" name="carrier_status"
                                                style="width: 100%;" required="">
                                                <option value="" selected="" disabled="">Select</option>
                                                <option value="Active" style="font-family: 'Poppins', sans-serif;">
                                                    Active</option>
                                                <option value="In-Active" style="font-family: 'Poppins', sans-serif;">
                                                    In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Payment Terms </label>
                                        <div class="select2-purple">
                                            <select class="form-control select2" name="carrier_payment_terms"
                                                style="width: 100%;  ">
                                                <option selected="selected">Select
                                                    Payment
                                                </option>
                                                <option style="font-family: 'Poppins', sans-serif;">
                                                    Prepaid
                                                </option>
                                                <option style="font-family: 'Poppins', sans-serif;">
                                                    Postpaid
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Factoring Company </label>
                                        <input class="form-control" name="carrier_factoring_company"
                                            style="width: 100%; ">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">Notes</label>
                                        <textarea class="form-control" name="carrier_notes"
                                            style="width: 100%; height: 70px !important"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">File
                                            Upload</label>
                                        <input type="file" class="form-control" name="carrier_file_upload[]"
                                            id="carrier_file_upload" multiple="" accept="image/*,application/pdf"
                                            style="width: 100%; height: 70px !important">
                                    </div>
                                </div>
                                @if(in_array(Auth::user()->role_id, [1,2,3]))
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label>Assign To </label>
                                            <select class="form-control" id="user_id_add" required name="user_id"
                                                style="width: 100%;">
                                                <option value="">Select a Broker</option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}" data-id="{{$user->id}}">{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <input type="hidden" id="dispatcher_name_add" name="dispatcher_name" value="">
                                @else
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                <input type="hidden" name="dispatcher_name" value="{{Auth::user()->name}}">
                                @endif
                            </div>
                            <div class="mt-4 mb-4 text-center">
                                <input type="submit" class="btn btn-info" value="Save" style="padding: 8px 40px;">
                                <input type="button" class="btn btn-danger" data-bs-dismiss="modal" value="Cancel"
                                    style="font-size: 15px;padding: 8px 40px;">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
	
	
<script>
   $(document).on('click', '.custom-pagination a', function(e) {
    e.preventDefault();

    let url = $(this).attr('href');

    // Get active tab (without the #)
    let activeTab = $('.nav-link.active').attr('href');

	if (activeTab === '#my-carrier') {
		resultContainer = '#my-carrier-search-data';
		tableSelector = '#datatable-buttons';
	} else if (activeTab === '#all-carrier') {
		resultContainer = '#all-carrier-search-data';
		tableSelector = '#datatable-buttons-all-carrier';
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
                dom: 'rtip',
                buttons: false,
                buttons: false,
                pageLength: 50,              // ✅ default show 50
                //lengthMenu: [10, 25, 50, 100] // ✅ dropdown options
            });

            // Optional: update the browser URL
            window.history.pushState("", "", url);
        }
    });
});
</script>
<script>
    $(document).ready(function() {
        $('#user_id_add').on('change', function() {
            var selectedName = $(this).find('option:selected').text();
            $('#dispatcher_name_add').val(selectedName);
        });
    });
</script>

    <script>
    $(document).ready(function () {
    // Initialize Select2 once
    $('#country').select2({ width: '100%', dropdownParent: $('body') });
    $('#state').select2({ width: '100%', dropdownParent: $('body') });

    // Handle change event
    $('#country').on('change', function () {
        let countryId = $(this).find('option:selected').data('id');

        if (countryId) {
            $.ajax({
                url: '/broker/carrier-get-states/' + countryId, // Adjust route if needed
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
</script>
    <script>
        //const modal = new bootstrap.Modal($('#carrierModal')[0]);

        // Open modal for edit
        $('.editCarrierBtn').on('click', function () {
            let id = $(this).data('id');

            $.ajax({
                url: `/broker/carrier/${id}/edit`,
                method: 'GET',
                dataType: 'json',
                success: function (json) {
                    $('#carrierForm').attr('action', `/carrier/${id}`);
                    $('#carrierMethod').val('PUT');
                    $('#carrierModalTitle').text('Edit Carrier');
                    $('#carrierSubmit').text('Update Carrier');

                    $('#carrier_name').val(json.carrier_name);
                    $('#carrier_mc_ff').val(json.carrier_mc_ff);
                    $('#carrier_mc_ff_input').val(json.carrier_mc_ff_input);
                    // populate other fields if present...

                    //modal.show();
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });

    </script>


<script>

$(document).ready(function () {
    $('form.app-search .position-relative').attr('id', 'my-carrier-search');

    let initializedTabs = {};

    function initializeTab(target) {
        let inputSelector = '';
        let ajaxUrl = '';
        let resultContainer = ''; 

        if (target === '#my-carrier') {
            $('form.app-search .position-relative').attr('id', 'my-carrier-search');
            inputSelector = '#my-carrier-search input[name="query"]';
            ajaxUrl = '/broker/my-carrier-search';
            resultContainer = '#my-carrier-search-data';
            tableSelector = '#datatable-buttons';
        } else if (target === '#all-carrier') {
            $('form.app-search .position-relative').attr('id', 'all-carrier-search');
            inputSelector = '#all-carrier-search input[name="query"]';
            ajaxUrl = '/broker/all-carrier-search';
            resultContainer = '#all-carrier-search-data';
            tableSelector = '#datatable-buttons-all-carrier';
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
                            $(resultContainer).html(response.html);
                            $(tableSelector).DataTable({
                                responsive: true,
                                dom: 'rtip',
                                buttons: false,
                                buttons: false,
                                pageLength: 50,              // default show 50
                               // lengthMenu: [10, 25, 50, 100] // dropdown options
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
       
        if (target === '#all-carrier' && !cprTableInitialized) {
            $('#datatable-buttons-all-carrier').DataTable({
                responsive: true,
                dom: 'rtip',
                buttons: false,
                pageLength: 50,              // ✅ default show 50
                //lengthMenu: [10, 25, 50, 100] // ✅ dropdown options
            });
            cprTableInitialized = true;
        }
        initializeTab(target);
    });
 
});

$('#filterusers').on('change', function () {
    const selectedUser = $(this).val();
    const activeTab = $('.nav-link.active').attr('href'); // e.g., "#open"
    let ajaxUrl = '';
    let resultContainer = '';
    let tableSelector = '';

    
	if (activeTab === '#my-carrier') {
		
		ajaxUrl = '/broker/carrier-search-user';
		resultContainer = '#my-carrier-search-data';
		tableSelector = '#datatable-buttons';
	} else {
		return;
	}


    $.ajax({
        url: ajaxUrl,
        type: 'GET',
        data: {
			activeTab: activeTab,
            user_id: selectedUser  // assuming your backend expects user_id
        },
        success: function (response) {
            if ($.fn.DataTable.isDataTable(tableSelector)) {
                $(tableSelector).DataTable().destroy();
            }

            $(resultContainer).html(response);

            $(tableSelector).DataTable({
                responsive: true,
                dom: 'frtip',
                buttons: false,
                order: [[0, 'desc']],
                pageLength: 50,
                //lengthMenu: [10, 25, 50, 100],
            });

            $('.loader-container').addClass('hide');
        },
        error: function (xhr) {
            console.error("AJAX error:", xhr.responseText);
            $('.loader-container').addClass('hide');
        }
    });
});
</script>


    @endsection

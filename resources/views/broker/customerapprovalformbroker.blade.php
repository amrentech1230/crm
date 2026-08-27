@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
    .iti {
    width: 100%;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Approval Form </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Customer</li>
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

                        <h4 class="card-title">Customer Approval Form</h4>
                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Customer Details</button>
                        </div>

                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>Agent Name</th>
                                    <th>Agent Email</th>
                                    <th>Customer Email</th>
                                    <th>Company Name</th>
                                    <th>Address</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Zip Code</th>
                                    <th>Disptacher first Name</th>
                                    <th>Disptacher Last Name</th>
                                    <th>phone Number</th>
                                    <th>Requested Credit Limit</th>
                                    <th>Added Date</th>
                             
                                </tr>
                            </thead>

                            <tbody id="customer-table-body">
                            @include('broker.partials.customer_approval_form_table')
							</tbody>
                        </table>
                        <div class="custom-pagination">
                            
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> 
    </div>
<div class="modal fade bs-example-modal-xl" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('customer.approval.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">
@php
    $editableUsers = [52, 62, 90, 105, 109, 150, 174, 259];
@endphp
                        <!-- Agent Name & Agent Email (Same Row) -->
                        <div class="col-md-6">
                            <label class="form-label">Agent Name</label>
                            <input type="text" name="agent_name" class="form-control" value="{{ Auth::user()->name }}"{{ !in_array(Auth::id(), $editableUsers) ? 'readonly' : '' }}>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agent Email</label>
                            <input type="email" name="email"
                                   class="form-control"
                                  value="{{ Auth::user()->email }}"{{ !in_array(Auth::id(), $editableUsers) ? 'readonly' : '' }}>
                        </div>

                        <!-- Customer Email -->
                        <div class="col-md-6">
                            <label class="form-label">Customer Email <span class="text-danger">*</span></label>
                            <input type="email" name="customer_email" class="form-control" required>
                        </div>

                        <!-- Company Name -->
                        <div class="col-md-6">
                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <label class="form-label">Address <span class="text-danger">*</span></label>
                            <input type="text" name="address" class="form-control" required>
                        </div>

                        <!-- Country -->
                        <div class="col-md-3">
                            <label class="form-label">Country <span class="text-danger">*</span></label>
                            <input type="text" name="country" class="form-control" required>
                        </div>

                        <!-- State -->
                        <div class="col-md-3">
                            <label class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control" required>
                        </div>

                        <!-- City -->
                        <div class="col-md-3">
                            <label class="form-label">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" required>
                        </div>

                        <!-- Zip Code -->
                        <div class="col-md-3">
                            <label class="form-label">Zip Code <span class="text-danger">*</span></label>
                            <input type="text" name="zip_code" class="form-control" required>
                        </div>

                        <!-- Dispatcher First Name -->
                        <div class="col-md-6">
                            <label class="form-label">Dispatcher First Name <span class="text-danger">*</span></label>
                            <input type="text" name="dispatcher_first_name" class="form-control" required>
                        </div>

                        <!-- Dispatcher Last Name -->
                        <div class="col-md-6">
                            <label class="form-label">Dispatcher Last Name <span class="text-danger">*</span></label>
                            <input type="text" name="dispatcher_last_name" class="form-control" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Phone Number <span class="text-danger">*</span>
                            </label>

                            <input type="tel" id="phone" name="phone_number" class="form-control" required>
                        </div>

                        <!-- Requested Credit Limit -->
                        <div class="col-md-6">
                            <label class="form-label">Requested Credit Limit <span class="text-danger">*</span></label>
                            <input type="number" name="requested_credit_limit" class="form-control" required>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Customer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </div>
        </form>
    </div>
</div>



@endsection
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"></script>
<script>
    $('#customerApprovalForm').on('submit', function (e) {
    e.preventDefault();

    $.ajax({
        url: "{{ route('customer.approval.store') }}",
        type: "POST",
        data: $(this).serialize(),
        success: function (res) {
            alert(res.message);
            $('#customerApprovalModal').modal('hide');
            location.reload();
        },
        error: function (xhr) {
            alert('Validation error');
            console.log(xhr.responseText);
        }
    });
});

</script>

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
				$('#customer-table-body').html(data);
				$('#datatable').DataTable({
					responsive: true,
					dom: 'frtip',
					
					paging: true,
                    pageLength: 50,              // ✅ default show 50
                    lengthMenu: false,
                                            stateSave: true,   // ✅ remembers column visibility, page, search, etc.
        buttons: [
            {
                extend: 'colvis',
                text: 'Select Columns'
            }
        ]
				});
                 
                window.history.pushState("", "", url); // optional: update URL
            }
        });
    });
</script>

<script>
    const input = document.querySelector("#phone");

    const iti = window.intlTelInput(input, {
        initialCountry: "in", // default India
        separateDialCode: true,
        autoPlaceholder: "polite",
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
    });

    // Validate on form submit
    document.querySelector("form").addEventListener("submit", function (e) {
        if (!iti.isValidNumber()) {
            e.preventDefault();
            alert("Please enter a valid phone number for selected country.");
            input.focus();
        }
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const input = document.querySelector("#phone");

    window.intlTelInput(input, {
        initialCountry: "us",
        separateDialCode: true,
        autoPlaceholder: "polite"
    });

});
</script>
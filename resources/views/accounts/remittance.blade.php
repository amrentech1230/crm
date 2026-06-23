@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Remittance</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Remittance</li>
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

                        <h4 class="card-title">Remittance</h4>
                       
                        <table id="datatable"
                            class="table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
							<thead>
                                <tr>
                                  <th>Sr No.</th>
                                    <th>Customer Name</th>
                                    <th>Address</th>
									<th>Remitance</th>
									<th>Remitance File</th>
                                    <th>Phone No</th>
                                    <th>Added Date</th>
                                    <th>Agent</th>
                                    <th>Team Leader</th>
                                    <th>Manager</th>
                                    <th>Remaning Credit</th>
                                    <th>Invoice Credit Limit</th>
                                    <th>Last Load</th>
                                    <th>Approved Status</th>
                                    <th>Comment / Notes</th>
                                    <th>Documents</th>
                                </tr>
                            </thead>
                            <tbody id="customer-table-body">
                            @include('accounts.partials.remittance_table')
							</tbody>
                        </table>
                        <div class="custom-pagination">
                            {{ $customers->links() }}
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
                    <h5 class="modal-title" id="myExtraLargeModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('create.customer') }}" id="myForm" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Customer Name <code>*</code></label>
                                        <input class="form-control select2" type="text" required="" name="customer_name" id="customer_name" />
                                    </div>
                                </div>
                                <input type="text" name="user_id" hidden="" />
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label class="mr-2">
                                            MC# /FF#
                                        </label>
                                        <div class="d-flex" style="width: 100%;">
                                            <select class="form-control select2 mr-2 customer_mc_ff" name="customer_mc_ff"
                                                id="customer_mc_ff">
                                                <option selected="selected" id="mc_ff_code_na" value="NA">NA</option>
                                                <option value="MC">MC</option>
                                                <option value="FF">FF</option>
                                            </select>
                                            <input class="form-control select2" name="customer_mc_ff_input"
                                                id="customer_mc_ff_input" style="display:none;"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Address <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_address" id="customer_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Country <code>*</code></label>
                                        <div>
                                           <select class="form-control select2" required name="customer_country" id="country">
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
                                            <select class="form-control select2" required="" name="customer_state"
                                                id="state" disabled="">
                                                <option value="Please Select" selected="">Please Select</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>City <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="customer_city"
                                            id="customer_city" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Zip <code>*</code></label>
                                        <input type="text" class="form-control select2" required="" name="customer_zip"
                                            id="customer_zip" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-3 d-flex align-items-center">
                                        <label class="one-line-label">Same as Physical Address</label>
                                        <input class="form-control select2" type="checkbox" name="same_as_physical"
                                            id="same_as_physical" style="width: 0px;border: 2px solid;padding: 6px; margin-left: 10px;"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label>Billing Address <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_address" id="customer_billing_address" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing Country <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_country" id="customer_billing_country" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing State <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_state" id="customer_billing_state" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing City <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_city" id="customer_billing_city" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Billing Zip <code>*</code></label>
                                        <input type="text" class="form-control select2" required=""
                                            name="customer_billing_zip" id="customer_billing_zip" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>POC Name</label>
                                        <input type="text" class="form-control select2"
                                            name="customer_primary_contact" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Phone No <code>*</code></label>
                                        <input type="number" class="form-control select2" required=""
                                            name="customer_telephone" id="customer_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Extn. </label>
                                        <input type="text" class="form-control select2" name="customer_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Email <code>*</code></label>
                                        <input type="email" class="form-control select2" required=""
                                            name="customer_email" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group mb-3">
                                        <label>Website URL </label>
                                        <input class="form-control select2" name="adv_customer_webiste_url"
                                            id="adv_customer_webiste_url" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Fax</label>
                                        <input type="text" class="form-control select2" name="customer_fax" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Acc Pay Email</label>
                                        <input type="email" class="form-control select2"
                                            name="customer_secondary_email" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>AP Contact</label>
                                        <input type="number" class="form-control select2"
                                            name="customer_billing_telephone" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>AP Extn.</label>
                                        <input type="text" class="form-control select2" name="customer_billing_extn" />
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3 align-items-center">
                                        <label class="mr-2">Status <code>*</code></label>
                                        <div>
                                            <select class="form-control select2" required="" name="customer_status">
                                                <option value="">
                                                    Please Select
                                                </option>
                                                <option> Active</option>
                                                <option> In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-header mt-3">
                            <h3 class="card-title head">ADVANCED</h3>
                        </div>
                        <div class="card-body text-left">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Currency Setting </label>
                                        <div class="d-flex">
                                            <select class="form-control select2 mr-2"
                                                name="adv_customer_currency_Setting">
                                                <option value="">Please Select </option>
                                                <option>
                                                    American Dollars
                                                </option>
                                                <option>
                                                    Canadian Dollars
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Payment Terms</label>
                                        <div class="d-flex" style="width: 100%;">
                                            <div class="d-flex" style="width: 100%;">
                                                <select class="form-control select2" name="adv_customer_payment_terms"
                                                    onchange="showInput(this)">
                                                    <option value="">Please Select</option>
                                                    <option value="Net 30">Net30 </option>
                                                    <option value="Quick Pay 6% 1 Day"> Quick Pay 6% 1 Day</option>
                                                    <option value="Quick Pay 4% 5 Days"> Quick Pay 4% 5 Days</option>
                                                    <option value="Prepay">Prepay </option>
                                                    <option value="Custom" id="custome">
                                                        Custom
                                                    </option>
                                                </select>
                                                <input class="form-control select2"
                                                    name="adv_customer_payment_terms_custome" id="custome_input" style="display:none;"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label>Sales Rep. <code>*</code></label>
                                        <input type="text" class="form-control select2" name="adv_customer_sales_rep"
                                            value="{{ Auth::user()->name }}" readonly="" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-3">
                                        <label class="control-label mb-1 el_min100">Duplicate</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="AddAsShipper"
                                                name="AddAsShipper" style="border: 2px solid;"/>
                                            <label class="form-check-label" for="AddAsShipper"
                                                style="font-size: 10px;">Add as Shipper</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="AddAsConsignee"
                                                name="AddAsConsignee" style="border: 2px solid;"/>
                                            <label class="form-check-label" for="AddAsConsignee"
                                                style="font-size: 10px;">Add as Consignee</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3 align-items-center">
                                        <label style="line-height: 1.2em;">Internal Notes </label>
                                        <textarea class="select2" type="text" name="adv_customer_internal_notes"
                                            id="adv_customer_internal_notes"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group mb-3">
                                        <label style="line-height: 1.2em;">Upload files</label>
                                        <label for="upload" class="upload-button" style="height: 47px;">
                                            <input type="file" id="upload" name="customer_file_uploads[]" multiple="" accept="image/*,application/pdf"/>
                                            <p class="choose-file" style="font-size: 12px;">Choose the file</p>
                                        </label>
                                        <p>Please upload the file you want to share</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-info" value="Save" />
                                <input type="reset" style="font-size: 14px !important;" class="btn btn-warning"
                                    id="clearFormButton" value="Clear Form" />
                                <input type="button" class="btn btn-danger" data-bs-dismiss="modal" value="Cancel" />
                            </div>
                        </div>
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
	
	<div class="modal fade" id="remittanceModal" tabindex="-1" aria-labelledby="remittanceModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-xl">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="remittanceModalLabel">Remittance Files</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  
			<div class="modal-body">

			<!-- Filter Row -->
			<div class="row mb-3 align-items-end">
				<div class="col-md-3">
				<label for="filterRange" class="form-label">Filter by Range</label>
				<select id="filterRange" class="form-control">
					<option value="all">All</option>
					<option value="1m">1 Month</option>
					<option value="3m">3 Months</option>
					<option value="6m">6 Months</option>
					<option value="1y">1 Year</option>
					<option value="2y">2 Years</option>
					<option value="last_year">Last Year</option>
				</select>
				</div>

				<div class="col-md-3">
				<label for="filterDate" class="form-label">Filter by Upload Date</label>
				<input type="date" id="filterDate" class="form-control">
				</div>
			</div>

			<!-- Files Accordion -->
			<div id="remittanceAccordion">
				<!-- Files will be loaded here -->
			</div>
			</div>

		</div>
	  </div>
	</div>
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
					buttons: false,
					paging: true,
                    pageLength: 50,              // ✅ default show 50
                    lengthMenu: false // ✅ dropdown options
				});
                
                window.history.pushState("", "", url); // optional: update URL
            }
        });
    });
</script>

<script>  
$(document).on('change', '.remittance-upload', function (e) {
	
    const input = $(this);
    const customerId = input.data('customer-id');
    let files = e.target.files;
	
    let formData = new FormData();

    for (let i = 0; i < files.length; i++) {
		
        formData.append('remittance[]', files[i]);
    }

    formData.append('customer_id', customerId);

    $.ajax({ 
        url: '/account/customer/upload-remittance',
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            alert('Upload successful');
			
            location.reload(); // This is fine to refresh the file list
        },
        error: function (xhr) {
            console.error(xhr.responseText);
        }
    });
});



// Load & show files
function showRemittanceFiles(customerId) {
    $('#remittanceAccordion').html('<div class="text-center p-3">Loading...</div>');

    $.ajax({
        url: '/account/customer/remittance/files',
        method: 'POST',
        data: {
            customer_id: customerId,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            let accordionContent = '';
            if (response.files.length === 0) {
                accordionContent = '<div class="text-center p-3">No files found.</div>';
            } else {
                accordionContent += `<div class="list-group">`;

            response.files.forEach((file, index) => {
                if (typeof file !== 'string' || !file) return; // Skip if file is not a valid string

                const fileName = file.split('/').pop();
                const collapseId = `collapseFile${index}`;
                const fileExtension = fileName.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension);
                const isPDF = fileExtension === 'pdf';

                accordionContent += `
                    <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn btn-link text-start w-100 text-decoration-none"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#${collapseId}">
                            <i class="bi bi-caret-down-fill me-2"></i>${fileName}
                        </button>

                        <button class="btn btn-sm btn-danger ms-2"
                                onclick="deleteRemittanceFile('${file}', ${customerId})">
                            Delete
                        </button>
                    </div>

                    <div class="collapse" id="${collapseId}">
                        <div class="mt-2 ps-3">

                            ${isImage ? `
                                <img src="/public/uploads/remittances/${fileName}" class="img-fluid" style="max-height:300px;">
                            ` : ''}

                            ${isPDF ? `
                                <embed src="/public/uploads/remittances/${fileName}"
                                        width="100%"
                                        height="450" type="application/pdf"
                                        style="border:none;">
                            ` : ''}

                        </div>
                    </div>
                </div>
                `;
            });



                accordionContent += `</div>`;
            }
            $('#remittanceAccordion').html(accordionContent);
            $('#remittanceModal').modal('show');
        },
        error: function () {
            $('#remittanceAccordion').html('<div class="text-center p-3 text-danger">Failed to load files.</div>');
        }
    });
}


// Delete file
function deleteRemittanceFile(filePath, customerId) {
    if (!confirm("Are you sure you want to delete this file?")) return;

    $.ajax({
        url: '/account/customer/remittance/delete',
        method: 'POST',
        data: {
            file: filePath,
            customer_id: customerId,
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            // Refresh file list
            showRemittanceFiles(customerId);

            // Also remove the "View Remittance Files" button if no files remain
            $.post('/customer/remittance/files', {
                customer_id: customerId,
                _token: '{{ csrf_token() }}'
            }, function (res) {
                if (res.files.length === 0) {
                    $(`#view-button-${customerId}`).parent().html('<td>No Remittance File</td>');
                }
            });
        },
        error: function () {
            alert('Delete failed.');
        }
    });
}


function showRemittanceFiles(customerId, startDate = '', endDate = '') {
    $('#remittanceAccordion').html('<div class="text-center p-3">Loading...</div>');

    $.ajax({
        url: '/account/customer/remittance/filter',
        method: 'POST',
        data: {
            customer_id: customerId,
            start_date: startDate,
            end_date: endDate,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            let accordionContent = '';
            if (response.files.length === 0) {
                accordionContent = '<div class="text-center p-3">No files found.</div>';
            } else {
                accordionContent += `<div class="list-group">`;

                response.files.forEach((file, index) => {
                    const fileName = file.path.split('/').pop();
                    const collapseId = `collapseFile${index}`;
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    const isImage = ['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(fileExtension);
                    const isPDF = fileExtension === 'pdf';

                accordionContent += `
                    <div class="list-group-item remittance-item" data-uploaded-at="${file.uploaded_at}">
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-link text-start w-100 text-decoration-none" 
                                    type="button" data-bs-toggle="collapse" 
                                    data-bs-target="#${collapseId}" aria-expanded="false" 
                                    aria-controls="${collapseId}">
                                <i class="bi bi-caret-down-fill me-2"></i>${fileName}
                                <small class="text-muted ms-2">(${file.uploaded_at})</small>
                                <small class="text-muted ms-2" style="color:green">(${file.note || ''})</small>
                            </button>
                        </div>

                        <div class="collapse" id="${collapseId}">
                            <div class="mt-2 ps-3">
                                ${isImage ? `<img src="/public/${file.path}" class="img-fluid" style="max-height: 300px;">` : ''}
                                ${isPDF ? `<iframe src="/public/${file.path}" width="100%" height="400px" style="border:none;"></iframe>` : ''}

                                <div class="mt-2 d-flex align-items-center">
                                    <textarea id="note_${index}" 
                                            class="form-control form-control-sm me-2" 
                                            style="width:250px; resize:none;" disabled
                                            placeholder="Add note...">${file.note || ''}</textarea>
                           
                                </div>
                            </div>
                        </div>
                    </div>
                `;



                });

                accordionContent += `</div>`;
            }
            $('#remittanceAccordion').html(accordionContent);
            $('#remittanceModal').modal('show');
        },
        error: function () {
            $('#remittanceAccordion').html('<div class="text-center p-3 text-danger">Failed to load files.</div>');
        }
    });
}
</script>



<script>
function filterFiles() {
  const range = document.getElementById('filterRange').value;
  const specificDate = document.getElementById('filterDate').value;
  const fileItems = document.querySelectorAll('.remittance-item');

  const now = new Date();
  let rangeStart = null;
  let rangeEnd = null;

  switch (range) {
    case '1m':
      rangeStart = new Date(now.getFullYear(), now.getMonth() - 1, now.getDate());
      break;
    case '3m':
      rangeStart = new Date(now.getFullYear(), now.getMonth() - 3, now.getDate());
      break;
    case '6m':
      rangeStart = new Date(now.getFullYear(), now.getMonth() - 6, now.getDate());
      break;
    case '1y':
      rangeStart = new Date(now.getFullYear() - 1, now.getMonth(), now.getDate());
      break;
    case '2y':
      rangeStart = new Date(now.getFullYear() - 2, now.getMonth(), now.getDate());
      break;
    case 'last_year':
      rangeStart = new Date(now.getFullYear() - 1, 0, 1); // Jan 1 last year
      rangeEnd = new Date(now.getFullYear() - 1, 11, 31); // Dec 31 last year
      break;
    case 'all':
    default:
      rangeStart = null;
      rangeEnd = null;
  }

  fileItems.forEach(item => {
    const uploadDateStr = item.getAttribute('data-uploaded-at')?.split(' ')[0];
    if (!uploadDateStr) return;

    const uploadDate = new Date(uploadDateStr);
    let show = true;

    // Filter by specific date
    if (specificDate) {
      const selectedDate = new Date(specificDate);
      show = uploadDate.toDateString() === selectedDate.toDateString();
    } else if (range !== 'all') {
      if (range === 'last_year') {
        if (uploadDate < rangeStart || uploadDate > rangeEnd) {
          show = false;
        }
      } else if (rangeStart && uploadDate < rangeStart) {
        show = false;
      }
    }

    item.style.display = show ? '' : 'none';
  });
}

document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('filterDate').addEventListener('change', filterFiles);
  document.getElementById('filterRange').addEventListener('change', filterFiles);
});
</script>
<script>
  
$(document).ready(function () {
    // Set ID for the search form wrapper
    $('form.app-search .position-relative').attr('id', 'customer');

    function initializeTab() {
        const inputSelector = 'input[name="query"]';
        const ajaxUrl = '/account/customer_search';
        const resultContainer = '#customer-table-body';
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

</script>

@endsection

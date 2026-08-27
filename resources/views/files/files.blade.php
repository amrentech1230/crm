@extends('layout.compact.app')
@section('content')

<div class="page-content">
    <div class="container-fluid">
		 <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Upload Files</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Upload Files</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
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
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
						<form class="mb-4" action="{{ route('files.upload.post', ['filesId' => $load->id]) }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="">
								<h6 class="mb-2 text-left" style="font-size: 15px;"><b>Load Number: {{ $load->load_number }}</b></h6>
							   <div class="table-responsive">
							   <table class="table table-bordered">
									<thead>
										<tr>
											<th>File Name</th>
											<th>Upload / Existing Files</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<!-- Carrier Rate Confirmation -->
										<tr>
											<td style="padding: 0 10px;"><b>Carrier Rate Confirmation</b></td>
											<td style="padding: 0 10px;">
												<!-- File upload field -->
												<input class="form-control form-control-lg" name="carrer_rate_cnfrm_doc" id="carrer_rate_cnfrm_doc" accept="image/*,application/pdf" type="file" onchange="previewFile(this, 'preview_carrer_rate_cnfrm_doc')">
											</td>
										   
											<td style="padding: 0 10px;" class="d-flex justify-content-center">
											@if (!empty($uploadedFiles['carrer_rate_cnfrm_doc']))
												@foreach ($uploadedFiles['carrer_rate_cnfrm_doc'] as $subFile)
													<a href="{{ asset('public/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"> </a>
												@endforeach
											@endif

											<!-- Preview selected file -->
											<div id="preview_carrer_rate_cnfrm_doc"></div>

											<!-- Delete button for existing file -->
											@if (!empty($uploadedFiles['carrer_rate_cnfrm_doc']))
												<button class="delete-file btn fa fa-trash mt-2" data-key="carrer_rate_cnfrm_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
												</button>
											@endif

											</td>
										</tr>

										<!-- Pod -->
										<tr>
											<td style="padding: 0 10px;"><b>Pod</b></td>
											<td style="padding: 0 10px;">
												<input class="form-control form-control-lg" name="pod_doc" id="pod_doc" type="file" accept="image/*,application/pdf" onchange="previewFile(this, 'preview_pod_doc')">
											</td>
										   
											<td style="padding: 0 10px;">
											@if (!empty($uploadedFiles['pod_doc']))
													@foreach ($uploadedFiles['pod_doc'] as $subFile)
														<a href="{{ asset('public/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
													@endforeach
												@endif
												<div id="preview_pod_doc"></div>
												@if (!empty($uploadedFiles['pod_doc']))
													<button class="delete-file btn fa fa-trash mt-2" data-key="pod_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
													</button>
												@endif
											</td>
										</tr>

										<!-- Shipper Rate Approval -->
										<tr>
											<td style="padding: 0 10px;"><b>Shipper Rate Approval (Screen Shot)</b></td>
											<td style="padding: 0 10px;">
												<input class="form-control form-control-lg" name="shipper_rate_approval_doc" accept="image/*,application/pdf" id="shipper_rate_approval_doc" type="file" onchange="previewFile(this, 'preview_shipper_rate_approval_doc')">
											</td>
										   
											<td style="padding: 0 10px;">
											@if (!empty($uploadedFiles['shipper_rate_approval_doc']))
													@foreach ($uploadedFiles['shipper_rate_approval_doc'] as $subFile)
														<a href="{{ asset('public/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
													@endforeach
												@endif
												<div id="preview_shipper_rate_approval_doc"></div>
												@if (!empty($uploadedFiles['shipper_rate_approval_doc']))
													<button class="delete-file btn fa fa-trash mt-2" data-key="shipper_rate_approval_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
													</button>
												@endif
											</td>
										</tr>

										<!-- Carrier Invoice -->
										<tr>
											<td style="padding: 0 10px;"><b>Carrier Invoice</b></td>
											<td style="padding: 0 10px;">
												<input class="form-control form-control-lg" name="carrier_invoice_doc" accept="image/*,application/pdf" id="carrier_invoice_doc" type="file" onchange="previewFile(this, 'preview_carrier_invoice_doc')">
											</td>
											
											<td style="padding: 0 10px;">
											@if (!empty($uploadedFiles['carrier_invoice_doc']))
													@foreach ($uploadedFiles['carrier_invoice_doc'] as $subFile)
														<a href="{{ asset('public/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
													@endforeach
												@endif
												<div id="preview_carrier_invoice_doc"></div>
												@if (!empty($uploadedFiles['carrier_invoice_doc']))
													<button class="delete-file btn fa fa-trash mt-2" data-key="carrier_invoice_doc" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
													</button>
												@endif
											</td>
										</tr>

										<!-- Delivery Order -->
										<tr>
											<td style="padding: 0 10px;"><b>Delivery Order</b></td>
											<td style="padding: 0 10px;">
												<input class="form-control form-control-lg" type="file" name="do" id="do" accept="image/*,application/pdf" multiple onchange="previewMultipleFiles(this, 'preview_do')">
											</td>  
											
											<td style="padding: 0 10px;">
											@if (!empty($uploadedFiles['do']))
													@foreach ($uploadedFiles['do'] as $subFile)
														<a href="{{ asset('public/' . $subFile) }}" target="_blank" class="btn fa fa-eye mt-2" style="color: #000 !important; background: unset; font-size: 17px;"></a>
													@endforeach
												@endif
												<div id="preview_do"></div>
												@if (!empty($uploadedFiles['do']))
													<button class="delete-file btn fa fa-trash mt-2" data-key="DO" data-file="{{ $subFile }}" data-record-id="{{ $load->id }}" style="color: #000 !important; background: unset; font-size: 17px;">
													</button>
												@endif
											</td>
										</tr>

										<!-- Optional Documents Section -->
										<tr>
											<td style="padding: 0 10px;"><b>Optional Documents</b></td>
											<td style="padding: 0 10px;">
												<input class="form-control form-control-lg" name="optional_docs[]" accept="image/*,application/pdf" id="optional_docs" type="file" multiple onchange="previewMultipleFiles(this, 'preview_optional_docs')">
											</td>
											<td style="padding: 0 10px;">
												<div id="preview_optional_docs"></div>
											</td>
										</tr>

									</tbody>
								</table>
							   </div>

								<div class="text-center mt-3">
									<button type="submit" class="btn btn-info" style="padding: 5px 19px;">Save</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.delete-file').on('click', function(e) {
            e.preventDefault();

            var button = $(this);
            var fileKey = button.data('key');
            var filePath = button.data('file');
            var recordId = button.data('record-id');

            if (confirm('Are you sure you want to delete this file?')) {
                $.ajax({
                    url: '{{ route('delete.file.broker') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        record_id: recordId,
                        file_name: filePath
                    },
                    success: function(response) {
                        if (response.success) {
                            button.closest('li').remove();
                        } else {
                            alert('Failed to delete the file.');
                        }
                    },
                    error: function(response) {
                        alert('An error occurred while trying to delete the file.');
                    }
                });
                location.reload();
            }
        });
    });
</script>

<script>
// Function to convert bytes to a readable format (KB, MB)
function formatSize(bytes) {
    if (bytes < 1024) return bytes + ' B';
    else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + ' KB';
    else if (bytes < 1073741824) return (bytes / 1048576).toFixed(2) + ' MB';
    else return (bytes / 1073741824).toFixed(2) + ' GB';
}

// Preview selected file
function previewFile(input, previewId) {
    var preview = document.getElementById(previewId);
    preview.innerHTML = "";  // Clear previous preview

    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileType = file.type;
        var fileSize = formatSize(file.size);  // Get the readable file size

        // Display file size
        var sizeDisplay = document.createElement('p');
        sizeDisplay.innerText = 'Size: ' + fileSize;
        preview.appendChild(sizeDisplay);

        if (fileType.startsWith('image/')) {
            // Display image preview
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-thumbnail';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else if (fileType === 'application/pdf') {
            // Display PDF icon
            var icon = document.createElement('i');
            icon.className = 'fa fa-file-pdf-o text-danger';
            var pdfLink = document.createElement('a');
            pdfLink.href = URL.createObjectURL(file);
            pdfLink.target = '_blank';
            pdfLink.appendChild(icon);
            preview.appendChild(pdfLink);
        } else {
            // Display a generic file icon
            var icon = document.createElement('i');
            icon.className = 'fa fa-file-o';
            preview.appendChild(icon);
        }
    }
}

// Preview multiple files (optional documents)
function previewMultipleFiles(input, previewId) {
    var preview = document.getElementById(previewId);
    preview.innerHTML = "";  // Clear previous previews

    if (input.files) {
        Array.from(input.files).forEach(function(file) {
            var fileType = file.type;
            var fileSize = formatSize(file.size);  // Get the readable file size

            // Display file size
            var sizeDisplay = document.createElement('p');
            sizeDisplay.innerText = 'Size: ' + fileSize;
            preview.appendChild(sizeDisplay);

            if (fileType.startsWith('image/')) {
                // Display image preview
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.maxWidth = '200px';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            } else if (fileType === 'application/pdf') {
                // Display PDF icon
                var icon = document.createElement('i');
                icon.className = 'fa fa-file-pdf-o text-danger';
                var pdfLink = document.createElement('a');
                pdfLink.href = URL.createObjectURL(file);
                pdfLink.target = '_blank';
                pdfLink.appendChild(icon);
                preview.appendChild(pdfLink);
            } else {
                // Display a generic file icon
                var icon = document.createElement('i');
                icon.className = 'fa fa-file-o';
                preview.appendChild(icon);
            }
        });
    }
}
</script>


@endsection

        @foreach($invoiced as $i => $invoice)
            @php
                $shouldShowInvoicedRow = app(\App\Http\Controllers\AccountController::class)->shouldShowInvoicedTabForLoad($invoice);
                $shipperAppointment = json_decode($invoice->load_shipper_appointment, true);
                $firstAppointment = '';

                if (is_array($shipperAppointment) && !empty($shipperAppointment)) {
                    reset($shipperAppointment);
                    $firstItem = current($shipperAppointment);

                    if (is_array($firstItem)) {
                        if (isset($firstItem['date'])) {
                            $firstAppointment = $firstItem['date'];
                        } else {
                            $firstAppointment = reset($firstItem);
                        }
                    } elseif (is_string($firstItem)) {
                        $firstAppointment = $firstItem;
                    }
                }

                $consigneeAppointment = json_decode($invoice->load_consignee_appointment, true);
                $lastAppointment = '';

                if (is_array($consigneeAppointment) && !empty($consigneeAppointment)) {
                    $lastItem = end($consigneeAppointment);

                    if (is_array($lastItem)) {
                        // If last item is an array, try to get 'date' key or first value
                        if (isset($lastItem['date'])) {
                            $lastAppointment = $lastItem['date'];
                        } else {
                            $lastAppointment = reset($lastItem);
                        }
                    } elseif (is_string($lastItem)) {
                        $lastAppointment = $lastItem;
                    }
                }
            @endphp
            @if($shouldShowInvoicedRow)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $invoice->load_number }}</td>
                <td>{{ $invoice->invoice_number }}</td>
                <td>
                    <a id="markAsPaidRecordBtn_{{ $invoice->id }}" title="Approved"
                        class="{{ $invoice->invoice_status === 'Paid Record' ? 'success' : 'danger' }} btn btn-primary btn-sm"
                        onclick="markAsPaidRecord({{ $invoice->id }})" ><i class=" fas fa-check"></i></a>

                    <a class="btn btn-primary btn-sm" onclick="openUploadWindow('{{route('load.edit', $invoice->id)}}')"><i class=" fas fa-edit"></i></a>

                    <a href="#" onclick="markAsBackDeliveredRecord({{ $invoice->id }})" title="Back" class="btn btn-primary btn-sm"><i class=" fas fa-reply"></i></a>

                    <span data-bs-toggle="modal" class="btn btn-primary btn-sm" style="color: #ffffffff; cursor:pointer" data-bs-target="#view-mail-{{ $invoice->id }}"><i class=" fas fa-envelope-open"></i></span>

                    <a href="javascript:void(0);" onclick="printPreInvoice({{ $invoice->id }})" title="Print invoice" class="btn btn-primary btn-sm"><i class=" fas fa-print"></i></a>
					
					<a href="{{route('CompletedPublicDoc',$invoice->id)}}" title="public file" class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer"> <i class="fas fa-file"></i></a>
					
					<a href="{{ route('shipper.download.pdf', $invoice->id) }}" class="btn btn-primary btn-sm" title="Shipper RC" target="_blank">
						<i class="fas fa-file-pdf dynamic-data"></i> 
					</a>
						
					<a href="{{route('rc.download.pdf', $invoice->load_number)}}" target="_blank" class="btn btn-primary btn-sm" title="Carrier RC">
                        <i class="fas fa-file-pdf dynamic-data"></i>
                    </a>

					
					<div class="modal fade mymodal modal-xl" id="view-mail-{{ $invoice->id }}" tabindex="-1" data-bs-backdrop="true" aria-labelledby="view-mail" aria-hidden="false">
						<div class="modal-dialog modal-xl">
								<div class="modal-content">
									<!-- Modal Header -->
									<div class="modal-header" style="padding-left: 14px;">
									<h4 class="modal-title">Send Mail</h4>
									<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
									</div>


									<div class="modal-body">                           
										<form class="sendemailfunction" method="POST">
											@csrf
											<label>Email:</label>
											<input type="text" class="form-control" id="email" name="email" value="{{$invoice->customer?->customer_email}}" required><br><br> 
											<label>CC Email:</label>
											<input type="text" class="form-control" id="ccemail" name="ccemail" value="ar@cargoconvoy.co"><br><br>
											<input type="hidden" id="load_no" name="load_no" value="{{$invoice->load_number}}">
											<input type="hidden" name="refrance_no" value="{{$invoice->load_workorder}}">
											<input type="hidden" name="invoice_no" value="{{$invoice->invoice_number}}">
											
											<strong>Upload new documents:</strong><br><br>
                                            <input type="file" class="newDocuments" data-id="{{ $invoice->load_number }}" onchange="maildocumetupload(this, '{{ $invoice->load_number }}')" accept="application/pdf" multiple>
                                            <small class="text-muted d-block mt-1">Select PDF files. Multiple selected documents are sent as one merged PDF.</small>
                                            <div id="uploadStatus{{ $invoice->load_number }}"></div>
                                            <div id="uploadedDocsAccordion{{ $invoice->load_number }}" class="mail-document-grid mt-3"></div>

											<strong>Select documents to attach:</strong><br><br>

											@php
												$docs = json_decode($invoice->load_delivery_do_file, true);
												
											@endphp

                                            @if(empty($docs))
                                                <p>No documents found.</p>
                                            @else
                                                <div class="mail-document-grid">
                                                    @foreach($docs as $key => $file)
                                                        @php
                                                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                                            $fileName = basename($file);
                                                            $filePath = public_path(ltrim($file, '/'));
                                                        @endphp
                                                        @if(!file_exists($filePath)) @continue @endif
                                                        <label class="mail-document-card" title="Click to select or deselect">
                                                            <input type="checkbox" name="documents[]" value="{{ $file }}" @if(Str::startsWith($fileName, 'Load_invoice') || Str::startsWith($fileName, 'load_invoice')) checked @endif>
                                                            <a class="mail-document-preview" href="{{ asset($file) }}" target="_blank" rel="noopener" onclick="event.stopPropagation();">
                                                                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                                    <img src="{{ asset($file) }}" alt="{{ $fileName }}" style="max-width:100%;max-height:150px;object-fit:contain;">
                                                                @else
                                                                    <iframe src="{{ asset($file) }}" style="width:150px;height:150px;border:none;pointer-events:none;" scrolling="no"></iframe>
                                                                @endif
                                                            </a>
                                                            <span class="mail-document-name">{{ $fileName }}</span>
                                                            <button type="button" class="btn btn-sm btn-outline-danger remove-mail-document" title="Remove from this email" aria-label="Remove {{ $fileName }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif

											<button type="submit"class="btn btn-primary waves-effect waves-light mb-3" onclick="sendemailfunction(this, '{{ $invoice->id }}')" data-id ="{{$invoice->id}}" >Send Email</button>
										</form>
								
									</div>
								</div>
						</div>
					</div>
                    <a href="{{ route('accounts.view_loads_detail', $invoice->id) }}" class="btn btn-primary btn-sm" title="logs"> <i class="fas fa-eye"></i></a>
                </td> 
                <td class="dynamic-data">
                    {{ $invoice->load_workorder }}</td>
                <td class="dynamic-data">
                    {{ $invoice->load_bill_to }}</td>
                
                <td>{{ !empty($invoice->paper_work_date) ? \Carbon\Carbon::parse($invoice->paper_work_date)->format('m-d-Y') : '' }}</td>
             
                <td>
                    <input type="date" class="form-control paymentreceivingdate_{{$invoice->id}}"
                        name="payment_receiving_date"
                        value="{{ !empty($invoice->payment_receiving_date) ? \Carbon\Carbon::parse($invoice->payment_receiving_date)->format('Y-m-d') : '' }}">

                </td>

                <td class="dynamic-data">
                    {{ $invoice->shipper_load_final_rate }}
                    <div class="form-check form-check-inline ms-2" style="display: inline-block; vertical-align: middle; margin-left: 8px;">
                        <input type="checkbox" class="form-check-input use-final-rate-checkbox" style="width: 18px; height: 18px;" 
                            data-invoice-id="{{ $invoice->id }}"
                            data-shipper-final-rate="{{ $invoice->shipper_load_final_rate }}"
                            id="use_final_rate_{{ $invoice->id }}">
                        <label class="form-check-label" for="use_final_rate_{{ $invoice->id }}" style="font-size: 12px; margin-left: 4px;">Use ₹{{ number_format(floatval($invoice->shipper_load_final_rate), 2) }}</label>
                    </div>
                    <!-- <div>
                        <a href="#" class="add-note-link" data-invoice-id="{{ $invoice->id }}" style="font-size: 12px; color: #0d6efd; text-decoration: underline; display: inline-block; margin-top: 4px;">Additional note</a>
                    </div> -->
                </td>
                <td class="dynamic-data">
                    <input type="number" class="form-control receiving_amount"
                        name="receiving_amount" data-invoice-id="{{ $invoice->id }}"
                        data-shipper-load-final-rate="{{ $invoice->shipper_load_final_rate }}"
                        id="receiving_amount_{{ $invoice->id }}"
                        value="{{ $invoice->receiving_amount }}">
                    <input type="hidden" class="remaining_amount_{{ $invoice->id }}" value="{{ number_format(floatval($invoice->shipper_load_final_rate) - floatval($invoice->receiving_amount), 2, '.', '') }}">
                </td>
                <td class="dynamic-data">
                  
                       <textarea name="invoice_internal_value" onkeyup="RemainingAmount(this)" row="10" col="5" style="width: 450px !important;height: 50px;"   data-invoice-id="{{ $invoice->id }}" class="invoice_internal_value" placeholder="Enter additional notes...">{{ $invoice->invoice_internal_value }}</textarea>

                </td>
                
                <td class="dynamic-data">
                    @if(!empty($invoice->invoice_date) && $invoice->invoice_date !== '0000-00-00')
    {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('m-d-Y') }}
@elseif(!empty($invoice->invoice_status_date) && $invoice->invoice_status_date !== '0000-00-00')
    {{ \Carbon\Carbon::parse($invoice->invoice_status_date)->format('m-d-Y') }}
@else
    -
@endif

                </td>
                
                <td class="dynamic-data">
                @if($invoice->user) {{ $invoice->user->name }} @endif
                </td>


                <td class="dynamic-data">
                @if($invoice->user)  {{ $invoice->user->officedata?->office_name }} @endif</td>
                <td class="dynamic-data">
                @if($invoice->user) {{ $invoice->user->teamLeaderInfo?->tl}} @endif</td>
                <td class="dynamic-data">
                @if($invoice->user)  {{ $invoice->user->managerInfo?->manager }} @endif</td>
                <td class="dynamic-data">
                {{ $invoice->created_at->format('m-d-Y') }}
                </td>
                @php
                $shipper_appointment =
                json_decode($invoice->load_shipper_appointment,true);
                @endphp
                <td class="dynamic-data">
                    {{ isset($shipper_appointment[0]['appointment']) ? \Carbon\Carbon::parse($shipper_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                </td>
                @php
                $consignee_appointment =
                json_decode($invoice->load_consignee_appointment,true);
                @endphp
                <td class="dynamic-data">
                    {{ isset($consignee_appointment[0]['appointment']) ? \Carbon\Carbon::parse($consignee_appointment[0]['appointment'])->format('m-d-Y') : '' }}
                </td>
                <td class="dynamic-data">
                {{ \Carbon\Carbon::parse($invoice->load_actual_delivery_date)->format('m-d-Y') }}
                </td>
                <td class="dynamic-data">{{ $invoice->load_carrier }}</td>
				<td class="dynamic-data">{{ $invoice->carrier?->carrier_mc_ff_input }}</td> 
                <td class="dynamic-data">{{ $invoice->load_final_carrier_fee }}</td>
                @php
                $shipper_location = json_decode($invoice->load_shipper_location,
                true);
                @endphp
                <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                    {{ \Illuminate\Support\Str::words($shipper_location[0]['location'] ?? '', 3, '...') }}
                    <span class="tooltip-text">{{ $shipper_location[0]['location'] ?? '' }}</span>
                </td>

                @php
                $consignee_loaction = json_decode($invoice->load_consignee_location,
                true);
                @endphp
                <td class="dynamic-data tooltip-container" onclick="copyToClipboard(this)">
                    {{ \Illuminate\Support\Str::words($consignee_loaction[0]['location'] ?? '', 3, '...') }}
                    <span class="tooltip-text">{{ $consignee_loaction[0]['location'] ?? '' }}</span>
                </td>
                <td class="dynamic-data">
                    
                   {{ $invoice->load_status }}

                </td>
                <td class="dynamic-data">
                    @if($invoice->invoice_status == 'Paid')
                        Invoiced
                    @else
                        {{  $invoice->invoice_status }}
                    @endif
                </td>

<td class="dynamic-data">
@php
    $invoiceDate = \Carbon\Carbon::parse($invoice->invoice_date)->addHours(24);
    $now = \Carbon\Carbon::now();

    $agingDays = 0;

    if ($now->greaterThan($invoiceDate)) {
        $hours = $invoiceDate->diffInHours($now);
        $agingDays = ceil($hours / 24);
    }
@endphp

{{ $agingDays }} Days
</td>
            </tr>
			
            @endif
        @endforeach
		
<script>
   function sendemailfunction(inputElement, invoiceno) {
    // Get the closest form element
    let form = $(inputElement).closest('form');
    let formData = new FormData(form[0]); // Pass native DOM element

    // Get CSRF token
    let csrfToken = $('meta[name="csrf-token"]').attr('content') || $('input[name="_token"]').val();

    // Disable submit button
    let submitButton = form.find('button[type="submit"]');
    submitButton.prop('disabled', true).text('Sending...');

    $.ajax({
        url: "{{ route('send.mail') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function (response) {
            console.log('Success:', response);

            $('#mc-success-message').text(response.message).fadeIn();
            $('.mymodal').modal('hide');

            setTimeout(function () {
                $('#mc-success-message').text('').fadeOut();
            }, 10000);

            submitButton.prop('disabled', false).text('Send Email');
        },
        error: function (response) {
            console.error('Error:', response);
            let errorMessage = response.responseJSON?.message || 'An error occurred';
            $('#mc-error-message').text(errorMessage).fadeIn();

            setTimeout(function () {
                $('#mc-error-message').text('').fadeOut();
            }, 10000);

            submitButton.prop('disabled', false).text('Send Email');
        }
    });
}
</script>
<script>
    function openUploadWindow(url) {
        // Define the size of the new window
        var width = 1500;   // Width of the new window
        var height = 800;  // Height of the new window

        // Calculate the position to center the window
        var left = screen.width / 2 - width / 2;   // Center horizontally
        var top = screen.height / 2 - height / 2;  // Center vertically

        // Open the new window with the specified URL and properties
        var newWindow = window.open(url, 'UploadWindow', 'width=' + width + ',height=' + height + ',top=' + top + ',left=' + left + ',resizable=yes,scrollbars=yes');
        
        // Focus on the new window, if it was successfully opened
        if (newWindow) {
            newWindow.focus();
        }
    }
</script>
<script>
function escapeMailDocumentHtml(value) {
    return String(value).replace(/[&<>'"]/g, function (character) {
        return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;' })[character];
    });
}

function mailDocumentCard(filePath, fileUrl) {
    const fileName = filePath.split('/').pop();
    const safeName = escapeMailDocumentHtml(fileName);
    const safePath = escapeMailDocumentHtml(filePath);
    const safeUrl = escapeMailDocumentHtml(fileUrl);

    return `
        <label class="mail-document-card" title="Click to select or deselect">
            <input type="checkbox" name="documents[]" value="${safePath}">
            <a class="mail-document-preview" href="${safeUrl}" target="_blank" rel="noopener" onclick="event.stopPropagation();">
                <iframe src="${safeUrl}" style="width:150px;height:150px;border:none;pointer-events:none;" scrolling="no"></iframe>
            </a>
            <span class="mail-document-name">${safeName}</span>
            <button type="button" class="btn btn-sm btn-outline-danger remove-mail-document" title="Remove from this email" aria-label="Remove ${safeName}">
                <i class="fas fa-trash"></i>
            </button>
        </label>`;
}

$(document).on('click', '.remove-mail-document', function (event) {
    event.preventDefault();
    event.stopPropagation();
    $(this).closest('.mail-document-card').remove();
});

function maildocumetupload(inputElement, invoiceno) {
    const files = inputElement.files;
    const load_no = $(inputElement).data('id');

    if (!files.length) return;

    const $status = $('#uploadStatus' + load_no);
    const $uploadedDocsContainer = $('#uploadedDocsAccordion' + load_no);

    if (!$status.length || !$uploadedDocsContainer.length) {
        console.error('Missing status or accordion container for load_no:', load_no);
        return;
    }

    const formData = new FormData();
    $.each(files, function (i, file) {
        formData.append('document[]', file);
    });

    formData.append('load_no', load_no);
    formData.append('_token', '{{ csrf_token() }}');

    $status.html(`Uploading ${files.length} file(s)...`);

    $.ajax({
        url: '{{ route("mail.upload.document") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
            if (data.files && data.files.length > 0) {
                $status.html(`<span class="text-success">Uploaded ${data.files.length} file(s) successfully.</span>`);

                data.files.forEach(function (filePath) {
                    const fileUrl = `{{ url('/') }}/${filePath}`.replace(/([^:]\/)\/+/g, "$1");
                    $uploadedDocsContainer.append(mailDocumentCard(filePath, fileUrl));
                });
                inputElement.value = '';
            } else {
                $status.html(`<span class="text-danger">Upload failed.</span>`);
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
            $status.html(`<span class="text-danger">Upload error.</span>`);
        }
    });
}


</script>

<script>

function printPreInvoice(id) {
        var printWindow = window.open('/account/print-invoice/' + id, '_blank', 'width=800,height=600');
        printWindow.focus();
        printWindow.onload = function () {
            printWindow.print();
        };
    }
    
function markAsPaidRecord(loadId) {
   
    const paymentReceivingDate = $(`.paymentreceivingdate_${loadId}`).val();
    const receivingAmount = $(`#receiving_amount_${loadId}`).val();
    const remainingAmount = parseFloat($(`.remaining_amount_${loadId}`).val()) || 0;

    if (paymentReceivingDate === '') {
         $('#mc-error-message').text('Please select the payment receiving date').fadeIn();
         setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
        return;
    }

    $.ajax({
        url: "{{ route('update.invoice.status.as.paid.record', ':id') }}".replace(':id', loadId),
        method: 'POST',
        data: {
            payment_receiving_date: paymentReceivingDate,
            receiving_amount: receivingAmount,
            remaining_amount: remainingAmount
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            const $row = $(`#markAsPaidRecordBtn_${loadId}`).closest('tr');
            if ($row.length) {
                $row.remove();
            }
            $('#mc-success-message').text(response.message).fadeIn();
            setTimeout(() => $('#mc-success-message').text('').fadeOut(), 2000);
        },
        error: function(xhr) {
            $('#mc-error-message').text('Failed to Mark as Invoice').fadeIn();
            setTimeout(() => $('#mc-error-message').text('').fadeOut(), 2000);
        }
        });
}

function markAsBackDeliveredRecord(loadId) {
    if (confirm('Are you sure you want to back this record in Completed?')) {
        $.ajax({
            url: `/account/update-invoice-status-as-back-complete/${loadId}`,
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Laravel CSRF token
            },
            success: function(response) {
                console.log('AJAX request successful:', response);
                location.reload(); // Reload the page after successful update
            },
            error: function(xhr, status, error) {
                console.error('Error marking as Back to Deliver:', error);
                alert('Failed to back in deliver.');
            }
        });
    }
}
        function updateRemainingAmount(invoiceId, receiving_amount) {
            
            var shipperLoadFinalRate = parseFloat($('#receiving_amount_' + invoiceId).data(
                'shipper-load-final-rate'));
            var receivingAmount = parseFloat(receiving_amount) || 0;
              
            var remainingAmount = shipperLoadFinalRate - receivingAmount;
            $('.remaining_amount_' + invoiceId).val(remainingAmount.toFixed(2));

            if (receivingAmount > shipperLoadFinalRate) {
                $('#mc-success-message').text('Advance / excess payment will be recorded.').fadeIn();
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 2000);
            }
            
        }

    function saveReceivingAmount(invoiceId, receiving_amount) {
        var receivingAmount = receiving_amount;
        var remainingAmount = parseFloat($('.remaining_amount_' + invoiceId).val()) || 0;

        $.ajax({
            url: '{{ route("load.updateReceivingAmount") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                load_id: invoiceId,
                receiving_amount: receivingAmount,
                remaining_amount: remainingAmount
            },
            success: function (response) {
                if (response.success) {
                    $('.remaining_amount_' + invoiceId).val(response.remaining_amount);
                } else {
                    $('#mc-error-message').text('Failed to update receiving amount').fadeIn();
             setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                
                $('#mc-error-message').text('An error occurred while updating the receiving amount').fadeIn();
             setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
            }
        });
    }
	
	function saveadvanceReceivingAmount(element) {
        var invoiceId = $(element).data('invoice-id');
        var receivingAmount = $(element).val();

        $.ajax({
            url: '{{ route("load.updateadvReceivingAmount") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                load_id: invoiceId,
                adv_receiving_amount: receivingAmount
            },
            success: function (response) {
                if (response.success) {
                    // Optionally update all fields with the same class for this invoice
                    $('.adv_receiving_amount[data-invoice-id="' + invoiceId + '"]').val(receivingAmount);
                } else {
                    $('#mc-error-message').text('Failed to update receiving amount').fadeIn();
                    setTimeout(function () {
                        $('#mc-error-message').text('').fadeOut();
                    }, 2000);
                }
            },
            error: function (xhr, status, error) {
                console.error(error);
                $('#mc-error-message').text('An error occurred while updating the Advance receiving amount').fadeIn();
                setTimeout(function () {
                    $('#mc-error-message').text('').fadeOut();
                }, 2000);
            }
        });
    }
	
	function RemainingAmount(inputElement) {
			var invoiceId = $(inputElement).data('invoice-id'); // get invoice ID from data attribute
			var invoice_internal_value = $(inputElement).val(); // get current value of input

			$.ajax({
				url: '{{ route("load.updateRemainingAmount") }}',
				type: 'POST',
				data: {
					_token: '{{ csrf_token() }}',
					load_id: invoiceId,
					invoice_internal_value: invoice_internal_value
				},
				success: function (response) {
					if (response.success) {
						//$('.adv_receiving_amount_' + invoiceId).val(receivingAmount);
					} else {
						$('#mc-error-message').text('Failed to update receiving amount').fadeIn();
						setTimeout(function () {
							$('#mc-error-message').text('').fadeOut();
						}, 2000);
					}
				},
				error: function (xhr, status, error) {
					console.error(error);

					$('#mc-error-message').text('An error occurred while updating the Advance receiving amount').fadeIn();
					setTimeout(function () {
						$('#mc-error-message').text('').fadeOut();
					}, 2000);
				}
			});
		}


    function handleFinalRateCheckbox(invoiceId) {
        var $checkbox = $('#use_final_rate_' + invoiceId);
        var receivingInput = $('#receiving_amount_' + invoiceId);
        var shipperFinalRate = parseFloat($checkbox.data('shipper-final-rate')) || 0;
        var currentValue = $.trim(receivingInput.val());
        var currentAmount = parseFloat(currentValue);
        var manualEdited = receivingInput.data('manual-edited') === true;

        if ($checkbox.is(':checked')) {
            if (currentValue === '' || isNaN(currentAmount) || (currentAmount === 0 && !manualEdited)) {
                receivingInput.val(shipperFinalRate.toFixed(2)).data('auto-filled', true).data('manual-edited', false).trigger('change');
            } else {
                receivingInput.data('auto-filled', false).trigger('change');
            }
        } else {
            var wasAutoFilled = receivingInput.data('auto-filled') === true;
            if (wasAutoFilled) {
                receivingInput.val('').data('auto-filled', false).trigger('change');
            } else {
                receivingInput.trigger('change');
            }
        }
    }

    $(document).on('input change', '.receiving_amount', function () {
        var invoiceId = $(this).data('invoice-id');
        var receiving_amount = $(this).val();
        $(this).data('manual-edited', true).data('auto-filled', false);
        updateRemainingAmount(invoiceId, receiving_amount);
        saveReceivingAmount(invoiceId, receiving_amount);
    });

    $(document).on('change', '.receiving_amount', function () {
         var invoiceId = $(this).data('invoice-id');
          var receiving_amount = $(this).val();
         updateRemainingAmount(invoiceId, receiving_amount);
         saveReceivingAmount(invoiceId, receiving_amount);
     });

    $(document).on('change', '.use-final-rate-checkbox', function () {
        var invoiceId = $(this).data('invoice-id');
        handleFinalRateCheckbox(invoiceId);
    });

    $(document).on('click', '.add-note-link', function (e) {
        e.preventDefault();
        var invoiceId = $(this).data('invoice-id');
        var noteField = $('.invoice_internal_value[data-invoice-id="' + invoiceId + '"]');
        if (noteField.length) {
            noteField.focus();
        }
    });
	 
	//  $(document).on('input', '.adv_receiving_amount', function () {
    //     var invoiceId = $(this).data('invoice-id');
    //     var adv_receiving_amount = $(this).val();
    //     saveadvanceReceivingAmount(invoiceId, adv_receiving_amount);
    // });

    // $(document).on('change', '.adv_receiving_amount', function () {
    //      var invoiceId = $(this).data('invoice-id');
    //       var adv_receiving_amount = $(this).val();
    //      saveadvanceReceivingAmount(invoiceId, adv_receiving_amount);
    //  });
	 
	 // $(document).on('input', '.remaining_amount', function () {
        // var invoiceId = $(this).data('invoice-id');
        // var remaining_amount = $(this).val();
        // RemainingAmount(invoiceId, remaining_amount);
    // });

    // $(document).on('change', '.remaining_amount', function () {
         // var invoiceId = $(this).data('invoice-id');
          // var remaining_amount = $(this).val();
         // RemainingAmount(invoiceId, remaining_amount);
     // });



</script>
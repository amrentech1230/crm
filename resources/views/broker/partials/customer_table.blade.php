
@foreach($customers as $key => $customer)
<tr>
    <td>
        {{ ($customers->currentPage() - 1) * $customers->perPage() + $key + 1 }}
    </td>
<td>
@if(in_array(Auth::user()->role_id, [1,2,3]))
    <a href="{{ route('edit.customer', encrypt($customer->id)) }}">{{ $customer->customer_name }}</a>
@else
    @if($customer->status == 'Not Approved')
    <a href="{{ route('customer.edit', encrypt($customer->id)) }}">{{ $customer->customer_name }}</a>
    @else
        {{ $customer->customer_name }}
    @endif
@endif
</td>

    <td class="dynamic-data">
        {{ $customer->customer_address }} 
        {{ $customer->customer_country }} 
        {{ $customer->customer_state }} 
        {{ $customer->customer_city }} 
        {{ $customer->customer_zip }}
    </td>
    <td class="dynamic-data">{{ $customer->customer_telephone }}</td>
    <td class="dynamic-data">{{ $customer->created_at->format('m-d-Y') }}</td>
    <td class="dynamic-data">{{ $customer->user?->name }}</td>
    <td class="dynamic-data">{{ $customer->user?->teamLeaderInfo?->tl }}</td>
    <td class="dynamic-data">{{ $customer->user?->managerInfo?->manager }}</td>
    <td class="dynamic-data">
        @if($customer->status == 'Approved')
            ${{ $customer->remaining_credit }}
        @else
        xxx
        @endif
    </td>
    <td class="dynamic-data">
            ${{ $customer->invoice_credit_limit }}
    </td>
    @php
                $lastdate = \App\Models\Load::where('customer_id', $customer->id)
                            ->where('user_id', $customer->user?->id)
                            ->latest('created_at')
                            ->value('created_at');
                $daysDifference = $lastdate ? \Carbon\Carbon::parse($lastdate)->diffInDays(\Carbon\Carbon::now()) : null;
    @endphp

    <td class="dynamic-data"> {{ $lastdate ?  $daysDifference.' Days'  : 'N/A' }} </td>
    
    <td class="dynamic-data">
        {{ $customer->status == 'Approved' ? 'Approved' : 'Pending For Approval' }}
    </td>
	<td>
		<input type="file" name="remittance[]" id="remittance_{{ $customer->id }}" data-customer-id="{{ $customer->id }}" multiple class="remittance-upload">
	</td>

 
	<td>
		<button id="view-button-{{ $customer->id }}" onclick="showRemittanceFiles({{ $customer->id }})" class="btn btn-info btn-sm" style="background-color: unset;border: unset;">
			<i class="fa fa-eye" style="font-size: 17px;color: #000;"></i>
		</button>
	</td>
    <td class="dynamic-data">
        @if($customer->commenter_name)
            @php
                // Decode the JSON strings
                $commenterNames = json_decode($customer->commenter_name, true);
                $commentNotes = json_decode($customer->comment_notes, true);

                // Initialize an empty string for comments
                $comments = '';

                // Check if the decoding was successful and both are arrays
                if (is_array($commenterNames) && is_array($commentNotes)) {
                    for ($j = 0; $j < count($commenterNames); $j++) {
                        // Concatenate comments if indexes exist
                        if (isset($commenterNames[$j]) && isset($commentNotes[$j])) {
                            $comments .= $commenterNames[$j] . ': ' . $commentNotes[$j] . "\n";
                        }
                    }
                }
            @endphp
            <textarea disabled name="comment_text" id="comment_text" rows="1">{{ $comments }}</textarea>
        @else
            <textarea disabled name="comment_text" rows="1">No Comment Found</textarea>
        @endif
        

    </td>
     <td class="status-{{ $customer->id }}">
        <span data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#view-documents-{{ $customer->id }}"> View Documents</span>
    </td>
    <div class="modal fade" id="view-documents-{{ $customer->id }}" tabindex="-1" aria-labelledby="view-documents" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 800px;">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header" style="padding-left: 14px;">
                    <h4 class="modal-title">View Documents</h4>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>


                    <div class="modal-body">
                    <!-- Existing Credit Logs -->

                    @php
                        $alladoc = $customer->customer_file_upload;
                        $docs = json_decode($alladoc, true);
                        
                    @endphp

                    @if(empty($docs))
                        <p>No documents found.</p>
                    @else

                        <div class="accordion" id="accordionExample">
                            @foreach($docs as $key => $all)
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                                    view document #{{$key + 1}}
                                    </button>
                                </h2>
                                <div id="collapse{{$key}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       @php
                                            $file = $all; // Or $all['file'] depending on your data structure
                                            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        @endphp

                                        <div style="margin-bottom: 20px;">
                                            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']))
                                                <!-- Image Preview -->
                                                <img src="{{ asset('public/'.$file) }}" alt="Image" style="max-width: 500px;">
                                            @elseif($extension === 'pdf')
                                                <!-- PDF Preview -->
                                                <embed src="{{ asset('public/'.$file) }}" type="application/pdf" width="600" height="400">
                                            @elseif(in_array($extension, ['doc', 'docx']))
                                                <!-- Word Preview with Google Docs Viewer -->
                                                <iframe src="https://docs.google.com/gview?url={{ urlencode(asset('public/'.$file)) }}&embedded=true" 
                                                        style="width:600px; height:500px;" frameborder="0"></iframe>
                                                <!-- Optional download link -->
                                                <br><a href="{{ asset($file) }}" target="_blank">Download Word Document</a>
                                            @else
                                                <!-- Unsupported file -->
                                                <p>Unsupported file type.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif

                    </div>
                </div>
        </div>
    </div>

</tr>
@endforeach

<script>  

// Load & show files
function showRemittanceFiles(customerId, startDate = '', endDate = '') {
    $('#remittanceAccordion').html('<div class="text-center p-3">Loading...</div>');

    $.ajax({
        url: '/broker/customer/remittance/filter',
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
            <div class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <button class="btn btn-link text-start w-100 text-decoration-none"
                            type="button" data-bs-toggle="collapse"
                            data-bs-target="#${collapseId}" aria-expanded="false"
                            aria-controls="${collapseId}">
                        <i class="bi bi-caret-down-fill me-2"></i>${fileName}
                        <small class="text-muted ms-2">(${file.uploaded_at})</small>
                    </button>
                    <button class="btn btn-sm btn-danger ms-2" onclick="deleteRemittanceFile('${file.path}', ${customerId})">Delete</button>
                </div>

                <div class="collapse" id="${collapseId}">
                    <div class="mt-2 ps-3">
                        ${isImage ? `<img src="/public/${file.path}" class="img-fluid" style="max-height: 300px;">` : ''}
                        ${isPDF ? `<iframe src="/public/${file.path}" width="100%" height="400px" style="border:none;"></iframe>` : ''}

                        <div class="mt-2">
                            <strong>Note:</strong> <span>${file.note || 'No note added'}</span>
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

// Delete file
function deleteRemittanceFile(filePath, customerId) {
    if (!confirm("Are you sure you want to delete this file?")) return;

    $.ajax({
        url: '/broker/customer/remittance/delete',
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
        url: '/broker/customer/remittance/filter',
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
$(document).on('change', '.remittance-upload', function (e) {
    const input = $(this);
    const customerId = input.data('customer-id');
    let files = e.target.files;

    if (files.length === 0) return;

    // Ask for note once (applied to all uploaded files in this batch)
    let note = prompt("Enter a note for these files (optional):", "");
    if (note === null) return; // Cancel upload

    let formData = new FormData();
    for (let i = 0; i < files.length; i++) {
        formData.append('remittance[]', files[i]);
    }

    formData.append('customer_id', customerId);
    formData.append('note', note);

    $.ajax({
        url: '/broker/customer/upload-remittance',
        type: 'POST',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: formData,
        processData: false,
        contentType: false,
        success: function () {
            alert('Upload successful');
            showRemittanceFiles(customerId); // refresh modal content
        },
        error: function (xhr) {
            console.error(xhr.responseText);
            alert('Upload failed.');
        }
    });
});


</script>

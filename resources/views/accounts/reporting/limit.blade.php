
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach($sortedCustomers as $index => $customer)
                                    <tr class="load-row" >                                      <td class="dynamic-data" style=" vertical-align: middle !important;">{{ ($sortedCustomers->currentPage() - 1) * $sortedCustomers->perPage() + $index + 1 }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->name }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                             <a href="{{ route('edit.customer', ['id' => $customer->id]) }}">{{ $customer->customer_name }}</a>
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            {{ $customer->customer_address }} {{ $customer->customer_country }} {{ $customer->customer_state }} {{ $customer->customer_city }} {{ $customer->customer_zip }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->customer_telephone }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->created_at->format('m/d/Y') }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->teamLeaderInfo?->tl }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->managerInfo?->manager }} @endif</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">@if($customer->user) {{ $customer->user->officedata?->office_name }} @endif</td>
                                         <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            
                                            @php
                                            $credits = json_decode($customer->credit_limit_log, true);

                                            if (is_array($credits)) {
                                                $totalCreditLimit = array_sum(array_column($credits, 'credit_limit'));
                                            } else {
                                                $totalCreditLimit = 0;
                                            }
                                            @endphp
                                            ${{ $totalCreditLimit }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                        ${{ $totalCreditLimit - $customer->remaining_credit }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">
                                            ${{ number_format(floatval($customer->remaining_credit), 2) }}
                                        </td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->status }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->aging_days !== null ? $customer->aging_days . ' days' : 'N/A' }}</td>
                                        <td class="dynamic-data" style=" vertical-align: middle !important;">{{ $customer->created_at->format('m-d-Y') }}</td>
										<td>
											<input type="file" name="remittance[]" id="remittance_{{ $customer->id }}" data-customer-id="{{ $customer->id }}" multiple class="remittance-upload">
										</td>

														 
										<td>
											<button id="view-button-{{ $customer->id }}" onclick="showRemittanceFiles({{ $customer->id }})" class="btn btn-info btn-sm" style="background-color: unset;border: unset;">
												<i class="fa fa-eye" style="font-size: 17px;color: #000;"></i>
											</button>
										</td>
                                        <td class="dynamic-data">
                                            <div class="d-flex justify-content-center">
                                                @php
                                                    $st = $customer->status;
                                                @endphp
                                                <a href="{{ route('edit.customer', ['id' => $customer->id]) }}">
                                                    <i class="fa fa-edit" style="font-size: 17px;color: #0dcaf0;"></i>
                                                </a>
                                                <a href="javascript:void(0);" class="delete-customer" data-id="{{ $customer->id }}">
                                                    <i class="fa fa-trash" style="font-size: 17px;color: red;"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
									
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
                            <button class="btn btn-link text-start w-100 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                <i class="bi bi-caret-down-fill me-2"></i>${fileName}
                            </button>
                            <button class="btn btn-sm btn-danger ms-2" onclick="deleteRemittanceFile('${file}', ${customerId})">Delete</button>
                        </div>
                        <div class="collapse" id="${collapseId}">
                            <div class="mt-2 ps-3">
                                ${isImage ? `<img src="/${file}" class="img-fluid" style="max-height: 300px;">` : ''}
                                ${isPDF ? `<iframe src="/${file}" width="100%" height="400px" style="border:none;"></iframe>` : ''}
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
                                            <button class="btn btn-link text-start w-100 text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#${collapseId}" aria-expanded="false" aria-controls="${collapseId}">
                                                <i class="bi bi-caret-down-fill me-2"></i>${fileName}
                                                <small class="text-muted ms-2">(${file.uploaded_at})</small>
                                            </button>
                                            
                                        </div>
                                        <div class="collapse" id="${collapseId}">
                                            <div class="mt-2 ps-3">
                                                ${isImage ? `<img src="/public/${file.path}" class="img-fluid" style="max-height: 300px;">` : ''}
                                                ${isPDF ? `<iframe src="/public/${file.path}" width="100%" height="400px" style="border:none;"></iframe>` : ''}
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
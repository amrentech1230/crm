<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Bootstrap CSS (must also be loaded somewhere) -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

@foreach($vendormanagement as $i => $vendor)
        <tr class="load-row {{ 
            ($vendor->load_status == 'Open') ? 'row-open' : 
            ($vendor->load_status == 'Delivered' && $vendor->invoice_status == 'Paid' ? 'row-delivered-paid' : 
            ($vendor->load_status == 'Delivered' && $vendor->invoice_status == 'Paid Record' ? 'row-delivered-paid-record' : 
            ($vendor->load_status == 'Delivered' ? 'row-delivered' : ''))) 
        }}" data-created-at="{{ $vendor->created_at->format('m-d-Y') }}">
            <td class="dynamic-data">{{ $i+1 }}</td>
            <td class="dynamic-data" id="load_number">
            <a>
                {{ $vendor->load_number }}
            </a>

            </td>

            <td class="dynamic-data">{{ $vendor->load_bill_to }}</td>
            <td class="dynamic-data">
                <input type="date" class="form-control load_carrier_due_date" name="load_carrier_due_date" value="{{ $vendor->load_carrier_due_date }}" data-id="{{ $vendor->id }}">
            </td>
            <td class="dynamic-data">
                <span class="formatted_date due_date-{{ $vendor->id }}">{{ $vendor->load_carrier_due_date ? \Carbon\Carbon::parse($vendor->load_carrier_due_date)->format('d-m-Y') : '' }}</span>
            </td>
            <td class="dynamic-data">
                <select style="width: 100%;" name="quick_pay"  class="form-control quick_pay" class="quick_pay" data-id="{{ $vendor->id }}">
                    <option value="{{ $vendor->quick_pay }}">{{ $vendor->quick_pay ?? 'Please Select Quick Pay' }}</option>
                    <option value="1%">1%</option>
                    <option value="2%">2%</option>
                    <option value="3%">3%</option>
                    <option value="4%">4%</option>
                    <option value="5%">5%</option>
                    <option value="6%">6%</option>
                </select>
            </td>
            <td class="dynamic-data">
                <select style="width: 100%;"  class="form-control payment_method" name="payment_method" class="payment_method" data-id="{{ $vendor->id }}">
                    <option value="{{ $vendor->payment_method }}">{{ $vendor->payment_method ?? 'Please Select Payment Method' }}</option>
                    <option value="ACH">ACH</option>
                    <option value="Quick Pay">Quick Pay</option>
                    <option value="OTR">OTR</option>
                    <option value="Zelle">Zelle</option>
                    <option value="Check">Check</option>
                    <option value="Wire">Wire</option>
                    <option value="Buyout">Buyout</option>
                </select>
            </td>
            <td class="dynamic-data">
                <select style="width: 100%;" class="form-control ready_to_pay" name="ready_to_pay" class="ready_to_pay" data-id="{{ $vendor->id }}">
                    <option value="{{ $vendor->ready_to_pay }}">{{ $vendor->ready_to_pay ?? 'Please Select Ready to Pay' }}</option>
                    <option value="Yes" style="background-color: green; color: white;">Yes</option>
                    <option value="No" style="background-color: red; color: white;">No</option>
                    <option value="Hold" style="background-color: yellow; color: black;">Hold</option>
                </select>
            </td>
           <td class="dynamic-data">
                @if ($vendor->carrier_mark_as_paid != 'Paid')
                    <input type="checkbox" class="carrier_mark_as_paid" data-id="{{ $vendor->id }}">
                @else
                    Paid
                @endif
            </td>

           <td class="dynamic-data">
                <input type="file" class="carrierDoc" name="carrierDoc[]" multiple data-id="{{ $vendor->id }}">
            </td>

            <!-- Blade Table -->
            @if($vendor->carrierDoc)
            <td class="text-center dynamic-data">
                <a href="javascript:void(0)" class="view-files" data-toggle="modal" data-id="{{ $vendor->id }}" data-target="#filesModal">
                    <i class="fa fa-eye" style="font-size: 16px;"></i>
                </a>
            </td>
            @else
            <td class="dynamic-data">
                <p style="font-size:7px;color:red">No files uploaded</p>
            </td>
            @endif



            <td class="dynamic-data">{{ $vendor->load_workorder }}</td>
            <td class="dynamic-data">{{ $vendor->load_carrier }}</td>
            <td class="dynamic-data">{{ $vendor->invoice_number }}</td>
            <td class="dynamic-data">{{ $vendor->invoice_date }}</td>
            <td class="dynamic-data">
                @if($vendor->invoice_status == 'Paid')
                    Invoiced
                @elseif($vendor->invoice_status == 'Paid Record')
                    Paid
                @elseif($vendor->load_status == 'Completed')
                    Completed
                @elseif($vendor->load_status == 'Open')
                    Open
                @elseif($vendor->load_status == 'Unloading')
                    Unloading
                @else
                    {{ $vendor->load_status }}
                @endif
            </td>
            <td class="dynamic-data">{{ $vendor->created_at }}</td>
            <td class="dynamic-data">@if($vendor->user) {{ $vendor->user->name }} @endif</td>
            
            <td>
                @if($vendor->public_file)
                    <li class="d-flex">
                        @php
                        // Define the path to the folder on the server
                        $folderPath = storage_path('app/public/vendor_files/' . $vendor->id); // Adjust this to your folder path

                        // Check if the folder exists
                        if (file_exists($folderPath)) {
                            // Get the folder creation time (metadata change time)
                            $folderCreationTime = filectime($folderPath);

                            // Format the folder creation time
                            $folderCreationDate = date('Y-m-d H:i:s', $folderCreationTime); // Format the date
                        } else {
                            $folderCreationDate = 'Folder does not exist';
                        }
                        @endphp

                        <a style="padding: 0; font-size: 14px; background-color: unset; border: unset;" 
                            class="btn btn-primary text-white"
                            data-toggle="modal" 
                            data-target="#view-file">
                            <i class="fa fa-eye" style="margin-right: 10px;color: #212529;"></i>
                        </a>

                        <!-- Display Folder Creation Date -->
                        <p style="margin: 7px 0;">Folder Created At: {{ $folderCreationDate }}</p>
                    </li>
                @else
                    <li>
                        <a style="padding: 0; font-size: 14px; background-color: unset; border: unset;" class="btn btn-primary text-white" href="javascript:void(0);" style="text-decoration:unset"> 
                            <i class="fa fa-eye-slash" style="margin-right: 10px;color: red;"></i>
                        </a>
                    </li>
                @endif
            </td>
        </tr>
        <!-- File View Modal -->
<!-- Modal -->
<div class="modal fade" id="filesModal" tabindex="-1" role="dialog" aria-labelledby="filesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Uploaded Files</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="fileList">
        <p>Loading files...</p>
      </div>
    </div>
  </div>
</div>

@endforeach 



<script>

function initVendorDataTable() {
    
    // Reinitialize
    $('#datatable-buttons-vendor').DataTable({
        responsive: true,
        dom: 'Bfrtip',
        buttons: ['copy', 'excel', 'pdf', 'colvis'],
    });
}

$(document).ready(function() {

   initVendorDataTable();
});


$(document).on('change', '.load_carrier_due_date', function() {
    var dueDate = $(this).val();
    var vendorId = $(this).data('id');

    $.ajax({
        url: '/update-carrier-due-date', // Replace with your actual endpoint
        method: 'POST',
        data: {
            id: vendorId,
            load_carrier_due_date: dueDate
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
                console.log('Success:', response);
                $('.due_date-'+vendorId ).text(dueDate);
                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
    });
});


$(document).ready(function() {
    $(document).on('change', '.quick_pay', function(e){
        var load_id = $(this).data('id');
        var quick_pay = $(this).val();

        $.ajax({
            url: '/quick_pay',
            method: 'POST',
            data: {
                load_id: load_id,
                quick_pay: quick_pay
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);

                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});


$(document).ready(function() {
    $(document).on('change', '.payment_method', function(e){
        var load_id = $(this).data('id');
        var payment_method = $(this).val();

        $.ajax({
            url: '/payment_method',
            method: 'POST',
            data: {
                load_id: load_id,
                payment_method: payment_method
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);

                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});


$(document).ready(function() {
    $(document).on('change', '.ready_to_pay', function(e){
        var load_id = $(this).data('id');
        var ready_to_pay = $(this).val();

        $.ajax({
            url: '/ready_to_pay',
            method: 'POST',
            data: {
                load_id: load_id,
                ready_to_pay: ready_to_pay
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log('Success:', response);

                $('#mc-success-message').text(response.message).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-success-message').text('').fadeOut();
                }, 1000); // 10000ms = 10s
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                $('#mc-error-message').text(error).fadeIn();

                // Hide after 10 seconds
                setTimeout(function() {
                    $('#mc-error-message').text('').fadeOut();
                }, 1000); 
            }
        });
    });
});

$(document).ready(function() {
    // Handle file upload
    $('.carrierDoc').on('change', function() {

        var input = $(this);
        var files = input[0].files;
        var id = input.data('id'); // Get the vendor ID
        var formData = new FormData();

        // Append files and ID to FormData
        for (var i = 0; i < files.length; i++) {
            formData.append('carrierDoc[]', files[i]);
        }
        formData.append('id', id);  // Append the vendor ID

        // Send the AJAX request
        $.ajax({
            url: '/uploadCarrierDocs', // Your route for uploading
            type: 'POST',
            data: formData,
            contentType: false, // Don't set content type (important for FormData)
            processData: false, // Don't process the data (important for FormData)
            success: function(response) {
                // Handle the success response
                if (response.success) {
                    alert('Files uploaded successfully!');
                    location.reload(); // Reload the page after successful upload
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                // Handle any error during the request
                alert('Failed to upload files. Please try again.');
            }
        });
    });
});

</script>

<script>
    $(document).on('change', '.carrier_mark_as_paid', function () {
        var checkbox = $(this);
        var loadId = checkbox.data('id');

        if (checkbox.is(':checked')) {
            $.ajax({
                url: '{{ route("carrier.mark.paid") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: loadId
                },
                success: function (response) {
                    if (response.status === 'success') {
                        checkbox.parent().html('Paid');
                    } else {
                        alert('Error: ' + response.message);
                        checkbox.prop('checked', false);
                    }
                },
                error: function () {
                    alert('Something went wrong. Try again.');
                    checkbox.prop('checked', false);
                }
            });
        }
    });
</script>

<script>
$(document).ready(function () {
    $(document).on('change', '.carrierDoc', function () {
        let input = $(this);
        let files = input[0].files;
        let id = input.data('id');

        if (files.length === 0) return;

        let formData = new FormData();

        for (let i = 0; i < files.length; i++) {
            formData.append('carrierDoc[]', files[i]);
        }

        formData.append('id', id);

        $.ajax({
            url: '{{ route("uploadCarrierDocs") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    alert('Files uploaded successfully!');
                    location.reload(); // Or update DOM if you prefer
                } else {
                    alert('Upload failed: ' + res.message);
                }
            },
            error: function () {
                alert('Upload error. Please check file type and size.');
            }
        });
    });
});
</script>

<!-- Script -->
<script>
$(document).ready(function () {
    $(document).on('click', '.view-files', function () {
        let loadId = $(this).data('id');
        $('#fileList').html('<p>Loading files...</p>');

        $.ajax({
            url: '/load/get-files/' + loadId,
            type: 'GET',
            success: function (response) {
                console.log(response); // for debug
                if (response.success && response.files.length > 0) {
                    let html = '<ul class="list-group">';
                    response.files.forEach(file => {
                        let filename = file.split('/').pop();
                        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="/${file}" target="_blank">${filename}</a>
                                    <button class="btn btn-sm btn-danger delete-file" data-id="${loadId}" data-file="${file}">Delete</button>
                                </li>`;
                    });
                    html += '</ul>';
                    $('#fileList').html(html);
                } else {
                    $('#fileList').html('<p>No files found.</p>');
                }
            },
            error: function () {
                $('#fileList').html('<p>Error loading files.</p>');
            }
        });
    });
});
</script>
<script>
    $(document).on('click', '.delete-file', function () {
    console.log('Delete button clicked'); // ✅ Add this line

    let loadId = $(this).data('id');
    let file = $(this).data('file');
    let button = $(this);

    if (confirm('Are you sure you want to delete this file?')) {
        $.ajax({
            url: '{{ route("load.delete.file") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: loadId,
                file: file
            },
            success: function (res) {
                if (res.success) {
                    button.closest('li').remove();
                } else {
                    alert('Delete failed: ' + res.message);
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert('Error deleting file.');
            }
        });
    }
});

</script>
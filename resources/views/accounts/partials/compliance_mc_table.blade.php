@foreach($carriers as $carrier)

<tr>
    <td>{{$carrier->carrier_mc_ff_input}}</td>
    <td>{{$carrier->carrier_dot}}</td>
    <td>{{$carrier->carrier_name}}</td>
    <td>{{$carrier->user?->name}}</td>
    <td>{{$carrier->created_at}}</td>
     <td>
        <select name="mc_check" onchange="mc_check(this)" id="mc_check-{{ $carrier->id }}" class="form-control" width="100%">
            <option value="" data-carrier-id="{{ $carrier->id }}">Please Select MC</option>
            <option value="Approved"  data-carrier-id="{{ $carrier->id }}" {{ $carrier->mc_check == 'Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Not Approved"  data-carrier-id="{{ $carrier->id }}" {{ $carrier->mc_check == 'Not Approved' ? 'selected' : '' }}>Not Approved</option>
        </select>
    </td>
	<td>
		<select id="mc_setup-{{ $carrier->id }}" onchange="mc_setup(this)" name="setup" class="form-control" >
			<option value="" data-setup-id="{{ $carrier->id }}">Please Select Setup</option>
			<option value="Online Setup" data-setup-id="{{ $carrier->id }}" {{ $carrier->setup == 'Online Setup' ? 'selected' : '' }}>Online Setup</option>
			<option value="Manual Setup" data-setup-id="{{ $carrier->id }}" {{ $carrier->setup == 'Manual Setup' ? 'selected' : '' }}>Manual Setup</option>
			<option value="Pre Approved" data-setup-id="{{ $carrier->id }}" {{ $carrier->setup == 'Pre Approved' ? 'selected' : '' }}>Pre Approved</option>
		</select>
	</td>
    <td class="status-{{ $carrier->id }}">{{$carrier->mc_check}}</td>
	<td class="setup-{{ $carrier->id }}">{{$carrier->setup}}</td>
    <td>
        <span data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#view-documents-{{ $carrier->id }}"> View Documents</span>
    </td>
    @if($carrier->carrier_block == 'Blocked')
        <td style="background-color: red; color: white; font-weight: bold;"><input type="checkbox" name="carrier_block" id="carrier_block-{{ $carrier->id }}" onchange="carrier_block(this)" data-carrier-id="{{ $carrier->id }}" {{ $carrier->carrier_block == 'Blocked' ? 'checked' : '' }}></td>
    @else
    <td>
        <input type="checkbox" name="carrier_block" id="carrier_block-{{ $carrier->id }}" onchange="carrier_block(this)" data-carrier-id="{{ $carrier->id }}" {{ $carrier->carrier_block == 'Blocked' ? 'checked' : '' }}>
    </td>
    @endif


    <div class="modal fade" id="view-documents-{{ $carrier->id }}" tabindex="-1" aria-labelledby="view-documents" aria-hidden="true">
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
                        $alladoc = $carrier->carrier_file_upload;
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
                                                <br><a href="{{ asset('public/'.$file) }}" target="_blank">Download Word Document</a>
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
function mc_check(e) {
    var $selectedOption = $(e).find('option:selected');
    var carrier_id = $selectedOption.data('carrier-id');
    var mc_check = $(e).val();

    $.ajax({
        url: '/account/mc-chcek', // Fixed the typo here
        method: 'POST',
        data: {
            carrier_id: carrier_id,
            mc_check: mc_check
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Success:', response);
            $('.status-' + carrier_id).text(mc_check);
            $('#mc-success-message').text(response.message).fadeIn();

            setTimeout(function () {
                $('#mc-success-message').text('').fadeOut();
            }, 10000); // 10 seconds
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            $('#mc-error-message').text(error).fadeIn();

            setTimeout(function () {
                $('#mc-error-message').text('').fadeOut();
            }, 10000); // 10 seconds
        }
    });
}


function mc_setup(e) {
    var $selectedOption = $(e).find('option:selected');
    var setup_id = $selectedOption.data('setup-id');
    var mc_setup = $(e).val();

    $.ajax({
        url: '/account/mc-setup', // Ensure this is the correct endpoint
        method: 'POST',
        data: {
            setup_id: setup_id,
            mc_setup: mc_setup
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log('Success:', response);
            $('.setup-' + setup_id).text(mc_setup);
            $('#mc-success-message').text(response.message).fadeIn();

            // Hide after 10 seconds
            setTimeout(function () {
                $('#mc-success-message').text('').fadeOut();
            }, 10000); // 10 seconds
        },
        error: function (xhr, status, error) {
            console.error('Error:', error);
            $('#mc-error-message').text(error).fadeIn();

            // Hide after 10 seconds
            setTimeout(function () {
                $('#mc-error-message').text('').fadeOut();
            }, 10000); // 10 seconds
        }
    }); 
}

</script>

<script>
function carrier_block(el) {

    var carrierId = el.getAttribute("data-carrier-id");
    var isChecked = el.checked ? 1 : 0;

    $.ajax({
        url: "{{ route('carrier_block') }}",
        type: "GET",
        data: {
            carrier_id: carrierId,
            is_blocked: isChecked
        },
        success: function(response) {
            console.log(response);
            location.reload();

            // Optional success alert
            Swal.fire({
                icon: 'success',
                title: 'Updated',
                text: 'Carrier status updated to ' + response.value,
                timer: 1500
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update status'
            });
        }
    });
}
</script>






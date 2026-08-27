@foreach($carriers as $carrier)
@if($carrier->carrier_block !== 'Blocked')
<tr>
    <td>
	@if(in_array(Auth::user()->role_id, [1,2,3]))
		<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
				data-bs-target="#editCarrier_{{ $carrier->id }}">
				<i class="fas fa-edit"></i>
		</button>
	@else
		
		@if($carrier->mc_check !== 'Approved')

			<button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
				data-bs-target="#editCarrier_{{ $carrier->id }}">
				<i class="fas fa-edit"></i>
			</button>
		@else
			--
		@endif
	@endif
        {{-- <form method="POST" action="{{ route('carrier.destroy', $carrier->id) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                <i class="fas fa-trash"></i>
            </button>
        </form> --}}
    </td>
    <td>{{ $carrier->carrier_name }}</td>
    <td>{{ $carrier->carrier_mc_ff }} {{ $carrier->carrier_mc_ff_input }}</td>
    <td>{{ $carrier->carrier_dot }}</td>
    <td>{{ $carrier->carrier_address_two }} {{ $carrier->carrier_country }} {{ $carrier->carrier_city }}
        {{ $carrier->carrier_zip }}</td>
    <td>{{ $carrier->carrier_telephone }}</td>
    <td>{{ $carrier->created_at }}</td>
    <td>{{ $carrier->user?->name }}</td>
    <td>{{ $carrier->user?->teamLeaderInfo?->tl }}</td>
    <td>{{ $carrier->user?->managerInfo?->manager }}</td>
    <td>{{ $carrier->mc_check ?? 'Not-Approved'}}</td>
	<td class="status-{{ $carrier->id }}">
        <span data-bs-toggle="modal" style="color: #0c7ce6; cursor:pointer" data-bs-target="#view-documents-{{ $carrier->id }}"> View Documents</span>
    </td>
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
    <!-- …etc… -->
</tr>

{{-- inline “Edit Carrier” modal for this $carrier --}}
<div id="editCarrier_{{ $carrier->id }}" class="modal fade" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="POST" action="{{ route('carrier.update', $carrier->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Carrier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        {{-- Carrier Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Carrier Name <code>*</code></label>
                            <input type="text" name="carrier_name" class="form-control"
                                value="{{ $carrier->carrier_name }}" required>
                        </div>

                        {{-- MC / FF --}}
                        <div class="col-md-6">
                            <label class="form-label">M.C. # / F.F. # <code>*</code></label>
                            <div class="input-group">
                                <select name="carrier_mc_ff" class="form-select" required>
                                    <option value="MC" {{ $carrier->carrier_mc_ff == 'MC' ? 'selected' : '' }}>MC
                                    </option>
                                    <option value="FF" {{ $carrier->carrier_mc_ff == 'FF' ? 'selected' : '' }}>FF
                                    </option>
                                </select>
                                <input type="text" name="carrier_mc_ff_input" class="form-control"
                                    value="{{ $carrier->carrier_mc_ff_input }}" required>
                            </div>
                        </div>

                        {{-- DOT --}}
                        <div class="col-md-4">
                            <label class="form-label">D.O.T</label>
                            <input type="text" name="carrier_dot" class="form-control"
                                value="{{ $carrier->carrier_dot }}">
                        </div>

                        {{-- Address --}}
                        <div class="col-md-8">
                            <label class="form-label">Address <code>*</code></label>
                            <input type="text" name="carrier_address_two" class="form-control"
                                value="{{ $carrier->carrier_address_two }}" required>
                        </div>

                        {{-- Country --}}
                        <div class="col-md-4">
                            <label class="form-label">Country <code>*</code></label>
                            <select name="carrier_country" id="carrier_country" class="form-select" required onchange="getCarrierStates(this)">
								<option value="">Choose Country</option>
								@foreach($allcountry as $country)
									<option value="{{ $country->name }}" data-id="{{ $country->id }}" data-carrier-id="{{$carrier->id}}"
										@if($carrier->carrier_country == $country->name) selected @endif>
										{{ $country->name }}
									</option>
								@endforeach
							</select>
                        </div>

                        {{-- State --}}
                        <div class="col-md-4">
                            <label class="form-label">State <code>*</code></label>
                            <select name="carrier_state" id="carrier_state_{{$carrier->id}}" class="form-control">
                                <option value="{{$carrier->carrier_state}}" selected>{{$carrier->carrier_state}}</option>
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="col-md-4">
                            <label class="form-label">City <code>*</code></label>
                            <input type="text" name="carrier_city" class="form-control"
                                value="{{ $carrier->carrier_city }}" required>
                        </div>

                        {{-- Zip --}}
                        <div class="col-md-4">
                            <label class="form-label">Zip <code>*</code></label>
                            <input type="text" name="carrier_zip" class="form-control"
                                value="{{ $carrier->carrier_zip }}" required>
                        </div>

                        {{-- POC Name --}}
                        <div class="col-md-4">
                            <label class="form-label">POC Name</label>
                            <input type="text" name="carrier_contact_name" class="form-control"
                                value="{{ $carrier->carrier_contact_name }}">
                        </div>

                        {{-- Email --}}
                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" name="carrier_email" class="form-control"
                                value="{{ $carrier->carrier_email }}">
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-4">
                            <label class="form-label">Phone No <code>*</code></label>
                            <input type="number" name="carrier_telephone" class="form-control"
                                value="{{ $carrier->carrier_telephone }}" required>
                        </div>

                        {{-- Extn --}}
                        <div class="col-md-4">
                            <label class="form-label">Extn.</label>
                            <input type="text" name="carrier_extn" class="form-control"
                                value="{{ $carrier->carrier_extn }}">
                        </div>

                        {{-- Fax --}}
                        <div class="col-md-4">
                            <label class="form-label">Fax</label>
                            <input type="text" name="carrier_fax" class="form-control"
                                value="{{ $carrier->carrier_fax }}">
                        </div>

                        {{-- Status --}}
                        <div class="col-md-4">
                            <label class="form-label">Status <code>*</code></label>
                            <select name="carrier_status" class="form-select" required>
                                <option value="">Select</option>
                                <option value="Active" {{ $carrier->carrier_status == 'Active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="In-Active"
                                    {{ $carrier->carrier_status == 'In-Active' ? 'selected' : '' }}>In-Active</option>
                            </select>
                        </div>

                        {{-- Payment Terms --}}
                        <div class="col-md-4">
                            <label class="form-label">Payment Terms</label>
                            <select name="carrier_payment_terms" class="form-select">
                                <option value="">Select Payment</option>
                                <option value="Prepaid"
                                    {{ $carrier->carrier_payment_terms == 'Prepaid' ? 'selected' : '' }}>Prepaid
                                </option>
                                <option value="Postpaid"
                                    {{ $carrier->carrier_payment_terms == 'Postpaid' ? 'selected' : '' }}>Postpaid
                                </option>
                            </select>
                        </div>

                        {{-- Factoring Company --}}
                        <div class="col-md-4">
                            <label class="form-label">Factoring Company</label>
                            <input type="text" name="carrier_factoring_company" class="form-control"
                                value="{{ $carrier->carrier_factoring_company }}">
                        </div>

                        {{-- Notes --}}
                        <div class="col-md-6">
                            <label class="form-label">Notes</label>
                            <textarea name="carrier_notes" class="form-control"
                                rows="3">{{ $carrier->carrier_notes }}</textarea>
                        </div>

                        {{-- File Upload --}}
                        <div class="col-md-6">
                            <label class="form-label">File Upload</label>
                            <input type="file" name="carrier_file_upload[]" class="form-control" multiple>
                            <small class="text-muted">Uploading new files will not remove previously uploaded
                                ones.</small>
                        </div>

                        @if(in_array(Auth::user()->role_id, [1,2,3]))
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Assign To </label>
                                    <select class="form-control" id="user_id" required name="user_id"
                                        style="width: 100%;">
                                        <option value="">Select a Broker</option>
                                        @foreach($users as $user)
                                        <option value="{{$user->id}}" data-id="{{$user->id}}" @if($user->id == $carrier->user_id) selected @endif>{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <input type="hidden" id="dispatcher_name" name="dispatcher_name" value="{{$carrier->dispatcher_name}}">
                        @else
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="dispatcher_name" value="{{Auth::user()->name}}">
                        @endif
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#user_id').on('change', function() {
            var selectedName = $(this).find('option:selected').text();
            $('#dispatcher_name').val(selectedName);
        });
    });
</script>

 <script>
    function getCarrierStates(selectElement) {
        let countryId = selectElement.options[selectElement.selectedIndex].getAttribute('data-id');
		let carrierId = selectElement.options[selectElement.selectedIndex].getAttribute('data-carrier-id');

        if (countryId) {
            $.ajax({
                url: '/broker/carrier-get-states/' + countryId, // Adjust route as needed
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('#carrier_state_'+carrierId).empty().prop('disabled', false);
                    $('#carrier_state_'+carrierId).html(data);
                }
            });
        } else {
            $('#carrier_state').empty();
            $('#carrier_state').append('<option value="">Choose State</option>');
        }
    }
</script>
@endif
@endforeach

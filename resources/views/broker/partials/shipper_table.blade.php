        @foreach($shipper as $shipper)
        <tr>
            <td>
                {{-- Edit button --}}
                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                    data-bs-target="#editShipperModal_{{ $shipper->id }}">
                    <i class="fas fa-edit"></i>
                </button>
                {{-- Delete form --}}
                <!--<form action="{{ route('shipper.destroy',$shipper->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>--->
            </td>
            <td>{{ $shipper->shipper_name }}</td>
            <td>{{ $shipper->shipper_address }}</td>
            <td>{{ $shipper->shipper_telephone }}</td>
            <td>{{ $shipper->created_at->format('Y-m-d') }}</td>
            <td>{{ $shipper->user?->name }}</td>
            <td>{{ $shipper->user?->teamLeaderInfo?->tl }}</td>
            <td>{{ $shipper->user?->managerInfo?->manager }}</td>
			<td>{{ $shipper->shipper_status }}</td>
        </tr>

        {{-- Inline “Edit Shipper” Modal --}}
        <div class="modal fade" id="editShipperModal_{{ $shipper->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <form action="{{ route('shipper.update', $shipper->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Shipper</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-3">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <label class="form-label">Name <code>*</code></label>
                                    <input type="text" name="shipper_name" class="form-control"
                                        value="{{ old('shipper_name', $shipper->shipper_name) }}" required>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-6">
                                    <label class="form-label">Address <code>*</code></label>
                                    <input type="text" name="shipper_address" class="form-control"
                                        value="{{ old('shipper_address', $shipper->shipper_address) }}" required>
                                </div>

                                {{-- Country --}}
                                <div class="col-md-3">
                                    <label class="form-label">Country <code>*</code></label>
                                    <select name="shipper_country" id="shipper_country" class="form-select" required onchange="getShipperStates(this)">
										<option value="">Choose Country</option>
										@foreach($allcountry as $country)
											<option value="{{ $country->name }}" data-id="{{ $country->id }}" data-shipper-id="{{$shipper->id}}" 
												@if($country->name == $shipper->shipper_country) selected @endif>
												{{ $country->name }}
											</option>
										@endforeach
									</select>
                                </div>

                                {{-- State --}}
                                <div class="col-md-3">
                                    <label class="form-label">State <code>*</code></label>
                                    <select name="shipper_state" id="shipper_state_{{$shipper->id}}" class="form-select" required>
                                        @foreach($state as $states)
										@if($states->name == $shipper->shipper_state)
											<option value="{{$shipper->shipper_state}}"  selected> {{$states->name}} </option>
										@endif
										
										@endforeach
                                    </select>
                                </div>

                                {{-- City --}}
                                <div class="col-md-3">
                                    <label class="form-label">City <code>*</code></label>
                                    <input type="text" name="shipper_city" class="form-control"
                                        value="{{ old('shipper_city', $shipper->shipper_city) }}" required>
                                </div>

                                {{-- Zip --}}
                                <div class="col-md-3">
                                    <label class="form-label">Zip <code>*</code></label>
                                    <input type="text" name="shipper_zip" class="form-control"
                                        value="{{ old('shipper_zip', $shipper->shipper_zip) }}" required>
                                </div>

                                {{-- POC Name --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">POC Name</label>
                                    <input type="text" name="shipper_contact_name" class="form-control"
                                        value="{{ old('shipper_contact_name', $shipper->shipper_contact_name) }}">
                                </div>

                                {{-- Contact Email --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Contact Email</label>
                                    <input type="email" name="shipper_contact_email" class="form-control"
                                        value="{{ old('shipper_contact_email', $shipper->shipper_contact_email) }}">
                                </div>

                                {{-- Telephone --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Telephone <code>*</code></label>
                                    <input type="number" name="shipper_telephone" class="form-control"
                                        value="{{ old('shipper_telephone', $shipper->shipper_telephone) }}" required>
                                </div>

                                {{-- Ext --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Ext.</label>
                                    <input type="text" name="shipper_extn" class="form-control"
                                        value="{{ old('shipper_extn', $shipper->shipper_extn) }}">
                                </div>

                                {{-- Fax --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Fax</label>
                                    <input type="text" name="shipper_fax" class="form-control"
                                        value="{{ old('shipper_fax', $shipper->shipper_fax) }}">
                                </div>

                                {{-- Appointments --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Appointments</label>
                                    <select name="shipper_appointments" class="form-select">
                                        <option value=""
                                            {{ old('shipper_appointments', $shipper->shipper_appointments) == '' ? 'selected' : '' }}>
                                            Select</option>
                                        <option value="Yes"
                                            {{ old('shipper_appointments', $shipper->shipper_appointments) == 'Yes' ? 'selected' : '' }}>
                                            Yes</option>
                                        <option value="No"
                                            {{ old('shipper_appointments', $shipper->shipper_appointments) == 'No' ? 'selected' : '' }}>
                                            No</option>
                                    </select>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-3 col-sm-6">
                                    <label class="form-label">Status <code>*</code></label>
                                    <select name="shipper_status" class="form-select" required>
                                        <option value="" disabled
                                            {{ old('shipper_status', $shipper->shipper_status) == '' ? 'selected' : '' }}>
                                            Select</option>
                                        <option value="Active"
                                            {{ old('shipper_status', $shipper->shipper_status) == 'Active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="In-Active"
                                            {{ old('shipper_status', $shipper->shipper_status) == 'In-Active' ? 'selected' : '' }}>
                                            In-Active</option>
                                    </select>
                                </div>

                                {{-- Add as consignee (checkbox) --}}
                                <div class="col-md-3 col-sm-6 d-flex align-items-center">
                                    <label class="form-label me-2 mb-0">Add as consignee</label>
                                    <input type="checkbox" name="same_as_consignee" id="same_as_consignee" value="1"
                                        {{ old('same_as_consignee', $shipper->same_as_consignee) ? 'checked' : '' }}>
                                </div>

                                {{-- Shipping Notes --}}
                                <div class="col-md-6 col-sm-6">
                                    <label class="form-label">Shipping Notes</label>
                                    <textarea name="shipper_shipping_notes" class="form-control"
                                        style="height: 100px;">{{ old('shipper_shipping_notes', $shipper->shipper_shipping_notes) }}</textarea>
                                </div>

                                {{-- Internal Notes --}}
                                <div class="col-md-6 col-sm-6">
                                    <label class="form-label">Internal Notes</label>
                                    <textarea name="shipper_internal_notes" class="form-control"
                                        style="height: 100px;">{{ old('shipper_internal_notes', $shipper->shipper_internal_notes) }}</textarea>
                                </div>

                                @if(in_array(Auth::user()->role_id, [1,2,3]))
                                    <div class="col-md-6 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label>Assign To </label>
                                            <select class="form-control" required name="user_id"
                                                style="width: 100%;">
                                                <option value="">Select a Broker</option>
                                                @foreach($users as $user)
                                                <option value="{{$user->id}}" data-id="{{$user->id}}" @if($user->id == $shipper->user_id) selected @endif>{{$user->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                                @endif
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Update Shipper</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
<script>
    function getShipperStates(selectElement) {
        let countryId = selectElement.options[selectElement.selectedIndex].getAttribute('data-id');
		let shipperid = selectElement.options[selectElement.selectedIndex].getAttribute('data-shipper-id');
		

        if (countryId) {
            $.ajax({
                url: '/broker/shipper-get-states/' + countryId, // Adjust route as needed
                type: 'GET',
                dataType: 'json',
                success: function (data) {
				
                    $('#shipper_state_'+shipperid).empty();
                    $('#shipper_state_'+shipperid).html(data);
                }
            });
        } else {
            $('#shipper_state').empty();
            $('#shipper_state').append('<option value="">Choose State</option>');
        }
    }
</script>
        @endforeach

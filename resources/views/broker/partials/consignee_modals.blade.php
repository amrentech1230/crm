@foreach($consignees as $consignee)
<div class="modal fade" id="editConsigneeModal_{{ $consignee->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('consignee.update', $consignee->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Consignee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name <code>*</code></label>
                            <input type="text" name="consignee_name" class="form-control"
                                value="{{ old('consignee_name', $consignee->consignee_name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Address <code>*</code></label>
                            <input type="text" name="consignee_address" class="form-control"
                                value="{{ old('consignee_address', $consignee->consignee_address) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Country <code>*</code></label>
                            <select name="consignee_country" id="consignee_country_{{ $consignee->id }}" class="form-select" required onchange="getConsigneeStates(this)">
                                <option value="">Choose Country</option>
                                @foreach($allcountry as $country)
                                    <option value="{{ $country->name }}" data-id="{{ $country->id }}" data-consignee-id="{{ $consignee->id }}"
                                        @if($country->name == $consignee->consignee_country) selected @endif>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">State <code>*</code></label>
                            <select name="consignee_state" id="consignee_state_{{ $consignee->id }}" class="form-select">
                                @foreach($state as $states)
                                    @if($states->name == $consignee->consignee_state)
                                        <option value="{{ $consignee->consignee_state }}" selected>{{ $states->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">City <code>*</code></label>
                            <input type="text" name="consignee_city" class="form-control"
                                value="{{ old('consignee_city', $consignee->consignee_city) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Zip <code>*</code></label>
                            <input type="text" name="consignee_zip" class="form-control"
                                value="{{ old('consignee_zip', $consignee->consignee_zip) }}" required>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">POC Name</label>
                            <input type="text" name="consignee_contact_name" class="form-control"
                                value="{{ old('consignee_contact_name', $consignee->consignee_contact_name) }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="consignee_contact_email" class="form-control"
                                value="{{ old('consignee_contact_email', $consignee->consignee_contact_email) }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Telephone <code>*</code></label>
                            <input type="number" name="consignee_telephone" class="form-control"
                                value="{{ old('consignee_telephone', $consignee->consignee_telephone) }}" required>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Ext.</label>
                            <input type="text" name="consignee_extn" class="form-control"
                                value="{{ old('consignee_extn', $consignee->consignee_extn) }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Fax</label>
                            <input type="text" name="consignee_fax" class="form-control"
                                value="{{ old('consignee_fax', $consignee->consignee_fax) }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Appointments</label>
                            <select name="consignee_appointments" class="form-select">
                                <option value=""
                                    {{ old('consignee_appointments', $consignee->consignee_appointments) == '' ? 'selected' : '' }}>
                                    Select</option>
                                <option value="Yes"
                                    {{ old('consignee_appointments', $consignee->consignee_appointments) == 'Yes' ? 'selected' : '' }}>
                                    Yes</option>
                                <option value="No"
                                    {{ old('consignee_appointments', $consignee->consignee_appointments) == 'No' ? 'selected' : '' }}>
                                    No</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Status <code>*</code></label>
                            <select name="consignee_status" class="form-select" required>
                                <option value="" disabled
                                    {{ old('consignee_status', $consignee->consignee_status) == '' ? 'selected' : '' }}>
                                    Select</option>
                                <option value="Active"
                                    {{ old('consignee_status', $consignee->consignee_status) == 'Active' ? 'selected' : '' }}>
                                    Active</option>
                                <option value="In-Active"
                                    {{ old('consignee_status', $consignee->consignee_status) == 'In-Active' ? 'selected' : '' }}>
                                    In-Active</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Add as shipper</label>
                            <input type="checkbox" name="same_as_shipper" id="same_as_shipper_{{ $consignee->id }}" value="1"
                                {{ old('same_as_shipper', $consignee->same_as_shipper) ? 'checked' : '' }}>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <label class="form-label">Shipping Notes</label>
                            <textarea name="consignee_shipping_notes" class="form-control"
                                style="height: 100px;">{{ old('consignee_shipping_notes', $consignee->consignee_shipping_notes) }}</textarea>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            <label class="form-label">Internal Notes</label>
                            <textarea name="consignee_internal_notes" class="form-control"
                                style="height: 100px;">{{ old('consignee_internal_notes', $consignee->consignee_internal_notes) }}</textarea>
                        </div>

                        @if(in_array(Auth::user()->role_id, [1,2,3]))
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group mb-3">
                                    <label>Assign To </label>
                                    <select class="form-control" required name="user_id" style="width: 100%;">
                                        <option value="">Select a Broker</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" data-id="{{ $user->id }}" @if($user->id == $consignee->user_id) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @else
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Consignee</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
function getConsigneeStates(selectElement) {
    let countryId = selectElement.options[selectElement.selectedIndex].getAttribute('data-id');
    let consigneeId = selectElement.options[selectElement.selectedIndex].getAttribute('data-consignee-id');

    if (countryId) {
        $.ajax({
            url: '/broker/consignee-get-states/' + countryId,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#consignee_state_' + consigneeId).empty().prop('disabled', false);
                $('#consignee_state_' + consigneeId).html(data);
            }
        });
    } else {
        $('#consignee_state_' + consigneeId)
            .empty()
            .append('<option value="">Choose State</option>');
    }
}
</script>

@foreach($consignees as $consignee)
<tr>
    <td>
        {{-- Edit button --}}
        <button class="btn btn-sm btn-info" data-bs-toggle="modal"
            data-bs-target="#editConsigneeModal_{{ $consignee->id }}">
            <i class="fas fa-edit"></i>
        </button>

        {{-- Delete form --}}
        <form action="{{ route('consignee.destroy', $consignee->id) }}" method="POST" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
    <td>{{ $consignee->consignee_name }}</td>
    <td>{{ $consignee->consignee_address }}</td>
    <td>{{ $consignee->consignee_telephone }}</td>
    <td>{{ $consignee->created_at->format('Y-m-d') }}</td>
    <td>{{ $consignee->user->name }}</td>
    <td>{{ $consignee->user->teamLeaderInfo?->tl }}</td>
    <td>{{ $consignee->user->managerInfo?->manager }}</td>
</tr>

{{-- Edit Consignee Modal --}}
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
                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Name <code>*</code></label>
                            <input type="text" name="consignee_name" class="form-control"
                                value="{{ old('consignee_name', $consignee->consignee_name) }}" required>
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <label class="form-label">Address <code>*</code></label>
                            <input type="text" name="consignee_address" class="form-control"
                                value="{{ old('consignee_address', $consignee->consignee_address) }}" required>
                        </div>

                        {{-- Country --}}
                        <div class="col-md-3">
                            <label class="form-label">Country <code>*</code></label>
                            <select name="customer_country" class="form-select" required>
                                <option value="">Choose Country</option>
                                <option value="233 United States"
                                    {{ (old('customer_country', $consignee->customer_country) == '233 United States') ? 'selected' : '' }}>
                                    United States
                                </option>
                                <option value="247 Zimbabwe"
                                    {{ (old('customer_country', $consignee->customer_country) == '247 Zimbabwe') ? 'selected' : '' }}>
                                    Zimbabwe
                                </option>
                                {{-- Add other countries here --}}
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="col-md-3">
                            <label class="form-label">State <code>*</code></label>
                            <select name="customer_state" class="form-select" required>
                                <option value="">Please Select</option>
                                <option value="1|Southern Nations, Nationalities, and Peoples' Region"
                                    {{ (old('customer_state', $consignee->customer_state) == "1|Southern Nations, Nationalities, and Peoples' Region") ? 'selected' : '' }}>
                                    Southern Nations, Nationalities, and Peoples' Region
                                </option>
                                <option value="2|Somali Region"
                                    {{ (old('customer_state', $consignee->customer_state) == "2|Somali Region") ? 'selected' : '' }}>
                                    Somali Region
                                </option>
                                <option value="5227|Loyalty Islands Province"
                                    {{ (old('customer_state', $consignee->customer_state) == "5227|Loyalty Islands Province") ? 'selected' : '' }}>
                                    Loyalty Islands Province
                                </option>
                                {{-- Add other states here --}}
                            </select>
                        </div>

                        {{-- City --}}
                        <div class="col-md-3">
                            <label class="form-label">City <code>*</code></label>
                            <input type="text" name="customer_city" class="form-control"
                                value="{{ old('customer_city', $consignee->customer_city) }}" required>
                        </div>

                        {{-- Zip --}}
                        <div class="col-md-3">
                            <label class="form-label">Zip <code>*</code></label>
                            <input type="text" name="customer_zip" class="form-control"
                                value="{{ old('customer_zip', $consignee->customer_zip) }}" required>
                        </div>

                        {{-- POC Name --}}
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">POC Name</label>
                            <input type="text" name="consignee_contact_name" class="form-control"
                                value="{{ old('consignee_contact_name', $consignee->consignee_contact_name) }}">
                        </div>

                        {{-- Contact Email --}}
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Contact Email</label>
                            <input type="email" name="consignee_contact_email" class="form-control"
                                value="{{ old('consignee_contact_email', $consignee->consignee_contact_email) }}">
                        </div>

                        {{-- Telephone --}}
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Telephone <code>*</code></label>
                            <input type="number" name="consignee_telephone" class="form-control"
                                value="{{ old('consignee_telephone', $consignee->consignee_telephone) }}" required>
                        </div>

                        {{-- Ext --}}
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Ext.</label>
                            <input type="text" name="consignee_extn" class="form-control"
                                value="{{ old('consignee_extn', $consignee->consignee_extn) }}">
                        </div>

                        {{-- Fax --}}
                        <div class="col-md-3 col-sm-6">
                            <label class="form-label">Fax</label>
                            <input type="text" name="consignee_fax" class="form-control"
                                value="{{ old('consignee_fax', $consignee->consignee_fax) }}">
                        </div>

                        {{-- Appointments --}}
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

                        {{-- Status --}}
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

                        {{-- Add as shipper (checkbox) --}}
                        <div class="col-md-3 col-sm-6 d-flex align-items-center">
                            <label class="form-label me-2 mb-0">Add as shipper</label>
                            <input type="checkbox" name="same_as_shipper" id="same_as_shipper" value="1"
                                {{ old('same_as_shipper', $consignee->same_as_shipper) ? 'checked' : '' }}>
                        </div>

                        {{-- Shipping Notes --}}
                        <div class="col-md-6 col-sm-6">
                            <label class="form-label">Shipping Notes</label>
                            <textarea name="consignee_shipping_notes" class="form-control"
                                style="height: 100px;">{{ old('consignee_shipping_notes', $consignee->consignee_shipping_notes) }}</textarea>
                        </div>

                        {{-- Internal Notes --}}
                        <div class="col-md-6 col-sm-6">
                            <label class="form-label">Internal Notes</label>
                            <textarea name="consignee_internal_notes" class="form-control"
                                style="height: 100px;">{{ old('consignee_internal_notes', $consignee->consignee_internal_notes) }}</textarea>
                        </div>
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

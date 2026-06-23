        @foreach($shipper as $shipper)
        <tr>
            <td>
                {{-- Edit button --}}
                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                    data-bs-target="#editShipperModal_{{ $shipper->id }}">
                    <i class="fas fa-edit"></i>
                </button>
                {{-- Delete form --}}
                <form action="{{ route('shipper.destroy',$shipper->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
            <td>{{ $shipper->shipper_name }}</td>
            <td>{{ $shipper->shipper_address }}</td>
            <td>{{ $shipper->shipper_telephone }}</td>
            <td>{{ $shipper->created_at->format('Y-m-d') }}</td>
            <td>{{ $shipper->user->name }}</td>
            <td>{{ $shipper->user->teamLeaderInfo?->tl }}</td>
            <td>{{ $shipper->user->managerInfo?->manager }}</td>
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
                                    <select name="customer_country" class="form-select" required>
                                        <option value="">Choose Country</option>
                                        <option value="233 United States"
                                            {{ (old('customer_country', $shipper->customer_country) == '233 United States') ? 'selected' : '' }}>
                                            United States
                                        </option>
                                        <option value="247 Zimbabwe"
                                            {{ (old('customer_country', $shipper->customer_country) == '247 Zimbabwe') ? 'selected' : '' }}>
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
                                            {{ (old('customer_state', $shipper->customer_state) == "1|Southern Nations, Nationalities, and Peoples' Region") ? 'selected' : '' }}>
                                            Southern Nations, Nationalities, and Peoples' Region
                                        </option>
                                        <option value="2|Somali Region"
                                            {{ (old('customer_state', $shipper->customer_state) == "2|Somali Region") ? 'selected' : '' }}>
                                            Somali Region
                                        </option>
                                        <option value="5227|Loyalty Islands Province"
                                            {{ (old('customer_state', $shipper->customer_state) == "5227|Loyalty Islands Province") ? 'selected' : '' }}>
                                            Loyalty Islands Province
                                        </option>
                                        {{-- Add other states here --}}
                                    </select>
                                </div>

                                {{-- City --}}
                                <div class="col-md-3">
                                    <label class="form-label">City <code>*</code></label>
                                    <input type="text" name="customer_city" class="form-control"
                                        value="{{ old('customer_city', $shipper->customer_city) }}" required>
                                </div>

                                {{-- Zip --}}
                                <div class="col-md-3">
                                    <label class="form-label">Zip <code>*</code></label>
                                    <input type="text" name="customer_zip" class="form-control"
                                        value="{{ old('customer_zip', $shipper->customer_zip) }}" required>
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
        @endforeach

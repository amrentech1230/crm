@foreach($carriers as $carrier)
<tr>
    <td>

        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
            data-bs-target="#editCarrier_{{ $carrier->id }}">
            <i class="fas fa-edit"></i>
        </button>
        <form method="POST" action="{{ route('carrier.destroy', $carrier->id) }}" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </td>
    <td>{{ $carrier->carrier_name }}</td>
    <td>{{ $carrier->carrier_mc_ff }} {{ $carrier->carrier_mc_ff_input }}</td>
    <td>{{ $carrier->carrier_dot }}</td>
    <td>{{ $carrier->carrier_address_two }} {{ $carrier->carrier_country }} {{ $carrier->carrier_city }}
        {{ $carrier->carrier_zip }}</td>
    <td>{{ $carrier->carrier_telephone }}</td>
    <td>{{ $carrier->created_at }}</td>
    <td>{{ $carrier->user->name }}</td>
    <td>{{ $carrier->user->teamLeaderInfo?->tl }}</td>
    <td>{{ $carrier->user->managerInfo?->manager }}</td>
    <td>{{ $carrier->carrier_status }}</td>
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
                            <select name="carrier_country" class="form-select" required>
                                <option value="">Choose Country</option>
                                <option value="233 United States"
                                    {{ $carrier->carrier_country == '233 United States' ? 'selected' : '' }}>United
                                    States</option>
                                <option value="39 Canada"
                                    {{ $carrier->carrier_country == '39 Canada' ? 'selected' : '' }}>Canada</option>
                            </select>
                        </div>

                        {{-- State --}}
                        <div class="col-md-4">
                            <label class="form-label">State <code>*</code></label>
                            <input type="text" name="carrier_state" class="form-control"
                                value="{{ $carrier->carrier_state }}" required>
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
@endforeach

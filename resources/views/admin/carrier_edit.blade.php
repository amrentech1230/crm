@extends('layout.compact.app')
@section('content')

<style>
    #mc-success-message {
        padding: 10px;
        background-color: rgb(212, 237, 218);
        color: rgb(21, 87, 36);
        border: 1px solid rgb(195, 230, 203);
        border-radius: 4px;
        position: fixed;
        width: 20%;
        right: 10px;
        z-index: 9999;
        top: 10px;
    }

    #mc-error-message {
        padding: 10px;
        background-color: rgb(243, 118, 129);
        color: rgb(87, 21, 26);
        border: 1px solid rgb(243, 118, 129);
        border-radius: 4px;
        position: fixed;
        width: 20%;
        right: 10px;
        z-index: 9999;
        top: 10px;
    }

    input:invalid {
        border: 2px solid red !important;
    }

    .section-title {
        font-size: 13px;
        font-weight: 700;
        color: #fff;
        background: #a6ce3a;
        padding: 6px 12px;
        border-radius: 4px;
        margin: 20px 0 12px;
    }

    .doc-thumb {
        max-width: 100px;
        max-height: 80px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin: 4px;
    }

</style>

<div id="mc-success-message" style="display:none;"></div>
<div id="mc-error-message" style="display:none;"></div>

<div class="page-content">
    <div class="container-fluid">

        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">{{ session('error') }}</div>
        @endif
        @if(session('success'))
        <div class="alert alert-success" id="success-alert">{{ session('success') }}</div>
        @endif

        {{-- Page Title --}}
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Carrier Edit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Carrier Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form method="POST" action="{{ route('carrier.update.admin', $carrier->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body text-left">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Carrier Name <code>*</code></label>
                                            <input class="form-control select2" required="" name="carrier_name"
                                                style="width: 100%;" value="{{ $carrier->carrier_name }}">

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="mr-2">
                                                M.C. #/F.F.# <code>*</code>
                                            </label>

                                            <div class="d-flex" style="width:100%;">

                                                <select class="form-control select2 mr-2" name="carrier_mc_ff"
                                                    style="width:35% !important;height:35px;" required>

                                                    <option value="FF"
                                                        {{ old('carrier_mc_ff', $carrier->carrier_mc_ff) == 'FF' ? 'selected' : '' }}>
                                                        FF
                                                    </option>

                                                    <option value="MC"
                                                        {{ old('carrier_mc_ff', $carrier->carrier_mc_ff) == 'MC' ? 'selected' : '' }}>
                                                        MC
                                                    </option>

                                                </select>

                                                <input type="text" class="form-control" name="carrier_mc_ff_input"
                                                    id="carrier_mc_ff_input"
                                                    value="{{ old('carrier_mc_ff_input', $carrier->carrier_mc_ff_input) }}"
                                                    style="width:65%;" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">
                                            <label>D.O.T</label>
                                            <input class="form-control" name="carrier_dot" style="width: 100%;"
                                                value="{{ $carrier->carrier_dot }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label>Address<code>*</code></label>
                                            <input class="form-control" required="" name="carrier_address_two"
                                                style="width: 100%;" value="{{ $carrier->carrier_address_two }}">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Country<code>*</code></label>
                                            <input class="form-control" name="carrier_country" required=""
                                                style="width: 100%;  " value="{{ $carrier->carrier_country }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>State<code>*</code></label>
                                            <div>
                                                <input class="form-control" name="carrier_state"
                                                    value="{{ $carrier->carrier_state }}" style="width: 100%;" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>City<code>*</code></label>
                                            <input class="form-control" name="carrier_city" required=""
                                                value="{{ $carrier->carrier_city }}" style="width: 100%;  ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Zip<code>*</code></label>
                                            <input class="form-control" type="text" name="carrier_zip" required=""
                                                id="carrier_zip" value="{{ $carrier->carrier_zip }}"
                                                style="width: 100%;  ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>POC Name</label>
                                            <input class="form-control" name="carrier_contact_name"
                                                value="{{ $carrier->carrier_contact_name }}" style="width: 100%; ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Email</label>
                                            <input class="form-control" name="carrier_email"
                                                value="{{ $carrier->carrier_email }}" style="width: 100%; ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Phone No<code>*</code></label>
                                            <input type="number" class="form-control" name="carrier_telephone"
                                                required="" id="carrier_telephone"
                                                value="{{ $carrier->carrier_telephone }}" style="width: 100%; ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Extn. </label>
                                            <input class="form-control" name="carrier_extn"
                                                value="{{ $carrier->carrier_extn }}" style="width: 100%; ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Fax</label>
                                            <input class="form-control" name="carrier_fax"
                                                value="{{ $carrier->carrier_fax }}" style="width: 100%; ">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Status <code>*</code></label>
                                            <div class="select2-purple">
                                                <select class="form-control select2" name="carrier_status"
                                                    style="width:100%;" required>

                                                    <option value="" disabled
                                                        {{ empty(old('carrier_status', $carrier->carrier_status)) ? 'selected' : '' }}>
                                                        Select
                                                    </option>

                                                    <option value="Active"
                                                        {{ old('carrier_status', $carrier->carrier_status) == 'Active' ? 'selected' : '' }}>
                                                        Active
                                                    </option>

                                                    <option value="In-Active"
                                                        {{ old('carrier_status', $carrier->carrier_status) == 'In-Active' ? 'selected' : '' }}>
                                                        In-Active
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Payment Terms </label>
                                            <div class="select2-purple">
                                                <div class="select2-purple">
                                                    <select class="form-control select2" name="carrier_payment_terms"
                                                        style="width:100%;">

                                                        <option value="" disabled
                                                            {{ old('carrier_payment_terms', $carrier->carrier_payment_terms ?? '') == '' ? 'selected' : '' }}>
                                                            Select Payment
                                                        </option>

                                                        <option value="Prepaid"
                                                            {{ old('carrier_payment_terms', $carrier->carrier_payment_terms ?? '') == 'Prepaid' ? 'selected' : '' }}>
                                                            Prepaid
                                                        </option>

                                                        <option value="Postpaid"
                                                            {{ old('carrier_payment_terms', $carrier->carrier_payment_terms ?? '') == 'Postpaid' ? 'selected' : '' }}>
                                                            Postpaid
                                                        </option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label>Factoring Company </label>
                                            <input class="form-control" name="carrier_factoring_company"
                                                style="width: 100%; " value="{{ $carrier->carrier_factoring_company }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label
                                                style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">Notes</label>
                                            <textarea class="form-control" name="carrier_notes"
                                                style="width: 100%; height: 70px !important">{{ $carrier->carrier_notes }}</textarea>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label style="margin-bottom: 0; font-weight: 600;color: #4a4a4a;">File
                                                Upload</label>
                                            <input type="file" class="form-control" name="carrier_file_upload[]"
                                                id="carrier_file_upload" multiple="" accept="image/*,application/pdf"
                                                style="width: 100%; height: 70px !important">
                                        </div>
                                    </div> -->

                                    <div class="mt-4 mb-4 text-center">
                                        <input type="submit" class="btn btn-info" value="Save"
                                            style="padding: 8px 40px;">
                                        <a href="{{ route('all_data') }}" class="btn btn-danger">
                                            Back
                                        </a>
                                        
                                    </div>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function () {
        $('#country').select2();
        $('#state').select2();

        $('#country').on('change', function () {
            let countryId = $(this).find('option:selected').data('id');
            if (countryId) {
                $.ajax({
                    url: '/broker/carrier-get-states/' + countryId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#state').empty().prop('disabled', false)
                            .append('<option value="">Choose State</option>')
                            .append($(data))
                            .trigger('change');
                    }
                });
            } else {
                $('#state').empty().append('<option value="">Choose State</option>');
            }
        });
    });

</script>

@endsection

@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')
<style>
    .iti {
        width: 100%;
    }

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Approval Form </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Customer</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        @if(session('error'))
        <div class="alert alert-danger" id="error-alert">
            {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="alert alert-success" id="success-alert">
            {{ session('success') }}
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">

                        <form id="customerApprovalForm" method="POST" action="{{ route('customer.approval.store') }}"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="modal-content">


                                <div class="modal-body">
                                    <div class="row g-3">
                                        @php
                                        $editableUsers = [52, 62, 90, 105, 109, 150, 174, 259];
                                        @endphp
                                        <!-- Agent Name & Agent Email (Same Row) -->
                                        <div class="col-md-6">
                                            <label class="form-label">Agent Name</label>
                                            <input type="text" name="agent_name" class="form-control"
                                                value="{{ Auth::user()->name }}"
                                                {{ !in_array(Auth::id(), $editableUsers) ? 'readonly' : '' }}>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Agent Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ Auth::user()->email }}"
                                                {{ !in_array(Auth::id(), $editableUsers) ? 'readonly' : '' }}>
                                        </div>

                                        <!-- Customer Email -->
                                        <div class="col-md-6">
                                            <label class="form-label">Customer Email <span
                                                    class="text-danger">*</span></label>
                                            <input type="email" name="customer_email" class="form-control" required>
                                        </div>

                                        <!-- Company Name -->
                                        <div class="col-md-6">
                                            <label class="form-label">Company Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="company_name" class="form-control" required>
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-12">
                                            <label class="form-label">Address <span class="text-danger">*</span></label>
                                            <input type="text" name="address" class="form-control" required>
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-3">
                                            <label class="form-label">Country <span class="text-danger">*</span></label>
                                            <input type="text" name="country" class="form-control" required>
                                        </div>

                                        <!-- State -->
                                        <div class="col-md-3">
                                            <label class="form-label">State <span class="text-danger">*</span></label>
                                            <input type="text" name="state" class="form-control" required>
                                        </div>

                                        <!-- City -->
                                        <div class="col-md-3">
                                            <label class="form-label">City <span class="text-danger">*</span></label>
                                            <input type="text" name="city" class="form-control" required>
                                        </div>

                                        <!-- Zip Code -->
                                        <div class="col-md-3">
                                            <label class="form-label">Zip Code <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="zip_code" class="form-control" required>
                                        </div>

                                        <!-- Dispatcher First Name -->
                                        <div class="col-md-6">
                                            <label class="form-label">Dispatcher First Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="dispatcher_first_name" class="form-control"
                                                required>
                                        </div>

                                        <!-- Dispatcher Last Name -->
                                        <div class="col-md-6">
                                            <label class="form-label">Dispatcher Last Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="dispatcher_last_name" class="form-control"
                                                required>
                                        </div>

                                        <!-- Phone Number -->
                                        <div class="col-md-6">
                                            <label class="form-label">
                                                Dispatcher Phone Number <span class="text-danger">*</span>
                                            </label>

                                            <input type="tel" id="phone" name="phone_number" class="form-control"
                                                required>
                                        </div>

                                        <!-- Requested Credit Limit -->
                                        <div class="col-md-6">
                                            <label class="form-label">Requested Credit Limit <span
                                                    class="text-danger">*</span></label>
                                            <input type="number" name="requested_credit_limit" class="form-control"
                                                required>
                                        </div>

                                    </div>
                                </div>
                            </div>
                                                            <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save Customer</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                </div>
                        </form>

                    </div>
                </div>
            </div>
        </div> <!-- end col -->
    </div>
</div>




@endsection
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('#customerApprovalForm');
        const phoneInput = document.querySelector('#phone');

        if (!form || !phoneInput) {
            return;
        }

        const phone = window.intlTelInput(phoneInput, {
            initialCountry: 'us',
            separateDialCode: true,
            autoPlaceholder: 'polite',
            utilsScript: 'https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js'
        });

        form.addEventListener('submit', function (event) {
            if (!phone.isValidNumber()) {
                event.preventDefault();
                alert('Please enter a valid phone number for selected country.');
                phoneInput.focus();
            }
        });
    });
</script>

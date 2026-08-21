@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Customer Approval Form</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Customer Approval Form</li>
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
                        <h4 class="card-title">Customer Approval Form</h4>
                        <div class="table-responsive" style="max-height: 500px; overflow: auto;">
                            <table class="table table-striped table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <span>
                                    <a href="{{route('customer.approval.excel')}}">
                                        <button class="btn btn-primary waves-effect waves-light mb-3 exlbtn">Customer
                                            Approval Excel</button>
                                    </a>
                                </span>
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Agent Name</th>
                                        <th>Agent Email</th>
                                        <th>Customer Email</th>
                                        <th>Company Name</th>
                                        <th>Address</th>
                                        <th>Country</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Zip Code</th>
                                        <th>Disptacher first Name</th>
                                        <th>Disptacher Last Name</th>
                                        <th>phone Number</th>
                                        <th>Requested Credit Limit</th>
                                        <th>Added Date</th>
                                        <th>Customer Status</th>
                                        <th>Customer Assign to Agent</th>
                                        <th>Credit Doc Upload</th>
                                        <th>Credit Doc View</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach($customers as $customerApprovalFormBroker)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $customerApprovalFormBroker->agent_name }}</td>
                                        <td>{{ $customerApprovalFormBroker->agent_email }}</td>
                                        <td>{{ $customerApprovalFormBroker->customer_email }}</td>
                                        <td>{{ $customerApprovalFormBroker->company_name }}</td>
                                        <td>{{ $customerApprovalFormBroker->address }}</td>
                                        <td>{{ $customerApprovalFormBroker->country }}</td>
                                        <td>{{ $customerApprovalFormBroker->state }}</td>
                                        <td>{{ $customerApprovalFormBroker->city }}</td>
                                        <td>{{ $customerApprovalFormBroker->zip_code }}</td>
                                        <td>{{ $customerApprovalFormBroker->dispatcher_first_name }}</td>
                                        <td>{{ $customerApprovalFormBroker->dispatcher_last_name }}</td>
                                        <td>{{ $customerApprovalFormBroker->phone_number }}</td>
                                        <td>{{ $customerApprovalFormBroker->requested_credit_limit }}</td>
@php
    $createdAtNY = $customerApprovalFormBroker->created_at
        ? $customerApprovalFormBroker->created_at->timezone('America/New_York')
        : null;

    $isToday = $createdAtNY
        ? $createdAtNY->isToday()
        : false;
@endphp

<td>
    @if($createdAtNY)
        <span
            style="
                {{ $isToday
                    ? 'background:#d4edda; color:#155724; padding:5px 10px; border-radius:5px; font-weight:600;'
                    : ''
                }}
            "
        >
            {{ $createdAtNY->format('m-d-Y h:i A') }}
        </span>
    @else
        -
    @endif
</td>
                                        <td>
                                            <select class="status-dropdown form-control"
                                                data-id="{{ $customerApprovalFormBroker->id }}">

                                                <option value=""
                                                    {{ empty($customerApprovalFormBroker->status) ? 'selected' : '' }}>
                                                    Please Select
                                                </option>

                                                <option value="Open"
                                                    {{ $customerApprovalFormBroker->status == 'Open' ? 'selected' : '' }}>
                                                    Open
                                                </option>

                                                <option value="Locked"
                                                    {{ $customerApprovalFormBroker->status == 'Locked' ? 'selected' : '' }}>
                                                    Locked
                                                </option>

                                        

                                            </select>
                                        </td>
                                    <td>
                                        @if($customerApprovalFormBroker->duplicate == 'Yes')
                                            <input type="checkbox" checked disabled>
                                            <span style="color:green; font-size:12px;">Assigned</span>
                                        @else
                                            <input type="checkbox" class="assign-agent" data-id="{{ $customerApprovalFormBroker->id }}">
                                        @endif
                                    </td>

                                        <td><input type="file" name="credit_doc_upload[]"
                                                class="form-control credit-doc-upload"
                                                data-id="{{ $customerApprovalFormBroker->id }}" multiple></td>
                                        <td>
                                            @if($customerApprovalFormBroker->credit_doc_upload)
                                            <button type="button" class="btn btn-primary view-files-btn"
                                                data-id="{{ $customerApprovalFormBroker->id }}">View Files</button>
                                            @else
                                            <span class="text-muted">No files uploaded</span>
                                            @endif
                                        </td>

                                        <div class="modal fade" id="filesModal" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Uploaded Credit Documents</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div id="filesContent" class="text-center text-muted">
                                                            Loading...
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div>
</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {

        document.querySelectorAll('.credit-doc-upload').forEach(input => {

            input.addEventListener('change', function () {

                const formId = this.dataset.id;
                const files = this.files;

                if (!files.length) return;

                let formData = new FormData();

                for (let i = 0; i < files.length; i++) {
                    formData.append('credit_doc_upload[]', files[i]);
                }

                fetch(`/account/credit-application/upload/${formId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Documents uploaded successfully');
                            location.reload();
                        } else {
                            alert('Upload failed');
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        // alert('Something went wrong!');
                    });

            });

        });

    });
</script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).on('click', '.view-files-btn', function () {

        let id = $(this).data('id');

        // Bootstrap 5 modal
        let modal = new bootstrap.Modal(document.getElementById('filesModal'));
        modal.show();

        $('#filesContent').html('<p class="text-center">Loading files...</p>');

        $.ajax({
            url: "{{ route('get.files.customer.approval.docs') }}",
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function (response) {

                if (!response.files || response.files.length === 0) {
                    $('#filesContent').html(
                        '<p class="text-center text-muted">No files uploaded.</p>'
                    );
                    return;
                }

                let table = `
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

                $.each(response.files, function (index, file) {
                    table += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${file.name}</td>
                        <td>
                            <a href="${file.url}" target="_blank"
                               class="btn btn-sm btn-success">
                                View
                            </a>
                            <a href="${file.url}" download
                               class="btn btn-sm btn-secondary">
                                Download
                            </a>
                        </td>
                    </tr>
                `;
                });

                table += `</tbody></table>`;

                $('#filesContent').html(table);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                $('#filesContent').html(
                    '<p class="text-danger text-center">Something went wrong.</p>'
                );
            }
        });
    });
</script>

<script>
    $(document).on('change', '.status-dropdown', function () {
        let status = $(this).val();
        let id = $(this).data('id');

        $.ajax({
            url: '{{ route("customerApproval.updateStatus") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function (response) {
                alert('Status updated successfully');
            },
            error: function () {
                alert('Something went wrong');
            }
        });
    });
</script>

<script>
$(document).on('change', '.assign-agent', function () {
    let checkbox = $(this);
    let id = checkbox.data('id');

    if (checkbox.is(':checked')) {
        $.ajax({
            url: "{{ route('assign.customer') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                id: id
            },
            success: function (response) {
                alert('Customer Created Successfully');
                location.reload();

                // ✅ disable checkbox after success
                checkbox.prop('disabled', true);
            },
            error: function (xhr) {
                alert(xhr.responseJSON?.error || 'Something went wrong');

                // ❌ uncheck if failed
                checkbox.prop('checked', false);
            }
        });
    }
});
</script>
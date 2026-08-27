@extends('layout.compact.app')

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">IP Configuration</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">IP Configuration</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts -->
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

        <!-- IP Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Allowed IPs</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary btn-add-ip">
                                + Add IP
                            </button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap"
                            style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Sr No.</th>
                                    <th>IP Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i = 1; @endphp
                                @foreach($ipconfig as $ip)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $ip->ip_address }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="text-primary editIp"
                                            data-id="{{ $ip->id }}" data-ip="{{ $ip->ip_address }}"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('ip.config.delete', $ip->id) }}" method="POST"
                                            style="display: inline-block;"
                                            onsubmit="return confirm('Are you sure you want to delete this IP?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0"
                                                title="Delete IP">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Add IP Modal -->
<div class="modal fade" id="ipModal" tabindex="-1" role="dialog" aria-labelledby="ipModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ipModalTitle">Add IP Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="ipForm" class="row" method="POST" action="{{ route('ip.config.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <input type="hidden" id="ip_id" name="ip_id">

                    <div class="col-4 mb-4">
                        <label for="ip_address" class="form-label">IP Address</label>
                        <input type="text" id="ip_address" name="ip_address"
                            class="form-control @error('ip_address') is-invalid @enderror"
                            value="{{ old('ip_address') }}" placeholder="Enter IP address">
                        @error('ip_address')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-success" id="ipModalSubmit">Save IP</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Optional JS -->
<script>
    $('#selectAll').on('click', function () {
        $('.form-check-input').prop('checked', this.checked);
    });

</script>
<script>
    $(document).ready(function () {
        // Open Modal in Add Mode
        $('.btn-add-ip').on('click', function () {
            $('#ipForm').attr('action', "{{ route('ip.config.store') }}");
            $('#formMethod').val("POST");
            $('#ipModalTitle').text('Add IP Address');
            $('#ip_address').val('');
            $('#ip_id').val('');
            $('#ipModalSubmit').text('Save IP');
            $('#ipModal').modal('show');
        });

        // Open Modal in Edit Mode
        $('.editIp').on('click', function () {
            const ipId = $(this).data('id');
            const ip = $(this).data('ip');

            $('#ipForm').attr('action', '/ip-config-update/' + ipId); // Make sure this route exists
            $('#formMethod').val("PUT");
            $('#ipModalTitle').text('Edit IP Address');
            $('#ip_address').val(ip);
            $('#ip_id').val(ipId);
            $('#ipModalSubmit').text('Update IP');
            $('#ipModal').modal('show');
        });
    });

</script>

@endsection

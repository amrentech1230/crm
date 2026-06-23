@extends('layout.compact.app')
@section('content')

<section class="page-content">
    <div class="container-fluid">

        <div class="block-header">
            <h2>Factoring Management</h2>
        </div>

        @if(session('success'))
        <div class="alert alert-success" id="successAlert">
            {{ session('success') }}
        </div>
        @endif

        <div class="card">
            <div class="card-body">

                <form method="POST" action="{{ route('factoring.add') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4">
                            <label>Factoring Name *</label>
                            <input type="text" name="factoring_name" class="form-control" required>
                        </div>

                        <div class="col-md-3">
                            <label>Added By</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                        </div>

                        <div class="col-md-2 mt-4">
                            <button class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>

                <hr>

                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($factorings as $key => $factoring)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $factoring->factoring_name }}</td>
                            <td>{{ $factoring->user->name ?? '-' }}</td>
                            <td>{{ $factoring->created_at->format('d-m-Y') }}</td>
                            <td>

                                <button class="btn btn-sm btn-primary editFactoring" data-id="{{ $factoring->id }}"
                                    data-name="{{ $factoring->factoring_name }}">
                                    Edit
                                </button>

                                <form action="{{ route('factoring.delete',$factoring->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Delete this factoring?')">
                                        Delete
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

    {{-- EDIT MODAL --}}
    <div class="modal fade" id="editFactoringModal">
        <div class="modal-dialog">
            <form method="POST" id="editFactoringForm">
                @csrf
                @method('PUT')

                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Edit Factoring</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <label>Name</label>
                        <input type="text" name="factoring_name" id="editFactoringName" class="form-control" required>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-success">Update</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @endsection

    @section('scripts')
{{-- REQUIRED: jQuery FIRST --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- REQUIRED: Bootstrap JS --}}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{{-- DataTables --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#datatable').DataTable();
        });

        setTimeout(function () {
            $('#successAlert').fadeOut();
        }, 5000);

        $(document).on('click', '.editFactoring', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            $('#editFactoringName').val(name);
            $('#editFactoringForm').attr('action', '/factoring/update/' + id);

            $('#editFactoringModal').modal('show');
        });
    </script>
    @endsection
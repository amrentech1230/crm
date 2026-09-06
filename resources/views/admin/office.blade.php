@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Office</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Office</li>
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

                        <h4 class="card-title">Office</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">+ Add Office</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Office Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($alloffice as $office)
                                <tr>
                                    <td>{{ $office->office_name }}</td>
                                    <td>{{ $office->status }}</td>
                                    <td><span type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#editoffice_{{$office->id}}">
                                            <i class="fas fa-edit"></i>
                                        </span>

                                        <form action="{{ route('delete_office', $office->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; color: red;" onclick="return confirm('Are you sure you want to delete this office?');">
                                                <i class="fas fa-trash"></i> <!-- Trash icon -->
                                            </button>
                                        </form>


                                    </td>
                                </tr>

                                <!-- sample modal content -->
                                <div id="editoffice_{{$office->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">EditOffice</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="addOfficeForm" class="row" action="{{ route('update_office', $office->id) }}" method="POST" novalidate="novalidate">
                                                    @csrf
                                                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                                                        <label class="form-label" for="office_name">Office</label>
                                                        <input type="text" id="office_name" name="office_name" class="form-control" placeholder="Office Name" value="{{ $office->office_name }}">
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Office</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                                @endforeach
                            </tbody>
                        </table>
						<div class="custom-pagination"> 
							{{$alloffice->links('pagination::bootstrap-5')}}
						</div>
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Office</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="addOfficeForm" class="row" action="{{ route('store_office') }}" method="POST" novalidate="novalidate">
                    @csrf

                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="office_name">Office</label>
                        <input type="text" id="office_name" name="office_name" class="form-control" placeholder="Office Name">
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Office</button>
                    </div>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection
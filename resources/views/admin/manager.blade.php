@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">
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
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manger</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Manger</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title">Manger</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">+ Add Manger</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Manager Name</th>
                                    <th>Office</th>
                                    <th>Department</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $manager)
                                <tr>
                                    <td>{{ $manager->manager_name }}</td> <!-- Manager's Name -->
                                    <td>{{ $manager->office_name }}</td> <!-- Office Name -->
                                    <td>{{ $manager->department_name }}</td> <!-- Department Name -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
						<div class="custom-pagination"> 
							{{$managers->links()}}
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
                <h5 class="modal-title" id="myModalLabel">Manger</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addOfficeForm" class="row" action="{{ route('store_manager') }}" method="POST">
                    @csrf <!-- Add CSRF token for security -->

                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalOfficeName">Office</label>
                        <select id="modalOfficeName" name="modalOfficeName" class="form-control">
                            <option value="">Select Office</option>
                            @foreach($alloffice as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modaldepartmentName">Department</label>
                        <select id="modaldepartmentName" name="modaldepartmentName" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($alldepartment as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalmangerName">Select User as Manager</label>
                        <select id="modalmangerName" name="modalmangerName" class="form-control">
                            <option value="">Select User as Manager</option>
                            @foreach($alluser as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Manager</button>
                    </div>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->


@endsection
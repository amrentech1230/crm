@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Department</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Department</li>
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

                        <h4 class="card-title">Department</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">+ Add Department</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Department Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach($alldepartment as $department)
                                <tr>
                                    <td>{{$department->department_name}}</td>
                                    <td>{{$department->status}}</td>
                                    <td>
                                        <span type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#editDepartment_{{$department->id}}"><i class="fas fa-edit"></i></span>

                                        <form action="{{ route('delete_department', $department->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this department?');">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>

                                <div id="editDepartment_{{$department->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Edit Department</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">

                                                <form id="addDepartmentForm" method="post" action="{{ route('update_department', $department->id) }}" class="row">
                                                    @csrf
                                                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                                                        <label class="form-label" for="department_name">Department</label>
                                                        <input type="text" id="department_name" name="department_name" class="form-control" placeholder="Department Name" value="{{$department->department_name}}">
                                                        @if ($errors->has('department_name'))
                                                        <span class="text-danger">{{ $errors->first('department_name') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="col-12 text-center">
                                                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Update Department</button>
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
							{{$alldepartment->links()}}
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
                <h5 class="modal-title" id="myModalLabel">Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="addDepartmentForm" class="row" action="{{route('store_department')}}" method="Post" novalidate="novalidate">
                    @csrf
                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalDepartmentName">Department</label>
                        <input type="text" id="department_name" name="department_name" class="form-control" placeholder="Department Name" value="">
                        @if ($errors->has('department_name'))
                        <span class="text-danger">{{ $errors->first('department_name') }}</span>
                        @endif
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Department</button>
                    </div>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection
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
                    <h4 class="mb-sm-0">Team Leader</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Team Leader</li>
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

                        <h4 class="card-title">Team Leader</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#myModal">+ Add Team Leader</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Manager</th>
                                    <th>Office</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($teamleaders as $teamleader)
                                <tr>
                                    <td>{{ $teamleader->leader_name }}</td> <!-- Team Leader's Name -->
                                    <td>{{ $teamleader->department_name }}</td> <!-- Department Name -->
                                    <td>{{ $teamleader->manager_name }}</td> <!-- Manager Name -->
                                    <td>{{ $teamleader->office_name }}</td> <!-- Office Name -->
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
						<div class="custom-pagination"> 
							{{$teamleaders->links()}}
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
                <h5 class="modal-title" id="myModalLabel">Team Leader</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form id="addOfficeForm" action="{{ route('store_teamleader') }}" method="POST" class="row" novalidate>
                    @csrf
                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalOfficeName">Office</label>
                        <select id="modalOfficeName" name="modalOfficeName" class="form-control">
                            <option>Select Office</option>
                            @foreach ($alloffice as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option> <!-- Office Name -->
                            @endforeach
                        </select>
                    </div>


                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalOfficeName">Department</label>
                        <select id="modaldepartmentName" name="modaldepartmentName" class="form-control">
                            <option>Select Department</option>
                            @foreach ($alldepartment as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name }}</option> <!-- Department Name -->
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
                        <label class="form-label" for="modalOfficeName">Select Manager</label>
                        <select id="modalmangerName" name="modalmangerName" class="form-control">
                            <option>Select Manager</option>
                            @foreach ($allmanager as $manager)
                            <option value="{{ $manager->id }}">{{ $manager->manager }}</option> <!-- Manager Name -->
                            @endforeach
                        </select>
                    </div>
<div class="col-12 form-control-validation mb-4 fv-plugins-icon-container">
    <label class="form-label" for="modalleaderName">Select User as Team Leader</label>
    <select id="modalleaderName" name="modalleaderName" class="form-control">
        <option value="">Select User as Team Leader</option>
        @foreach ($alluser as $user)
            <option value="{{ $user->name }}" data-email="{{ $user->email }}">
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>


                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-4 me-1">Create Team Leader</button>
                    </div>
                </form>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection


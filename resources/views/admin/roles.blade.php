@extends('layout.compact.app')
<!-- This links to the app.blade.php layout -->

@section('content')

<div class="page-content">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Roles</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                            <li class="breadcrumb-item active">Roles</li>
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

                        <h4 class="card-title">Roles</h4>

                        <div class="my-4">
                            <button type="button" class="btn btn-primary waves-effect waves-light"
                                data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">+ Add Role</button>
                        </div>

                        <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" 
                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Department</th>
                                    <th>Type</th>
                                    <th>Parent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->name}}</td>
                                    <td>{{ $role['department']->department_name }}</td>
                                    <td>
                                        @if($role->type == 1)
                                        Admin
                                        @elseif($role->type == 2)
                                        Manager
                                        @elseif($role->type == 3)
                                        Team leader
                                        @endif
                                    </td>
                                    <td>{{$role->parentUser ? $role->parentUser->name : 'No parent user'}}</td>
                                    <td><a href="{{ route('role_edit', $role->id)}}"><i class="fas fa-edit"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
						
                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->



    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->


<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Role And Set Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm" class="row g-6" action="{{ route('role_create') }}" method="POST"
                    novalidate="novalidate">
                    @csrf
                    <div class="col-6 mb-3">
                        <label class="form-label" for="department">Department</label>
                        <select id="department" name="department" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="type">Type</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">Team leader</option>
                            <option value="4">User</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="name">Role Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name"
                            tabindex="-1">
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label" for="parent_role">Parent Role</label>
                        <select id="parent_role" name="parent_role" class="form-control">
                            <option value="">Select Parent Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name. ' '}} @if($role->type == 1)
                                (Admin)
                                @elseif($role->type == 2)
                                (Manager)
                                @elseif($role->type == 3)
                                (Team leader)
                                @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <h5 class="mb-6">Role Permissions</h5>
                        <!-- Permission table -->
                        <div class="table-responsive" style="height: 50vh;">
                            <table class="table table-flush-spacing mb-0 border-top">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap"> Access <i class="icon-base bx bx-info-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                aria-label="Allows a full access to the system"
                                                data-bs-original-title="Allows a full access to the system"></i></td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td class="text-nowrap fw-medium text-heading">{{$permission->name}}</td>
                                        <td>
                                            <input class="form-check-input" name="permission_menu[]" type="hidden"
                                                value="{{ $permission->id }}" id="userManagementRead">
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0 me-4 me-lg-12">
                                                    <input class="form-check-input" name="read_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementRead">
                                                    <label class="form-check-label" for="userManagementRead"> Read
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0 me-4 me-lg-12">
                                                    <input class="form-check-input" name="write_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementWrite">
                                                    <label class="form-check-label" for="userManagementWrite"> Write
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" name="create_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementCreate">
                                                    <label class="form-check-label" for="userManagementCreate"> Create
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                    <input type="hidden">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!--  Modal content for the above example -->
<div class="modaledit fade bs-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Add Role And Set Permissions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRoleForm" class="row g-6" action="{{ route('role_create') }}" method="POST"
                    novalidate="novalidate">
                    @csrf
                    <div class="col-6 mb-3">
                        <label class="form-label" for="department">Department</label>
                        <select id="department" name="department" class="form-control">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->department_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="type">Type</label>
                        <select id="type" name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Admin</option>
                            <option value="2">Manager</option>
                            <option value="3">Team leader</option>
                            <option value="4">User</option>
                        </select>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="form-label" for="name">Role Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name"
                            tabindex="-1">
                    </div>

                    <div class="col-6 mb-3">
                        <label class="form-label" for="parent_role">Parent Role</label>
                        <select id="parent_role" name="parent_role" class="form-control">
                            <option value="">Select Parent Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name. ' '}} @if($role->type == 1)
                                (Admin)
                                @elseif($role->type == 2)
                                (Manager)
                                @elseif($role->type == 3)
                                (Team leader)
                                @endif</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <h5 class="mb-6">Role Permissions</h5>
                        <!-- Permission table -->
                        <div class="table-responsive" style="height: 50vh;">
                            <table class="table table-flush-spacing mb-0 border-top">
                                <tbody>
                                    <tr>
                                        <td class="text-nowrap"> Access <i class="icon-base bx bx-info-circle"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                aria-label="Allows a full access to the system"
                                                data-bs-original-title="Allows a full access to the system"></i></td>
                                        <td>
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @foreach($permissions as $permission)
                                    <tr>
                                        <td class="text-nowrap fw-medium text-heading">{{$permission->name}}</td>
                                        <td>
                                            <input class="form-check-input" name="permission_menu[]" type="hidden"
                                                value="{{ $permission->id }}" id="userManagementRead">
                                            <div class="d-flex justify-content-end">
                                                <div class="form-check mb-0 me-4 me-lg-12">
                                                    <input class="form-check-input" name="read_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementRead">
                                                    <label class="form-check-label" for="userManagementRead"> Read
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0 me-4 me-lg-12">
                                                    <input class="form-check-input" name="write_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementWrite">
                                                    <label class="form-check-label" for="userManagementWrite"> Write
                                                    </label>
                                                </div>
                                                <div class="form-check mb-0">
                                                    <input class="form-check-input" name="create_{{ $permission->id }}"
                                                        type="checkbox" id="userManagementCreate">
                                                    <label class="form-check-label" for="userManagementCreate"> Create
                                                    </label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Permission table -->
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                            aria-label="Close">Cancel</button>
                    </div>
                    <input type="hidden">
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    $('#selectAll').on('click', function () {
        $('.form-check-input').prop('checked', true);;
    })

</script>
@endsection

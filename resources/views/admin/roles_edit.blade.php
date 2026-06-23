@extends('layout.compact.app') <!-- This links to the app.blade.php layout -->

@section('content')
   
<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0">Edit Role</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CCI</a></li>
                                            <li class="breadcrumb-item active">Edit Role</li>
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
                        <div class="card">
                            <div class="card-body">
                                <form id="addRoleForm" class="row g-6" action="{{ route('role_update', $roledata->id) }}" method="POST" novalidate="novalidate">
                                    @csrf
                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="department">Department</label>
                                        <select id="department" name="department" class="form-control">
                                            <option value="">Select Department</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" @if($roledata->department_id == $department->id) selected @endif>{{ $department->department_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="type">Type</label>
                                        <select id="type" name="type" class="form-control">
                                            <option value="">Select Type</option>
                                            <option value="1" @if($roledata->type == 1) selected @endif>Admin</option>
                                            <option value="2" @if($roledata->type == 2) selected @endif>Manager</option>
                                            <option value="3" @if($roledata->type == 3) selected @endif>Team leader</option> 
                                            <option value="4" @if($roledata->type == 4) selected @endif>User</option> 
                                        </select>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="name">Role Name</label>
                                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name" tabindex="-1" value="{{$roledata->name}}">
                                    </div>

                                    <div class="col-6 mb-3">
                                        <label class="form-label" for="parent_role">Parent Role</label>
                                        <select id="parent_role" name="parent_role" class="form-control">
                                            <option value="">Select Parent Role</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" @if($roledata->parent_role == $role->id) selected @endif>{{ $role->name. ' '}} @if($role->type == 1)
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
                                                <td class="text-nowrap"> Access <i class="icon-base bx bx-info-circle" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Allows a full access to the system" data-bs-original-title="Allows a full access to the system"></i></td>
                                                <td>
                                                <div class="d-flex justify-content-end">
                                                    <div class="form-check mb-0">
                                                    <input class="form-check-input" type="checkbox" id="selectAll">
                                                    <label class="form-check-label" for="selectAll"> Select All </label>
                                                    </div>
                                                </div>
                                                </td>
                                            </tr>
                                                    @php
                                                        $permissionsMap = collect($assignedPermissions)->keyBy('permission_id');
                                                    @endphp

                                                    @foreach($permissions as $permission)
                                                        @php
                                                            $perm = $permissionsMap[$permission->id] ?? null;
                                                        @endphp
                                                        <tr>
                                                            <td class="text-nowrap fw-medium text-heading">{{ $permission->name }}</td>
                                                            <td>
                                                                <input class="form-check-input" name="permission_menu[]" type="hidden" value="{{ $permission->id }}">

                                                                <div class="d-flex justify-content-end">
                                                                    <div class="form-check mb-0 me-4 me-lg-12">
                                                                        <input class="form-check-input" name="read_{{ $permission->id }}" type="checkbox" id="read_{{ $permission->id }}"
                                                                            @if($perm && $perm['read']) checked @endif>
                                                                        <label class="form-check-label" for="read_{{ $permission->id }}">Read</label>
                                                                    </div>
                                                                    <div class="form-check mb-0 me-4 me-lg-12">
                                                                        <input class="form-check-input" name="write_{{ $permission->id }}" type="checkbox" id="write_{{ $permission->id }}"
                                                                            @if($perm && $perm['write']) checked @endif>
                                                                        <label class="form-check-label" for="write_{{ $permission->id }}">Write</label>
                                                                    </div>
                                                                    <div class="form-check mb-0">
                                                                        <input class="form-check-input" name="create_{{ $permission->id }}" type="checkbox" id="create_{{ $permission->id }}"
                                                                            @if($perm && $perm['create']) checked @endif>
                                                                        <label class="form-check-label" for="create_{{ $permission->id }}">Create</label>
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
                                    </div>
                                    <input type="hidden">
                                </form>
                            </div>
                        </div>
                        
                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->




                



<script>
$('#selectAll').on('click', function(){
    $('.form-check-input').prop('checked', true);;
})
</script>
@endsection
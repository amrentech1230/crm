<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Models\Office;
use App\Models\StatusType;
use App\Models\ShipmentType;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RoleHasPermission;

class RolesController extends Controller
{
     /**
     * Display a permissions.
     */
    public function permissions()
    {
        $departments = Department::all();
        $permissions = Permission::with('department')->get();
        return view('admin.permissions', compact('departments', 'permissions'));
    }

    public function create_permissions(Request $request){
       
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            
        ]);
    
        // Create a new department with the validated input
        $Permission = new Permission();
        $Permission->name = $request->input('name');
        $Permission->department_id = strtolower($request->input('department_id'));
        // Save the new department to the database
        $Permission->save();

        $subject = "Create the permission, permissionid:-".$Permission->id;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');
    
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Permission created successfully.');
    }


     /**
     * Display a Roles.
     */
    public function roles()
    {
        $departments = Department::all();
        $permissions = Permission::with('department')->get();
        $roles = Role::with('department')->get();
        return view('admin.roles', compact('departments', 'roles', 'permissions'));
    }


    public function role_create(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required',
            
        ]);

        // Create a new department with the validated input
        $Role = new Role();
        $Role->name = $request->input('name');
        $Role->department_id = strtolower($request->input('department'));
        $Role->type = strtolower($request->input('type'));
        $Role->parent_role = strtolower($request->input('parent_role'));
        // Save the new department to the database
        $Role->save();

        $lastInsertId = $Role->id;

        foreach($request->input('permission_menu') as $menu){
            $permisionid = $menu;
            $role_id = $lastInsertId;
            $read = isset($request->input('read_'.$menu)[0]) ? 1 : 0;
            $write = isset($request->input('write_'.$menu)[0]) ? 1 : 0;
            $create = isset($request->input('create_'.$menu)[0]) ? 1 : 0;   

            $RoleHasPermission = new RoleHasPermission();
            $RoleHasPermission->permission_id = $permisionid;
            $RoleHasPermission->role_id = $role_id;
            $RoleHasPermission->read = $read ? 1 : 0;
            $RoleHasPermission->write = $write ? 1 : 0;
            $RoleHasPermission->create = $create ? 1 : 0;
            $RoleHasPermission->save();
           

        }

        $subject = "Create the Role, roleid:-".$RoleHasPermission->id;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Role created successfully.');
       
    }

    public function role_edit(Request $request, $id){

        $departments = Department::all();
        $permissions = Permission::with('department')->get();
        $roles = Role::with('department')->get();
        $assignpermission = RoleHasPermission::where('role_id', $id)->get();
        $assignedPermissions = [];
        foreach($assignpermission as $permission){
            $assignedPermissions[] = array(
                'permission_id' => $permission->permission_id,
                'read' => $permission->read ?? 0,
                'write' => $permission->write ?? 0,
                'create' => $permission->create ?? 0,
            );
        }
        $roledata = Role::with('department')->where('id', $id)->first();


        return view('admin.roles_edit', compact('departments', 'roles', 'permissions', 'assignedPermissions', 'roledata'));
    }


     public function role_update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'department' => 'required',
            
        ]);

        // Create a new department with the validated input
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->department_id = strtolower($request->input('department'));
        $role->type = strtolower($request->input('type'));
        $role->parent_role = strtolower($request->input('parent_role'));
        // Save the new department to the database
        $role->save();

        $permissions = RoleHasPermission::where('role_id', $id)->delete();


        foreach($request->input('permission_menu') as $menu){
            $permisionid = $menu;
            $role_id = $id;
            $read = isset($request->input('read_'.$menu)[0]) ? 1 : 0;
            $write = isset($request->input('write_'.$menu)[0]) ? 1 : 0;
            $create = isset($request->input('create_'.$menu)[0]) ? 1 : 0;   

            $RoleHasPermission = new RoleHasPermission();
            $RoleHasPermission->permission_id = $permisionid;
            $RoleHasPermission->role_id = $role_id;
            $RoleHasPermission->read = $read ? 1 : 0;
            $RoleHasPermission->write = $write ? 1 : 0;
            $RoleHasPermission->create = $create ? 1 : 0;
            $RoleHasPermission->save();
           

        }

        $subject = "Update the Role, roleid:-".$role_id;
        addToLog($customerId ='', $id='', $subject, $oldData ='', $newData ='');
        // Redirect back with a success message
        return redirect()->back()->with('success', 'Role Update successfully.');
       
    }
}

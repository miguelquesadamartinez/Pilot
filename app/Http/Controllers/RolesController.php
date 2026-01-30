<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Permissions;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    public function roles(){

        $roles = Roles::get();

        return view('admin.roles', compact('roles'));

    }

    public function newRol(Request $request){
        return view('admin.newrol');
    }

    public function createRol(Request $request){

        Role::create(['name' => $request->nameRol]);

        $roles = Roles::get();

        return view('admin.roles', compact('roles'));
    }

    public function viewRol(Request $request, int $id){

        $rol = Role::find($id);
        $permissions = Permission::all();

        //$permission_roles = $rol->permissions()->get();
        $permission_roles = $rol->getAllPermissions();

        $arr = array();
        foreach ($permission_roles as $key => $value){
            $arr[] = $value->name;
        }

        return view('admin.viewrol', compact('rol', 'permission_roles', 'permissions', 'arr'));
    }

    public function addRolPerm(Request $request, int $id, string $perm){

        $role = Role::find($id);
        $role->givePermissionTo($perm); 
        
        $perm_name = Permission::find($perm);

        $roles = Role::all();

        $msg = "Permission: $perm_name->name added to Role: $role->name";

        return view('admin.roles', compact('roles', 'msg'));
    }

    public function revokeRol(Request $request, int $id){
        $roles = Roles::get();
        $rol = Role::find($id);
        $usersWithRole = User::role($rol->name)->get();
        foreach ($usersWithRole as $user) {
            $user->removeRole($rol->name);
        }
        $msg = "Permission: $rol->name revoked to all users";
        return view('admin.roles', compact('roles', 'msg'));
    }

    public function viewRolUsers(Request $request, int $id){

        $role = Role::findById($id);

        $vble = User::role($role->name)->get();

        $roleName = $role->name ;

        return view('admin.roleusers', compact('vble', 'roleName'));
    }


    public function deleteRolPerm(Request $request, int $perm, int $rol){

        $role = Role::findById($rol);
        $permission = Permission::findById($perm);

        $roles = Role::all();

        $role->revokePermissionTo($permission->name);

        $msg = "Permission: $permission->name romoved from Rol: $role->name";

        return view('admin.roles', compact('roles', 'msg'));
    }

}

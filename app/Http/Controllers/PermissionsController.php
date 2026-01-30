<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use App\Models\Permissions;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsController extends Controller
{

    public function permissionsTable(){

        $data['roles'] = Role::get();
        $data['permissions'] = Permission::get();
        $data['permissionRole'] = Roles::getRolePermissions();

        return view('admin.app-users-permission')->with($data);
    }

    public function savePermission(Request $request)
    {
        Roles::rolesHasPermissionTruncate();

        //Role::findByName('DocumentsActive')->delete();
        //Permission::findByName('Manage')->delete();

        //return redirect()->back();

        $input = $request->all();
        $permissions = Arr::get($input, 'permission');

        //$this->array_get($input, 'permission');
        if ($permissions != '') {
            foreach ($permissions as $r_key => $permission) {
                foreach ($permission as $p_key => $per) {
                    $values[] = $p_key;
                }

                if (count($values)) {
                    for ($i = 0; $i < count($values); $i++) {
                        Roles::create($values[$i], $r_key);
                    }
                }
                unset($values);
            }
        }
        app()->make(PermissionRegistrar::class)->forgetCachedPermissions();
        return redirect()->back()->with(['toast-message' => trans('setting.permissions_updated_successfully'), 'toast-color' => 'toast-green']);
    }

    public function permissions(){

        $permissions = Permissions::get();

        return view('admin.permissions', compact('permissions'));
    }

    public function newPermission(Request $request){

        return view('admin.newpermission');
    }

    public function createPermission(Request $request){

        Permission::create(['name' => $request->namePermission]);

        $permissions = Permissions::get();

        $msg = "Permission $request->namePermission created";

        return view('admin.permissions', compact('permissions', 'msg'));
    }

    public function viewPermission(Request $request, int $id){

        $permission = Permissions::find($id)->get();

        return view('admin.viewrol', compact('permission'));
    }

    public function deletePermission(Request $request, int $id, string $perm){

        $permissions = Permissions::get();

        foreach (Role::all() as $key => $value) {
            $value->revokePermissionTo($perm);   
        }

        $roles = Role::all();

        $msg = "Permission: $perm revoked to all users";

        return view('admin.permissions', compact('permissions', 'msg'));
    }

    public function viewPermRoles(Request $request, int $id){

        $perm = Permission::findById($id);

        $vble = Permission::whereName($perm->name)->first()->roles;

        $permName = $perm->name;

        return view('admin.rolespermission', compact('vble', 'permName'));
    }
}

<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasFactory;

    public static function getRolePermissions()
    {
        return DB::table('role_has_permissions')
        ->select(DB::raw("CONCAT(role_id,'-',permission_id) AS detail"))
        ->pluck('detail')->toArray();
    }

    public static function rolesHasPermissionTruncate()
    {
        DB::table('role_has_permissions')->truncate();
    }

    public static function create($permission_id,$role_id) {

        $role = DB::table('role_has_permissions')
        ->where('permission_id', $permission_id)
        ->where('role_id', $role_id)
        ->get();

        if ( ! count($role) ) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $permission_id,
                'role_id' => $role_id
            ]);
        }
    }
}

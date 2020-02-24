<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RoleController extends Controller
{
    /**
     * Retrieve all the Roles.
     * @return Response
     */
    public function getAll() {
        return response()->json(Role::all(), 200);
    }

    /**
     * Create a Role.
     * @param string name
     * @return Response
     */
    public function create(Request $req) {
        $role = new Role();
        $role->name = $req->input('name');
        if ($role->save()) {
            return response()->json($role, 201);
        } else {
            return response()->json($role, 400);
        }
    }

    /**
     * Add a Permission to a Role.
     * @param int role_id
     * @param int permission_id
     * @return Response
     */
    public function givePermission(Request $req) {
        $role = Role::find($req->input('role_id'));
        if ($role) {
            $permission = Permission::find($req->input('permission_id'));
            if ($permission) {
                if ($role->givePermissionTo($permission)) {
                    return response()->json(['message' => "Permission $permission->name granted to Role $role->name"], 201);
                } else {
                    return response()->json(['error' => 'Permission couldnt be stablish to role'], 400);
                    # code...
                }
            } else {
                return response()->json(['error' => 'Permission do not exist, id:' . $req->input('permission_id')], 404);
            }
        } else {
            return response()->json(['error' => 'Role do not exist, id:' . $req->input('role_id')], 404);
        }
    }

    /**
     * Add a Permission to a Role.
     * @param int role_id
     * @param int permission_id
     * @return Response
     */
    public function revokePermission(Request $req) {
        $permission = Permission::find($req->input('permission_id'));
        if ($permission) {
            $role = Role::find($req->input('role_id'));
            if ($role) {
                if ($role->revokePermissionTo($permission)) {
                    return response()->json(['message' => "Permission $permission->name revoked from Role $role->name"], 201);
                } else {
                    return response()->json(['error' => 'Permission couldnt be revoked from role'], 400);
                    # code...
                }
            } else {
                return response()->json(['error' => 'Role do not exist, id:' . $req->input('role_id')], 404);
            }
        } else {
            return response()->json(['error' => 'Permission do not exist, id:' . $req->input('permission_id')], 404);
        }
    }
}

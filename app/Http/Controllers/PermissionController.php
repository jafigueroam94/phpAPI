<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Retrieve all the Permissions.
     * @return Response
     */
    public function getAll() {
        return response()->json(Permission::all(), 200);
    }

    /**
     * Create a Permission.
     * @param string name
     * @return Response
     */
    public function create(Request $req) {
        $permission = new Permission();
        $permission->name = $req->input('name');
        $permission->guard_name = 'api';
        if ($permission->save()) {
            return response()->json($permission, 201);
        } else {
            return response()->json($permission, 400);
        }
    }
}

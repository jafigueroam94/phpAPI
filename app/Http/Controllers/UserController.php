<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Retrieve all the users.
     * @return Response
     */
    public function getAll() {
        return response()->json(User::all(), 200);
    }

    /**
     * Create a user.
     * @param string name
     * @param string email
     * @param string user
     * @param string password
     * @return Response
     */
    public function create(Request $req) {
        $user = new User();
        $user->name = $req->input('name');
        $user->email = $req->input('email');
        $user->user = $req->input('user');
        $user->password = md5($req->input('password'));
        if ($user->save()) {
            return response()->json($user, 201);
        } else {
            return response()->json($user, 400);
        }
    }

    /**
     * Update a user by id.
     * @param int id
     * @param string email
     * @param string name
     * @return Response
     */
    public function update(Request $req) {
        $user = User::where('id', '=', $req->input('id'))->first();
        if ($user) {
            if ($req->input('name')) {
                $user->name = $req->input('name');
            }
            if ($req->input('email')) {
                $user->email = $req->input('email');
            }
            if ($user->save()) {
                return response()->json($user, 200);
            } else {
                return response()->json(['error' => 'Error al acualizar el registro'], 400);
            }
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 400);
        }
    }

    /**
     * Delete a user by id.
     * @param int id
     * @return Response
     */
    public function delete(Request $req) {
        $user = User::where('id', '=', $req->input('id'))->first();
        if ($user) {
            if ($user->delete()) {
                return response()->json($user, 200);
            } else {
                return response()->json(['error' => 'Error al acualizar el registro'], 400);
            }
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    /**
     * Assign a role to a user.
     * @param int id
     * @param int role_id
     * @return Response
     */
    public function assignRole(Request $req) {
        $user = User::where('id', '=', $req->input('id'))->first();
        if ($user) {
            $role = Role::where('id', '=', $req->input('role_id'))->first();
            if ($role) {
                if ($user->assignRole($role)) {
                    return response()->json(['message' => 'Role assign succesfully to User'], 200);
                } else {
                    return response()->json(['error' => 'Role couldnt be assign to user'], 400);
                }
            } else {
                return response()->json(['error' => 'Role do not exist'], 404);
            }
        } else {
            return response()->json(['error' => 'User do not exist'], 404);
        }
    }

    /**
     * Assign a role to a user.
     * @param int id
     * @param int role_id
     * @return Response
     */
    public function revokeRole(Request $req) {
        $user = User::where('id', '=', $req->input('id'))->first();
        if ($user) {
            $role = Role::where('id', '=', $req->input('role_id'))->first();
            if ($role) {
                if ($user->removeRole($role)) {
                    return response()->json(['message' => 'Role revoked succesfully from User'], 200);
                } else {
                    return response()->json(['error' => 'Role couldnt be revoked from user']);
                }
            } else {
                return response()->json(['error' => 'Role do not exist'], 404);
            }
        } else {
            return response()->json(['error' => 'User do not exist'], 404);
        }
    }

    /**
     * User has permission.
     * @param int id
     * @return Response
     */
    public function getPermissions(Request $req) {
        $user = User::where('id', '=', $req->input('id'))->first();
        if ($user) {
            $response = $user->hasPermissionTo('create_user');
            return response()->json(['data' => $response], 200);
        } else {
            return response()->json(['error' => 'User do not exist'], 404);
        }

    }
}

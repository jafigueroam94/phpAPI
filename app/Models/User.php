<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\DB;


/**
 * @property string name
 * @property string email
 * @property string user
 * @property string password
 */
class User extends Model
{
    //
    use HasRoles;

    protected $guarded = ['id'];
    protected $guard_name = 'api';

    public function hasPermissionTo($permission){
        $model_has_role = DB::table('model_has_roles')
        ->select('role_id')
        ->where('model_id', $this->id)
        ->first();
        $role = Role::find($model_has_role->role_id);
        return $role->hasPermissionTo($permission);
    }
}

?>

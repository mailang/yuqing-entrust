<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustRole;

class Roles extends EntrustRole
{
    protected $table = "roles";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name', 'display_name','description',
    ];
    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permissions', 'permission_role', 'roles_id', 'permissions_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\Admins', 'role_user', 'role_id', 'user_id');
    }
}

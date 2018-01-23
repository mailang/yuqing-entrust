<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
class Permissions extends EntrustPermission
{
    //
    protected $table="permissions";
    protected $fillable=['name','display_name','link','icon','pid'];
}

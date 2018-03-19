<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    protected  $table="court";
    protected  $fillable=[
        'name',
        'nick',
        'province'
    ];
}

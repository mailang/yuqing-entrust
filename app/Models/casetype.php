<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class casetype extends Model
{
    protected  $table="casetype";
    protected  $fillable=[
        'name',
        'pid'
    ];
}

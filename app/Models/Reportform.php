<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reportform extends Model
{
    protected  $table="reportform";
    protected  $fillable=[
        'title',
        'description',
        'type'
    ];
}

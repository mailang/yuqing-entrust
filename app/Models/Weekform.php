<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weekform extends Model
{
    protected $table="weekform";
    protected $fillable=['title','description','starttime','endtime'];
}

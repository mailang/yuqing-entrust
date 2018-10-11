<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    /*type:0:微博：1：公众号*/
    protected  $table='reading';
    protected  $fillable=[
        'reportform_id',
        'concern_num',
        'article_num',
        'reader_num',
        'type'
    ];}

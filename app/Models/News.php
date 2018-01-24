<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{

    protected  $table="news";
    protected  $fillable=[
        'id',
        'title',
        'content',
        'author',
        'orientation',
        'firstwebsit',
        'sitetype',
        'link',
        'uuid',
        'keywords',
        'subject',
        'transmit',
        'starttime'
    ];
}

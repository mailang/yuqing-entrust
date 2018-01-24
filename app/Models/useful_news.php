<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class useful_news extends Model
{
    protected  $table="useful_news";
    protected  $fillable=[
        'admin_id',
        'title',
        'content',
        'author',
        'attribute',
        'firstwebsit',
        'sitetype',
        'link',
        'uuid',
        'keywords',
        'transmit',
        'tag',
        'court',
        'address_id',
        'abstract',
        'starttime',
        'visitnum',
        'replynum',
        'orientation',
        'ispush',
        'yuqinginfo',
        'screen',
        'subject_id',
        'reportform_id',
        'casetype_id',
    ];
}

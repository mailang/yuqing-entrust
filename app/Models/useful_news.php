<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Useful_news extends Model
{
    protected  $table="useful_news";
    protected  $fillable=[
        'admin_id',
        'title',
        'content',
        'author',
        'firstwebsit',
        'sitetype',
        'link',
        'uuid',
        'keywords',
        'transmit',
        'tag',
        'court',
        'areacode',
        'abstract',
        'starttime',
        'visitnum',
        'replynum',
        'orientation',
        'ispush',
        'yuqinginfo',
        'screen',
        'md5',
        'oldsubject',
        'subject_id',
        'reportform_id',
        'casetype_id',
    ];
}

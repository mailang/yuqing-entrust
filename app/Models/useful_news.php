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
        'verify_option',
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
        'isrepeats',
        'oldsubject',
        'subject_id',
        'reportform_id',
        'casetype_id',
    ];

    public function hasOneCourt()
    {
        return $this->hasOne('Court', 'user_id', 'id');
    }
}

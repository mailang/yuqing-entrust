<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use  App\Models\Useful_news;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    function  getjson()
    {
        $data=Useful_news::where('ispush',1)->whereNotNull('weekform_id')->limit(2)->get([
            'id',
            'title',
            'content',
            'author',
            'firstwebsite',
            'sitetype',
            'link',
            'keywords',
            'transmit',
            'court',
            'abstract',
            'starttime',
            'visitnum',
            'replynum',
            'orientation',
            'yuqinginfo',
        ]);
        $json=\GuzzleHttp\json_encode($data);
        return $json;
    }
}

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

    function push(){
        $data = $this->getjson();

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, 'http://112.74.109.207:7500/sentimentPush');
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, true);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, true);
        //设置post数据
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行命令
        $out = curl_exec($curl);
        //关闭URL请求
        curl_close($out);
        //显示获得的数据
        print_r($out);
    }

    function  getjson()
    {
        $data=Useful_news::where('ispush',1)->whereNotNull('weekform_id')->limit(1)->get([
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
        $json=json_encode($data);
        return $json;
    }
}

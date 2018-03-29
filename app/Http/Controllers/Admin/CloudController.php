<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\WordCloud;

class CloudController extends Controller
{
       /*热词首页*/
    public  function  index()
    {
          return view('admin.cloud.index');
    }

    /**
     * 返回热词的json格式
     */
    public function getjson()
    {
        $cloud = WordCloud::all()->first();
        return $cloud->words;
    }
        /*post添加热词*/
    public  function  add(Request $request)
    {
        $req = $request->all();
        $data["name"] = $req["keyword"];
        $data["value"] = $req["wordnum"];
        $color["color"]= $req["itemstyle"];
        $normal["normal"]=$color;
        $data["itemStyle"] = $normal;
        $cloud = WordCloud::all()->first();
        $words = array();
        try{
            if ($cloud) {
                //数据库中存在数据
                // $first=$cloud->first();
                $id = $cloud->id;
                $words = json_decode($cloud->words);
                array_push($words, $data);
                $cloud["words"] =json_encode($words);
                $cloud->update();
            } else
            {
                array_push($words, $data);
                $cloud["words"] =json_encode($words);
                WordCloud::create($cloud);
            } flash("操作成功");
        }
        catch (Exception $exception){redirect()->back()->withErrors("操作失败");}

        return redirect()->route('cloud.word');
    }
}

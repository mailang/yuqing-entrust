<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use  App\Models\WordCloud;
use Illuminate\Support\Facades\DB;

class CloudController extends Controller
{
       /*热词首页*/
    public  function  index()
    {
          return view('admin.cloud.index');
    }

   public  function  upload()
  {
    return view('admin.cloud.upload');
  }

     public  function  store(Request $request)
    {

        $pic=$request->file('picture');
        if ($request->hasFile('picture')) {
            $images = $request->file('picture');
            $imgdir = storage_path("cloud/");
            $extension =strtolower($images->getClientOriginalExtension());// $images->getClientOriginalName(); //4、获取上传图片的后缀名
            $exs=array('png','jpeg','jpg');
            if(in_array($extension,$exs)) {
                $newImagesName = date('Ymd') . "." . $extension;//5、重新命名上传文件名字
                $images->move($imgdir, $newImagesName);
                $ftppath = env("FTP_DIR", "");
                if ($ftppath !== "") {
                    if (file_exists($ftppath)) {
                        copy($imgdir.$newImagesName,$ftppath.$newImagesName);
                    }
                    flash("操作成功");
                }
            }
            else flash("格式不正确");
            return redirect()->back();
        }
    }

    /**
     * 返回热词的json格式
     */
    public function getjson()
    {
        $cloud=DB::table("wordcloud")->limit(1)->orderByDesc("id")->get(['id','words']);
        return $cloud[0]->words;
    }
    public  function  add(Request $request)
    {
         $req = $request->all();
         $old=explode("|",$req["old"]);
         $news=explode("|",$req["new"]);
         $words = array();
         foreach ($old as $items)
        {
            if ($items!="")
            {
                $item=explode(",",$items);
                $data["name"] = $item[0];
                $data["value"] = $item[1];
                $color["color"]= $item[2].",".$item[3].",".$item[4];
                $normal["normal"]=$color;
                $data["itemStyle"] = $normal;
                array_push($words, $data);
            }
        }
        foreach ($news as $items)
        {
            if ($items!="")
            {
                $item=explode(",",$items);
                $data["name"] = $item[0];
                $data["value"] = $item[1];
                $color["color"]= $item[2].",".$item[3].",".$item[4];
                $normal["normal"]=$color;
                $data["itemStyle"] = $normal;
                array_push($words, $data);
            }
        }
         $first = DB::table('wordcloud')->whereDate('created_at','>',date('Y-m-d'))->get();
         $cloud=$first->first();
        try{
            if ($cloud) {
                //数据库中存在数据
                $id = $cloud->id;
                $cloud["words"] =json_encode($words);
                $cloud->update();
            } else
            {
                $cloud["words"] =json_encode($words);
                WordCloud::create($cloud);
            } flash("操作成功");
        }
        catch (Exception $exception){redirect()->back()->withErrors("操作失败");}

        return redirect()->route('cloud.word');
    }
        /*post添加热词*/
    public  function  oldadd(Request $request)
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

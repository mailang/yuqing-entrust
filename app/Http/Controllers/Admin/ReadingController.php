<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reading;
use Illuminate\Support\Facades\DB;

class ReadingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $reading=DB::table('reading')->where('reportform_id',$id)->get();
        $read=array();
        $read['blog_id']="";
        $read['wx_id']="";
        if($reading->count()>0)
        {
            $wx=$reading->where('type','1')->first();
            $blog=$reading->where('type','0')->first();
            if ($blog){
                $read['blog_id']=$blog->id;
                $read['blog_concern']=$blog->concern_num;
                $read['blog_article']=$blog->article_num;
                $read['blog_reader']=$blog->reader_num;
            }
            if ($wx){
                $read['wx_id']=$wx->id;
                $read['wx_concern']=$wx->concern_num;
                $read['wx_article']=$wx->article_num;
                $read['wx_reader']=$wx->reader_num;
            }

        }
        else
        {
            //取出最新记录为默认值
            $reading=DB::table('reading')
                ->limit(2)
                ->orderByDesc('reportform_id')
                ->get();
            $wx=$reading->where('type','1')->first();
            $blog=$reading->where('type','0')->first();
            if ($blog){
                $read['blog_concern']=$blog->concern_num;
                $read['blog_article']=$blog->article_num;
                $read['blog_reader']=$blog->reader_num;
            }
            if ($wx){
                $read['wx_concern']=$wx->concern_num;
                $read['wx_article']=$wx->article_num;
                $read['wx_reader']=$wx->reader_num;
            }
        }
        $read['reportform_id']=$id;
        return view('admin.reading.add',compact('read'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req=$request->all();
        $blog=$req['blog'];
        $wx=$req['wx'];
        $blog['reportform_id']=$req["reportform_id"];
        $wx['reportform_id']=$req["reportform_id"];
        $blog["type"]=0;
        $wx["type"]=1;
        $reading=Reading::where('reportform_id',$req["reportform_id"])
            ->get();
        if (count($reading)>0)
        {
            $read1=$reading->where('type','0')->first();
            $read1["concern_num"]=$blog["concern_num"];
            $read1["article_num"]=$blog["article_num"];
            $read1["reader_num"]=$blog["reader_num"];
            $read1->save();
            $read2=$reading->where('type','1')->first();
            $read2["concern_num"]=$wx["concern_num"];
            $read2["article_num"]=$wx["article_num"];
            $read2["reader_num"]=$wx["reader_num"];
            $read2->save();
        }
        else
        {
            Reading::create($blog);
            Reading::create($wx);
        }
        flash("操作成功");return redirect()->back();
    }
}
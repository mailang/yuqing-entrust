<?php

namespace App\Http\Controllers\Admin;

use App\Models\Useful_news;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportform;
use Illuminate\Support\Facades\DB;
use App\Src;

class ReportformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports=Reportform::all()->sortByDesc('created_at');
        return view('admin.report.lists',compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
          $newsid=$req["newsid"];

          $report["title"]=date('Ymd')."0".($request["type"]+1);
          //dd($request,$report["title"]);
          $report["type"]=$req['type'];
          $report["admin_id"]=\Auth::guard('admin')->id();
          $rpt= Reportform::create($report);
          if (!$rpt->isEmpty)
          {
              $num=Useful_news::whereIn('id',explode(',',$req["newsid"]))->update(['reportform_id'=>$rpt->id]);
              flash('操作成功');return redirect()->back();
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $report=Reportform::find($id);
        $newslist=DB::table('useful_news')->where('reportform_id',$id)->get();
       return view('admin.report.edit',compact('report','newslist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $req=$request->all();
        $post=$req["report"];
        $report=Reportform::find($id);
        $report["title"]=$post["title"];
        $report["type"]=$post["type"];
        $report->save();
        flash('操作成功');
        return redirect()->route('report.day');
        //  return redirect()->route('report.day');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id)
        {
            $report = Reportform::find($id);
            $useful=DB::table('useful_news')
                 ->where('reportform_id',$report->id)
                 ->update(['reportform_id'=>null]);
            $report->delete();
            flash("操作成功");
            return redirect()->back();
        }
    }

    /**
     *从报表除去相关新闻，设置成未生成报表的状态
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $useful=DB::table('useful_news')->where('id',$id)
            ->update(['reportform_id'=>null]);
        flash("操作成功");
        return redirect()->back();
    }

    public function createzip($id)
    {
        $c = new Src\CreateFile();
        if ($c->createzip($id)){
            flash("生成成功");
        }
        return redirect()->back();
    }

    public function downloadzip($id)
    {
        $c = new Src\CreateFile();
        return  $c->downloadzip($id);
    }

    public function downloaddocx($id)
    {
        $c = new Src\CreateFile();
        return $c->downloaddocx($id);
    }

    public function createpersonzip()
    {

        $newsid=explode(',',$_GET['id']);
        $c = new Src\CreateFile();
        return $c-> person_createzip($newsid);

    }
}

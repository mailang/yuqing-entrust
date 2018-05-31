<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Weekform;
use Illuminate\Support\Facades\DB;
use App\Models\Useful_news;

class WeekformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports=DB::table('weekform')
            ->orderByDesc('created_at')->paginate(50);
        return view('admin.report.weekform',compact('reports'));
    }
    public function newslist($id)
    {
        $newslist=DB::table('useful_news')->where('weekform_id',$id)
            ->orderByDesc('created_at')->paginate(50);
        return view('admin.report.newslist',compact('newslist'));

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

        $report["starttime"]=$req['starttime'];
        $report["endtime"]=$req['endtime'];
        $report["title"]=date('Ymd',strtotime($req['starttime']))."-".date('Ymd',strtotime($req['endtime']));
        $rpt=Weekform::where('starttime',$report["starttime"])->where('endtime',$report["endtime"])->orderBy('id','desc')->first();
        if (!$rpt){$rpt= Weekform::create($report);}
        if (!$rpt->isEmpty)
        {
            $num=Useful_news::whereIn('id',explode(',',$req["newsid"]))->update(['weekform_id'=>$rpt->id]);
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
        $report=Weekform::find($id);
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
        //
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
}

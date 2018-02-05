<?php

namespace App\Http\Controllers\Admin;

use App\Models\Useful_news;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportform;
use Illuminate\Support\Facades\DB;

class ReportformController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports=Reportform::all();
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

          $report["title"]=date('YmdHis');
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
        //
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
        //
    }
}

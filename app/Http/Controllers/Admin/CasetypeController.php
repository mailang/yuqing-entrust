<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\casetype;
use Illuminate\Support\Facades\DB;

class CasetypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pid=null)
    {
        if ($pid){
            $casetypes=DB::table('casetype')->where('pid', $pid)->get();
        }else $casetypes=DB::table('casetype')->where('pid', '-1')->get();
        return view('admin.casetype.list',compact('casetypes','pid'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id){//编辑
            $casetype=casetype::find($id);
            return view('admin.casetype.edit',compact('casetype'));
        }else//添加
        {
            $pid='-1';
            return view('admin.casetype.add',compact('pid'));
        }
    }
    public function child($pid)
    {
        if ($pid)
        {
            return view('admin.casetype.add',compact('pid'));
        }
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
        $casetype=$req["casetype"];
        $filer=casetype::where('name',$casetype["name"])->first();
        if ($filer)return redirect()->back()->withErrors("该案件类型已经添加");
        if ($casetype["description"]=null)$casetype["description"]=$casetype["name"];
        $tag=casetype::create($casetype);
        if ($tag){ flash("操作成功");return redirect()->back();}
        else return redirect()->back()->withErrors("操作失败");
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
        if ($id) {
            $req=$request->all();
            $casetype = casetype::find($id);
            if ($casetype) {
                $casetype["name"]=$req["casetype"]["name"];
                $casetype["description"]=$req["casetype"]["description"];
                $casetype->save();
                flash("操作成功");return redirect()->back();
            }
        }
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
            $child=casetype::where('pid',$id)->get()->first();
            if ($child)return redirect()->back()->withErrors('存在子级请先删除子级');
            $casetype=casetype::find($id);
            if ($casetype){
                $casetype->delete();flash("操作成功");return redirect()->back();}
            else return redirect()->back()->withErrors('记录不存在');
        }
    }
}

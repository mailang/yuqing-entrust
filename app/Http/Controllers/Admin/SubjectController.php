<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects=Subject::all();
        return view('admin.subject.list',compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id){
            //编辑
            $subject=Subject::find($id);
            return view('admin.subject.edit',compact('subject'));
        }else//添加
             return view('admin.subject.add');
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
        $subject=$req["subject"];
        $filer=Subject::where('subject',$subject["subject"])->first();
        if ($filer)return redirect()->back()->withErrors("该专题已经添加");
        if ($subject["description"]=null)$subject["description"]=$subject["subject"];
        $tag=Subject::create($subject);
        if ($tag){flash("操作成功");return redirect()->back();}
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
            $subject = Subject::find($id);
            if ($subject) {
                $subject["subject"]=$req["subject"]["subject"];
                $subject["description"]=$req["subject"]["description"];
                $subject->save();
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
            $subject=Subject::find($id);
            if ($subject){
            $subject->delete();flash("操作成功");return redirect()->back();}
            else return redirect()->back()->withErrors('记录不存在');
        }
    }
}

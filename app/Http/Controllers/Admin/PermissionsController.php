<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permissions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($pid=null)
    {
        if ($pid){
            $permissions=DB::table('permissions')->where('pid', $pid)->get();
        }else
        $permissions=DB::table('permissions')->where('pid', '-1')->get();
        return view('admin.permission.list',compact('permissions','pid'));
    }
    public function permschild($pid)
    {
       if ($pid)
       {
           return view('admin.permission.add',compact('pid'));
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        if ($id) {
            $permission=Permissions::find($id);
            return view('admin.permission.edit', compact('permission'));
        } else{ $pid='-1'; return view('admin.permission.add',compact('pid'));}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *   "name" => "d"
    "display_name" => "d"
    "icon" => "fa-sign-out"
    "description" => null
    "pid" => "-1"
     */
    public function store(Request $request)
    {
        $req=$request->all();
        $permission=$req['new'];
        //$permission['pid']='-1';
        $permission['display_name']=$permission['name'];
        //dd($permission);
        $exist=Permissions::where('name',$permission['name'])->first();
        if ($exist) {flash("该模块已经添加");return redirect()->back();}
        else{
            $insert=Permissions::create($permission);
            if ($insert) flash("操作成功");
            else flash('操作失败');
            return redirect()->back();
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
        if ($id){
        $req=$request->all();
        $permission=Permissions::find($id);
        $new=$req['new'];
        $permission['link']=$new['link'];
        $permission['icon']=$new['icon'];
        $permission['description']=$new['description'];
        $permission->save();
        flash('操作成功');
            return redirect()->back();
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

        $child = Permissions::where('pid', $id)->first();
        if ($child) {
            return redirect()->back()
                ->withErrors("请先将子菜单删除后再做删除操作!");
        }
        else
        {
            $permission= Permissions::find($id);
            $permission->delete([$id]);
            return redirect()->back()->withSuccess('删除成功');
        }

    }
}

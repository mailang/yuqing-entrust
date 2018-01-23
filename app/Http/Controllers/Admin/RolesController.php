<?php

namespace App\Http\Controllers\Admin;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Roles::all();
        return view('admin.roles.list',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
      {
          $permissions=Permissions::all();
          if ($id)
          {
              $roles=Roles::find($id);
              //获取角色已有的权限
              $permitids=array();
              if ($roles->perms) {
                  foreach ($roles->perms as $v) {
                      $permitids[] = $v->id;
                  }
              }
             //dd($permitids);
              return  view('admin.roles.edit',compact('permissions','roles','permitids'));
          }
          else return view('admin.roles.add',compact('permissions'));
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $req=$request->all();
        $role=$req['new'];
        $role["display_name"]=$role['name'];
        $newrole=Roles::create($role);
        $permissions=$req['permissions'];
        if ($newrole&&$permissions)
        {
            $newrole->attachPermissions($permissions);
            flash('操作成功');
        }
      return redirect()->back();
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
        if ($id){
            $req=$request->all();
            $new=$req['new'];
            $role=Roles::find($id);
            $role->name=$new['name'];
            $role->save();
            /*权限更新*/
           // dd($role->perms);

                $permitids=array();
                foreach ($role->perms as $v) {
                    $permitids[] = $v->id;
                }
              if ($permitids) $role->detachPermissions($permitids);//已有权限回收
              //dd($req['permissions'][0]);
            $role->attachPermissions($req['permissions']);//重新分配新权限
            flash("操作成功");
        }else flash("参数错误");
        return redirect()->back();


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
        if ($id)
        {
            $roles=Roles::find($id);
          //  dd($role);
            if ($roles)
            {
                $roles->delete([$id]);
                flash('删除成功');
                return redirect()->back();
            }
        }
    }

}

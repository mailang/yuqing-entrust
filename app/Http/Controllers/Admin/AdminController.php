<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admins;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;


class AdminController extends Controller
{
    //
    public function __construct()
    {
    }
    /*获取用户列表*/
    public function  index()
    {
        $admins=Admins::all();
        return view('admin.admins.list',compact('admins'));
    }
    /*后台登录用户修改密码*/
     public function  modify($id)
     {
         $roleid=0;
         $admins=Admins::find($id);
         $arr= $admins->roles->toArray();
         if ($arr) $roleid=$arr[0]["pivot"]["role_id"];
         $roles=Roles::find($roleid);
         return  view('admin.admins.my',compact('admins','roles'));
     }

    /**
     * Show the form for creating a new resource.
     *
     *如果id为空则创建新账号，否则编辑账号
     */
    public function create($id=null)
    {
        $roles=Roles::all();
        $roleid=0;
        if ($id)
        {
            $admins=Admins::find($id);
            $arr= $admins->roles->toArray();
            if ($arr) $roleid=$arr[0]["pivot"]["role_id"];
            return  view('admin.admins.edit',compact('admins','roles','roleid'));
        }
        else return view('admin.admins.add',compact('roles'));
    }

    public function update(Request $request,$id)
    {
        if ($id){
            $req=$request->all();
            $new=$req['new'];
            $admins=Admins::find($id);
            $admins->username=$new['username'];
            $admins->realname=$new['realname'];
            if ($new['password']!=""&&$new['password_confirmation']!=""){
            if ($new['password']==$new['password_confirmation']) {
                $admins['password']=bcrypt($new['password']);
            }
            else flash("两次密码输入不一致");}
            $admins->save();
             /*角色更新*/
            $admins->detachRole($admins->roles[0]);//已有角色回收
            $admins->attachRole($req['roles'][0]);//重新分配新角色
            flash("操作成功");
        }else flash("参数错误");
        return redirect()->back();
    }
   /*删除后台用户，删除用户
   * 删除角色
   * */
    public function destroy($id)
    {
        if ($id)
        {
          $admin = Admins::find((int)$id);
          $admin->delete([$id]);
          //echo url()->current();
            flash("操作成功");
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        $req=$request->all();
        $new=$req['new'];
        $exist= Admins::where('username',$new['username'])->first();
        if ($exist){flash('该用户已经存在');return redirect()->back();}
        if ($new['password']==$new['password_confirmation']) {
            $new['password']=bcrypt($new['password']);
            $admin=Admins::create($new);
           //dd($admin);
            /*角色添加*/
            $role=Roles::find($req['roles'][0]);
            //调用EntrustUserTrait提供的attachRole方法
            $admin->attachRole($role); // 参数可以是Role对象，数组或id

            flash("操作成功");
        }
        else flash("两次密码输入不一致");
        return redirect()->back();
    }

    public function  name()
    {
        $admin = Auth::guard('admin')->user();
        dd($admin);
    }
}

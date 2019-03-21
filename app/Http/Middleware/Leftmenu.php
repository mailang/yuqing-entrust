<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;

class Leftmenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        view()->share('menu',$this->getMenu());

        return $next($request);
    }
    /**
     *获取左边菜单栏
     * @return array
     */
    public function  getMenu()
    {
      //获取一级栏目
        $admin = Auth::guard('admin')->user();
        $arr= $admin->roles->toArray();
        $permitids=array();
        $userper=array();
        if ($arr){
            $roleid=$arr[0]["pivot"]["role_id"];
            $role=Roles::find($roleid);
            foreach ($role->perms as $v) {
                $permitids[] = $v->id;
            }
        }
        if ($permitids)
        {
            $userper=Permissions::WhereIn('id',$permitids)
                ->OrderBy('pid')
                ->get();
        }
         return  $userper;
       // return $userper->where('pid','-1');
       // return array_where($userper->toArray(),function ($value){return $value='-1';});
    }
}

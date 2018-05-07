<?php

namespace App\Http\Controllers\Admin;

use App\Models\Schedule;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\Log;


class ScheduleController extends Controller
{
    /*如果本周的上班表没有排班，
    则自动生成一个，如数据库中存在排班表，则取出数据就OK*/
    public function schedule($time=null)
    {
        $data["time2"]=date('Y-m-d');
        $schedule=DB::table('schedule')->whereDate('time',$data['time2']);
        if (!$schedule->first()||date("w")==5){
         $this->generate();
        }
        if($time)$list=DB::table('schedule')->where('starttime',Date('Y-m-d',$time))->orderBy('id')->get();
        else $list=DB::table('schedule')->limit(7)->orderBy('id')->get();
        $data["time1"]=$list->first()->starttime;
        $data["time2"]=date('Y-m-d',strtotime($data['time1'].'+6 day'));
        $data['role']=\Auth::guard('admin')->user()->roles->toArray()[0]["pivot"]["role_id"];
       return view('admin.schedule.schedule',compact('list','data'));
    }
    /*生成排班表
    一天9个小时，按奇偶数分为两组，将人员分配到这两组中
    一组5个小时，二组
    */
    public function  generate()
    {
         $admins= DB::table('admins')->leftJoin('role_user','admins.id','=','role_user.user_id')
             ->where('role_id','2')
             ->orderBy(\DB::raw('RAND()'))
             ->get(['id','realname']);//随机排列
         $count=$admins->count();
        $weekarray=array("一","二","三","四","五","六","日"); //先定义一个数组
        $starttime=date('Y-m-d',strtotime('+'.(6-date("w")+2).' day'));
       if (DB::table('schedule')->whereDate('starttime',$starttime)->first()) return;
        if($count%2==0)
        {
                 //如果是偶数，取出近一天的排班表，时间段互换一下
                $count2=$count/2;
                $all=array_column(json_decode($admins),'realname');
                $push1['admins']=array_slice($all,0,$count2);
                $push2['admins']=array_slice($all,$count2,$count);
                $splice=array(); $splice1=array();
                for ($i=0;$i<5;$i++)
                {
                $arr=array();
                if ($i==0)
                {
                    $push1["group"]=1;
                    $push2['group']=2;
                    array_push($arr,$push1);
                    array_push($arr,$push2);
                }
                else
                {
                    $push1["group"]=2;
                    $push2['group']=1;
                    if ($count>2&&$count<8){
                        $a=$this->getrand($splice,$push1);$b=$this->getrand($splice1,$push2);
                        if (count($splice)>0&&count($splice)==count($push1['admins'])){array_splice($splice,0,count($splice)-1);array_splice($splice1,0,count($splice1)-1);}
                        array_push($splice,$push1['admins'][$a]);
                        array_push($splice1,$push2['admins'][$b]);
                        array_push($push2['admins'],array_splice($push1['admins'],$a,1)[0]);
                        array_push($push1['admins'],array_splice($push2['admins'],$b,1)[0]);
                    }
                    else if($count>6) {
                        $a=array_rand($push1['admins'],$count2/2);
                        $b=array_rand($push2['admins'],$count2/2);

                        for ($j=0;$j<$count2/2;$j++)
                        {
                            array_push($push2['admins'],array_splice($push1['admins'],$a[$j],1)[0]);
                            array_push($push1['admins'],array_splice($push2['admins'],$b[$j],1)[0]);
                        }
                    }
                    array_push($arr,$push2);
                    array_push($arr,$push1);
                }
                $schedule["schedule"]=\GuzzleHttp\json_encode($arr);
                $schedule["weekday"]="星期".$weekarray[$i];
                $schedule["starttime"]=$starttime;
                $schedule["time"]=date('Y-m-d',strtotime($starttime.'+'.$i.' day'));
                Schedule::create($schedule);
            }
        }
        else
        {
            //奇数则第一组分人数多一个
             $num=(int)ceil($count/2);//ceil向上取整
             $list=DB::table('schedule')->where('weekday','星期五')->orderByDesc('starttime')->limit(1)->get();
             if ($list->first())
             {
                 $list=\GuzzleHttp\json_decode($list->first()->schedule);
                 $list[0]->group==1?$user1=$list[0]->admins:$user2=$list[0]->admins;
                 $list[1]->group==1?$user1=$list[1]->admins:$user2=$list[1]->admins;
                 $push1['admins']=array();
                 $push2['admins']=array();
                 foreach ($admins as $admin)
                 {
                     if (in_array($admin->realname,$user1))
                     {if (count($push2['admins'])==$num-1)array_push($push1['admins'],$admin->realname);  else array_push($push2['admins'],$admin->realname);}
                     else
                     {
                         if(in_array($admin->realname,$user2))
                             array_push($push1['admins'],$admin->realname);
                         else{
                             if(count($push1['admins'])<$num)array_push($push1['admins'],$admin->realname);
                             else array_push($push2['admins'],$admin->realname);
                         }
                     }
                 }
             }
             else
             {
                 $all=array_column(json_decode($admins),'realname');
                 $push1['admins']=array_slice($all,0,$num);
                 $push2['admins']=array_slice($all,$num,$count);
             }
            $push1["group"]=1;
            $push2['group']=2;
            $splice=array();
             for ($i=0;$i<5;$i++)
             {
                $arr=array();
                if ($i==0)
                {
                    array_push($arr,$push1);
                    array_push($arr,$push2);
                }
                else
                {
                        if (count($splice)>0&&count($splice)==count($push1['admins'])){array_splice($splice,0,count($splice)-1);}
                        $a= $this->getrand($splice,$push1);
                        $temp=$push2['admins'];
                        array_push($temp,$push1['admins'][$a]);
                        array_push($splice,$push1['admins'][$a]);
                        array_splice($push1['admins'],$a,1);
                        $push2['admins']=$push1['admins'];
                        $push1['admins']=$temp;
                        array_push($arr,$push1);
                        array_push($arr,$push2);
                }
                $schedule["schedule"]=\GuzzleHttp\json_encode($arr);
                $schedule["weekday"]="星期".$weekarray[$i];
                $schedule["starttime"]=$starttime;
                $schedule["time"]=date('Y-m-d',strtotime($starttime.'+'.$i.' day'));
                Schedule::create($schedule);
            }
        }
        /*安排周末*/
        $this->weekend($admins,$starttime);
    }

    function weekend($admins,$starttime)
    {
        $all=array_column(json_decode($admins),'realname');
        $week_schedule=DB::table('schedule')->where('weekday','星期六')
            ->orWhere('weekday','星期日')
            ->orderByDesc('id')->limit(count($all))->get(['schedule']);
        if ($week_schedule->first()){
            $exist=array();
            foreach ($week_schedule as $week)
            {
                $schedule=\GuzzleHttp\json_decode($week->schedule);
                if (!in_array(($schedule[0]->admins)[0],$exist))
                array_push($exist,($schedule[0]->admins)[0]);
            }
            if (count($exist)==count($all))
                $a=array_rand($all,2);
            else
            {
                for ($i=0;$i<count($exist);$i++)
                {
                    if (in_array($exist[$i],$all)) {
                    $key = array_search($exist[$i], $all);
                    array_splice($all,$key,1);}
                    else
                        array_splice($all,$i,1);
                }
                if (count($all)>=2)$a=array_rand($all,2);
                else{
                    $a[0]=$all[0];
                    $a[1] = $exist[array_rand($exist,1)];
                  }
            }
        }
        else
        $a=array_rand($all,2);
        $weekarray=array("一","二","三","四","五","六","日"); //先定义一个数组
        for ($i=5;$i<7;$i++)
        {    $push=array();
            $scdl['group']=1;
            $scdl['admins']=array($all[$a[$i-5]]);
            array_push($push,$scdl);
            $scdl["group"]=2;
            array_push($push,$scdl);
            $schedule["schedule"]=\GuzzleHttp\json_encode($push);
            $schedule["weekday"]="星期".$weekarray[$i];
            $schedule["starttime"]=$starttime;
            $schedule["time"]=date('Y-m-d',strtotime($starttime.'+'.$i.' day'));
            Schedule::create($schedule);

        }
    }
    /*得到随机数*/
    public function getrand($splice,$push1)
    {
         $a= array_rand($push1['admins'],1);
         if (count($splice)>0&&in_array($push1['admins'][$a],$splice)) {
           array_splice($push1['admins'],$a,1);
            $this->getrand($splice,$push1,1);}
         return $a;
    }
     /*管理员手动修改排班表*/
    public function update(Request $request,$id)
    {
       $req=$request->all();
       //去掉空值项，防止手误两名字中间输入多个|
       $push1['admins']=array_filter(explode('|',$req["group1"]));
       $push2['admins']=array_filter(explode('|',$req["group2"]));
       $schedule=Schedule::find($id);
       $push1['group']=1;
       $push2['group']=2;
       $arr=array($push1,$push2);
       $schedule['schedule']=\GuzzleHttp\json_encode($arr);
       if($schedule->save())
       flash('操作成功');
       else  flash('操作失败');
        return redirect()->back();
    }
      /*进入编辑页面*/
    public  function create($id)
    {
         $schedule=Schedule::find($id);
        return view('admin.schedule.edit',compact('schedule'));
    }
    /* 列出所有排班列表 */
    public function list()
    {
        $list=DB::table('schedule')
            ->select(['starttime'])
            ->groupBy(['starttime'])
            ->orderByDesc('starttime')->paginate(10);
        return view('admin.schedule.list',compact('list'));
    }
}

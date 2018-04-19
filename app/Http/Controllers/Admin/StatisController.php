<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Useful_news;
use App\Models\Admins;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\VarDumper\Caster\DateCaster;

class StatisController extends Controller
{
    /**
     * Display a listing of the resource.
     *查询所有和各个用户上传新闻的统计
     * @return \Illuminate\Http\Response
     */
    public function index($id=null)
    {
            $admins=Admins::all();
            /*取出最近一周的统计数据*/
            $newslist=DB::table('useful_news')
                ->whereDate('created_at','>',Date('Y-m-d',strtotime('-7 day')))
                ->where('tag','!=','0')
                ->get(['id','tag','created_at','updated_at']);
            $week["all"]=$newslist->count();
            $week["noverify"]=$newslist->where('tag','-1')->count();
            $week["verify"]= $week["all"]- $week["noverify"];
            $week["repeat"]=$newslist->where('tag','2')->count();
            $week["nopass"]=$newslist->where('tag','-2')->count();
            $week["pass"]=$newslist->where('tag','1')->count();

            /*取出最近一天的统计数据*/
            $daylist=$newslist->where('created_at','>',Date('Y-m-d',strtotime('-1 day')));
            $day["all"]=$daylist->count();
            $day["noverify"]=$daylist->where('tag','-1')->count();
            $day["verify"]= $day["all"]- $day["noverify"];
            $day["repeat"]=$daylist->where('tag','2')->count();
            $day["nopass"]=$daylist->where('tag','-2')->count();
            $day["pass"]=$daylist->where('tag','1')->count();
        return view('admin.tongji.lists',compact('admins','day','week'));
    }

        /*获取指定用户的统计数据*/
    public function person($id=null)
    {
        if (!$id)$id=\Auth::guard('admin')->id();
        /*取出最近一周的统计数据*/
        $newslist=DB::table('useful_news')
            ->where('admin_id',$id)
            ->whereDate('created_at','>',Date('Y-m-d',strtotime('-7 day')))
            ->where('tag','!=','0')
            ->get(['id','admin_id','tag','created_at','updated_at']);
        $week["all"]=$newslist->count();
        $week["noverify"]=$newslist->where('tag','-1')->count();
        $week["verify"]= $week["all"]- $week["noverify"];
        $week["repeat"]=$newslist->where('tag','2')->count();
        $week["nopass"]=$newslist->where('tag','-2')->count();
        $week["pass"]=$newslist->where('tag','1')->count();

        /*取出最近一天的统计数据*/
        $daylist=$newslist->where('created_at','>',Date('Y-m-d',strtotime('-1 day')));
        $day["all"]=$daylist->count();
        $day["noverify"]=$daylist->where('tag','-1')->count();
        $day["verify"]= $day["all"]- $day["noverify"];
        $day["repeat"]=$daylist->where('tag','2')->count();
        $day["nopass"]=$daylist->where('tag','-2')->count();
        $day["pass"]=$daylist->where('tag','1')->count();

        return view('admin.tongji.tongji',compact('week','day'));
    }

        /*指定时间段统计*/
     public function search(Request $request)
     {
         $req=$request->all();
         $time1=$req["time1"];
         $time2=$req["time2"];
             $admins=Admins::all();
         if ($time1!=null&&$time2!=null)
         {
             $search["time1"]=$time1;
             $search["time2"]=$time2;
             $newslist=DB::table('useful_news')
                 ->whereBetween('starttime',[$time1,$time2])
                 ->where('tag','!=','0')
                 ->get(['id','admin_id','tag','created_at','updated_at']);
             $search["all"]=$newslist->count();
             $search["noverify"]=$newslist->where('tag','-1')->count();
             $search["verify"]= $search["all"]- $search["noverify"];
             $search["repeat"]=$newslist->where('tag','2')->count();
             $search["nopass"]=$newslist->where('tag','-2')->count();
             $search["pass"]=$newslist->where('tag','1')->count();
             return view('admin.tongji.lists',compact('admins','search'));
         }
        else{ return redirect()->back()->withErrors('时间输入不正确'); }
     }
       /* 个人指定时间段统计    */
      public function person_search(Request $request,$id=null)
      {
          $req=$request->all();
          $time1=$req["time1"];
          $time2=$req["time2"];
          if (!$id)$id=\Auth::guard('admin')->id();
          if ($time1!=null&&$time2!=null)
          {
              $search["time1"]=$time1;
              $search["time2"]=$time2;
          $newslist=DB::table('useful_news')
              ->where('admin_id',$id)
              ->whereBetween('starttime',[$time1,$time2])
              ->where('tag','!=','0')
              ->get(['id','admin_id','tag','created_at','updated_at']);
          $search["all"]=$newslist->count();
          $search["noverify"]=$newslist->where('tag','-1')->count();
          $search["verify"]= $search["all"]- $search["noverify"];
          $search["repeat"]=$newslist->where('tag','2')->count();
          $search["nopass"]=$newslist->where('tag','-2')->count();
          $search["pass"]=$newslist->where('tag','1')->count();
          return view('admin.tongji.tongji',compact('search'));
          }
          else{ return redirect()->back()->withErrors('时间输入不正确'); }
      }
    /**
     * 区域性新闻统计
     *
     * @return \Illuminate\Http\Response
     */
    public function province()
    {
        $search['time1']=date('Y-m-d',strtotime('-7 day'));
        $search['time2']=date('Y-m-d');
        $list=DB::table('useful_news')->leftJoin('court','useful_news.court','=','court.name')
            ->select(DB::raw('court.province,useful_news.orientation,count(1) as num'))
            ->whereBetween('useful_news.starttime',$search)
            ->where('tag','1')
            ->whereNotNull('reportform_id')
            ->groupBy(['court.province','useful_news.orientation'])
            ->orderByDesc('num')
            ->get();
       $newslist=$list->groupBy('province');
       $datalist=array();
       foreach ($newslist as $key=>$news)
       {
            $data["province"]=$key;
            $data["total"]=$news->sum('num');
            $data["fumian"]=$news->where('orientation','负面')->first()==null?0:$news->where('orientation','负面')->first()->num;
            $data["zhengmian"]=$news->where('orientation','正面')->first()==null?0:$news->where('orientation','正面')->first()->num;
            $data["zhongxing"]=$news->where('orientation','中性')->first()==null?0:$news->where('orientation','中性')->first()->num;
            array_push($datalist,$data);
       }
        $dblist= collect($datalist)->sortByDesc('total');
        return view('admin.tongji.province',compact('dblist','search'));
    }
    /**
     * 区域性新闻统计搜索
     *
     * @return \Illuminate\Http\Response
     */
    public function province_search(Request $request)
    {
        $req=$request->all();
        $search['time1']=date('Y-m-d H:i:s',strtotime($req['time1']));
        $search['time2']=date('Y-m-d H:i:s',strtotime($req['time2']));
        $list=DB::table('useful_news')->leftJoin('court','useful_news.court','=','court.name')
            ->select(DB::raw('court.province,useful_news.orientation,count(1) as num'))
            ->whereBetween('useful_news.starttime',$search)
            ->where('tag','1')
            ->whereNotNull('reportform_id')
            ->groupBy(['court.province','useful_news.orientation'])
            ->orderByDesc('num')
            ->get();
        $newslist=$list->groupBy('province');
        $datalist=array();
        foreach ($newslist as $key=>$news)
        {
            $data["province"]=$key;
            $data["total"]=$news->sum('num');
            $data["fumian"]=$news->where('orientation','负面')->first()==null?0:$news->where('orientation','负面')->first()->num;
            $data["zhengmian"]=$news->where('orientation','正面')->first()==null?0:$news->where('orientation','正面')->first()->num;
            $data["zhongxing"]=$news->where('orientation','中性')->first()==null?0:$news->where('orientation','中性')->first()->num;
            array_push($datalist,$data);
        }
        $dblist= collect($datalist)->sortByDesc('total');
        return view('admin.tongji.province',compact('dblist','search'));
    }
    /**
     * 新闻来源统计
     *
     * @return \Illuminate\Http\Response
     */
    public function source()
    {
        $search['time1']=date('Y-m-d',strtotime('-7 day'));
        $search['time2']=date('Y-m-d');
        $list=DB::table('useful_news')->leftJoin('court','useful_news.court','=','court.name')
            ->select(DB::raw('court.province,useful_news.orientation,count(1) as num'))
            ->where('tag','1')
            ->whereBetween('useful_news.starttime',$search)
            ->groupBy(['court.province','useful_news.orientation'])
            ->orderByDesc('num')
            ->get();
        $newslist=$list->groupBy('province');
        $datalist=array();
        foreach ($newslist as $key=>$news)
        {
            $data["province"]=$key;
            $data["total"]=$news->sum('num');
            $data["fumian"]=$news->where('orientation','负面')->first()==null?0:$news->where('orientation','负面')->first()->num;
            $data["zhengmian"]=$news->where('orientation','正面')->first()==null?0:$news->where('orientation','正面')->first()->num;
            $data["zhongxing"]=$news->where('orientation','中性')->first()==null?0:$news->where('orientation','中性')->first()->num;
            array_push($datalist,$data);
        }
        $dblist= collect($datalist)->sortByDesc('total');
        return view('admin.tongji.source',compact('dblist','search'));
    }
    /**
     * 新闻来源统计搜索
     *
     * @return \Illuminate\Http\Response
     */
    public function source_search(Request $request)
    {
        $search['time1']=date('Y年m月d日',strtotime('-7 day'));
        $search['time2']=date('Y年m月d日');
        return view('admin.tongji.province',compact('search'));
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

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
        $list=DB::table('news')
            ->select(DB::raw('media_type,orientation,count(1) as num'))
            ->whereBetween('starttime',$search)
            ->groupBy(['media_type','orientation'])
            ->orderBy('media_type')
            ->get();
        $newslist=$list->groupBy('orientation');
        $datalist=array();
        array_push($datalist,$this->getsourcedata($newslist['正面'],"正面"));
        array_push($datalist,$this->getsourcedata($newslist['负面'],"负面"));
        array_push($datalist,$this->getsourcedata($newslist['中性'],"中性"));
        $dblist= collect($datalist);
        return view('admin.tongji.source',compact('dblist','search'));
    }
     public function  getsourcedata($newslist,$orientation)
     {
         $data=array();
         $data['orientation']=$orientation;
         $data["wangmei"] =0;$data["bbs"] =0;
         $data["weibo"] =0;$data["weibo"] =0;
         $data["weixin"] =0;$data["blog"] =0;
         $data["paper"] =0;$data["video"] =0;
         $data["app"] =0;$data["search"]=0;
         $data["comment"]=0;
         foreach ($newslist as $news) {
             switch ($news->media_type) {
                 case 1:$data["wangmei"] =$news->num; break;
                 case 2:$data["bbs"] =$news->num; break;
                 case 4:$data["weibo"] =$news->num; break;
                 case 8:$data["weibo"] =$news->num; break;
                 case 6:$data["weixin"] =$news->num; break;
                 case 3:$data["blog"] =$news->num; break;
                 case 5:$data["paper"] =$news->num; break;
                 case 7:$data["video"] =$news->num; break;
                 case 9:$data["app"] =$news->num; break;
                 case 99:$data["search"] =$news->num; break;
                 case 10:$data["comment"] =$news->num; break;
             }
         }
         return $data;

     }
    /**
     * 新闻来源统计搜索
     *
     * @return \Illuminate\Http\Response
     */
    public function source_search(Request $request)
    {
        $req=$request->all();
        $search['time1']=date('Y-m-d H:i:s',strtotime($req['time1']));
        $search['time2']=date('Y-m-d H:i:s',strtotime($req['time2']));
        $list=DB::table('news')
            ->select(DB::raw('media_type,orientation,count(1) as num'))
            ->whereBetween('starttime',$search)
            ->groupBy(['media_type','orientation'])
            ->orderBy('media_type')
            ->get();
        $newslist=$list->groupBy('orientation');
        $datalist=array();
        array_push($datalist,$this->getsourcedata($newslist['正面'],"正面"));
        array_push($datalist,$this->getsourcedata($newslist['负面'],"负面"));
        array_push($datalist,$this->getsourcedata($newslist['中性'],"中性"));
        $dblist= collect($datalist);
        return view('admin.tongji.source',compact('dblist','search'));
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

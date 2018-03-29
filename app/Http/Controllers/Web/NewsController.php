<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Useful_news;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filed=['Useful_news.id','Useful_news.title','Useful_news.firstwebsite','Useful_news.starttime','court.province'];
        $newslist=  DB::table('Useful_news')->leftJoin('court','Useful_news.court','=','court.name')
          ->where('tag',1)
          ->whereNotNull('reportform_id')
          ->orderByDesc('updated_at')
          ->limit(5)
          ->get($filed);
         $week["date"]=array(date('m-d',strtotime('-6 day')),date('m-d',strtotime('-5 day')),date('m-d',strtotime('-4 day')),date('m-d',strtotime('-3 day')),date('m-d',strtotime('-2 day')),date('m-d',strtotime('-1 day')),date('m-d'));
         $week["data"]=$this->week_trend();
         $listmaps=$this->map();
         $datamap=array();
        foreach ($listmaps as $map)
        {
            $data["name"]=$map->province=="内蒙"?"内蒙古":$map->province;
            $data["value"]=$map->total==null?"0":$map->total;
            array_push($datamap,$data);
        }
        //dd($datamap);
      return view('web.index',compact('newslist','week','listmaps','datamap'));
    }
    public function map()
    {
        $sql="select  `a`.`province`,`d`.`total`,`d`.`fumian` from (select province from court group by court.province) a LEFT OUTER JOIN (select b.*,c.fumian from".
            "(select `province`,count(1) as total from `Useful_news` left join `court` on `Useful_news`.`court` = `court`.`name` where `tag` = '1' and `reportform_id` is not null group by province) b join ("
          ."select `province`,count(1) as fumian  from `Useful_news` left join `court` on `Useful_news`.`court` = `court`.`name` where `tag` = '1' and `reportform_id` is not null and `orientation`='负面' group by province) c) d on `a`.`province`=`d`.`province` order by total desc";
        $list=DB::select($sql);

        return $list;
    }
     /*一周走势*/
     public function week_trend(){
       $filed=['id','title','orientation','starttime'];
       $list=  DB::table('useful_news')
           ->where('tag',1)
           ->whereNotNull('reportform_id')
           ->whereDate('starttime','>=',date('Y-m-d  00:00:00',strtotime('-6 day')))
           ->get($filed);

       $time2=date('Y-m-d',strtotime('-5 day'));
       $time3=date('Y-m-d',strtotime('-4 day'));
       $time4=date('Y-m-d',strtotime('-3 day'));
       $time5=date('Y-m-d',strtotime('-2 day'));
       $time6=date('Y-m-d',strtotime('-1 day'));
       $time7=date('Y-m-d');
       $new1=$list->where('starttime','<',$time2);//17
       $new2=$list->where('starttime','>',$time2)->where('starttime','<',$time3);//
       $new3=$list->where('starttime','>',$time3)->where('starttime','<',$time4);//
       $new4=$list->where('starttime','>',$time4)->where('starttime','<',$time5);//
       $new5=$list->where('starttime','>',$time5)->where('starttime','<',$time6);//
       $new6=$list->where('starttime','>',$time6)->where('starttime','<',$time7);//
       $new7=$list->where('starttime','>',$time7);

       $first["all"]=$new1->count();
       $first["plus"]=$new1->where('orientation','正面')->count();
       $first["neuter"]=$new1->where('orientation','中性')->count();
       $first["minus"]=$new1->where('orientation','负面')->count();
       $first["sent"]=$list->where('starttime','<',$time2)->count();
       //dd($new1->where('orientation','中性'));

       $second["all"]=$new2->count();
       $second["plus"]=$new2->where('orientation','正面')->count();
       $second["neuter"]=$new2->where('orientation','中性')->count();
       $second["minus"]=$new2->where('orientation','负面')->count();
       $second["sent"]=$list->where('starttime','>',$time2)->where('starttime','<',$time3)->count();

       $third["all"]=$new3->count();
       $third["plus"]=$new3->where('orientation','正面')->count();
       $third["neuter"]=$new3->where('orientation','中性')->count();
       $third["minus"]=$new3->where('orientation','负面')->count();
       $third["sent"]=$list->where('starttime','>',$time3)->where('starttime','<',$time4)->count();

       $fourth["all"]=$new4->count();
       $fourth["plus"]=$new4->where('orientation','正面')->count();
       $fourth["neuter"]=$new4->where('orientation','中性')->count();
       $fourth["minus"]=$new4->where('orientation','负面')->count();
       $fourth["sent"]=$list->where('starttime','>',$time4)->where('starttime','<',$time5)->count();

       $fifth["all"]=$new5->count();
       $fifth["plus"]=$new5->where('orientation','正面')->count();
       $fifth["neuter"]=$new5->where('orientation','中性')->count();
       $fifth["minus"]=$new5->where('orientation','负面')->count();
       $fifth["sent"]=$list->where('starttime','>',$time5)->where('starttime','<',$time6)->count();

       $sixth["all"]=$new6->count();
       $sixth["plus"]=$new6->where('orientation','正面')->count();
       $sixth["neuter"]=$new6->where('orientation','中性')->count();
       $sixth["minus"]=$new6->where('orientation','负面')->count();
       $sixth["sent"]=$list->where('starttime','>',$time6)->where('starttime','<',$time7)->count();

       $seventh["all"]=$new7->count();
       $seventh["plus"]=$new7->where('orientation','正面')->count();
       $seventh["neuter"]=$new7->where('orientation','中性')->count();
       $seventh["minus"]=$new7->where('orientation','负面')->count();
       $seventh["sent"]=$list->where('starttime','>',$time7)->count();

       $data["all"]=array("name"=>'全部',"type"=>'bar',"data"=>[$first["all"], $second["all"], $third["all"], $fourth["all"], $fifth["all"], $sixth["all"],$seventh["all"]]);
       $data["plus"]=array("name"=>'正面',"type"=>'bar',"data"=>[$first["plus"], $second["plus"],$third["plus"], $fourth["plus"], $fifth["plus"],  $sixth["plus"],$seventh["plus"]]);
       $data["neuter"]=array("name"=>'中性',"type"=>'bar',"data"=>[$first["neuter"], $second["neuter"], $third["neuter"], $fourth["neuter"],$fifth["neuter"], $sixth["neuter"],$seventh["neuter"]]);
       $data["minus"]=array("name"=>'负面',"type"=>'bar',"data"=>[$first["minus"], $second["minus"], $third["minus"], $fourth["minus"], $fifth["minus"], $sixth["minus"], $seventh["minus"]]);
       $data["sent"]=array("name"=>'推送舆情',"type"=>'bar',"data"=>[$first["sent"], $second["sent"], $third["sent"], $fourth["sent"], $fifth["sent"], $sixth["sent"], $seventh["sent"]]);
       return array($data["all"],$data["plus"], $data["neuter"],$data["minus"],$data["sent"]);
    }
     /* 获取更多的新闻显示列表*/
      function  list()
      {
          $filed=['id','title','abstract','firstwebsite','starttime','orientation'];
          $newslist=  Useful_news::where('tag',1)
              ->whereNotNull('reportform_id')
              ->orderByDesc('updated_at')
              ->limit(10)
              ->get($filed);
          $total=  Useful_news::where('tag',1)
              ->whereNotNull('reportform_id')
              ->count('id');
          $data["total"]=$total;
          $data["page"]=1;
          $data["size"]=10;
          return view('web.news.list',compact('newslist','data'));
      }
        /*新闻搜索*/
      public function search(Request $request)
      {
          $req=$request->all();   if($req==null) return redirect()->route('web.news.list');
          $type=$req["type"];
          $keyword=$req["keyWord"];
          if ($keyword!=null&&$keyword!='')
          {
              $filed=['id','title','abstract','firstwebsite','starttime','orientation'];
              $newslist=  Useful_news::where('tag',1)
                      ->whereNotNull('reportform_id')
                     ->where($type,'like','%'.$keyword.'%')
                      ->orderByDesc('updated_at')
                      ->get($filed);
              $total=  Useful_news::where('tag',1)
                  ->whereNotNull('reportform_id')
                  ->where($type,'like','%'.$keyword.'%')
                  ->count('id');
              $data["total"]=$total;
              $data["page"]=1;
              $data["size"]=10;
              $data["type"]=$type;
              $data["keyword"]=$keyword;
              return view('web.news.list',compact('newslist','data'));
          }
      }
      /*新闻分页*/
      function page(Request $request)
      {
        $req=$request->all();
        if($req==null) return redirect()->route('web.news.list');
        $num=$req["pageNum"];
        $size=$req["pageSize"];

        if ($num!=null&&$size!=null){
            $filed=['id','title','abstract','firstwebsite','starttime','orientation'];
            $sql="select `id`, `title`, `abstract`, `firstwebsite`, `starttime`, `orientation` from `useful_news` where `tag` = '1' and `reportform_id` is not null order by `updated_at` desc limit ".($num-1)*$size.",".$size;
            if($req["skeywords"]!=null&&$req["stype"]!=null)
            {

                $sql="select `id`, `title`, `abstract`, `firstwebsite`, `starttime`, `orientation` from `useful_news` where `tag` = '1' and `reportform_id` is not null and `".$req["stype"]."` like '%".$req["skeywords"]."%' order by `updated_at` desc limit ".($num-1)*$size.",".$size;
                $data["type"]=$req["stype"];
                $data["keyword"]=$req["skeywords"];
                $total=  Useful_news::where('tag',1)
                    ->whereNotNull('reportform_id')
                    ->where($req["stype"],'like','%'.$req["skeywords"].'%')
                    ->count('id');
            }
            else
                $total=  Useful_news::where('tag',1)
                    ->whereNotNull('reportform_id')
                    ->count('id');
            $newslist=DB::select($sql);
            $data["total"]=$total;
            $data["page"]=$num;
            $data["size"]=$size;
            return view('web.news.list',compact('newslist','data'));
        }
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
        $filed=['id','title','content','author','firstwebsite','link','orientation','starttime'];
        $news=Useful_news::where('id',$id)->get($filed)->first();
        return view('web.news.content',compact('news'));
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

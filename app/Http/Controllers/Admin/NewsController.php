<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\casetype;
use App\Models\Reportform;
use App\Models\Subject;
use Faker\Provider\DateTime;
use Illuminate\Database\Schema\SQLiteBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Useful_news;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Cache;
use Carbon\Carbon;
class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *用户查看个人添加的新闻
     * @return \Illuminate\Http\Response
     */
    public function  person()
    {
        $subjects=Subject::all();
        $filed=['id','title','isedit','created_at','tag'];
        $admin_id=Auth::guard('admin')->id();
        $newslist=DB::table('useful_news')->where('admin_id',$admin_id)
            ->select($filed)
            ->orderByDesc('created_at')
            ->paginate(50);
        return view('admin.news.person',compact('newslist','subjects'));
    }
    /*查看搜索新闻内容*/
    public function see($id)
    {
        if ($id)
        {
            $news=News::find($id);
            //添加相同新闻
            $newslist=News::where('title','like','%'.$news->title.'%')
                ->where('id','!=',$news->title)
                ->orderByDesc('starttime')
                ->get(['title','link','firstwebsite','starttime']);
            return view('admin.news.see',compact('news','newslist'));
        }
    }
    /*查看搜索新闻列表*/
    public function index()
    {
            $filed=['id','title','author','orientation','starttime','keywords','abstract'];
            $time1=date("Y-m-d H:i:s",strtotime('-5 hour'));
            $time2=date("Y-m-d H:i:s");
            $newslist=DB::table('news')
                ->whereBetween('starttime',[$time1,$time2])
             ->orderByDesc('starttime')->paginate(200);
            //$sql="select `id`, `title`, `author`, `orientation`, `starttime`, `keywords`,left(content,200) as abstract from `news` where `starttime` between '".$time1."' and '".$time2."' order by `starttime` desc";
            //$newslist=DB::select($sql);
            return view('admin.news.lists',compact('newslist'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $subjects=Subject::all();
        $casetypes=null;
         $root=casetype::where('pid','-1')->get();
        if (!$root->isEmpty()){
            $casetypes=json_encode($this->getdata($root,array()));
        }
        $areacode=Address::all()->toJson();
        if ($id)
        {
            $news=Useful_news::find($id);
            if ($news["casetype_id"]!=null&&$news["casetype_id"]!="")
                $news["casetype"]=casetype::where('id',$news["casetype_id"])->get(["name"])->first()->name;
            return view('admin.news.edit',compact('news','subjects','casetypes','areacode'));
        }else return view('admin.news.add',compact('subjects','casetypes','areacode'));
    }
   protected  function getdata($nodes,$data)
   {
    foreach($nodes as $node)
    {
        $p["text"]=$node["name"];
        $p["id"]=$node["id"];
        $p["nodeId"]=$node["id"];
        $pid=$node["pid"];
        $child=casetype::where('pid',$p["id"])->get();
       if ($child->first()!=null) {
           if ($p["id"]==6)dd($child->first());
           $p["nodes"]= $this->getdata($child, array());
           array_push($data,$p);
       }else{$p["nodes"]=null;array_push($data,$p);return $data;}
    }
   }
    /* 获取已提交到三报的新闻列表
     *修改审核通过的均显示
     */
    public  function submit($id=null)
    {
        $subjects=Subject::all();
        if ($id)
        {
            $news=Useful_news::find($id);
            $casetypes=casetype::all();
            $areacode=Address::all()->toJson();
            return view('admin.news.passed_see',compact('news','subjects','casetypes','areacode'));
        }
        else{
            //获取提交到三报的所有新闻列表
        $filed=['useful_news.id','useful_news.abstract','useful_news.title','useful_news.firstwebsite','useful_news.weekform_id','useful_news.tag','useful_news.created_at','useful_news.starttime','useful_news.keywords','useful_news.reportform_id','admins.username'];
        $newslist=DB::table('useful_news')->leftJoin('admins', 'useful_news.admin_id', '=', 'admins.id')
                ->select($filed)
                ->where('tag','1')
                ->orderByDesc('created_at')
                ->paginate(100);
            return view('admin.news.submit',compact('newslist','subjects'));
         }
    }
    /*
     * 获取审核通过的新闻列表
     */
    public  function passed($id=null)
    {
        $subjects=Subject::all();
        if ($id)
        {
            $news=Useful_news::find($id);
            $casetypes=casetype::all();
            $areacode=Address::all()->toJson();
            return view('admin.news.passed_see',compact('news','subjects','casetypes','areacode'));
        }
        else{
            $filed=['id','title','author','orientation','created_at','updated_at','keywords','reportform_id'];
            $newslist=DB::table('useful_news')
                ->select($filed)
                ->where('tag','=','1')
                ->orderByDesc('created_at')
                ->paginate(100);
            return view('admin.news.passed',compact('newslist','subjects'));
        }
    }
    /*
     * 获取需要审核的新闻列表
     */
    public function verify()
    {
            $subjects=Subject::all();
            $filed=['id','title','tag','author','court','orientation','created_at','keywords'];
            $newslist=DB::table('useful_news')
                ->where('tag','-1')
                ->orderByDesc('created_at')
                ->get($filed);
            return view('admin.news.verify',compact('newslist','subjects','id'));
    }
    /*审核新闻*/
    public function verify_option( Request $request,$id)
    {
      $req=$request->all();
      $tag=$req["tag"];
      $isrepeats=$req["isrepeats"];
      $verify_option=$req["verify_option"];
      $num=Useful_news::find($id)
          ->update(['tag'=>$tag,'verify_option'=>$verify_option,'isrepeats'=>$isrepeats]);
      if ($num){
         flash('操作成功');
        return redirect()->route('verify.lists');}
        else     return redirect()->back()->withErrors('操作失败');
    }
    /*进入审核页面*/
     public function  option_edit($id)
     {
         if ($id) {
             $news = Useful_news::find($id);
             //dd($news);
             return view('admin.news.examine', compact('news'));
             // return view('admin.news.examine','news');
         }
     }
    /*
     * 将新闻加到useful_news新闻中
     * */
    public function useful_news($id)
    {
        if ($id){
            $news=News::find($id)->toArray();
            $useful=new Useful_news();
            $useful['admin_id']=Auth::guard('admin')->id();
           //$useful['subject_id']=$request->all()['subject'];
            $useful['news_id']=$id;
            $useful['title']=$news['title'];
            $useful['content']=$news['content'];
            $useful['author']=$news['author'];
            $useful['orientation']=$news['orientation'];
            $useful['firstwebsite']=$news['firstwebsite'];
            switch ($news['media_type'])
            {
                //02论坛03博客04,08微博05报刊06微信07视频09APP;10评论；99搜索
                case 0:$media_type=$news['sitetype'];break;
                case 1:$media_type='网媒'; break;
                case 2:$media_type='论坛'; break;
                case 3:$media_type='博客'; break;
                case 4:$media_type='微博'; break;
                case 5:$media_type='报刊'; break;
                case 6:$media_type='微信'; break;
                case 7:$media_type='视频'; break;
                case 8:$media_type='微博'; break;
                case 9:$media_type='APP'; break;
                case 10:$media_type='评论'; break;
                case 99:$media_type='搜索'; break;
            }
            $useful['sitetype']=$media_type;
            $useful['link']=$news['link'];
            $useful['uuid']=$news['uuid'];
            $useful['keywords']=$news['keywords'];
            $useful['oldsubject']=$news['subject'];
            $useful['transmit']=$news['transmit'];
            $useful['starttime']=$news['starttime'];
            $useful['md5']=md5($news['title'].$news['author'].$news['firstwebsite']);
            $useful->save();
             if ($useful){
                 return 1;
                //flash("操作成功");
                // return redirect()->back();
            }else return -1; //return redirect()->back()->withErrors('操作失败');
        }
    }
    /**
     * 保存自行添加的新闻
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $req=$request->all();
        $news=$req["news"];
        $news['admin_id']=Auth::guard('admin')->id();
        if (isset($news['areacode2'])&&$news['areacode2']!=null)
            $useful['areacode']=$news['areacode2'];
        if ($news['areacode2']==null&&$news['areacode1']!=null)  $useful['areacode']=$news['areacode1'];
        $news["title"]=preg_replace('/"([^"]*)"/', '“${1}”', $news["title"]);
        $news["transmit"]= $news["transmit"]==null?"0":$news["transmit"];
        $news["visitnum"]= $news["visitnum"]==null?"0":$news["visitnum"];
        $news["replynum"]= $news["replynum"]==null?"0":$news["replynum"];
        $news["content"]= $news["content"]==null?"":$news["content"];
        $news['isedit']=1;
        $news['md5']=md5($news['title'].$news['author'].$news['firstwebsite']);
        $use=Useful_news::create($news);
       if ($use)
       {
           flash('操作成功');   return redirect()->route('person.lists');
       }else return redirect()->back()->withErrors('操作失败');
    }

    /**
     * Display the specified resource.
     *批量提交到审核
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     function submitverify(Request $request)
     {
         $req=$request->all();

         try{
             $nums=Useful_news::whereIn('id',explode(',',$req["newsid"]))->where('isedit','0');
             if ($nums->count()>0) return redirect()->back()->withErrors('提交项中存在未曾编辑项，请先编辑后再提交');
             $num=Useful_news::whereIn('id',explode(',',$req["newsid"]))->where('isedit','1')->update(['tag'=>'-1']);
             flash('操作成功');return redirect()->back();
         }
         catch(Exception $e) { return redirect()->back()->withErrors('操作失败'); }
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
        $useful=Useful_news::find($id);
        $req=$request->all();
        $news=$req['news'];
        if ($useful) {
            $useful['title']=$news['title'];
            $useful['content']=$news['content'];
            $useful['isrepeats']=$news['isrepeats'];
            $useful['author']=$news['author'];
            $useful['firstwebsite']=$news['firstwebsite'];
            $useful['sitetype']=$news['sitetype'];
            $useful['keywords']=$news['keywords'];
            $useful['court']=$news['court'];
            $useful['transmit']=$news['transmit'];
            $useful['visitnum']=$news['visitnum'];
            $useful['replynum']=$news['replynum'];
            $useful['starttime']=$news['starttime'];
            $useful['orientation']=$news['orientation'];
            $useful['yuqinginfo']=$news['yuqinginfo'];
            $useful['subject_id']=$news['subject_id'];
            $useful['casetype_id']=$news['casetype_id'];
            $useful['abstract']=$news['abstract'];
            $useful['isedit']=1;
             if (isset($news['areacode2'])&&$news['areacode2']!=null)
            $useful['areacode']=$news['areacode2'];
             if ($news['areacode2']==null&&$news['areacode1']!=null)  $useful['areacode']=$news['areacode1'];
            $useful->save();
            flash('操作成功');
            return redirect()->route('person.lists');//redirect()->back();
        }
        else return redirect()->back()->withErrors('操作失败');
    }

    /**
     * Remove the specified resource from storage.
     *已经提交到审核的新闻不给删除
     * $id为空时可能为批量删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id=null)
    {
       if ($id)
       {
           $news=Useful_news::find($id);
         //  dd($news);
           if ($news!=null&&$news['tag']==0)
           {
                $news->delete();
               flash('操作成功');return redirect()->back();
           }
           else
               return redirect()->back()->withErrors('该新闻您已提交，不可以删除');

       }
       else
       {   //批量删除
           $req=$request->all();
           $newsid=$req['newsid'];
           try{
               $num=Useful_news::whereIn('id',explode(',',$req["newsid"]))->where('tag','0')->delete();
               flash('操作成功');
               return redirect()->back();
           }
          catch(Exception $e) { return redirect()->back()->withErrors('操作失败'); }
       }
    }
    /*审核新闻搜索*/
    public function verify_search(Request $request){
        $req=$request->all();
        $data["time1"] = $req['time1'] == null ? "" : $req['time1'];
        $data["time2"] = $req['time2'] == null ? "" : $req['time2'];
        $data["title"] = $req['title'] == null ? "" : $req['title'];
        $data["court"] = $req['court'] == null ? "" : $req['court'];
        $data["orientation"] = $req['orientation'] == null ? "" : $req['orientation'];
        $data["subject_id"] = $req['subject'];
        $data["tag"] = $req['tag'];
        if ($data["time1"]=""&&$data["time2"]=""&&$data["title"]=""&&$data["court"]=""&&$data["orientation"]=""&&$data["subject_id"]="all"&&$data["tag"]=="all")
            return redirect()->route('verify.lists');
        $sql="select `id`, `title`, `tag`,`author`,`court`, `orientation`, `created_at`, `keywords` from `useful_news` WHERE ";
        if ($data["title"]!='')
            $sql=$sql."title like '%".$data["title"]."%' and ";
        if ( $data["court"]!='')
            $sql=$sql."court like '%". $data["court"]."%' and ";
        if ( $data["orientation"]!='')
            $sql=$sql."orientation='". $data["orientation"]."' and ";
        if ( $data["subject_id"]==null) $sql=$sql."subject_id is null and ";
        if ( $data["subject_id"]!=null&& $data["subject_id"]!="all")
            $sql=$sql."subject_id='". $data["subject_id"]."' and ";
        if ( $data["time1"]!=""&& $data["time2"]!="")
            $sql=$sql."`starttime` between '".$data["time1"]."' and '".$data["time2"]."' and ";
         if ($data["tag"]!="all")
        $sql=$sql."`tag` ='".$data["tag"]."' order by `created_at` desc limit 5000";
         else $sql=$sql."`tag` !='0' order by `created_at` desc limit 5000";
        $newslist=DB::select($sql);
        $subjects=Subject::all();
        return view('admin.news.verify',compact('newslist','subjects','data'));

    }
    /*我的新闻搜索*/
    public function person_search(Request $request)
    {
        $req=$request->all();
        if (!$request->has('page'))
        {
        $data["time1"] =  $req['time1'];
        $data["time2"] =  $req['time2'];
        $data["title"] = $req['title'];
        $data["court"] =  $req['court'];
        $data["orientation"] = $req['orientation'];
        $data["subject_id"]=$req["subject"];
            $request->session()->put('person', $data);
        }
        else
        {
            $sessions = $request->session()->all();
            $data= $sessions["person"];
        }
        if ($data["time1"]==null&&$data["time2"]==null&&$data["title"]==null&&$data["court"]==null&&$data["orientation"]==null&&$data["subject_id"]=="all")
            return redirect()->route('person.lists');
        $sql="select `id`, `title`,`isedit`, `author`,`tag`, `orientation`, `created_at`, `keywords` from `useful_news` WHERE ";
        if ($data["title"]!=null&&$data["title"]!='')
            $sql=$sql."title like '%".$data["title"]."%' and ";
        if ($data["court"]!=null&&$data["court"]!='')
            $sql=$sql."court like '%".$data["court"]."%' and ";
        if ($data["orientation"]!=null&&$data["orientation"]!='')
            $sql=$sql."orientation='".$data["orientation"]."' and ";
        if ( $data["subject_id"]==null) $sql=$sql."subject_id is null and ";
        if ( $data["subject_id"]!=null&& $data["subject_id"]!="all")
            $sql=$sql."subject_id='". $data["subject_id"]."' and ";
        if ($data["time1"]!=null&&$data["time2"]!=null)
            $sql=$sql."`starttime` between '".$data["time1"]."' and '".$data["time2"]."' and ";
        $id=Auth::guard('admin')->id();
        $sql=$sql."`admin_id` = '".$id."' order by `created_at` desc limit 5000";
        $subjects=Subject::all();
        if ($request->has('page')) {
            $current_page = $request->input('page');
            $current_page = $current_page <= 0 ? 1 :$current_page;
        } else {
            $current_page = 1;
        }
        $list=DB::select($sql);
        $perPage = 50;
        $item = array_slice($list, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($list);

        $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        $newslist =$paginator->toArray()['data'];
        return view('admin.news.person',compact('newslist','paginator','subjects','data'));
    }
    /*news搜索新闻*/
    public  function search(Request $request)
    {
        $req = $request->all();

        if (empty($req)) return redirect()->route('news.lists');
        if (!$request->has('page'))
        {
        $data["title"] = $req['title'] == null ? "" : $req['title'];
        $data["time1"] = $req['time1'] == null ? "" : $req['time1'];
        $data["time2"] = $req['time2'] == null ? "" : $req['time2'];
        $data["orientation"] = $req['orientation'] == null ? "" : $req['orientation'];
        $data["firstwebsite"] = $req['firstwebsite'] == null ? "" : $req['firstwebsite'];
        $request->session()->put('search', $data);
        }
        else
        {
            $sessions = $request->session()->all();
            $data= $sessions["search"];
        }
        if ($data["time1"]==""&&$data["time2"]==""&&$data["title"]==""&& $data["orientation"]==""&&$data["firstwebsite"]=="")
         return redirect()->route('news.lists');
        $sql="select `id`,`abstract`, `title`, `author`, `orientation`, `created_at`, `keywords`,`starttime` from `news` WHERE ";
        $str='';
        if ($data["orientation"]!='')
            $str=$str."orientation='".$data["orientation"]."'";
        if ( $data["title"]!='')
        {
            if ($str!='') $str=$str.' and ';
                $str=$str."title like '%". $data["title"]."%'";
        }
        if ( $data["firstwebsite"]!=''){
            if ($str!='') $str=$str.' and ';
            $str=$str."firstwebsite='". $data["firstwebsite"]."'";
        }
        if ($data["time1"]!=''&&$data["time2"]!='')
        {
            if (!strtotime($data["time1"])||!strtotime($data["time2"]))return redirect()->back()->withErrors('时间输入不正确');
            if ($str!='') $str=$str.' and ';
            $str=$str."`starttime` between '".$data["time1"]."' and '".$data["time2"]."'";
        }
        $sql=$sql.$str;
        $sql=$sql."order by `starttime` desc";
        if ($request->has('page')) {
            $current_page = $request->input('page');
            $current_page = $current_page <= 0 ? 1 :$current_page;
        } else {
            $current_page = 1;
        }
        $list=DB::select($sql);
        $perPage = 200;

        $item = array_slice($list, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($list);

        $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        $newslist =$paginator->toArray()['data'];
        return view('admin.news.lists',compact('newslist','paginator','data'));

    }
    /*通过审核的新闻进行搜索*/
    public  function passed_search(Request $request)
    {
        $req=$request->all();
        if (!$request->has('page')){
        $data["time1"] =  $req['time1'];
        $data["time2"] =  $req['time2'];
        $data["title"] = $req['title'];
        $data["court"] =  $req['court'];
        $data["orientation"] = $req['orientation'];
        $data["subject_id"]=$req["subject"];
        $data["tag"]=$req["tag"];
        $request->session()->put('passed', $data);
       }
      else
      {
        $sessions = $request->session()->all();
        $data= $sessions["search"];
      }
        $sql="select `id`, `title`, `author`, `orientation`, `created_at`, `keywords`,`reportform_id` from `useful_news` WHERE ";
        if ($data["title"] !=null&&$data["title"] !='')
            $sql=$sql."title like '%".$data["title"] ."%' and ";
        if ($data["court"]!=null&&$data["court"]!='')
            $sql=$sql."court like '%".$data["court"]."%' and ";
        if ($data["orientation"]!=null&&$data["orientation"]!='')
            $sql=$sql."orientation='".$data["orientation"]."' and ";
        if ($data["subject_id"]==null) $sql=$sql."subject_id is null and ";
        if ($data["subject_id"]!=null&&$data["subject_id"]!="all")
            $sql=$sql."subject_id='".$data["subject_id"]."' and ";
        if ($data["time1"]!=null&&$data["time2"] !=null)
            $sql=$sql."`starttime` between '".$data["time1"]."' and '".$data["time2"] ."' and ";
        if ($data["tag"]!=null&&$data["tag"]!='')
            $sql=$sql."`tag` = '".$data["tag"]." and reportform_id is null' order by `created_at` desc limit 5000";
        else
            $sql=$sql."`tag` = '1' order by `created_at` desc limit 5000";
        if ($request->has('page')) {
        $current_page = $request->input('page');
        $current_page = $current_page <= 0 ? 1 :$current_page;
       } else {
        $current_page = 1;
       }
          $list=DB::select($sql);
          $subjects=Subject::all();
        $perPage = 100;
        $item = array_slice($list, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($list);
        $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        $newslist =$paginator->toArray()['data'];
        return view('admin.news.passed',compact('newslist','paginator','subjects','data'));


    }
    /*提交到三报的新闻进行搜索*/
    public  function submit_search(Request $request)
    {
        $req=$request->all();
        if (!$request->has('page')){
        $data["time1"] =  $req['time1'];
        $data["time2"] =  $req['time2'];
        $data["title"] = $req['title'];
        $data["court"] =  $req['court'];
        $data["orientation"] = $req['orientation'];
        $data["subject_id"]=$req["subject"];
        $request->session()->put('submit', $data);
        }
      else
         {
        $sessions = $request->session()->all();
        $data= $sessions["submit"];
        }
        $sql="select `useful_news`.`id`, `useful_news`.`title`,`useful_news`.`abstract`, `useful_news`.`firstwebsite`,`useful_news`.`weekform_id`, `useful_news`.`tag`, `useful_news`.`created_at`, `useful_news`.`starttime`, `useful_news`.`keywords`, `useful_news`.`reportform_id`, `admins`.`username` from `useful_news` left join `admins` on `useful_news`.`admin_id` = `admins`.`id` where ";
        if ($data["title"]!=null&&$data["title"]!='')
            $sql=$sql."title like '%".$data["title"]."%' and ";
        if ($data["court"]!=null&&$data["court"]!='')
            $sql=$sql."court like '%".$data["court"]."%' and ";
        if ($data["orientation"]!=null&&$data["orientation"]!='')
            $sql=$sql."orientation='".$data["orientation"]."' and ";
        if ( $data["subject_id"]==null) $sql=$sql."subject_id is null and ";
        if ( $data["subject_id"]!=null&& $data["subject_id"]!="all")
            $sql=$sql."subject_id='". $data["subject_id"]."' and ";
        if ($data["time1"] !=null&&$data["time2"] !=null)
            $sql=$sql."`starttime` between '".$data["time1"] ."' and '".$data["time2"] ."' and ";
            $sql=$sql."`tag` = '1' and reportform_id is not null order by `created_at` desc limit 5000";
        if ($request->has('page')) {
            $current_page = $request->input('page');
            $current_page = $current_page <= 0 ? 1 :$current_page;
        } else {
            $current_page = 1;
        }
        $list=DB::select($sql);
        $subjects=Subject::all();
        $perPage = 100;
        $item = array_slice($list, ($current_page-1)*$perPage, $perPage); //注释1
        $total = count($list);
        $paginator =new LengthAwarePaginator($item, $total, $perPage, $current_page, [
            'path' => Paginator::resolveCurrentPath(),  //注释2
            'pageName' => 'page',
        ]);
        $newslist =$paginator->toArray()['data'];
        return view('admin.news.submit',compact('newslist','paginator','subjects','data'));
    }
}

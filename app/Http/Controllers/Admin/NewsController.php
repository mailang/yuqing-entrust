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
            ->orderByDesc('created_at')
            ->get($filed);
        return view('admin.news.person',compact('newslist','subjects'));
    }
    /*查看搜索新闻列表*/
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
            $time1=date("Y-m-d H:i:s",strtotime('-2 hour'));
            $time2=date("Y-m-d H:i:s");
            $newslist=DB::table('news')->whereBetween('starttime',[$time1,$time2])
              ->orderByDesc('starttime')
             ->get( $filed);
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
    /* 获取已提交到早报的新闻列表
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
        $filed=['useful_news.id','useful_news.abstract','useful_news.title','useful_news.author','useful_news.orientation','useful_news.created_at','useful_news.updated_at','useful_news.keywords','useful_news.reportform_id','admins.username'];
        $newslist=DB::table('useful_news')->leftJoin('admins', 'useful_news.admin_id', '=', 'admins.id')
                ->where('tag','=','1')
            ->where('reportform_id','!=','null')
                ->orderByDesc('created_at')
               ->limit(10000)
                ->get($filed);
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
                ->where('tag','=','1')
                ->orderByDesc('created_at')
                ->limit(10000)
                ->get($filed);
            return view('admin.news.passed',compact('newslist','subjects'));
        }
    }
    /*
     * 获取需要审核的新闻列表
     */
    public function verify()
    {
            $subjects=Subject::all();
            $filed=['id','title','tag','author','orientation','created_at','keywords'];
            $newslist=DB::table('useful_news')
                ->where('tag','<','0')
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
            $useful['sitetype']=$news['sitetype'];
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
        $time1=$req['time1'];
        $time2=$req['time2'];
        $title=$req['title'];
        $court=$req['court'];
        $orientation=$req['orientation'];
        $subject_id=$req["subject"];
        $tag=$req["tag"];

        $sql="select `id`, `title`, `tag`,`author`, `orientation`, `created_at`, `keywords` from `useful_news` WHERE ";
        if ($title!=null&&$title!='')
            $sql=$sql."title like '%".$title."%' and ";
        if ($court!=null&&$court!='')
            $sql=$sql."court like '%".$court."%' and ";
        if ($orientation!=null&&$orientation!='')
            $sql=$sql."orientation='".$orientation."' and ";
        if ($subject_id==null) $sql=$sql."subject_id is null and ";
        if ($subject_id!=null&&$subject_id!="all")
            $sql=$sql."subject_id='".$subject_id."' and ";
        if ($time1!=null&&$time2!=null)
            $sql=$sql."`starttime` between '".$time1."' and '".$time2."' and ";
         if ($tag!="all")
        $sql=$sql."`tag` ='".$tag."' order by `created_at` desc limit 5000";
         else $sql=$sql."`tag` !='0' order by `created_at` desc limit 5000";
        $newslist=DB::select($sql);
        $subjects=Subject::all();
        return view('admin.news.verify',compact('newslist','subjects'));

    }
    /*我的新闻搜索*/
    public function person_search(Request $request)
    {
        $req=$request->all();
        $time1=$req['time1'];
        $time2=$req['time2'];
        $title=$req['title'];
        $court=$req['court'];
        $orientation=$req['orientation'];
        $subject_id=$req["subject"];

        $sql="select `id`, `title`, `author`,`tag`, `orientation`, `created_at`, `keywords` from `useful_news` WHERE ";
        if ($title!=null&&$title!='')
            $sql=$sql."title like '%".$title."%' and ";
        if ($court!=null&&$court!='')
            $sql=$sql."court like '%".$court."%' and ";
        if ($orientation!=null&&$orientation!='')
            $sql=$sql."orientation='".$orientation."' and ";
        if ($subject_id==null) $sql=$sql."subject_id is null and ";
        if ($subject_id!=null&&$subject_id!="all")
            $sql=$sql."subject_id='".$subject_id."' and ";
        if ($time1!=null&&$time2!=null)
            $sql=$sql."`starttime` between '".$time1."' and '".$time2."' and ";
        $id=Auth::guard('admin')->id();
        $sql=$sql."`admin_id` = '".$id."' order by `created_at` desc limit 5000";
        $newslist=DB::select($sql);
        $subjects=Subject::all();
        return view('admin.news.person',compact('newslist','subjects'));

    }
    /*news搜索新闻*/
    public  function search(Request $request)
    {
        $req=$request->all();
       if (empty($req))return redirect()->route('news.lists');
        $time1=$req['time1']==null?"":$req['time1'];
        $time2=$req['time2']==null?"":$req['time2'];
        $title=$req['title']==null?"":$req['title'];
        $orientation=$req['orientation']==null?"":$req['orientation'];
        $firstwebsite=$req['firstwebsite']==null?"":$req['firstwebsite'];
        if ($time1==""&&$time2==""&&$title==""&&$orientation==""&&$firstwebsite=="")
        return redirect()->back();
        $sql="select `id`,`abstract`, `title`, `author`, `orientation`, `created_at`, `keywords`,`starttime` from `news` WHERE ";
        $str='';
        if ($orientation!='')
            $str=$str."orientation='".$orientation."'";
        if ($title!='')
        {
            if ($str!='') $str=$str.' and ';
                $str=$str."title like '%".$title."%'";
        }
        if ($firstwebsite!=''){
            if ($str!='') $str=$str.' and ';
            $str=$str."firstwebsite='".$firstwebsite."'";
        }
        if ($time1!=''&&$time2!='')
        {
            if (!strtotime($time1)||!strtotime($time2))return redirect()->back()->withErrors('时间输入不正确');
            if ($str!='') $str=$str.' and ';
            $str=$str."`starttime` between '".$time1."' and '".$time2."'";
        }
        $sql=$sql.$str;
        $sql=$sql."order by `created_at` desc limit 5000";
        $newslist=DB::select($sql);
      //  $subjects=Subject::all();
        return view('admin.news.lists',compact('newslist'));

    }
    /*通过审核的新闻进行搜索*/
    public  function passed_search(Request $request)
    {
        $req=$request->all();
        $time1=$req['time1'];
        $time2=$req['time2'];
        $title=$req['title'];
        $court=$req['court'];
        $orientation=$req['orientation'];
        $subject_id=$req["subject"];
        $tag=$req["tag"];

        $sql="select `id`, `title`, `author`, `orientation`, `created_at`, `keywords`,`reportform_id` from `useful_news` WHERE ";
        if ($title!=null&&$title!='')
            $sql=$sql."title like '%".$title."%' and ";
        if ($court!=null&&$court!='')
            $sql=$sql."court like '%".$court."%' and ";
        if ($orientation!=null&&$orientation!='')
            $sql=$sql."orientation='".$orientation."' and ";
        if ($subject_id==null) $sql=$sql."subject_id is null and ";
        if ($subject_id!=null&&$subject_id!="all")
            $sql=$sql."subject_id='".$subject_id."' and ";
        if ($time1!=null&&$time2!=null)
            $sql=$sql."`starttime` between '".$time1."' and '".$time2."' and ";
        if ($tag!=null&&$tag!='')
            $sql=$sql."`tag` = '".$tag."' order by `created_at` desc limit 5000";
        else
            $sql=$sql."`tag` = '1' order by `created_at` desc limit 5000";
          $newslist=DB::select($sql);
          $subjects=Subject::all();
        return view('admin.news.passed',compact('newslist','subjects'));


    }
    /*提交到早报的新闻进行搜索*/
    public  function submit_search(Request $request)
    {
        $req=$request->all();
        $time1=$req['time1'];
        $time2=$req['time2'];
        $title=$req['title'];
        $court=$req['court'];
        $orientation=$req['orientation'];
        $subject_id=$req["subject"];
        $sql="select `useful_news`.`id`, `useful_news`.`title`,`useful_news`.`abstract`, `useful_news`.`author`, `useful_news`.`orientation`, `useful_news`.`created_at`, `useful_news`.`updated_at`, `useful_news`.`keywords`, `useful_news`.`reportform_id`, `admins`.`username` from `useful_news` left join `admins` on `useful_news`.`admin_id` = `admins`.`id` where ";
        if ($title!=null&&$title!='')
            $sql=$sql."title like '%".$title."%' and ";
        if ($court!=null&&$court!='')
            $sql=$sql."court like '%".$court."%' and ";
        if ($orientation!=null&&$orientation!='')
            $sql=$sql."orientation='".$orientation."' and ";
        if ($subject_id==null) $sql=$sql."subject_id is null and ";
        if ($subject_id!=null&&$subject_id!="all")
            $sql=$sql."subject_id='".$subject_id."' and ";
        if ($time1!=null&&$time2!=null)
            $sql=$sql."`starttime` between '".$time1."' and '".$time2."' and ";
            $sql=$sql."`tag` = '1' order by `created_at` desc limit 5000";
        $newslist=DB::select($sql);
        $subjects=Subject::all();
        return view('admin.news.submit',compact('newslist','subjects'));


    }
}

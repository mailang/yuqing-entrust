<?php

namespace App\Http\Controllers\Admin;

use App\Models\Address;
use App\Models\casetype;
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

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *用户查看个人添加的新闻
     * @return \Illuminate\Http\Response
     */
    public function  person($id=null)
    {
        $subjects=Subject::all();
        $filed=['id','title','author','orientation','created_at','tag'];
        $admin_id=Auth::guard('admin')->id();
        if ($id)
        {
            $newslist=DB::table('useful_news')->where('admin_id',$admin_id)
                ->where('subject_id',$id)
                ->orderByDesc('created_at')
                ->get($filed);
        }else{
            $newslist=DB::table('useful_news')->where('admin_id',$admin_id)
                ->whereNull('subject_id')
                ->orderByDesc('created_at')
                ->get($filed);
        }
        return view('admin.news.person',compact('newslist','subjects','id'));
    }
    /*查看搜索新闻列表*/
    public function index($id=null)
    {
        if ($id)
        {
            $news=News::find($id);
            return view('admin.news.see',compact('news'));
        }else
        {
            $filed=['id','title','author','orientation','firstwebsite','keywords'];
            $time1=date("Y-m-d H:i:s",strtotime('-2 day'));
            $time2=date("Y-m-d H:i:s");
            $newslist=DB::table('news')->whereBetween('starttime',[$time1,$time2])->get( $filed);
            $subjects=Subject::all();
            return view('admin.news.lists',compact('newslist','subjects'));
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id=null)
    {
        $subjects=Subject::all();
        $casetypes=casetype::all();
        $areacode=Address::all()->toJson();
        if ($id)
        {
            $news=Useful_news::find($id);
            return view('admin.news.edit',compact('news','subjects','casetypes','areacode'));
        }else return view('admin.news.add',compact('subjects','casetypes','areacode'));
    }
    /*
     * 获取审核通过的新闻列表
     */
    public  function passed($id=null)
    {
        $subjects=Subject::all();
        $filed=['id','title','author','orientation','created_at','keywords'];
         $newslist=DB::table('useful_news')
                ->where('tag','>','0')
                ->limit(10000)
                ->orderByDesc('created_at')
                ->get($filed);
            return view('admin.news.passed',compact('newslist','subjects'));

    }
    /*
     * 获取需要审核的新闻列表
     */
    public function verify($id=null)
    {
        $subjects=Subject::all();
        $filed=['id','title','author','orientation','created_at','keywords'];
        if ($id)
        {
            $newslist=DB::table('useful_news')
                ->where('subject_id',$id)
                ->where('tag','-1')
                ->orWhere('tag','3')
                ->orderByDesc('created_at')
                ->get($filed);
            return view('admin.news.verify',compact('newslist','subjects','id'));
        }else{
            $newslist=DB::table('useful_news')
                ->orWhereNull('subject_id')
                ->where('tag','-1')
                ->orWhere('tag','3')
            ->orderByDesc('created_at')
            ->get($filed);
            return view('admin.news.verify',compact('newslist','subjects'));
        }

    }
    /*审核新闻*/
    public function verify_option( Request $request,$id)
    {
      $req=$request->all();
      $tag=$req["tag"];
      $verify_option=$req["verify_option"];
      $num=Useful_news::find($id)
          ->update(['tag'=>$tag,'verify_option'=>$verify_option]);
      if ($num){
      flash('操作成功');
        return redirect()->back();}
        else     return redirect()->back()->withErrors('操作失败');
    }
    /*进入审核页面*/
     public function  option_edit($id)
     {
         if ($id) {
             $news = Useful_news::find($id);
             return view('admin.news.examine', compact('news'));
         }
     }
    /*
     * 将新闻加到useful_news新闻中
     * */
    public function useful_news(Request $request,$id)
    {
        if ($id){
            $news=News::find($id)->toArray();
            $useful=new Useful_news();
            $useful['admin_id']=Auth::guard('admin')->id();
            $useful['subject_id']=$request->all()['subject'];
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
            $useful->save();
             if ($useful){
                flash("操作成功");
                return redirect()->back();
            }else return redirect()->back()->withErrors('操作失败');
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
        $news['areacode']=$news['areacode2'];
        $use=Useful_news::create($news);
       if ($use)
       {
           flash('操作成功');return redirect()->back();
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
         //dd('['.$req["newsid"].']');

         try{
             $num=Useful_news::whereIn('id',explode(',',$req["newsid"]))->update(['tag'=>'-1']);
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
        //dd($news);
        if ($useful) {
            $useful['title']=$news['title'];
            $useful['content']=$news['content'];
            $useful['link']=$news['link'];
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
            $useful['areacode']=$news['areacode2'];
            $useful->save();
            flash('操作成功');
            return redirect()->back();
        }
        else return redirect()->back()->withErrors('操作失败');
    }

    /**
     * Remove the specified resource from storage.
     *已经提交到审核的新闻不给删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
       if ($id)
       {
           $news=Useful_news::find($id);
         //  dd($news);
           if ($news!=null&&$news['tag']==0)
           {
                $news->delete();
               flash('操作成功能');return redirect()->back();
           }
           else
               return redirect()->back()->withErrors('该新闻您已提交，不可以删除');

       }
    }
    /*
    *news搜索新闻
    */
    public  function search(Request $request)
    {
        $req=$request->all();
        $time1=$req['time1'];
        $time2=$req['time2'];
        if ($time1!=''&&$time2!='')
        {
            $filed=['id','title','author','orientation','firstwebsite','keywords'];
            $newslist=DB::table('news')->whereBetween('starttime',[$time1,$time2])->get( $filed);
            $subjects=Subject::all();
            return view('admin.news.lists',compact('newslist','subjects'));
        }
        else return redirect()->back()->withErrors('时间输入不正确');

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

        $sql="select `id`, `title`, `author`, `orientation`, `created_at`, `keywords` from `useful_news` WHERE ";
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
          $sql=$sql."`tag` > '0' order by `created_at` desc limit 10000";
          DB::select($sql);
          flash('操作成功');return redirect()->back();



    }
}

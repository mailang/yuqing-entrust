<?php

namespace App\Http\Controllers\Admin;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Useful_news;
use App\Models\News;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function  person()
    {
        $filed=['id','title','author','orientation','created_at','keywords'];
        //用户查看个人添加的新闻
        $admin=Auth::guard('admin')->user();
        $newslist=DB::table('useful_news')->where('admin_id',$admin->id)
            ->orderByDesc('created_at')
            ->get($filed);
        return view('admin.news.person',compact('newslist'));

    }
    public function index()
    {
            $filed=['id','title','author','orientation','firstwebsite','keywords'];
            $time1=date("Y-m-d",strtotime('-2 day'));
            $time2=date("Y-m-d");
            $newslist=DB::table('news')->whereBetween('starttime',[$time1,$time2])->get( $filed);
        return view('admin.news.lists',compact('newslist'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if ($id)
        {
            $news=News::find($id);
            return view('admin.news.edit',compact('news'));
        }else return view('admin.news.add');
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
       //
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

@extends('layouts.newslist')
@section('title')
    <h1>
        首页
        <small>新闻管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>新闻管理</a></li>
        <li class="active">列表展示</li>
    </ol>
@endsection
@section('content')
    <style type="text/css">.active{color: #444;background: #f7f7f7; }a{color:#0a0a0a;}</style>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>文章标题</th>
                            <th>首发网站</th>
                            <th>倾向性</th>
                            <th>添加时间</th>
                            <th  data-sortable="false" width="40px">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newslist as $news)<tr>
                            <td><h3><a href="{{route('passed.lists',$news->id)}}" target="_blank" class="text-success ">{{strlen($news->title)>60?mb_substr($news->title,0,50).'...':$news->title}}</a></h3>
                            <br>   <div style=" font-size: 16px;">
                                    {!!html_entity_decode($news->abstract)!!}
                                </div></td>
                            <td>{{$news->firstwebsite}}</td>
                            <td>{{$news->orientation}}</td>
                            <td>{{$news->created_at}}</td>
                            <td>
                                <a href="{{route('passed.lists',$news->id)}}" class="text-success" target="_blank">查看</a>
                            </td>
                        </tr>@endforeach
                        </tbody>
                    </table>
                    <table width="100%"><tr><td>当前页{{$newslist->currentPage()}}共计{{$newslist->lastPage()}}页,总记录数{{$newslist->total()}}条 </td>
                            <td style="text-align: right"> {{$newslist->links()}}</td>
                        </tr></table>
                </div></div></div></div>

@endsection
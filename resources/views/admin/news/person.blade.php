@extends('layouts.master')
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

    <div class="row page-title-row" style="margin:5px;">
        <div class="col-md-6">

        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('useful_news.person.add')}}" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i> 添加新闻
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div>
                        <ul class="nav navbar-nav">
                             @foreach($subjects as $subject)
                            <li class="active"><a href="{{route('person.lists',$subject->id)}}">{{$subject->subject}}</a></li>
                             @endforeach
                        </ul>
                    </div>
                    <table id="tags-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false">&nbsp;</th>
            <th>文章标题</th>
            <th>作者</th>
            <th>倾向性</th>
            <th>添加时间</th>
            <th  data-sortable="false">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
             <td></td>
            <td>{{$news->title}}</td>
            <td>{{$news->author}}</td>
            <td>{{$news->orientation}}</td>
            <td>{{$news->created_at}}</td>
            <td><a href="{{route('useful_news.add',array('id'=>$news->id))}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>
            </td>
        </tr>@endforeach
        </tbody>
    </table>
                </div></div></div></div>

@endsection
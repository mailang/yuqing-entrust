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
    <style type="text/css">.active{color: #444;background: #f7f7f7; }a{color:#0a0a0a;}</style>
    <script type="text/javascript">$(function () {
            $('.nav').click(function () {
                $(this).addClass('active').siblings().removeClass('active');
            });
        })</script>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <div>
                        <ul class="nav navbar-nav">
                            @foreach($subjects as $key=>$subject)
                                @if((isset($id)&&$id==$subject->id)||(!isset($id)&&$key==0))
                                    <li class="active"><a href="{{route('verify.lists',$subject->id)}}">{{$subject->subject}}</a></li>
                                @else
                                    <li><a href="{{route('verify.lists',$subject->id)}}">{{$subject->subject}}</a></li>
                                @endif
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
                            <td><a href="{{route('useful_news.person.add',$news->id)}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>
                            </td>
                        </tr>@endforeach
                        </tbody>
                    </table>
                </div></div></div></div>

@endsection
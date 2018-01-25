@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>栏目管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>栏目管理</a></li>
        <li class="active">列表展示</li>
    </ol>
@endsection
@section('content')
    <table id="table" class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>文章标题</th>
            <th>作者</th>
            <th>倾向性</th>
            <th>关键词</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
            <td>{{$news->title}}</td>
            <td>{{$news->author}}</td>
            <td>{{$news->orientation}}</td>
            <td>{{$news->firstwebsite}}</td>
            <td>{{$news->keywords}}</td>
            <td>
                <a href="#">加入早报</a>
            </td>
        </tr>
             @endforeach
        </tbody>
    </table>
@endsection
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
                <i class="fa fa-plus-circle"></i> 添加搜索栏
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false">&nbsp;<input type="checkbox" value="全选"></th>
            <th>文章标题</th>
            <th>作者</th>
            <th>倾向性</th>
            <th>关键词</th>
            <th  data-sortable="false">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
             <td><input type="checkbox" value="{{$news->id}}" name="news[]"></td>
            <td>{{$news->title}}</td>
            <td>{{$news->author}}</td>
            <td>{{$news->orientation}}</td>
            <td>{{$news->keywords}}</td>
            <td>
                <a href="#" attr="{{$news->id}}" onclick="javascript:addnews(this);">
                    <i class="fa fa-plus-circle"></i>
                    我的新闻</a>
            </td>
        </tr>@endforeach
        </tbody>
    </table></div></div></div></div>
    <script>
        function addnews(obj) {
            var id = $(obj).attr('attr');
            $('.newsForm').attr('action', '/admin/useful_news/store/' + id);
            $("#modal-news").modal();
        }
    </script>
    <div class="modal fade" id="modal-news" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">添加我的新闻</h4>
                </div>
                <form id="newsForm" class="newsForm" method="POST" action="">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="tag" class="col-md-3 control-label">选择专题</label>
                        <div class="col-md-5">
                       <select id="subject" class="form-control" name="subject">
                           <option value="2">司法执行</option>
                       </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>提交
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
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
@section('css')
<link type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
<script type="text/javascript" src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
<script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
<script src="{{asset('js/jquery.ui.datepicker-zh-CN.js.js')}}" charset="gb2312"></script>
<script src="{{asset('js/jquery-ui-timepicker-zh-CN.js')}}"></script>
<script type="text/javascript">
    $(function () {
        // 时间设置
        $('#time1').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
        $('#time2').datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
    });
</script>
@endsection
@section('content')
    <div class="row page-title-row" style="margin:5px;">
        <div class="row text-center">
            <form id="search" action="{{route('news.search')}}" method="post">  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="col-xs-3"> <label for="time1" class="input-group">起始时间：</label>
            <input placeholder="开始时间" type="text" class="form-control" name="time1" required="required" id="time1" autocomplete="off" value="{{date("Y-m-d H:i:s")}}" autofocus>
                  </div><div class="col-xs-3"><label for="time1" class="input-group">结束时间：</label>
                          <input placeholder="结束时间" type="text" class="form-control" name="time2" required="required" id="time2" autocomplete="off" value="{{date("Y-m-d H:i:s")}}" autofocus>
                            </div>
                <div class="col-xs-3"><label class="input-group">&nbsp;</label> <button class="btn btn-success btn-md">
                <i class="fa fa-search-plus"></i>搜索
                    </button></div></form>
        </div>        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false"></th>
            <th>文章标题</th>
            <th>作者</th>
            <th>倾向性</th>
            <th>关键词</th>
            <th  data-sortable="false">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
             <td></td>
            <td>{{$news->title}}</td>
            <td>{{$news->author}}</td>
            <td>{{$news->orientation}}</td>
            <td>{{$news->keywords}}</td>
            <td>
                <a href="#" attr="{{$news->id}}" onclick="javascript:addnews(this);">
                    <i class="fa fa-plus-circle"></i>我的新闻</a>
               | <a href="{{route('news.lists',$news->id)}}">查看</a>
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
                                <option value="" selected>--无--</option>
                           @foreach($subjects as $subject)
                               <option value="{{$subject->id}}">{{$subject->subject}}</option>
                           @endforeach
                       </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>提交
                        </button></div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
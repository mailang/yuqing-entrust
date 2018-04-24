@extends('layouts.newslist')
@section('title')
    <h1>
        首页
        <small>统计管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>统计管理</a></li>
        <li class="active">统计新闻</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">新闻来源统计</h3>
                    </div>
                    <div class="panel-body">
                        <div  class="tab-content">
                            <div class="active tab-pane">
                                <form class="form-inline" role="form" action="{{route('tongji.source_search')}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">起始时间</label> </span>
                                            <input placeholder="开始时间" type="text" class="form-control" name="time1" id="time1" autocomplete="off" value="{{$search["time1"]}}" autofocus>                    </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">结束时间</label> </span>
                                            <input placeholder="结束时间" type="text" class="form-control" name="time2" id="time2" autocomplete="off" value="{{$search["time2"]}}" autofocus>
                                        </div>
                                        <button class="btn btn-success btn-md">
                                            <i class="fa fa-search-plus"></i>搜索
                                        </button></div>
                                    <br><br>
                                </form>
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{$search["time1"]}}&nbsp;-&nbsp;{{$search["time2"]}} 舆情统计</h3>
                                </div>
                                <table id="tags-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th data-sortable="false" data-show="false"></th>
                                        <th data-sortable="false">来源</th>
                                        <th>网媒</th>
                                        <th class="hidden-sm">论坛</th>
                                        <th class="hidden-md">微博</th>
                                        <th class="hidden-md">微信</th>
                                        <th class="hidden-md">博客</th>
                                        <th class="hidden-sm">报刊</th>
                                        <th class="hidden-md">视频</th>
                                        <th class="hidden-md">APP</th>
                                        <th class="hidden-md">搜索</th>
                                        <th data-sortable="false">评论</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td></td>
                                        <td>全部</td>
                                        <td>{{$dblist->sum('wangmei')}}</td>
                                        <td>{{$dblist->sum('bbs')}}</td>
                                        <td>{{$dblist->sum('weibo')}}</td>
                                        <td>{{$dblist->sum('weixin')}}</td>
                                        <td>{{$dblist->sum('blog')}}</td>
                                        <td>{{$dblist->sum('paper')}}</td>
                                        <td>{{$dblist->sum('video')}}</td>
                                        <td>{{$dblist->sum('app')}}</td>
                                        <td>{{$dblist->sum('search')}}</td>
                                        <td>{{$dblist->sum('comment')}}</td>
                                    </tr>
                                  @foreach($dblist as $news)
                                      <tr><td></td>
                                          <td>{{$news['orientation']}}</td>
                                          <td>{{$news['wangmei']}}</td>
                                          <td>{{$news['bbs']}}</td>
                                          <td>{{$news['weibo']}}</td>
                                          <td>{{$news['weixin']}}</td>
                                          <td>{{$news['blog']}}</td>
                                          <td>{{$news['paper']}}</td>
                                          <td>{{$news['video']}}</td>
                                          <td>{{$news['app']}}</td>
                                          <td>{{$news['search']}}</td>
                                          <td>{{$news['comment']}}</td>
                                      </tr>
                                  @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div></div></div></div></div></div>

@endsection
@section('css')
    <link type="text/css" href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
    <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
    <script src="{{asset('js/jquery.ui.datepicker-zh-CN.js.js')}}" charset="gb2312"></script>
    <script src="{{asset('js/jquery-ui-timepicker-zh-CN.js')}}"></script>
    <script type="text/javascript">
        $(function() {
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
    <style type="text/css">
        label{width: 100px;text-align: right; margin-left: 8px;}
    </style>
@endsection
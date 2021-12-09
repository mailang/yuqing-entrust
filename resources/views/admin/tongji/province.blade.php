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
                        <h3 class="panel-title">区域倾向性新闻统计<font color="red">提交三报的新闻统计</font></h3>
                    </div>
                    <div class="panel-body">
                        <div  class="tab-content">
                            <div class="active tab-pane">
                                <form class="form-inline" role="form" action="{{route('tongji.province_search')}}" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="time1" class="col-md-3 control-label">起始时间</label> </span>
                                            <input placeholder="开始时间" type="text" class="form-control" name="time1" id="time1" autocomplete="off" value="" autofocus>                    </div>
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="time2" class="col-md-3 control-label">结束时间</label> </span>
                                            <input placeholder="结束时间" type="text" class="form-control" name="time2" id="time2" autocomplete="off" value="" autofocus>
                                        </div>
                                        <button class="btn btn-success btn-md">
                                            <i class="fa fa-search-plus"></i>搜索
                                        </button></div>
                                    <br><br>
                                </form>
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{date('Y年m月d日',strtotime($search["time1"]))}}&nbsp;-&nbsp;{{date('Y年m月d日',strtotime($search["time2"]))}}舆情统计</h3>
                                </div>
                                <table id="tags-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th data-sortable="false">&nbsp;</th>
                                        <th>区域</th>
                                        <th class="hidden-sm">舆情条数</th>
                                        <th class="hidden-md">负面条数</th>
                                        <th class="hidden-md">负面占比</th>
                                        <th class="hidden-md">正面条数</th>
                                        <th class="hidden-md">正面占比</th>
                                        <th class="hidden-md">中性条数</th>
                                        <th class="hidden-md">中性占比</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($dblist as $data)
                                        <tr>
                                            <td></td>
                                            <td>{{$data['province']}}</td>
                                            <td>{{$data['total']}}</td>
                                            <td>{{$data['fumian']}}</td>
                                            <td>{{round($data['fumian']/$data['total'],3)*100}}%</td>
                                            <td>{{$data['zhengmian']}}</td>
                                            <td>{{round($data['zhengmian']/$data['total'],3)*100}}%</td>
                                            <td>{{$data['zhongxing']}}</td>
                                            <td>{{round($data['zhongxing']/$data['total'],3)*100}}%</td>
                                        </tr>
                                    @endforeach
                                    @if(!$dblist->IsEmpty())
                                    <tr>
                                        <td></td>
                                        <td>全部</td>
                                        <td>{{$dblist->sum('total')}}</td>
                                        <td>{{$dblist->sum('fumian')}}</td>
                                        <td>{{round($dblist->sum('fumian')/$dblist->sum('total'),3)*100}}%</td>
                                        <td>{{$dblist->sum('zhengmian')}}</td>
                                        <td>{{round($dblist->sum('zhengmian')/$dblist->sum('total'),3)*100}}%</td>
                                        <td>{{$dblist->sum('zhongxing')}}</td>
                                        <td>{{round($dblist->sum('zhongxing')/$dblist->sum('total'),3)*100}}%</td>
                                    </tr>
                                    @endif
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
    <script src="{{asset('js/jquery.ui.datepicker-zh-CN.js')}}"></script>
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
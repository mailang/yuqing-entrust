@extends('layouts.master')
@section('css')
    <link type="text/css" href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
    <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
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
    <style type="text/css">
        label{width: 100px;text-align: right; margin-left: 8px;}
    </style>
@endsection
@section('title')
    <h1>
        首页
        <small>统计</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>新闻统计</a></li>
        <li class="active">个人新闻统计</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">

                <section class="content">
                    <div class="row">
                        <form class="form-inline" role="form" action="{{route('tongji.search.person')}}" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><label for="title" class="col-md-3 control-label">起始时间</label> </span>
                                    <input placeholder="开始时间" type="text" class="form-control" name="time1" id="time1" autocomplete="off" value="" autofocus>                    </div>
                                <div class="input-group">
                                    <span class="input-group-addon"><label for="title" class="col-md-3 control-label">结束时间</label> </span>
                                    <input placeholder="结束时间" type="text" class="form-control" name="time2" id="time2" autocomplete="off" value="" autofocus>
                                </div>
                                <button class="btn btn-success btn-md">
                                    <i class="fa fa-search-plus"></i>搜索
                                </button></div>
                            <br><br>
                        </form>
                        <!-- left column -->
                        <div class="col-md-6">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                @if(isset($search))
                                    <div class="box-header with-border">
                                        <h3 class="box-title">{{$search["time1"]}}至{{$search["time2"]}} 统计</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><label> 提交数：</label><span>{{$search["all"]==null?"0":$search["all"]}}</span></li>
                                        <li><label> 未审核：</label><span>{{$search["noverify"]==null?"0":$search["noverify"]}}</span></li>
                                        <li><label> 已审核：</label><span>{{$search["verify"]==null?"0":$search["verify"]}}</span></li>
                                        <li><label> 重复： </label><span>{{$search["repeat"]==null?"0":$search["repeat"]}}</span> </li>
                                        <li><label> 不合格：</label><span>{{$search["nopass"]==null?"0":$search["nopass"]}}</span></li>
                                        <li><label> 提交三报：</label><span>{{ $search["pass"]==null?"0":$search["pass"]}}</span></li>
                                    </ul>
                                @endif
                                @if(isset($day))
                                <div class="box-header with-border">
                                    <h3 class="box-title">近一天统计</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                <ul class="nav nav-pills nav-stacked">
                                    <li><label> 提交数：</label><span>{{$day["all"]==null?"0":$day["all"]}}</span></li>
                                    <li><label> 未审核：</label><span>{{$day["noverify"]==null?"0":$day["noverify"]}}</span></li>
                                    <li><label> 已审核：</label><span>{{$day["verify"]==null?"0":$day["verify"]}}</span></li>
                                    <li><label> 重复： </label><span>{{$day["repeat"]==null?"0":$day["repeat"]}}</span> </li>
                                    <li><label> 不合格：</label><span>{{$day["nopass"]==null?"0":$day["nopass"]}}</span></li>
                                    <li><label> 提交三报：</label><span>{{ $day["pass"]==null?"0":$day["pass"]}}</span></li>
                                </ul>
                               @endif
                            </div>
                        </div>
                        <!--/.col (left) -->
                        <!-- right column -->
                        @if(isset($week))
                        <div class="col-md-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">近一周统计</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                <ul class="nav nav-pills nav-stacked">
                                    <li><label> 提交数：</label><span>{{$week["all"]==null?"0":$week["all"]}}</span></li>
                                    <li><label> 未审核：</label><span>{{$week["noverify"]==null?"0":$week["noverify"]}}</span></li>
                                    <li><label> 已审核：</label><span>{{$week["verify"]==null?"0":$week["verify"]}}</span></li>
                                    <li><label> 重复： </label><span>{{$week["repeat"]==null?"0":$week["repeat"]}}</span> </li>
                                    <li><label> 不合格：</label><span>{{$week["nopass"]==null?"0":$week["nopass"]}}</span></li>
                                    <li><label> 提交早报：</label><span>{{ $week["pass"]==null?"0":$week["pass"]}}</span></li>
                                </ul>
                            </div>
                        </div>
                        @endif
                        <!--/.col (right) -->
                    </div>
                    <!-- /.row -->
                </section>

            </div></div></div>
@endsection
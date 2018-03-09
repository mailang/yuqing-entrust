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
@endsection
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
                    <form class="form-inline" role="form" action="{{route('verify.search')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                <input type="text" class="form-control" name="title" placeholder="文章标题"  id="title" autocomplete="off" value="" autofocus>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><label for="court" class="col-md-3 control-label">法院</label> </span>
                                <input type="text" class="form-control" name="court"  id="title" placeholder="法院" autocomplete="off" value="" autofocus>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><label for="orientation" class="col-md-3 control-label">倾向性</label> </span>
                                <select id="orientation" name="orientation" class="form-control">
                                    <option value="">--请选择--</option>
                                    <option value="正面">正面</option>
                                    <option value="中性">中性</option>
                                    <option value="负面">负面</option>
                                </select>
                            </div>
                            <div class="input-group">      <span class="input-group-addon"><label class="col-sm-3 control-label" for="subject">专题</label> </span>
                                <select id="subject" name="subject" class="form-control">
                                    <option value="all">--请选择--</option>
                                    <option value="">未分类</option>
                                    @foreach($subjects as $key=>$subject)
                                        <option>{{$subject->subject}}</option>
                                    @endforeach
                                </select>
                            </div></div>
                        <br> <br>
                        <div class="input-group">      <span class="input-group-addon"><label class="col-sm-3 control-label" for="tag">新闻状态</label> </span>
                            <select id="tag" name="tag" class="form-control">
                                <option value="all">--请选择--</option>
                                <option value="-2">不合格</option>
                                <option value="-1">未审核</option>
                                <option value="1">合格并提交</option>
                                <option value="2">重复</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">起始时间</label> </span>
                            <input placeholder="开始时间" type="text" class="form-control" name="time1" id="time1" autocomplete="off" value="" autofocus>                    </div>
                        <div class="input-group">
                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">结束时间</label> </span>
                            <input placeholder="结束时间" type="text" class="form-control" name="time2" id="time2" autocomplete="off" value="" autofocus>
                        </div>
                        <button class="btn btn-success btn-md">
                            <i class="fa fa-search-plus"></i>搜索
                        </button>
                    </form>
                    <table id="tags-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th  data-sortable="false">&nbsp;</th>
                            <th>文章标题</th>
                            <th>作者</th>
                            <th>倾向性</th>
                            <th>状态</th>
                            <th>添加时间</th>
                            <th  data-sortable="false">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($newslist as $news)<tr>
                            <td></td>
                            <td>{{strlen($news->title)>35?mb_substr($news->title,0,30).'...':$news->title}}</td>
                            <td>{{$news->author}}</td>
                            <td>{{$news->orientation}}</td>
                            <td>@switch($news->tag)
                                    @case(-1)  <span style="color:blue">未审核 </span>@break
                                    @case(0)未提交@break
                                    @case(1)<span style="color:#00a65a">合格</span>@break
                                    @case(2)<span style="color:#00a65a">重复</span>@break
                                    @case(-2)<span style="color:red">不合格 </span>@break
                                @endswitch</td>
                            <td>{{$news->created_at}}</td>

                            <td>@if($news->tag<0)
                                <a href="{{route('useful_news.option',$news->id)}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 审核</a>
                                @endif
                            </td>
                        </tr>@endforeach
                        </tbody>
                    </table>
                </div></div></div></div>

@endsection
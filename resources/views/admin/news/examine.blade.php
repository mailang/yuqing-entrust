@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>新闻管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>新闻管理</a></li>
        <li class="active">审核新闻</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">审核新闻</h3>
                    </div>
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#verify" data-toggle="tab">审核</a></li>
                            <li><a href="#useful_news" data-toggle="tab">查看新闻</a></li>
                        </ul><br>
                        <div class="tab-content">
                            <div class="tab-pane" id="useful_news">
                                <div><h3> {{$news->title}}</h3></div>
                                <div style="text-align: left;height: 20px;color:blue;font-size: 15px;font-style: normal;">
                                    <span><font style="color: red">作者: </font>{{$news->author}}</span> <span>|</span>
                                    <span><font style="color: red">涉及法庭:</font>{{$news->court}}</span> <span>|</span>
                                    <span><font style="color: red">属性:</font>{{$news->orientation}}</span> <span>|</span>
                                    <span><font style="color: red">首次发布时间:</font>{{$news->starttime}}</span>
                                </div>
                                <div style="text-align: left;height: 20px;color: blue;font-size: 15px;font-style: normal;">
                                    <span><font style="color: red">首发网站：</font>{{$news->firstwebsite}}</span>
                                    <span><font style="color: red">网站类型：</font>{{$news->sitetype}}</span>
                                    <span><font style="color: red">转发数：</font>{{$news->transmit}}</span>
                                    <span><font style="color: red">访问数：</font>{{$news->visitnum}}</span>
                                    <span><font style="color: red">回复数：</font>{{$news->replynum}}</span>
                                    <span><font style="color: red">预警等级：</font>{{$news->yuqinginfo}}</span>
                                </div>
                                <div style="text-align: left;color: blue;font-size: 14px;font-style: normal;">  <span>原链接：{{$news->link}}</span></div>
                                <div style="font-size: 15px;"><strong>摘要：</strong>{!!html_entity_decode($news->abstract)!!}</div>
                                <div><strong>原文：</strong>{!!html_entity_decode($news->content)!!}</div>
                            </div>
                            <div class="active tab-pane" id="verify">
                        <form class="form-horizontal" role="form" method="POST" action="{{route('useful_news.verify',$news->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                            <input type="text" class="form-control" name="title" required="required" id="title" autocomplete="off" value="{{$news->title}}" autofocus>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group"> <div class="row"><div class="col-xs-6">
                                        <div class="input-group">&nbsp;&nbsp;&nbsp;&nbsp;<font style="color: red">预警等级：</font>{{$news->yuqinginfo}}</div>
                                    </div></div></div>
                            <div class="form-group">
                                <label for="abstract" class="col-md-3 control-label"></label>
                                <div class="col-md-10">
                                    <span><strong>摘要:</strong></span>
                                    @if($news->abstract)
                                   {{$news->abstract}}
                                    @else 暂无摘要
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                     <span class="input-group-addon"> <strong>审核类型</strong> </span>
                                    <select id="tag" name="tag" class="form-control">
                                        <option value="1">合格</option>
                                        <option value="2">合格重复</option>
                                        <option value="3">重复</option>
                                        <option value="-2">不合格</option>
                                    </select>
                                </div></div>
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <input name="isrepeats" type="hidden" value="0">
                                            <input id="isrepeats" name="isrepeats" type="checkbox"
                                                    @if($news->isrepeats==1)checked @endif value="1">
                                             <label for="isrepeats">重复舆情</label>
                                        </div></div>
                                </div></div>
                            <div class="form-group">
                                <label for="abstract" class="col-md-3 control-label"></label>
                                <div class="col-md-10">
                                    <span><strong>审核意见:</strong></span>
                                    <textarea class="form-control" id="verify_option" name="verify_option" rows="3" type="text">
                                    </textarea>
                                </div>
                            </div>
                      <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        提交
                                    </button>
                                </div>
                            </div>
                        </form>
                            </div></div></div></div></div></div></div>
    <script>
          function btncheck (obj) {
                if($(obj).prop("checked"))
                {
                    $(obj).val(1);
                    alert("111");
                }

                else  $(obj).val(0);
            }

    </script>
@endsection
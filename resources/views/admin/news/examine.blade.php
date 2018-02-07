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
                                <div style="text-align: left;height: 20px;color: #b7b7b7;font-size: 13px;font-style: normal;">
                                    <span>作者: {{$news->author}}</span> <span>|</span>
                                    <span>涉及法庭:{{$news->court}}</span> <span>|</span>
                                    <span>属性:{{$news->orientation}}</span> <span>|</span>
                                    <span>首次发布时间:{{$news->starttime}}</span>
                                </div>
                                <div style="text-align: left;height: 20px;color: #b7b7b7;font-size: 13px;font-style: normal;">                                    <span>首发网站：{{$news->firstwebsite}}</span>
                                    <span>网站类型：{{$news->sitetype}}</span>
                                    <span>转发数：{{$news->transmit}}</span>
                                    <span>访问数：{{$news->visitnum}}</span>
                                    <span>回复数：{{$news->replynum}}</span>
                                </div>
                                <div style="text-align: left;height: 20px;color: #b7b7b7;font-size: 13px;font-style: normal;">  <span>原链接：{{$news->link}}</span></div>
                                <div><strong>摘要：</strong>{!!html_entity_decode($news->abstract)!!}</div>
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
                                        </div></div>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                           <a href="#" target="_blank">查看详情</a>
                                        </div></div>
                                </div>
                            </div>
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
                                        <option value="-2">不合格</option>
                                    </select>
                                </div></div></div></div>
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
@endsection
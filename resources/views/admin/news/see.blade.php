@extends('layouts.master')
@section('css')
    <script src="{{asset('js/jquery.linq.min.js')}}"></script>
    <script src="{{asset('js/jquery.json.min.js')}}"></script>
    <script src="{{asset('js/jquery.linq.min.js')}}"></script>
    <script src="{{asset('js/jquery.json.min.js')}}"></script>
    <link type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
    <script src="{{asset('js/jquery.ui.datepicker-zh-CN.js.js')}}" charset="gb2312"></script>
    <script src="{{asset('js/jquery-ui-timepicker-zh-CN.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            // 时间设置
            $('#starttime').datetimepicker({
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
        <li class="active">列表新闻</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">添加新闻</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                            <input type="text" class="form-control" name="news[title]" required="required" id="title" autocomplete="off" value="{{$news->title}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="link" class="col-md-3 control-label">原文链接</label> </span>
                                            <input type="text" class="form-control" name="news[link]" required="required" id="link" autocomplete="off" value="{{$news->link}}" autofocus>
                                        </div></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="author" class="col-md-3 control-label">作者</label> </span>
                                            <input type="text" class="form-control" name="news[author]" id="author" autocomplete="off" value="{{$news->author}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="firstwebsite" class="col-md-3 control-label">首发网站</label> </span>
                                            <input type="text" class="form-control" name="news[firstwebsite]" required="required" id="firstwebsite" autocomplete="off" value="{{$news->firstwebsite}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="sitetype" class="col-md-3 control-label">网站类型</label> </span>
                                            <input type="text" class="form-control" name="news[sitetype]" required="required" id="sitetype" autocomplete="off" value="{{$news->sitetype}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="keywords" class="col-md-3 control-label">关键词</label> </span>
                                            <input type="text" class="form-control" name="news[keywords]" required="required" id="keywords" autocomplete="off" value="{{$news->keywords}}" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="transmit" class="col-md-3 control-label">转发数</label> </span>
                                            <input type="text" class="form-control" name="news[transmit]" required="required" id="transmit" autocomplete="off" value="{{$news->transmit}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="starttime" class="col-md-3 control-label">首发时间</label> </span>
                                            <input type="text" class="form-control" name="news[starttime]" required="required" id="starttime" autocomplete="off" value="{{$news->starttime}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="orientation" class="col-md-3 control-label">倾向性</label> </span>
                                            <select id="subject" name="news[orientation]" class="form-control">
                                                <option value="正面" @if($news->orientation=="正面")selected @endif>正面</option>
                                                <option value="中性" @if($news->orientation=="中性")selected @endif>中性</option>
                                                <option value="负面" @if($news->orientation=="负面")selected @endif>负面</option>
                                            </select>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="col-md-5"><strong> 文章内容:</strong><script id="editor" name="news[content]" type="text/plain" style="width:1024px;height:500px;">{{$news->content}}</script></div>        </div>

                        </form>
                    </div></div></div></div></div>
@endsection
@section('js')
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
    </script>
@endsection
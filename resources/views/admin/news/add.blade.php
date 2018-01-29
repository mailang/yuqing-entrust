@extends('layouts.master')
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
                        <form class="form-horizontal" role="form" method="POST" action="{{route('permission.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="new[pid]" value="">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">文章标题</label> </span>
                                        <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                    </div></div>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">原文链接</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">作者</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">首发网站</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">网站类型</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">关键词</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">涉及法院</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">转发数</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">访问数</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">回复数</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">首发时间</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">倾向性</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">舆情信息</label> </span>
                                            <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="tag" class="col-md-3 control-label">专题</label> </span>
                                           <select id="subject" class="form-control">
                                               <option>1</option>
                                               <option>2</option>
                                               <option>2</option>
                                           </select>

                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <label for="abstract" class="col-md-3 control-label"></label>
                                <div class="col-md-10">
                                    <span><strong>文章摘要:</strong></span>
                                    <textarea class="form-control" id="abstract" rows="3" type="text">

                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">

                                <div class="col-md-5"><strong> 文章内容:</strong><script id="editor" type="text/plain" style="width:1024px;height:500px;"></script></div>        </div>

                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        提交
                                    </button>
                                </div>
                            </div>
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
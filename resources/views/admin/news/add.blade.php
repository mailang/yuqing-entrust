@extends('layouts.master')
@section('css')
    <script src="{{asset('js/jquery.linq.min.js')}}"></script>
    <script src="{{asset('js/jquery.json.min.js')}}"></script>
    <script src="{{asset('js/jquery.linq.min.js')}}"></script>
    <script src="{{asset('js/jquery.json.min.js')}}"></script>
    <link type="text/css" href="http://code.jquery.com/ui/1.9.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
    <link type="text/css" href="{{asset('css/bootstrap-treeview.css')}}"/>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
    <script src="{{asset('js/jquery.ui.datepicker-zh-CN.js.js')}}" charset="gb2312"></script>
    <script src="{{asset('js/jquery-ui-timepicker-zh-CN.js')}}"></script>
    <script src="{{asset('js/bootstrap-treeview.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            // 时间设置
            $('#starttime').datetimepicker({
                timeFormat: "HH:mm:ss",
                dateFormat: "yy-mm-dd"
            });
            $('#treeview').treeview({data: getTree()});
            $("#casetype").mousedown(function () {
                $("#modal-news").modal("show");
            })
        });
        function getTree() {
            return  eval({!! $casetypes !!});

        }
        function btnok() {
            var arr = $('#treeview').treeview('getSelected');
            var child= arr[0]["nodes"];//显示子节点数组列表
            if(child)
            {   //存在子节点
                alert("有子节点");
            }
            else
            {
                $("#casetype").val(arr[0]["text"]);
                $("#casehidden").val(arr[0]["id"]);
                $("#modal-news").modal("hide");
            }
        }
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
                        <form class="form-horizontal" role="form" method="POST" action="{{route('useful_news.store')}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                    <div class="input-group">
                                        <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                        <input type="text" class="form-control" name="news[title]" required="required" id="title" autocomplete="off" value="" autofocus>
                                    </div></div>
                                    <div class="col-xs-6">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="link" class="col-md-3 control-label">原文链接</label> </span>
                                            <input type="text" class="form-control" name="news[link]" required="required" id="link" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="author" class="col-md-3 control-label">作者</label> </span>
                                            <input type="text" class="form-control" name="news[author]" id="author" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="firstwebsite" class="col-md-3 control-label">首发网站</label> </span>
                                            <input type="text" class="form-control" name="news[firstwebsite]" required="required" id="firstwebsite" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="sitetype" class="col-md-3 control-label">网站类型</label> </span>
                                            <input type="text" class="form-control" name="news[sitetype]" required="required" id="sitetype" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="keywords" class="col-md-3 control-label">关键词</label> </span>
                                            <input type="text" class="form-control" name="news[keywords]" required="required" id="keywords" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="court" class="col-md-3 control-label">涉及法院</label> </span>
                                            <input type="text" class="form-control" name="news[court]" required="required" id="court" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="transmit" class="col-md-3 control-label">转发数</label> </span>
                                            <input type="text" class="form-control" name="news[transmit]" required="required" id="transmit" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="visitnum" class="col-md-3 control-label">访问数</label> </span>
                                            <input type="text" class="form-control" name="news[visitnum]" required="required" id="visitnum" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="replynum" class="col-md-3 control-label">回复数</label> </span>
                                            <input type="text" class="form-control" name="news[replynum]" required="required" id="replynum" autocomplete="off" value="" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="starttime" class="col-md-3 control-label">首发时间</label> </span>
                                            <input type="text" class="form-control" name="news[starttime]" required="required" id="starttime" autocomplete="off" value="{{date("Y-m-d H:i:s")}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="orientation" class="col-md-3 control-label">倾向性</label> </span>
                                            <select id="subject" name="news[orientation]" class="form-control">
                                                <option value="正面">正面</option>
                                                <option value="中性" selected>中性</option>
                                                <option value="负面">负面</option>
                                            </select>

                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="yuqinginfo" class="col-md-3 control-label">舆情信息</label> </span>
                                            <input type="text" class="form-control" name="news[yuqinginfo]"  id="yuqinginfo" autocomplete="off" value="" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="subject" class="col-md-3 control-label">专题</label> </span>
                                           <select id="subject" name="news[subject_id]" class="form-control">
                                               @foreach($subjects as $subject)
                                                   <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                               @endforeach
                                           </select>
                                        </div></div>
                                  </div></div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="casetype" class="col-md-3 control-label">案件类型</label> </span>
                                            <input id="casehidden" name="news[casetype_id]" value="" type="hidden">
                                            <input type="text" class="form-control" name="news[casetype]" id="casetype" autocomplete="off" value="" autofocus>
                                        </div></div><label class="col-md-1 control-label">选择地区:</label>
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <select class="form-control" name="news[areacode0]" id="areacode0"
                                                        check-type="required number">
                                                    <option>--请选择--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="news[areacode1]" id="areacode1"
                                                        check-type="required number">
                                                    <option>--请选择--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="news[areacode2]" id="areacode2"
                                                        check-type="required number">
                                                    <option>--请选择--</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script language="JavaScript">
                                            $(function () {
                                                var ac = eval({!! $areacode !!});
                                                function refeshselect($o, pcode) {
                                                    var p = $.Enumerable.From(ac).Where("x=>x.pcode=='" + pcode + "'").ToArray();
                                                    $.each(p, function () {
                                                        // ...
                                                        $o.append("<option value='" + this.areacode + "'>" + this.name + "</option>");
                                                    });
                                                }
                                                refeshselect($("#areacode0"), "000000");
                                                $("#areacode0").change(function () {
                                                    $("#areacode1 option:gt(0)").remove();
                                                    $("#areacode2 option:gt(0)").remove();
                                                    refeshselect($("#areacode1"), $("#areacode0").val());
                                                });

                                                $("#areacode1").change(function () {
                                                    $("#areacode2 option:gt(0)").remove();
                                                    refeshselect($("#areacode2"), $("#areacode1").val());
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>  </div>
                            <div class="form-group">
                                <label for="abstract" class="col-md-3 control-label"></label>
                                <div class="col-md-10">
                                    <span><strong>文章摘要:</strong></span>
                                    <textarea class="form-control" id="abstract" name="news[abstract]" rows="3" type="text">

                                    </textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5"><strong> 文章内容:</strong><script id="editor" name="news[content]" type="text/plain" style="width:1024px;height:500px;"></script></div>        </div>
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        添加
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div></div></div></div></div>

    <div class="modal fade" id="modal-news" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">选择案件类型</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="col-md-8">
                            <div id="treeview"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger" onclick="javascript:btnok();">
                        <i class="fa fa-times-circle"></i>确定
                    </button></div>
            </div>

        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.config.js')}}"></script>
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.min.js')}}"></script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>


    <script type="text/javascript">

        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
        </script>
@endsection

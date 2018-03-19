@extends('layouts.master')
@section('css')
    <script src="{{asset('js/jquery.linq.min.js')}}"></script>
    <script src="{{asset('js/jquery.json.min.js')}}"></script>
    <link type="text/css" href="{{asset('css/bootstrap-treeview.css')}}"/>
    <link type="text/css" href="{{asset('css/jquery-ui.min.css')}}" rel="stylesheet" />
    <link type="text/css" href="{{asset('css/jquery-ui-timepicker-addon.css')}}"/>
    <script type="text/javascript" src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/jquery-ui-timepicker-addon.js')}}"></script>
    <script src="{{asset('js/jquery.ui.datepicker-zh-CN.js.js')}}" charset="gb2312"></script>
    <script src="{{asset('js/jquery-ui-timepicker-zh-CN.js')}}"></script>
    <script src="{{asset('js/bootstrap-treeview.js')}}"></script>
    <style>
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            /* 防止水平滚动条 */
            overflow-x: hidden;
        }
        /* IE 6 不支持 max-height
         * 我们使用 height 代替，但是这会强制菜单总是显示为那个高度
         */
        * html .ui-autocomplete {
            height: 200px;
        }
    </style>
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
                        <form class="form-horizontal" role="form" method="POST" action="{{route('useful_news.update',$news->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-5">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                            <input type="text" class="form-control" name="news[title]" required="required" id="title" autocomplete="off" value="{{$news->title}}" autofocus>
                                        </div></div>

                                    <div class="col-xs-6">
                                        <div>
                                                    <input name="news[isrepeats]" type="hidden" value="0">
                                                    <input id="isrepeats" name="news[isrepeats]" type="checkbox"
                                                           @if($news->isrepeats==1)checked @endif  value="1"><label for="isrepeats" class="control-label">重复舆情</label>
                                            <span ><label for="link" class="control-label">原文:</label> </span>
                                            <a href="{{$news->link}}" target="_blank" id="link">{{$news->link}} </a>
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
                                            <input type="text" class="form-control" name="news[firstwebsite]"  id="firstwebsite" autocomplete="off" value="{{$news->firstwebsite}}" autofocus>
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
                                            <span class="input-group-addon"><label for="court" class="col-md-3 control-label">涉及法院</label> </span>
                                            <input type="text" class="form-control" name="news[court]" required="required" id="court" autocomplete="off" value="{{$news->court}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="transmit" class="col-md-3 control-label">转发数</label> </span>
                                            <input type="text" class="form-control" name="news[transmit]" required="required" id="transmit" autocomplete="off" value="{{$news->transmit}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="visitnum" class="col-md-3 control-label">访问数</label> </span>
                                            <input type="text" class="form-control" name="news[visitnum]" required="required" id="visitnum" autocomplete="off" value="{{$news->visitnum}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="replynum" class="col-md-3 control-label">回复数</label> </span>
                                            <input type="text" class="form-control" name="news[replynum]" required="required" id="replynum" autocomplete="off" value="{{$news->replynum}}" autofocus>
                                        </div></div>
                                </div>      </div>
                            <div class="form-group">
                                <div class="row">
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
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="yuqinginfo" class="col-md-3 control-label">舆情信息</label> </span>
                                            <input type="text" class="form-control" name="news[yuqinginfo]" id="yuqinginfo" autocomplete="off" value="{{$news->yuqinginfo}}" autofocus>
                                        </div></div>
                                    <div class="col-xs-3">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="subject" class="col-md-3 control-label">专题</label> </span>
                                            <select id="subject" name="news[subject_id]" class="form-control">
                                                <option value="" selected>--无--</option>
                                                @foreach($subjects as $subject)
                                                    @if($subject->id==$news->subject_id)
                                                    <option value="{{$subject->id}}" selected>{{$subject->subject}}</option>
                                                    @else <option value="{{$subject->id}}">{{$subject->subject}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div></div>
                                </div>      </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><label for="casetype" class="col-md-3 control-label">案件类型</label> </span>
                                            <input id="casehidden" name="news[casetype_id]" value="" type="hidden">
                                            <input type="text" class="form-control" name="news[casetype]" id="casetype" value="{{$news->casetype}}" autocomplete="off" value="" autofocus>
                                        </div></div><label class="col-md-1 control-label">选择地区:</label>
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <select class="form-control" name="areacode0" id="areacode0"
                                                        check-type="required number">
                                                    <option value="">--请选择--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="news[areacode1]" id="areacode1"
                                                        check-type="required number">
                                                    <option value="">--请选择--</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <select class="form-control" name="news[areacode2]" id="areacode2"
                                                        check-type="required number">
                                                    <option value="">--请选择--</option>
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
                                                var dataac = "{{$news['areacode']}}";
                                                if (dataac != null && dataac != "" && dataac != undefined) {
                                                    var pac = dataac[0] + dataac[1] + "0000";
                                                    var cac = dataac[0] + dataac[1] + dataac[2] + dataac[3] + "00";

                                                    refeshselect($("#areacode1"), pac);
                                                    refeshselect($("#areacode2"), cac);

                                                    $("#areacode0").val(pac);
                                                    $("#areacode1").val(cac);
                                                    $("#areacode2").val(dataac);
                                                }
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
                                    <textarea class="form-control" id="abstract" name="news[abstract]" required rows="3" type="text">{{$news->abstract}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5"><strong> 文章内容:</strong><script id="editor" name="news[content]" type="text/plain" style="width:1024px;height:500px;">{!!html_entity_decode($news->content)!!}</script></div>        </div>
                            <div class="form-group">
                                <div class="col-md-7 col-md-offset-3">
                                    <button type="submit" class="btn btn-primary btn-md">
                                        <i class="fa fa-plus-circle"></i>
                                        确定
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
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/ueditor.all.min.js')}}"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
    <script type="text/javascript" charset="utf-8" src="{{asset('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script type="text/javascript">
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');

        $(function() {
            $.getJSON('{{route("court.list")}}',"", function(data) {
                $("#court").autocomplete({
                    source:data,
                    minLength: 1
                });
            });
        });
    </script>
@endsection
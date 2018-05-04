@extends('layouts.newslist')
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
                dateFormat: "yy-mm-dd",
                beforeShow: function () {
                    setTimeout(function () {
                            $('#ui-datepicker-div').css("z-index", 1500);
                        }, 100
                    );
                }
            });
            $('#time2').datetimepicker({
                timeFormat: "HH:mm:ss",
                dateFormat: "yy-mm-dd",
                beforeShow: function () {
                    setTimeout(function () {
                            $('#ui-datepicker-div').css("z-index", 1500);
                        }, 100
                    );
                }
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
                <form class="form-inline" role="form" action="{{route('passed.search')}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                            <input type="text" class="form-control" name="title" placeholder="文章标题"  id="title" autocomplete="off" value="@if(isset($data['title'])){{$data['title']}}@endif" autofocus>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><label for="court" class="col-md-3 control-label">法院</label> </span>
                            <input type="text" class="form-control" name="court"  id="court" placeholder="法院" autocomplete="off" value="@if(isset($data['court'])){{$data['court']}}@endif" autofocus>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><label for="orientation" class="col-md-3 control-label">倾向性</label> </span>
                            <select id="orientation" name="orientation" class="form-control">
                                <option value="">--请选择--</option>
                                <option @if(isset($data['orientation'])&&$data['orientation']=="正面")selected @endif value="正面">正面</option>
                                <option @if(isset($data['orientation'])&&$data['orientation']=="中性")selected @endif value="中性">中性</option>
                                <option @if(isset($data['orientation'])&&$data['orientation']=="负面")selected @endif value="负面">负面</option>
                            </select>
                        </div>
                        <div class="input-group">      <span class="input-group-addon"><label class="col-sm-3 control-label" for="subject">专题</label> </span>
                      <select id="subject" name="subject" class="form-control">
                          <option value="all">--请选择--</option>
                          <option @if(empty($data['subject_id']))selected @endif value="">未分类</option>
                          @foreach($subjects as $key=>$subject)
                              <option @if(isset($data['subject_id'])&&$data['subject_id']==$subject->id)selected @endif value="{{$subject->id}}">{{$subject->subject}}</option>
                         @endforeach
                     </select>
                        </div></div>
                    <br> <br>
                    <div class="input-group">
                        <span class="input-group-addon"><label for="orientation" class="col-md-3 control-label">新闻状态</label> </span>
                        <select id="tag" name="tag" class="form-control">
                            <option value="">--请选择--</option>
                            <option @if(isset($data['tag'])&&$data['tag']=="1")selected @endif value="1">合格</option>
                            <option @if(isset($data['tag'])&&$data['tag']=="2")selected @endif value="2">重复</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><label for="title" class="col-md-3 control-label">起始时间</label> </span>
                        <input placeholder="开始时间" type="text" class="form-control" name="time1" id="time1" autocomplete="off" value="@if(isset($data['time1'])){{$data['time1']}}@endif" autofocus>                    </div>
                    <div class="input-group">
                        <span class="input-group-addon"><label for="title" class="col-md-3 control-label">结束时间</label> </span>
                        <input placeholder="结束时间" type="text" class="form-control" name="time2" id="time2" autocomplete="off" value="@if(isset($data['time2'])){{$data['time2']}}@endif" autofocus>
                    </div>
                    <button class="btn btn-success btn-md">
                        <i class="fa fa-search-plus"></i>搜索
                    </button>
                </form>
                <table> <tr><td colspan="6">
                            <a href="#" onclick="javascript:reportbtn();" class="btn btn-success btn-md">生成报表</a>
                        </td></tr></table>
                <table id="tags-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th data-sortable="false"><input id="all" type="checkbox" value="" onclick="javascript:allclick(this);"><label for="all">全选</label></th>
                        <th>文章标题</th>
                        <th>作者</th>
                        <th>倾向性</th>
                        <th>添加时间</th>
                        <th  data-sortable="false" width="40px">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($newslist as $news)<tr>
                        <td> @if($news->reportform_id==null) <input type="checkbox" value="{{$news->id}}" name="news[]">@else<input type="hidden" value="{{$news->id}}">@endif</td>
                        <td><a href="{{route('passed.lists',$news->id)}}" target="_blank" class="text-success ">{{strlen($news->title)>60?mb_substr($news->title,0,50).'...':$news->title}}</a></td>
                        <td>{{$news->author}}</td>
                        <td>{{$news->orientation}}</td>
                        <td>{{$news->created_at}}</td>
                        <td>
                            <a href="{{route('passed.lists',$news->id)}}" class="text-success ">查看</a>
                        </td>
                    </tr>@endforeach
                    </tbody>
                </table>
                <table width="100%"><tr><td>@if(isset($paginator)) 当前页{{$paginator->currentPage()}}共计{{$paginator->lastPage()}}页，总记录数{{$paginator->total()}}条 @else当前页{{$newslist->currentPage()}}共计{{$newslist->lastPage()}}页,总记录数{{$newslist->total()}}条  @endif </td><td style="text-align: right;">@if(isset($paginator))  {{ $paginator->render() }} @else{{$newslist->links()}} @endif</td></tr></table>
            </div></div></div></div>
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <form id="deleteForm" class="deleteForm" method="POST" action="">
                    <div class="modal-body">
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>确定将所选项生成报表吗?
                        </p>
                            <div>
                            <input type="radio" value="0" name="type" id="type0" checked><label for="type0">早报</label>
                            <input type="radio" value="1" name="type" id="type1" ><label for="type1">午报</label>
                            <input type="radio" value="2" name="type" id="type2"><label for="type2">晚报</label>
                             </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" id="newsid" name="newsid" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>确认
                        </button></div>
                </form>
            </div>
        </div>
    </div>    <div class="modal fade" id="modal-alert" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <form id="alertform" class="deleteForm" method="POST" action="">
                    <div class="modal-body">
                        <p class="lead">
                            <i class="fa fa-question-circle fa-lg"></i>请选择新闻
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function  allclick(obj) {
            if($(obj).is(":checked"))$("input[name='news[]']").prop("checked",true);
            else $("input[name='news[]']").prop("checked",false);
        }
    function reportbtn() {
    var array=$("input[name='news[]']");
    var s='';
    $("input[name='news[]']:checkbox:checked").each(
    function(){
          s+=$(this).val()+',';
    });
        if(s==''){
            $("#modal-alert").modal();
        }
        else
        {
            s+="0";
            $("#newsid").val(s);
            $('.deleteForm').attr('action', '/admin/report/store');
            $("#modal-delete").modal();
        }

    }
    $(function () {
    allclick("#all");
    })
    </script>
@endsection
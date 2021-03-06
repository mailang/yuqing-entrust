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
    <div class="row page-title-row" style="margin:5px;">
        <div class="col-md-6">
        </div>
        <div class="col-md-6 text-right">
            <a href="{{route('useful_news.person.add')}}" class="btn btn-success btn-md">
                <i class="fa fa-plus-circle"></i> 添加新闻
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                                         <form class="form-inline" role="form" action="{{route('person.search')}}" method="post">
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
                                                 <div class="input-group"><span class="input-group-addon"><label class="col-sm-3 control-label" for="subject">专题</label> </span>
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
                    <table>   <tr><td colspan="3">
                                <a href="#" onclick="verifybtn()" class="btn btn-success btn-md">提交到审核</a>&nbsp;&nbsp;
                            </td><td colspan="3">
                                <a href="#" onclick="deletearray()" class="btn btn-success btn-md">批量删除</a>&nbsp;&nbsp;
                            </td>
                            <td colspan="3">
                                <a href="#" onclick="createzip()" class="btn btn-success btn-md">生成</a>
                            </td>
                        </tr>
                    </table>
                    <table id="tags-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false"><input id="all" type="checkbox" value="" onclick="javascript:allclick(this);"><label for="all">全选</label></th>
            <th>文章标题</th>
            <th>添加时间</th>
            <th>编辑状态</th>
            <th>状态</th>
            <th  data-sortable="false" width="100px">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
             <td> @if($news->tag==0) <input type="checkbox" value="{{$news->id}}" name="news[]">@else  <input type="hidden" value="{{$news->id}}">@endif</td>
             <td>  @if($news->tag<1)  <a href="{{route('useful_news.person.add',$news->id)}}"  @if($news->isedit==1)style="color:red;" @endif  class="text-success ">{{strlen($news->title)>60?mb_substr($news->title,0,50).'...':$news->title}}</a>
                @else {{strlen($news->title)>60?mb_substr($news->title,0,50).'...':$news->title}}@endif</td>
            <td>{{$news->created_at}}</td>
             <td>
             @if($news->isedit==0) 未曾编辑@else 已编辑@endif
             </td>
             <td>@switch($news->tag)
                 @case(-1)  <span style="color:blue">未审核 </span>@break
                 @case(0)未提交@break
                     @case(1)<span style="color:#00a65a">合格</span>@break
                     @case(2)<span style="color:#00a65a">重复</span>@break
                     @case(-2)<span style="color:red">不合格 </span>@break
                 @endswitch
             </td>
            <td>
              @if($news->tag<1)  <a href="{{route('useful_news.person.add',$news->id)}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>
                @endif
                  @if($news->tag==0)  <br>  <a style="margin:3px;" onclick="javascript:deletebtn(this);" href="#" attr="{{$news->id}}" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>@endif
            </td>
        </tr>@endforeach
        </tbody>
    </table>

                    <table width="100%"><tr>
                            <td>@if(isset($paginator)) 当前页{{$paginator->currentPage()}}共计{{$paginator->lastPage()}}页，总记录数{{$paginator->total()}}条 @else当前页{{$newslist->currentPage()}}共计{{$newslist->lastPage()}}页,总记录数{{$newslist->total()}}条  @endif </td>
                            <td style="text-align: right;">@if(isset($paginator))  {{ $paginator->render() }} @else{{$newslist->links()}} @endif</td></tr></table>

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

                </p>
            </div>
            <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="newsid" name="newsid" value="">

                  <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times-circle"></i>确认
                    </button>
            </div> </form>
            </div>

        </div>
    </div>
</div>
 <script type="text/javascript">
     function deletebtn(obj) {
         var id = $(obj).attr('attr');
         $('.deleteForm').attr('action', '/admin/useful_news/delete/' + id);
         $(".lead").html(" <i class=\"fa fa-question-circle fa-lg\"></i>确定要删除吗?");
         $("#modal-delete").modal();
     }
     function  deletearray() {
         bindid();
         $('.deleteForm').attr('action', '/admin/useful_news/delete');
         $(".lead").html(" <i class=\"fa fa-question-circle fa-lg\"></i>确定要删除所有选择的新闻吗?");
         $("#modal-delete").modal();
     }
     function  allclick(obj) {
         if($(obj).is(":checked"))$("input[name='news[]']").prop("checked",true);
         else $("input[name='news[]']").prop("checked",false);
     }
     function createzip() {
         bindid();
         //alert(  $("#newsid").val());
         location.href = "/admin/report/person/createzip?id="+ $("#newsid").val();
//         $.ajax({
//             url:'/admin/report/person/createzip',
//             type:'get',
//             async:false,
//             data:{id:$("#newsid").val()},
//             success:function (data) {
//                 location.href=data;
//             }
//         });
     }
     function bindid()
     {
         var s='';
         $("input[name='news[]']:checkbox:checked").each(
             function(){
                 s+=$(this).val()+',';
             });
         if (s!='')s+='0';
         $("#newsid").val(s);
     }
     function verifybtn() {
         bindid();
         $('.deleteForm').attr('action', '/admin/useful_news/submit/verify');
         $(".lead").html("<i class=\"fa fa-question-circle fa-lg\"></i>确定将所选项提交到审核吗?");
         $("#modal-delete").modal();
     }
  $(function () {
      allclick("#all");
  })
 </script>
@endsection
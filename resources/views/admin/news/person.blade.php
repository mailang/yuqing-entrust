@extends('layouts.master')
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
                    <div>
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="{{route('person.lists')}}">未分类</a></li>
                             @foreach($subjects as $key=>$subject)
                                 @if((isset($id)&&$id==$subject->id))<!--||(!isset($id)&&$key==0)-->
                            <li class="active"><a href="{{route('person.lists',$subject->id)}}">{{$subject->subject}}</a></li>
                                 @else
                                    <li><a href="{{route('person.lists',$subject->id)}}">{{$subject->subject}}</a></li>
                                @endif
                             @endforeach
                        </ul>
                    </div>
                    <table id="tags-table" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false"><input id="all" type="checkbox" value="" onclick="javascript:allclick(this);"><label for="all">全选</label></th>
            <th>文章标题</th>
            <th>作者</th>
            <th>倾向性</th>
            <th>添加时间</th>
            <th>状态</th>
            <th  data-sortable="false">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $news)<tr>
             <td><input type="checkbox" value="{{$news->id}}" name="news[]"></td>
             <td>{{$news->title}}</td>
            <td>{{$news->author}}</td>
            <td>{{$news->orientation}}</td>
            <td>{{$news->created_at}}</td>
             <td>@switch($news->tag)
                 @case(-1)  <span style="color:blue">未审核 </span>@break
                 @case(0)未提交@break
                     @case(1)<span style="color:#00a65a">合格</span>@break
                     @case(2)<span style="color:#00a65a">重复</span>@break
                     @case(3)<span style="color:red">不合格 </span>@break
                 @endswitch
             </td>
            <td>
                <a href="{{route('useful_news.person.add',$news->id)}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>
                <a style="margin:3px;" onclick="javascript:deletebtn(this);" href="#" attr="{{$news->id}}" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>
            </td>
        </tr>@endforeach
        <tr><td colspan="6">
                <a href="#" onclick="verifybtn()" class="btn btn-success btn-md">提交到审核</a>
            </td></tr>
        </tbody>
    </table>
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
                    <input type="hidden" id="newsid" name="newsid" value="{{ csrf_token() }}">

                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-times-circle"></i>确认
                    </button>
                </form>
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
     function  allclick(obj) {
        if($(obj).is(":checked"))$("input[name='news[]']").attr('checked','checked');
         else $("input[name='news[]']").removeAttr('checked');
     }
     function verifybtn() {
         var array=$("input[name='news[]']");
         var s='';
         $("input[name='news[]']").each(
             function(){
               s+=$(this).val()+',';
             }
         )
         s+="0";
         $("#newsid").val(s);
         $('.deleteForm').attr('action', '/admin/useful_news/submit/verify');
         $(".lead").html("<i class=\"fa fa-question-circle fa-lg\"></i>确定将所选项提交到审核吗?");
         $("#modal-delete").modal();
     }
  $(function () {
      allclick("#all");
  })
 </script>
@endsection
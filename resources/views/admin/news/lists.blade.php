@extends('layouts.newslist')
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
@section('content')
    <div class="row page-title-row" style="margin:5px;">
        <div class="row text-center">

        </div>        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <form class="form-inline" role="form" action="{{route('news.search')}}" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><label for="title" class="col-md-3 control-label">文章标题</label> </span>
                                <input type="text" class="form-control" name="title" placeholder="文章标题"  id="title" autocomplete="off" value="@if(isset($data['title'])){{$data['title']}}@endif" autofocus>
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
                            <div class="input-group">
                                <span class="input-group-addon"><label for="firstwebsite" class="col-md-3 control-label">首发网站</label> </span>
                                <input type="text" class="form-control" name="firstwebsite" placeholder="首发网站"  id="firstwebsite" autocomplete="off" value="@if(isset($data['firstwebsite'])){{$data['firstwebsite']}}@endif" autofocus>
                            </div>
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
                        </button></div>
                    </form>
                    <table id="tags-table" class="table-bordered table-striped">
        <thead>
        <tr>
            <th  data-sortable="false"></th>
            <th  data-sortable="false">文章标题</th>
            <th>作者</th>
            <th>发布时间</th>
            <th  data-sortable="false" width="80px">操作</th>
        </tr>
        </thead>
        <tbody>
         @foreach($newslist as $key=>$news)<tr>
             <td>{{$key+1}}</td>
             <td><h4>   <a href="{{route('news.see',$news->id)}}" target="_blank">{{$news->title}}</a></h4>
             <div>
                 {!!html_entity_decode($news->abstract)!!}
             </div>
             </td>
            <td>{{$news->author}}</td>
             <td>{{$news->starttime}}</td>
            <td>
                <a href="#" attr="{{$news->id}}" onclick="javascript:addnews(this);">
                    <i class="fa fa-plus-circle"></i>我的新闻</a><br>
              <!-- <a href="{{route('news.see',$news->id)}}" target="_blank">查看</a>-->
            </td>
        </tr>@endforeach
        </tbody>
    </table>
                  @if(isset($paginator))  {{ $paginator->render() }} @else{{$newslist->links()}} @endif
                </div></div></div></div>
    <script>
        function addnews(obj) {
            var id = $(obj).attr('attr');
           // $('.newsForm').attr('action', '/admin/useful_news/store/' + id);
            //$("#modal-news").modal();
            $.ajax({
               url:'/admin/useful_news/store/'+id,
               type:'get',
                async:false,
               success:function (data) {
                   if(data>0)$(".modal-body").html(" <p class=\"lead\">\n" +
                       "                        <i class=\"fa fa-question-circle fa-lg\"></i>\n" +
                       "                       操作成功\n" +
                       "                    </p>");
                   if(data<0)
                       $(".modal-body").html(" <p class=\"lead\">\n" +
                           "                        <i class=\"fa fa-question-circle fa-lg\"></i>\n" +
                           "                       操作失败\n" +
                           "                    </p>");
                       $("#modal-news").modal();
               }
            });
        }
    </script>
    <div class="modal fade" id="modal-news" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                        <button class="btn btn-danger" data-dismiss="modal">
                            <i class="fa fa-times-circle"></i>确认
                        </button>

                </div>

            </div>
        </div>
    </div>

@endsection
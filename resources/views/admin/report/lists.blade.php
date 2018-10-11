@extends('layouts.newslist')
@section('title')
    <h1>
        首页
        <small>报表管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>报表管理</a></li>
        <li class="active">报表管理</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th data-sortable="false">&nbsp;</th>
                            <th>名称</th>
                            <th>类型</th>
                            <th class="hidden-md">创建时间</th>
                            <th>微博微信关注</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr> <td></td><td> <a href="{{route('report.edit',$report->id)}}" class="X-Small btn-xs text-success ">{{ $report->title }}</a></td>
                                <td>
                                    @switch($report->type)
                                        @case(0) 早报 @break
                                        @case(1) 午报 @break
                                        @case(2) 晚报 @break
                                @endswitch
                                </td>
                                <td>{{$report->created_at}}</td>
                                <td>
                                    <a href="{{route('reading.index',$report->id)}}" data-toggle="modal"  data-target="#modal-alert" class="X-Small btn-xs text-success "> 编辑</a>
                                </td>
                                <td>
                                  <a href="{{route('report.edit',$report->id)}}" class="X-Small btn-xs text-success "> 编辑</a>
                                    <a style="margin:3px;" onclick="javascript:deletebtn(this);" href="#" attr="{{$report->id}}" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>
                                    <a href="{{route('report.createzip',$report->id)}}" class="X-Small btn-xs text-success "> 生成三报</a>
                                    <a href="{{route('report.downloadzip',$report->id)}}" class="X-Small btn-xs text-success "> 下载三报</a>
                                    <a href="{{route('report.pushzip',$report->id)}}" class="X-Small btn-xs text-success "> 推送三报</a>
                                    <a href="{{route('report.downloaddocx',$report->id)}}" class="X-Small btn-xs text-success "> 下载DOCX</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                  <table width="100%"><tr><td>当前页{{$reports->currentPage()}}共计{{$reports->lastPage()}}页,总记录数{{$reports->total()}}条 </td>
                      <td style="text-align: right"> {{$reports->links()}}</td>
                      </tr></table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-alert" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            </div></div></div>
<script type="text/javascript">
    $(function () {
        /* $("#modal-alert").on("hidden", function() {
             $(this).removeData("modal");
         });
         */
        $("#modal-alert").on("hidden.bs.modal", function() {
            $(this).removeData("bs.modal");
        });

    })
    function deletebtn(obj) {
        var id = $(obj).attr('attr');
        $('.deleteForm').attr('action', '/admin/report/delete/' + id);
        $("#modal-delete").modal();
    }

</script>
    <div class="modal fade" id="modal-delete" tabIndex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        ×
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p class="lead">
                        <i class="fa fa-question-circle fa-lg"></i>
                        确认要删除该记录吗?
                    </p>
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" class="deleteForm" method="POST" action="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times-circle"></i>确认
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
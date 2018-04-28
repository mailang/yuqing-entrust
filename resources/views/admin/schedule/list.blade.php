@extends('layouts.newslist')
@section('title')
    <h1>
        首页
        <small>排班表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>排班表</a></li>
    </ol>
    <style type="text/css">
        table td,table th{text-align:center;border:1px solid #0a0a0a; font-size:16px;height:auto !important;min-height:50px;}
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="tags-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="10px" style="visibility: hidden"></th>
                        <th>起始时间</th>
                        <th class="hidden-sm">结束时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $schedule)
                    <tr>
                        <td></td>
                        <td>{{ $schedule->starttime }}</td>
                        <td>{{date('Y-m-d',strtotime($schedule->starttime.'+6 day'))}}</td>
                        <td>
                            <a style="margin:3px;" href="{{route('schedule',array('time'=>strtotime($schedule->starttime)))}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 查看</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$list->links()}}
            </div>
        </div>
    </div>
</div>
<script>
    function deletebtn(obj) {
        var id = $(obj).attr('attr');
        $('.deleteForm').attr('action', '/admin/adminsdelete/' + id);
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
                    确认要删除该用户吗?
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
@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>专题管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>专题管理</a></li>
        <li class="active">专题列表</li>
    </ol>
@endsection
@section('content')
<div class="row page-title-row" style="margin:5px;">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('subject.add')}}" class="btn btn-success btn-md">
            <i class="fa fa-plus-circle"></i> 添加专题
        </a>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <table id="tags-table" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th data-sortable="false">&nbsp;</th>
                        <th>专题名</th>
                        <th class="hidden-md">创建时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subjects as $subject)
                    <tr> <td></td>
                        <td>{{ $subject->subject }}</td>
                        <td>{{$subject->created_at}}</td>
                        <td>
                            <a style="margin:3px;" href="{{route('subject.add',array('id'=>$subject->id))}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>

                            <a style="margin:3px;" onclick="javascript:deletebtn(this);" href="#" attr="{{$subject->id}}" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>

                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function deletebtn(obj) {
        var id = $(obj).attr('attr');
        $('.deleteForm').attr('action', '/admin/subject/delete/' + id);
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
                    确认要删除吗?
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
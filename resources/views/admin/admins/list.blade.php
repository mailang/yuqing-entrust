@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>用户管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>用户管理</a></li>
        <li class="active">添加账号</li>
    </ol>
@endsection
@section('content')
<div class="row page-title-row" style="margin:5px;">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
        <a href="{{route('admin.add')}}" class="btn btn-success btn-md">
            <i class="fa fa-plus-circle"></i> 添加用户
        </a>
    </div>
</div>
<div class="row page-title-row" style="margin:5px;">
    <div class="col-md-6">
    </div>
    <div class="col-md-6 text-right">
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
                        <th>用户名</th>
                        <th class="hidden-sm">真实姓名</th>
                        <th class="hidden-md">创建时间</th>
                        <th data-sortable="false">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admins as $admin)
                    <tr> <td></td>
                        <td>{{ $admin->username }}</td>
                        <td>{{$admin->realname}}</td>
                        <td>{{$admin->created_at}}</td>
                        <td>
                            <a style="margin:3px;" href="{{route('admin.add',array('id'=>$admin->id))}}" class="X-Small btn-xs text-success "><i class="fa fa-edit"></i> 编辑</a>
                            @if($admin->username!="admin")
                            <a style="margin:3px;" onclick="javascript:deletebtn(this);" href="#" attr="{{$admin->id}}" class="delBtn X-Small btn-xs text-danger "><i class="fa fa-times-circle-o"></i> 删除</a>
                            @endif
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
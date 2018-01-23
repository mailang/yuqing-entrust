@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>角色管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>角色管理</a></li>
        <li class="active">添加角色</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">添加角色</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('role.store')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">角色名称</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">权限列表</label><div class="col-md-4">
                                        @foreach($permissions as $key=>$permission)
                                        <input type="checkbox" id="box{{$permission->id}}"
                                               class="form-actions" name="permissions[]" id="tag" value="{{$permission->id}}" autofocus>
                                            <label for="box{{$permission->id}}">
                                                {{$permission['name']}}
                                            </label>
                                        @endforeach
                                </div> </div>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            提交
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

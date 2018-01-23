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
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">添加用户</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('admin.store')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">用户名</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[username]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">真实姓名</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[realname]"  id="tag" required="required" autocomplete="off" value="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">密码</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="new[password]" required="required" id="tag" value="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">密码确认</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="new[password_confirmation]" required="required" id="tag" value="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">角色列表</label><div class="col-md-4">
                                        @foreach($roles as $key=>$role)
                                        <input type="radio" id="box{{$role->id}}"
                                               @if($key==0)checked @endif
                                               class="form-actions" name="roles[]" id="tag" value="{{$role->id}}" autofocus>
                                            <label for="box{{$role->id}}">
                                                {{$role['display_name']}}
                                            </label>
                                        @endforeach
                                </div> </div>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>
                                            添加
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

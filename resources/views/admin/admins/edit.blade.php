@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>用户管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>用户管理</a></li>
        <li class="active">编辑账号</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑用户</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('admin.update',array('id'=>$admins->id))}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">用户名</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[username]" id="tag" value="{{$admins->username}}" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">真实姓名</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[realname]" id="tag" value="{{$admins->realname}}" autocomplete="off" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">密码</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="new[password]" id="tag" value="" autofocus>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">密码确认</label>
                                    <div class="col-md-5">
                                        <input type="password" class="form-control" name="new[password_confirmation]" id="tag" value="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">角色列表</label>
                                        <div class="col-md-6">    <div class="col-md-6" style="float:left;padding-left:20px;margin-top:8px;">
                                            @foreach($roles as $v)
                                           <span class="checkbox-custom checkbox-default">
                                            <i class="fa"></i>
                                          <input class="form-actions"
                                     @if(($v['id']==$roleid))
                                        checked
                                       @endif
                                        id="inputChekbox{{$v['id']}}" type="radio" value="{{$v['id']}}"
                                      name="roles[]"> <label for="inputChekbox{{$v['id']}}">
                                     {{$v['name']}}
                                    </label> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                       </span>
                                            @endforeach    </div>
                                        </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-7 col-md-offset-3">
                                        <button type="submit" class="btn btn-primary btn-md">
                                            <i class="fa fa-plus-circle"></i>提交
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

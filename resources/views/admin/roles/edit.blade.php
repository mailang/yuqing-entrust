@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>角色管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>角色管理</a></li>
        <li class="active">编辑角色</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑角色</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('role.update',array('id'=>$roles->id))}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">角色名</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[name]" id="tag" value="{{$roles->name}}" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">选择权限</label>
                                    <div class="col-md-8">
                                        <?php $roots=$permissions->where('pid',"-1"); ?>
                                        @foreach($roots as $key=>$root)
                                            <div><label for="box{{$root->id}}">{{$root['name']}}</label>
                                                <input type="hidden" id="box{{$root->id}}" class="form-actions" name="permissions[]" value="{{$root->id}}" autofocus> </div>
                                            <?php $childs=$permissions->where('pid',$root->id); ?>
                                            @foreach($childs as $child)
                                                <input type="checkbox" id="box{{$child->id}}"
                                                       @if((in_array($child['id'],$permitids)))
                                                       checked
                                                       @endif
                                                       class="form-actions" name="permissions[]" value="{{$child->id}}" autofocus>
                                                <label for="box{{$child->id}}">
                                                    {{$child['name']}}
                                                </label>
                                            @endforeach
                                        @endforeach
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

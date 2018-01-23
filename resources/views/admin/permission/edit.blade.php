@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>栏目管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>栏目管理</a></li>
        <li class="active">编辑栏目</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">编辑栏目</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('permission.update',array('id'=>$permission->id))}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">栏目名称</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[name]" id="tag" value="{{$permission->name}}" readonly="readonly" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">栏目链接</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="new[link]" id="tag" value="{{$permission->link}}" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                {{--图标修改--}}
                                <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css')}}"/>
                                <link rel="stylesheet" href="{{asset('plugins/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css')}}"/>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">图标</label>
                                    <div class="col-md-6">
                                        <!-- Button tag -->
                                        <button class="btn btn-default" name="new[icon]" data-iconset="fontawesome" data-icon="{{$permission->icon==null?'fa-sliders':$permission->icon}}" role="iconpicker"></button>
                                    </div>
                                </div>
                                @section('js')
                                    <script type="text/javascript" src="/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js"></script>
                                    <script type="text/javascript" src="/plugins/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.js"></script>
                                @endsection
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">权限概述</label>
                                    <div class="col-md-6">
                                        <textarea value="$permission->description" name="new[description]" class="form-control" rows="3"></textarea>
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

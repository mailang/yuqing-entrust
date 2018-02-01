@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>案件类型管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>案件类型管理</a></li>
        <li class="active">添加案件类型</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">添加案件类型</h3>
                        </div>
                        <div class="panel-body">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('casetype.store')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="casetype[pid]" value="{{$pid}}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">名称</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="casetype[name]" required="required" id="tag" autocomplete="off" value="" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">描述</label>
                                    <div class="col-md-5">
                                        <textarea type="text" class="form-control" name="casetype[description]"  id="description" rows="3"  autofocus></textarea>
                                    </div>
                                </div>


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

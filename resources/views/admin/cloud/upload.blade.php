@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>云词图</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>云词图上传</a></li>
        <li class="active">热词</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">云词图</h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal"  enctype="multipart/form-data" role="form" method="POST" action="{{route('cloud.store')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label for="tag" class="col-md-3 control-label">云词图</label>
                                <div class="col-md-5">
                                    <input type="file" id="picture" name="picture">
                                </div>
                            </div>
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
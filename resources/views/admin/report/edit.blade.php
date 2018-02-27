@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>日报管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>日报管理</a></li>
        <li class="active">日报管理</li>
    </ol>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">

            <div class="row">
                <div class="">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">日报管理</h3>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#report_edit" data-toggle="tab">更新报表</a></li>
                                <li><a href="#related_news" data-toggle="tab">相关新闻</a></li>
                            </ul><br>
                            <div class="tab-content">
                                <div class="active tab-pane" id="report_edit">
                            <form class="form-horizontal" role="form" method="POST" action="{{route('report.update',array('id'=>$report->id))}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">名称</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" name="report[title]" id="tag" value="{{$report->title}}" autocomplete="off" autofocus>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="tag" class="col-md-3 control-label">类型</label>
                                    <div class="row">
                                        <div class="col-md-5">
                                        <select class="form-control" name="report[type]">
                                            <option value="0" @if($report->type=="0")selected @endif>早报</option>
                                            <option value="1" @if($report->type=="1")selected @endif>中报</option>
                                            <option value="2" @if($report->type=="2")selected @endif>晚报</option>
                                        </select></div>
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
                            <div class="tab-pane" id="related_news">
                                <table id="tags-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th  data-sortable="false">
                                        </th>
                                        <th>文章标题</th>
                                        <th>作者</th>
                                        <th>倾向性</th>
                                        <th>添加时间</th>
                                        <th  data-sortable="false">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($newslist as $news)<tr>
                                        <td> @if($news->reportform_id==null) <input type="checkbox" value="{{$news->id}}" name="news[]">@endif</td>
                                        <td>{{$news->title}}</td>
                                        <td>{{$news->author}}</td>
                                        <td>{{$news->orientation}}</td>
                                        <td>{{$news->created_at}}</td>
                                        <td>
                                            <a href="{{route('report.useful.delete',$news->id)}}" class="delBtn X-Small btn-xs text-danger"><i class="fa fa-times-circle-o"></i> 删除</a>
                                        </td>
                                    </tr>@endforeach
                                    </tbody>
                                </table>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

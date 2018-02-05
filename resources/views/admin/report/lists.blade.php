@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>报表管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>报表管理</a></li>
        <li class="active">报表管理</li>
    </ol>
@endsection
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body">
                    <table id="tags-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th data-sortable="false">&nbsp;</th>
                            <th>名称</th>
                            <th>类型</th>
                            <th class="hidden-md">创建时间</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr> <td></td><td>{{ $report->title }}</td>
                                <td>
                                    @switch($report->type)
                                     @case(0) 早报
                                        @case(1)中报
                                        @case(2) 晚报

                                @endswitch
                                </td>

                                <td>{{$report->created_at}}</td>
                                <td>
                                   编辑
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
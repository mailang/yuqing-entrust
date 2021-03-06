@extends('layouts.newslist')
@section('title')
    <h1>
        首页
        <small>报表管理</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>报表管理</a></li>
        <li class="active">周报</li>
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
                            <th>起始时间</th>
                            <th class="hidden-md">结束时间</th>
                            <th data-sortable="false">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($reports as $report)
                            <tr> <td></td>
                                <td> <a href="{{route('weekform.newslist',$report->id)}}" class="X-Small btn-xs text-success ">{{ $report->title }}</a></td>
                                <td>{{date('Y-m-d',strtotime($report->starttime))}}</td>
                                <td>
                                    {{date('Y-m-d',strtotime($report->endtime))}}
                              </td>
                                <td><a href="{{route('weekform.destroy',$report->id)}}">删除</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <table width="100%"><tr><td>当前页{{$reports->currentPage()}}共计{{$reports->lastPage()}}页,总记录数{{$reports->total()}}条 </td>
                            <td style="text-align: right"> {{$reports->links()}}</td>
                        </tr></table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">

        function deletebtn(obj) {
            var id = $(obj).attr('attr');
            $('.deleteForm').attr('action', '/admin/report/delete/' + id);
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
                        确认要删除该记录吗?
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
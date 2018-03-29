@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>云词图</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>云词图</a></li>
        <li class="active">热词</li>
    </ol>
@endsection
@section('content')
    <div style="margin-top: 5px;">
    <form class="form-horizontal" role="form" onsubmit="return validate();" method="POST" action="{{route('cloud.add')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="itemstyle" id="itemstyle" value="">
        <div class="box-footer">
            <div class="form-group">
                <label for="keyword" class="col-md-3 control-label">热词</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="keyword" required="required" id="keyword" autocomplete="off" value="" autofocus>
                </div>
            </div>
                <div class="form-group">
                <label for="wordnum" class="col-md-3 control-label">值：</label>
                <div class="col-md-5">
                    <input type="text" class="form-control" name="wordnum" required="required" id="wordnum" autocomplete="off" value="">
                </div> <button type="submit" class="btn btn-info">提交</button>
            </div>
            </div>
    </form>
            <div id="wordcloud"  style="height:400px"></div>
    </div>
<script src="{{asset('web/js/echarts.js')}}"></script>
<script type="text/javascript">

        // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
        require.config({
            paths: {
                echarts: '/web/js'
            }
        });
        // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
        require([
                'echarts',
                'echarts/chart/wordCloud'
            ],
            function (ec) {
                var myChart2 = ec.init(document.getElementById('wordcloud'));
                myChart2.setOption({
                    title: {
                        text: '热词图',
                        link: '/Web/index'
                    },
                    tooltip: {
                        show: false
                    },
                    series: [{
                        name: '热词图',
                        type: 'wordCloud',
                        size: ['80%', '80%'],
                        textRotation: [0, 45, 90, -45],
                        textPadding: 10,
                        autoSize: {
                            enable: true,
                            minSize: 14
                        },
                        data:JSON.parse(getdata())
                    }]
                });
            });
        function getdata() {
            var re;
            $.ajax({
                url: '/cloud/words',
                type: 'get',
                datatype: 'json',
                async: false,
                success: function (data) {
                    re=data;
                }
            });
            return re;
        }
    function createRandomItemStyle() {
        return  'rgb(' + [
                    Math.round(Math.random() * 160),
                    Math.round(Math.random() * 160),
                    Math.round(Math.random() * 160)
                ].join(',') + ')';
    }
    function validate() {
        var name=$("#keyword").val();
        var value=$("#wordnum").val();
        var html="<div class=\"alert alert-danger\">输入项不能为空</div>";
        if(name==null||name==""){  $(".box .info").html(html);return false;}
           if ((!/^[0-9]\d*$/.test(value))) {$(".box .info").html("<div class=\"alert alert-danger\">请将热词的值输入整数</div>");return false;}
        $("#itemstyle").val(createRandomItemStyle());
        return true;
    }
</script>
@endsection

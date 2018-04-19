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
    <style type="text/css">
        #num{ margin-left:10px;width: 80px;height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;border-radius: 4px;}
        #wordlist,#oldlist,#wordlist li,#oldlist li{list-style: none;}
        input{border: 1px solid #ccc;}
        .subkeyword{border:1px solid transparent}
    </style>
 <script type="text/javascript">
     $(function () {
         $(".addkeyword").click(function () {
             var num=$("#num").val();
             if(/^[1-9]\d*$/.test(num))
             {
                 $(".box .info").html("");
                 for (var i=0;i<num;i++){
                     var li="<li><label for=\"words\">热词:</label><input class=\"words\" required=\"required\"><label for=\"val\">值:</label><input class=\"val\" required=\"required\" type='number'> <button type=\"button\" class=\"btn-primary subkeyword\">" +
                         "                            <span class=\"glyphicon glyphicon-minus\"></span>\n" +
                         "                        </button></li>";
                     $("#wordlist").append(li);
                 }
                 $(".subkeyword").click(function () {
                    $(this).parent("li").remove();
                 });
             }
             else { var html="<div class=\"alert alert-danger\">请输入正确热词数量</div>";$(".box .info").html(html);return false;}
         });
         $(".subkeyword").click(function () {
             $(this).parent("li").remove();
         });
     });

 </script>
    <div style="margin-top: 5px;">
    <form class="form-horizontal" role="form" onsubmit="return validate();" method="POST" action="{{route('cloud.add')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="old" id="old" value="">
        <input type="hidden" name="new" id="new" value="">
        <div class="box-footer">
            <div style=" overflow-y:auto; overflow-x:auto;width:100%;height: 450px;">
            <div style=" float: left; width: 50%; height: 100%;">
                <div class="form-group">&nbsp;&nbsp;
                    <label for="num">热词数量:</label><input type="text" name="keyword" required="required" id="num" autocomplete="off" value="1" autofocus>
                    <button type="button" class="btn btn-primary addkeyword">
                        <span class="glyphicon glyphicon-plus"></span>增加
                    </button>
                    <button type="submit" class="btn btn-info">提交保存</button> <font style="color: red;font-size: 12px;">*填写好热词后需要点击提交保存</font>
                </div>
                <div class="form-group">
                    <ul id="wordlist"></ul>
                </div>
            </div>
            <div style="float: left;">
                <div class="form-group"><h4>现有热词(<font color="red">降序</font>):</h4></div>
                <ul id="oldlist">
                </ul>
            </div>
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
                    shape:'circle',
                    tooltip: {
                        show: false
                    },
                    series: [{
                        name: '热词图',
                        type: 'wordCloud',
                        size: ['80%', '80%'],
                        textRotation: [0,0],
                        textPadding: 0,
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
                    var wordlist=eval(data);
                    wordlist.sort(function(x,y){
                        return y["value"] - x["value"];
                    });
                    for(var i=0;i<wordlist.length;i++)
                    {
                      var  li=" <li><label for=\"words\">热词:</label><input class=\"words\" required=\"required\" value='"+wordlist[i]["name"]+"'><label for=\"val\">值:</label><input class=\"val\" required=\"required\" type='number' value='"+wordlist[i]["value"]+"'>\n" +
                          "                        <button type=\"button\" class=\"btn-primary subkeyword\">\n" +
                          "                        <span class=\"glyphicon glyphicon-minus\"></span>\n" +
                          "                        </button>\n" +
                          "                        </li>";
                        $("#oldlist").append(li);

                    }
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
        var old="",words="";
        $("#oldlist li").each(function () {
            var data=new Array(3);
            data[0]=$(this).children(".words").val();
            data[1]=$(this).children(".val").val();
            data[2]=createRandomItemStyle();
            old+=data+"|";
        });
        $("#old").val(old);
        $("#wordlist li").each(function () {
            var data=new Array(3);
            data[0]=$(this).children(".words").val();
            data[1]=$(this).children(".val").val();
            data[2]=createRandomItemStyle();
            words+=data+"|";
        });
        $("#new").val(words);
        var html="<div class=\"alert alert-danger\">输入项不能为空</div>";
        if(old==null&&words==null){  $(".box .info").html(html);return false;}
           //if ((!/^[0-9]\d*$/.test(value))) {$(".box .info").html("<div class=\"alert alert-danger\">请将热词的值输入整数</div>");return false;}
       // $("#itemstyle").val(createRandomItemStyle());
        return true;
    }
</script>
@endsection

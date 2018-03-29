@extends('web.layouts.master')
@section('head')
    <link rel="stylesheet" href="{{asset('web/css/index.css')}}">

@stop
@section('content')
<!--main-->
<div class="main">
    <!--一周系列-->

    <div class="w">
        <!--一周预警-->
        <div class="fl">
            <div class="tsyj">
                <div class="theader">
                    <p class="yuqingpushP">推送预警</p>
                    <a target="_blank" href="{{route('web.news.list')}}" class="more">更多&gt;&gt;</a>
                </div>
                <div class="cont">
                    <div id="yujing" class="gres">
                        @foreach($newslist as $news)
                        <div class="gre gre1"><div class="leftico"><span class="colorpink"><i></i></span></div><span class="grayblock"></span><div class="righttex"><p class="tit"><a href="{{route('web.news.content',$news->id)}}"  target="_blank" title="{{strlen($news->title)>40?substr($news->title,0,40).'...':$news->title}}">{{strlen($news->title)>40?mb_substr($news->title,0,40).'...':$news->title}}</a></p><strong class="colorpink">{{$news->starttime.'&nbsp;'.$news->province}}</strong><em title="{{$news->firstwebsite}}">{{$news->firstwebsite}}</em></div></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!--一周走势图-->
        <div class="fr">
            <div class="zshiimg">
                <div class="theader">
                    <p class="yuqingpushP">一周走势图</p>
                </div>
                <div class="cont">
                    <div id="main" style="height: 286px; width: 650px; -webkit-tap-highlight-color: transparent; user-select: none; background-color: rgba(0, 0, 0, 0); cursor: default;" _echarts_instance_="1521433864750">
                </div>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div style="height: 20px; clear: both"></div>
    <div class="w">
        <!--地域舆情-->
            <div class="zshiimg">
                <div class="theader">
                    <p class="yuqingpushP">地域舆情</p>
                </div>
                <div class="cont">
                    <div id="mainmap" class="fl" style="height: 280px; width: 650px; -webkit-tap-highlight-color: transparent; user-select: none; background-color: rgba(0, 0, 0, 0); cursor: default;" _echarts_instance_="1521433864751">
                       </div>
                    <div class="lists" the-id="echarlist">
                        <table>
                            <thead>
                            <tr>
                                <td>地区</td>
                                <td>数据量</td>
                                <td>负面数</td>
                                <td>负面占比</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($listmaps as $map)
                            <tr>
                                <td>{{$map->province}}</td>
                                <td class="td1">{{$map->total==null?"0":$map->total}}</td>
                                <td class="td2">{{$map->fumian==null?"0":$map->fumian}}</td>
                                <td class="td2">{{$map->fumian==null?"0":round(($map->fumian/$map->total)*100,2)}}%</td>
                            </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div>
        <div style="height: 20px;"></div>
        <div class="zshiimg">
            <div style="height: 40px;line-height: 40px;border-bottom: 1px solid #e5e5e5;position: relative;">
                <p class="yuqingpushP">热词图</p>
            </div>
            <div id="wordcloud" style="height:400px;"  ></div>
        </div>

</div>
</div>
    @stop
<script src="{{asset('web/js/echarts.js')}}"></script>
<script type="text/javascript">
    // Step:3 为模块加载器配置echarts的路径，从当前页面链接到echarts.js，定义所需图表路径
    require.config({
        paths: {
            echarts: '/web/js'
        }
    });
    // Step:4 动态加载echarts然后在回调函数中开始使用，注意保持按需加载结构定义图表路径
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
            'echarts/chart/map',
            'echarts/chart/wordCloud'
        ],
        function (ec) {
            //--- 折柱 ---
            var myChart = ec.init(document.getElementById('main'),'macarons');
            myChart.setOption({
                tooltip : {
                    trigger: 'axis'
                },
                legend: {
                    data:['全部','正面','中性','负面','推送舆情']
                },
                toolbox: {
                    show : true,
                    feature : {
                        dataView : {show: true, readOnly: false},
                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data :{!!json_encode($week["date"]) !!}
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                    splitArea : {show : true}
                   }
                ],
                series : {!!json_encode($week["data"]) !!}
            });

            // --- 地图 ---
            var myChart2 = ec.init(document.getElementById('mainmap'), 'macarons');
            myChart2.setOption({
                tooltip : {
                    trigger: 'item',
                    formatter: '{b} : {c}'
                },
                dataRange: {
                    min: 0,
                    max: 100,
                    x: 'left',
                    y: 'bottom',
                    text:['高','低'],           // 文本，默认为数值文本
                    calculable : true
                },
                series : [
                    {
                        name: '中国',
                        type: 'map',
                        mapType: 'china',
                        itemStyle:{
                            normal:{label:{show:true}},
                            emphasis:{label:{show:true}}
                        },
                        data:{!!json_encode($datamap) !!}
                    }
                ]
            });
             //--热词图--
            var myChart3 = ec.init(document.getElementById('wordcloud'));
            myChart3.setOption({
                tooltip: {
                    show: true
                },
                series: [{
                    name: '热词图',
                    type: 'wordCloud',
                    size: ['80%', '80%'],
                    textRotation: [0, 45, 90, -45],
                    textPadding: 0,
                    autoSize: {
                        enable: true,
                        minSize: 14
                    },
                    data:JSON.parse(getdata())
                }]
            })

        }
    );
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
</script>
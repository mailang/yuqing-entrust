@extends('web.layouts.master')
@section('head')
    <link rel="stylesheet" href="{{asset('web/css/index.css')}}">
    <style type="text/css">
     #oldlist,#oldlist li{ text-indent:10px;list-style: none; font-size: 16px; font-family:"宋体",Arial,sans-serif}
    </style>
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


                            <tr>
                                <td>陕西</td>
                                <td class="td1">78881</td>
                                <td class="td2">5384</td>
                                <td class="td2">6.83%</td>
                            </tr>

                            <tr>
                                <td>湖南</td>
                                <td class="td1">91791</td>
                                <td class="td2">6239</td>
                                <td class="td2">6.80%</td>
                            </tr>

                            <tr>
                                <td>北京</td>
                                <td class="td1">275509</td>
                                <td class="td2">17077</td>
                                <td class="td2">6.20%</td>
                            </tr>

                            <tr>
                                <td>河北</td>
                                <td class="td1">98655</td>
                                <td class="td2">6067</td>
                                <td class="td2">6.15%</td>
                            </tr>

                            <tr>
                                <td>江西</td>
                                <td class="td1">64420</td>
                                <td class="td2">3912</td>
                                <td class="td2">6.07%</td>
                            </tr>

                            <tr>
                                <td>浙江</td>
                                <td class="td1">164326</td>
                                <td class="td2">9763</td>
                                <td class="td2">5.94%</td>
                            </tr>

                            <tr>
                                <td>湖北</td>
                                <td class="td1">90826</td>
                                <td class="td2">5346</td>
                                <td class="td2">5.89%</td>
                            </tr>

                            <tr>
                                <td>安徽</td>
                                <td class="td1">82161</td>
                                <td class="td2">4730</td>
                                <td class="td2">5.76%</td>
                            </tr>

                            <tr>
                                <td>香港</td>
                                <td class="td1">57784</td>
                                <td class="td2">3308</td>
                                <td class="td2">5.72%</td>
                            </tr>

                            <tr>
                                <td>广西</td>
                                <td class="td1">48659</td>
                                <td class="td2">2739</td>
                                <td class="td2">5.63%</td>
                            </tr>

                            <tr>
                                <td>台湾</td>
                                <td class="td1">50352</td>
                                <td class="td2">2816</td>
                                <td class="td2">5.59%</td>
                            </tr>

                            <tr>
                                <td>江苏</td>
                                <td class="td1">192673</td>
                                <td class="td2">10663</td>
                                <td class="td2">5.53%</td>
                            </tr>

                            <tr>
                                <td>福建</td>
                                <td class="td1">85326</td>
                                <td class="td2">4636</td>
                                <td class="td2">5.43%</td>
                            </tr>

                            <tr>
                                <td>辽宁</td>
                                <td class="td1">70188</td>
                                <td class="td2">3806</td>
                                <td class="td2">5.42%</td>
                            </tr>

                            <tr>
                                <td>山西</td>
                                <td class="td1">56427</td>
                                <td class="td2">3012</td>
                                <td class="td2">5.34%</td>
                            </tr>

                            <tr>
                                <td>河南</td>
                                <td class="td1">122892</td>
                                <td class="td2">6316</td>
                                <td class="td2">5.14%</td>
                            </tr>

                            <tr>
                                <td>天津</td>
                                <td class="td1">45422</td>
                                <td class="td2">2315</td>
                                <td class="td2">5.10%</td>
                            </tr>

                            <tr>
                                <td>重庆</td>
                                <td class="td1">51369</td>
                                <td class="td2">2616</td>
                                <td class="td2">5.09%</td>
                            </tr>

                            <tr>
                                <td>山东</td>
                                <td class="td1">171526</td>
                                <td class="td2">8335</td>
                                <td class="td2">4.86%</td>
                            </tr>

                            <tr>
                                <td>黑龙江</td>
                                <td class="td1">42380</td>
                                <td class="td2">2020</td>
                                <td class="td2">4.77%</td>
                            </tr>

                            <tr>
                                <td>上海</td>
                                <td class="td1">158924</td>
                                <td class="td2">7579</td>
                                <td class="td2">4.77%</td>
                            </tr>

                            <tr>
                                <td>贵州</td>
                                <td class="td1">39875</td>
                                <td class="td2">1871</td>
                                <td class="td2">4.69%</td>
                            </tr>

                            <tr>
                                <td>云南</td>
                                <td class="td1">72102</td>
                                <td class="td2">3359</td>
                                <td class="td2">4.66%</td>
                            </tr>

                            <tr>
                                <td>海南</td>
                                <td class="td1">34189</td>
                                <td class="td2">1544</td>
                                <td class="td2">4.52%</td>
                            </tr>

                            <tr>
                                <td>四川</td>
                                <td class="td1">142267</td>
                                <td class="td2">6395</td>
                                <td class="td2">4.50%</td>
                            </tr>

                            <tr>
                                <td>甘肃</td>
                                <td class="td1">36159</td>
                                <td class="td2">1620</td>
                                <td class="td2">4.48%</td>
                            </tr>

                            <tr>
                                <td>吉林</td>
                                <td class="td1">36170</td>
                                <td class="td2">1584</td>
                                <td class="td2">4.38%</td>
                            </tr>

                            <tr>
                                <td>澳门</td>
                                <td class="td1">7834</td>
                                <td class="td2">328</td>
                                <td class="td2">4.19%</td>
                            </tr>

                            <tr>
                                <td>广东</td>
                                <td class="td1">251262</td>
                                <td class="td2">10428</td>
                                <td class="td2">4.15%</td>
                            </tr>

                            <tr>
                                <td>青海</td>
                                <td class="td1">27553</td>
                                <td class="td2">1113</td>
                                <td class="td2">4.04%</td>
                            </tr>

                            <tr>
                                <td>新疆</td>
                                <td class="td1">37263</td>
                                <td class="td2">1367</td>
                                <td class="td2">3.67%</td>
                            </tr>

                            <tr>
                                <td>内蒙古</td>
                                <td class="td1">42214</td>
                                <td class="td2">1516</td>
                                <td class="td2">3.59%</td>
                            </tr>

                            <tr>
                                <td>西藏</td>
                                <td class="td1">20444</td>
                                <td class="td2">546</td>
                                <td class="td2">2.67%</td>
                            </tr>

                            <tr>
                                <td>宁夏</td>
                                <td class="td1">37531</td>
                                <td class="td2">822</td>
                                <td class="td2">2.19%</td>
                            </tr>


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
            <div class="cont">
            <div id="wordcloud" style="height:328px;width: 650px; float: left;"  ></div>
                <div class="lists">
                    <table  id="oldlist">
                        <thead>
                        <tr>
                            <td>热词</td>
                            <td>热词值</td>
                        </tr>
                        </thead>
                      </table>
            </div>  </div>
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
          series : [
                {
                    name:'全部',
                    type:'bar',
                    data:[18812, 19533, 19014, 15955, 10076, 8142, 1527]
                },
                {
                    name:'正面',
                    type:'bar',
                    data:[8520, 8765, 1572, 645, 201, 254, 60]
                },
                {
                    name:'中性',
                    type:'bar',
                    data:[3612, 4660, 13525, 11228, 7095, 6008, 1053]
                },
                {
                    name:'负面',
                    type:'bar',
                    data:[6680, 6108, 4289, 4363, 2860, 1954, 441]
                },
                {
                    name:'推送舆情',
                    type:'bar',
                    data:[52, 57, 58, 63, 30, 25, 4]
                }
            ]
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
                    max: 275509,
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
                        data:[
                            {'name':'陕西','value':78881},{'name':'湖南','value':91791},{'name':'北京','value':275509},{'name':'河北','value':98655},{'name':'江西','value':64420},{'name':'浙江','value':164326},{'name':'湖北','value':90826},{'name':'安徽','value':82161},{'name':'香港','value':57784},{'name':'广西','value':48659},{'name':'台湾','value':50352},{'name':'江苏','value':192673},{'name':'福建','value':85326},{'name':'辽宁','value':70188},{'name':'山西','value':56427},{'name':'河南','value':122892},{'name':'天津','value':45422},{'name':'重庆','value':51369},{'name':'山东','value':171526},{'name':'黑龙江','value':42380},{'name':'上海','value':158924},{'name':'贵州','value':39875},{'name':'云南','value':72102},{'name':'海南','value':34189},{'name':'四川','value':142267},{'name':'甘肃','value':36159},{'name':'吉林','value':36170},{'name':'澳门','value':7834},{'name':'广东','value':251262},{'name':'青海','value':27553},{'name':'新疆','value':37263},{'name':'内蒙古','value':42214},{'name':'西藏','value':20444},{'name':'宁夏','value':37531},
                        ]
                    }
                ]
            });
             //--热词图--
            var myChart3 = ec.init(document.getElementById('wordcloud'));
            myChart3.setOption({
                tooltip: {
                    show: false
                },
                series: [{
                    name: '热词图',
                    type: 'wordCloud',
                    size: ['80%', '80%'],
                    textRotation: [0, 0],
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
                var wordlist=eval(data);
                wordlist.sort(function(x,y){
                    return y["value"] - x["value"];
                });
                for(var i=0;i<wordlist.length;i++)
                {
                    var  li= "<tr><td>"+wordlist[i]["name"]+"</td><td class=\"td1\">"+wordlist[i]["value"]+"</td> </tr>"
                    $("#oldlist").append(li);
                }
            }
        });
        return re;
    }
</script>
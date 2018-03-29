@extends('web.layouts.master')
@section('head')
    <link rel="stylesheet" href="{{asset('web/css/public.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/toalarm.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/browse.css')}}">
    <link rel="stylesheet" href="{{asset('web/css/WdatePicker.css')}}">
    <script>
        $(function () {
          $('#allcheckbox').click(function () {
             if($(this).is(":checked")){$(".input_checkbox").prop('checked',true);}else $(".input_checkbox").prop('checked',false);
          });
            $("div[the-id=hideabstract_comold]").click(function (e) {
                var e = $(this).attr("type");
                "block" == e ? ($("[the-id=list_message]").slideUp(), $(this).attr("type", "none"), $(this).find("span").html("显示摘要")) : ($("[the-id=list_message]").slideDown(),
                    $(this).find("span").html("隐藏摘要"), $(this).attr("type", "block"));
            });
            $(".search_text").mouseup(function () {
                $("#skeywords").val($(this).val());
                $("#stype").val($(".input_select").val());

            });
        });
        function jump(p,s){
            $("#pageNum").val(p);
            $("#pageSize").val(s);
            $("#searchForm").attr("action","/Web/news/page");
            $("#searchForm").submit();
        }
    </script>
@stop
@section('content')
    <div class="wary" ajaxurl="#" the-id="getajaxUrl"><!--header start-->
        <input value="1" the-id="soundhidden" type="hidden"><!--centre start-->
        <div class="centre" the-id="type1" types="1"><!--左侧边栏导航栏sta-->
            <div class="slide_nav"><!--头部信息-->
                <div class="title_head"><img src="{{asset('web/img/push_picsmall.gif')}}"> 专题列表
                </div><!--伸缩菜单-->

            </div>
            <div class="centre_content centre_content_noright"><!--搜索条件上-->
                <div class="push_search"><!--切换搜索导航-->
                    <div class="nav_top"><input name="sid" value="" type="hidden"><input name="tid" value="07" type="hidden"><input name="sourcetype" value="" type="hidden"><input name="isread" value="" type="hidden"><input name="time" value="" type="hidden"><input name="etime" value="" type="hidden"><input name="btime" value="" type="hidden"><input name="isyj" value="" type="hidden">
                        <!--<ul><li class="hover" sourcetype=""  the-id='pushwarning_media'>全部</li><li sourcetype="01"  the-id='pushwarning_media'>新闻</li><li sourcetype="02"  the-id='pushwarning_media'>论坛</li><li sourcetype="03"  the-id='pushwarning_media'>博客</li><li sourcetype="04"  the-id='pushwarning_media'>微博</li><li sourcetype="05"  the-id='pushwarning_media'>平媒</li><li sourcetype="06"  the-id='pushwarning_media'>微信</li><li sourcetype="07"  the-id='pushwarning_media'>视频</li><li sourcetype="09"  the-id='pushwarning_media'>APP</li><li sourcetype="08"  the-id='pushwarning_media'>长微博</li><li sourcetype="10"  the-id='pushwarning_media'>评论</li><li sourcetype="99"  the-id='pushwarning_media'>其他</li></ul>-->
                        <div class="clear"></div>
                    </div><!--搜索条件-->
                    <div class="search_condition"><!--上方搜索框-->
                        <div class="top_search">
                            <div style="float: left;padding-bottom: 10px;padding-right: 10px;">
                                <form id="searchForm" action="{{route('web.news.search')}}" method="post">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="select">
                                        <select class="input_select" name="type" autocomplete="off">
                                            <option value="title">标题搜索</option>
                                            <option value="firstwebsite">来源搜索</option>
                                            <option value="author">作者搜索</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="pageNum" name="pageNum" value="">
                                    <input type="hidden" id="pageSize" name="pageSize" value="">
                                    <input type="hidden" id="stype" name="stype" value="@if(isset($data["type"])){{$data["type"]}}@endif">
                                    <input type="hidden" id="skeywords" name="skeywords" value="@if(isset($data["keyword"])){{$data["keyword"]}}@endif">
                                    <div class="input">
                                        <input class="search_text" name="keyWord" the-id="findmessage" placeholder="请输入关键字" required autocomplete="off" type="text">
                                        <div class="borwsehost_hint domains">
                                            <ul></ul>
                                        </div>
                                    </div>
                                    <div class="button"><input value="搜索" class="input_sub" type="submit"></div>
                                </form>
                            </div>
                            <div style="overflow: hidden;float: right;padding-bottom: 10px;">

                            </div>
                            <div class="clear"></div>
                        </div><!--搜索条件选项区域-->
                        <div class="search_content"><!--储存筛选条件区域-->
                            <!--选择筛选条件-->

                        </div>
                    </div>
                </div>
                <div class="content_list information_wrap">
                    <div class="search_top">
                        <div class="all_checkbox"><label><input class="input_checkbox" id="allcheckbox" type="checkbox">&nbsp;全选</label>
                        </div>
                        <div class="right_dom">
                            <div class="select">
                                <select class="num_show" sid="" tid="07" onchange="jump(1,this.value)"  the-id="num_show" autocomplete="off">
                                    <option value="10" selected="selected">10条</option>
                                    <option value="30" @if(isset($data["size"])&&$data["size"]==30)selected="selected"@endif >30条</option>
                                    <option value="50" @if(isset($data["size"])&&$data["size"]==50)selected="selected"@endif>50条</option>
                                    <option value="100" @if(isset($data["size"])&&$data["size"]==100)selected="selected"@endif>100条</option>
                                </select></div>
                            <div class="toggle_abstract" the-id="hideabstract_comold" type="block"><img src="{{asset('web/img/push_yincang.gif')}}"><span>隐藏摘要</span>
                            </div>
                        </div>
                    </div><!--信息列表-->
                    <div class="message_list">
                        <ul>
                            @foreach($newslist as $news)
                            <li>
                                <div class="all_checkbox"><label><input class="input_checkbox"  id="title_checkbox" type="checkbox"></label>
                                </div>
                                <div class="main_content new_data">
                                    <div class="top_message">
                                        <div class="title_text">
                                            <div class="title">
                                                <a href="{{route('web.news.content',$news->id)}}" target="_blank" class="fm">{{$news->title}}</a>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="list_message " the-id="list_message" style="display:block">
                                    <p style="text-indent:24pt;" class="MsoNormal">
	                                <span style="line-height:150%;font-family:宋体;font-size:12pt;"><span>{{$news->abstract}}</span> <span>　
                                    </span></span></p><div class="url_wrap">
                                            <div class="address"><em>倾向性： {{$news->orientation}}  </em><em> {{$news->firstwebsite}} </em><em> {{$news->starttime}}
                                                </em><em> 首发网站： {{$news->firstwebsite}} </em></div>
                                            <!--一堆图标-->

                                        </div>
                                    </div>
                                </div></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="comold-jump-browse jump" sid="" site="" orientation="" state="" tid="07" sourcetype="" repeat="" isread="" time="" btime="" etime="" type="" message="" pagesize="10" classid="" kkname="" isyj="" now="1484521796" mate="" region="" position="" distance="" filter="" ignore_loc="" ignore_topic="" ignore_a="" sourceattr="" degree="">
                        <div class="jump_wrap">
                            <div class="jump-index">
                                <input id="gPage" name="gPage" value="1" class="jump_text" type="text">
                                <input class="jump_submit" value="确定" type="button" onclick="jump(document.getElementById('gPage').value,{{ $data["size"] }} )">
                            </div>
                            <div class="jump-page" id="jump_wrap"><span class="rows">共 {{$data["total"]}} 条记录 {{ $data["page"] }}/{{ceil($data["total"]/$data["size"])}}页&nbsp;</span>
                                <a href="javascript:void(0)"  onclick="jump(1,{{$data["size"]}});">首页</a>
                                <a href="javascript:void(0)" @if ($data["page"]<ceil($data["total"]/$data["size"])) onclick="jump({{++$data["page"]}},{{$data["size"]}});"@endif>下一页</a>
                                <a href="javascript:void(0)" onclick="jump({{ceil($data["total"]/$data["size"])}},{{$data["size"]}});">末页</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--中间内容end--><!--右侧信息栏sta--><!--右侧信息栏end-->
            <div class="clear"></div>
        </div><!--centre end--><!--首页警示层STA-->
    </div>
    @stop
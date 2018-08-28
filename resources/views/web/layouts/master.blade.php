<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>人民法院执行舆情管理系统</title>
    <link rel="stylesheet" href="{{asset('web/css/base.css')}}">
    <script src="{{asset('web/js/jquery-1.11.1.js')}}"></script>
    @yield('head')
</head>
<body>
@section('header')
<!--head-->
<div class="header">
    <div class="w">
        <div class="clearfix" style="overflow: hidden">
            <div class="logoimg fl">
                <img src="{{asset('web/img/mslogo.png')}}" alt="">
            </div>
            <div class="fr" style="line-height: 64px;padding: 0 10px;color: #ffffff;">
              <!--  <p>欢迎您，zuigaofa</p>-->
            </div>
        </div>
    </div>
</div>@show
<div style="height: 20px;"></div>
<!--head end-->
@yield('content')
@section('footer')
<!--footer-->
<div class="clear"></div>
<div id="footer" class="footer">
    <div class="footer-left"><p>
            版权所有©中华人民共和国最高人民法院</p>
        <p>皖ICP备12009888号-1&nbsp;&nbsp;皖公网安备110123562008588号</p>
        <p>Copyright © 2001-2017 keeprisk.com.All rights reserved.</p></div>
    <div class="footer-right"><img src="{{asset('web/img/footer_s2.png')}}">
        <p>市场电话：0551-63699088</p>
        <p>客服邮箱：<a href="#">service@keeprisk.com</a></p>
        <p>客服电话：0551-63699088</p></div>
    <div class="clear"></div>
</div>
<!--footer end-->
@show
<script>

    $(function () {
        $win=$(window).height();
        $body=$("body").height();
        if ($body<$win)
         $("#footer").css({'position':'fixed','bottom':'0px'});
    })
</script>
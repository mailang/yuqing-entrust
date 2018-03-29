@extends('web.layouts.master')
@section('head')
    <link rel="stylesheet" href="{{asset('web/css/yuqtex.css')}}">
@stop
@section('content')
        <div class="w" style="margin-top: 20px;">
            <div class="maintext">

                <h1>{{$news->title}}</h1>
                <div class="information"><i style="margin-left:0;">{{$news->starttime}}
                    </i>
                    <i>{{$news->firstwebsite}}</i>
                    <i>作者：{{$news->author}}</i>
                    <i>属性：{{$news->orientation}}</i>
                    <i style="float:right;">首发网站：{{$news->firstwebsite}}</i></div>
                <div class="url">原文链接:&nbsp;

                    <a href="{{$news->link}}" target="target">{{$news->link}}</a>

                </div>
                <div class="content_wrap">
                   {!! html_entity_decode($news->content)!!}
                </div>

            </div>
        </div>

@stop
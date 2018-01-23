@extends('layouts.master')
@section('title')
    <h1>
        后台首页
        <small>it all starts here</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>index</a></li>
        <li class="active">index</li>

    </ol>
@endsection
@section('content')
test{{ auth('admin')->user()->username }}
@endsection

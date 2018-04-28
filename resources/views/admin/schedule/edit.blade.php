@extends('layouts.master')
@section('title')
    <h1>
        首页
        <small>排班表</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>排班表</a></li>
    </ol>
    <style type="text/css">
    table td{border:1px solid #0a0a0a; font-size:16px;height:auto !important;min-height:50px;}
    </style>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 40px;">
                        <div style="float: left;">
                            <a href="javascript:history.back('-1')"> 返回</a></div>
                    </div>
                </div></div>
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{route('schedule.update',$schedule->id)}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div style="text-align: center;"><h3> {{$schedule->time}}排班表({{$schedule->weekday}}) </h3> </div>
                        <div class="form-group">
                            <table  width="800" align="center">
                                <tr> <td style="text-align: center; width: 200px;">
                                        8:00-9:00<br>
                                        10:-11:00
                                        12:00-13:00<br>
                                        14:00-15:00<br>
                                        16:00-17:00
                                    </td>
                                <td style="text-align: left;width: 600px;">
                                    <?php $total=json_decode($schedule->schedule);
                                    $user1=$total[0]->group==1?$total[0]->admins:$total[1]->admins;
                                    ?>
                                    <textarea id="group1" name="group1" style="height: 113px;width: 500px;">  @foreach($user1 as $keys=>$user) @if(count($user1)==($keys+1)){{$user}}@else{{  $user.' |'}}@endif @endforeach </textarea>
                                </td>
                                </tr>
                                <tr> <td style="text-align: center;">
                                        8:00-9:00<br>
                                        10:-11:00<br>
                                        12:00-13:00<br>
                                        14:00-15:00<br>
                                        16:00-17:00
                                    </td>
                                    <td  style="text-align: left;">
                                        <?php
                                        $user2=$total[1]->group==2?$total[1]->admins:$total[0]->admins;
                                        ?>
                                        <textarea id="group2" name="group2" style="height: 113px;width: 500px;">@foreach($user2 as $keys=>$user)  @if(count($user2)==($keys+1)){{$user}}@else{{  $user.' |'}}@endif @endforeach </textarea>
                                    </td>
                                </tr>

                            </table>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                                <button type="submit" class="btn btn-primary btn-md">
                                    <i class="fa fa-plus-circle"></i>
                                    添加
                                </button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
@endsection
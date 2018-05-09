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
        table td,table th{text-align:center;border:1px solid #0a0a0a; font-size:16px;height:auto !important;min-height:50px;}
    </style>
@endsection
@section('content')
    <div class="main animsition">
        <div class="container-fluid">
            <div class="row">
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 40px;">
                       <div style="float: left;"><h3 class="panel-title">排班表</h3></div>
                        <div style="float: right"><a href="{{route('schedule.list')}}"><font color="blue">所有排班表</font></a></div>
                    </div>
                    <div class="box-body">
                      <div style="text-align: center;"><h3>{{$data['time1']}} &nbsp;- &nbsp;{{$data['time2']}} 排班表 </h3> </div>
                        <div>
                            <table  width="800" align="center">
                                <thead>
                                <tr style="height: 50px">
                                    <th width="20%">星期</th>
                                    <th width="40%">时间段</th>
                                    <th width="40%">排班人员</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $schedule)
                                <tr>
                                    <td rowspan="2">
                                        @if($data['role']==1)
                                        <a href="{{route('schedule.edit',$schedule->id)}}">{{$schedule->weekday}}</a>
                                        @else
                                            {{$schedule->weekday}}
                                        @endif
                                    </td>
                                    <td>
                                         8:00-9:00<br>
                                        10:00-11:00<br>
                                        12:00-13:00<br>
                                        14:00-15:00<br>
                                        16:00-17:00
                                    </td>
                                    <td>
                                        <?php $total=json_decode($schedule->schedule);

                                         $user1=$total[0]->group==1?$total[0]->admins:$total[1]->admins;

                                         foreach($user1 as $user){    echo $user.'<br>';}
                                        ?>


                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        9:00-10:00<br>
                                        11:00-12:00<br>
                                        13:00-14:00<br>
                                        15:00-16:00<br>
                                        17:00-17:30
                                    </td>
                                    <td>
                                          <?php
                                        $user2=$total[1]->group==2?$total[1]->admins:$total[0]->admins;
                                        foreach($user2 as $user){echo $user.'<br>';}
                                          ?>
                                    </td>
                                </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reportform;
use App\Models\Useful_news;
use Illuminate\Support\Facades\DB;

class ReportformController extends Controller
{
    /*get relateyl reportform*/
    function  list()
    {
        $report=Reportform::orderBy('id','desc')->first();
        $news=Useful_news::where('reportform_id',$report->id)->get(['title','content','author','firstwebsite','sitetype','link','keywords','court','transmit','visitnum','replynum','starttime','orientation','yuqinginfo','abstract']);
        $result_report=Array();
        $result_report["id"]=$report->id;
        $result_report["num"]=count($news);
        $result_report["data"]=$news;
      return \response()->json($result_report);
    }
}

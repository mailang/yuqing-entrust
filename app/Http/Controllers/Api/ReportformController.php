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
//    function  list()
//    {
//        $report=Reportform::orderBy('id','desc')->first();
//
//        $news=Useful_news::where('reportform_id',$report->id)->get(['title','content','author','firstwebsite','sitetype','link','keywords','court','transmit','visitnum','replynum','starttime','orientation','yuqinginfo','abstract as abs']);
//        $result_report=Array();
//        $result_report["id"]=$report->title;
//        $result_report["num"]=count($news);
//        $result_report["descountid"] = "0";
//        $result_report["data"]=$news;
//      return \response()->json($result_report);
//    }

    function list()
    {
        $report=Reportform::orderBy('id','desc')->first();
        $sql = "select `title`,`content`,`author`,`firstwebsite`,`sitetype`,`link`,`keywords`,`court`,`transmit`,`visitnum`,`replynum`,`starttime`,`orientation`,`yuqinginfo`,`abstract` as abs,c.province from useful_news left join (SELECT MAX(courtid),NAME,province FROM court GROUP BY NAME,province)as c on useful_news.court=c.name where useful_news.reportform_id='$report->id'";
        $news = DB::select("$sql");
        $result_report=Array();
        $result_report["id"]=$report->title;
        $result_report["num"]=count($news);
        $result_report["descountid"] = "0";
        $result_report["data"]=$news;
        return \response()->json($result_report);
    }

    function listtest()
    {
        $res = array();
        $reports = Reportform::orderBy('id','desc')->chunk(15,function ($reports){
            foreach ($reports as $report){
                $report=Reportform::orderBy('id','desc')->first();
                $sql = "select `title`,`content`,`author`,`firstwebsite`,`sitetype`,`link`,`keywords`,`court`,`transmit`,`visitnum`,`replynum`,`starttime`,`orientation`,`yuqinginfo`,`abstract` as abs,c.province from useful_news left join (SELECT MAX(courtid),NAME,province FROM court GROUP BY NAME,province)as c on useful_news.court=c.name where useful_news.reportform_id='$report->id'";
                $news = DB::select("$sql");
                $result_report=Array();
                $result_report["id"]=$report->title;
                $result_report["num"]=count($news);
                $result_report["descountid"] = "0";
                $result_report["data"]=$news;
                array_push($res,$result_report);
            }
        });
        return \response()->json($res);

    }
}

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

    function list($id = null)
    {
        if($id){
            $report=Reportform::where('title',$id)->where('ispush','1')->first();
            if (!$report){
                return;
            }
        }else{
            $report=Reportform::orderBy('id','desc')->where('ispush','1')->first();
        }
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
        $report=Reportform::orderBy('id','desc')->first();
        $reports = Reportform::where('created_at','>','2020-01-01')->where('id','<>',$report['id'])->where('ispush','1')->orderBy('id','asc')->get();
        //dd($reports);
        foreach ($reports as $report){

            $sql = "select `title`,`content`,`author`,`firstwebsite`,`sitetype`,`link`,`keywords`,`court`,`transmit`,`visitnum`,`replynum`,`starttime`,`orientation`,`yuqinginfo`,`abstract` as abs,c.province from useful_news left join (SELECT MAX(courtid),NAME,province FROM court GROUP BY NAME,province)as c on useful_news.court=c.name where useful_news.reportform_id='$report->id'";
            $news = DB::select("$sql");
            $result_report=Array();
            $result_report["id"]=$report->title;
            $result_report["num"]=count($news);
            $result_report["descountid"] = "0";
            $result_report["data"]=$news;
            //array_push($res,$result_report);
            $res[] = $result_report;
        }
        return \response()->json($res);
    }

    function listdate()
    {
        $starttime = isset($_GET["starttime"])?$_GET["starttime"]:"";
        $endtime = isset($_GET["endtime"])?$_GET["endtime"]:"";
        $reports = Reportform::where('ispush','1');

        $res = array();



        if (($starttime && !strtotime($starttime)) || ($endtime && !strtotime($endtime)))
            return \response()->json($res);

        if ($starttime)
            $reports = $reports->where('created_at','>',"$starttime");
        if ($endtime)
            $reports = $reports->where('created_at','<=',"$endtime");



        $reports = $reports->orderBy('id','asc')->get();
        //dd($reports);
        foreach ($reports as $report){

            $sql = "select `title`,`content`,`author`,`firstwebsite`,`sitetype`,`link`,`keywords`,`court`,`transmit`,`visitnum`,`replynum`,`starttime`,`orientation`,`yuqinginfo`,`abstract` as abs,c.province from useful_news left join (SELECT MAX(courtid),NAME,province FROM court GROUP BY NAME,province)as c on useful_news.court=c.name where useful_news.reportform_id='$report->id'";
            $news = DB::select("$sql");
            $result_report=Array();
            $result_report["id"]=$report->title;
            $result_report["num"]=count($news);
            $result_report["descountid"] = "0";
            $result_report["data"]=$news;
            //array_push($res,$result_report);
            $res[] = $result_report;
        }
        return \response()->json($res);
    }
}

<?php

namespace App\Http\Controllers;

use function GuzzleHttp\default_ca_bundle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use App\Models\News;
use App\Models\Reportform;
use App\Models\useful_news;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    //

    function index(){
        $tmppath = resource_path("template/");
        $path = storage_path("tmp/");

        if (!file_exists($path)){
            mkdir ($path,0777,true);
        }

        //$resualt = News::where([])->orderBy("id")->limit(10)->get();
        $id = 3;
        $r = Reportform::find($id);
        $zipname = $r["title"];
        $bm = "";
        switch ($r["type"]) {
            case 0:
                $bm = "早报";
                break;
            case 1:
                $bm = "午报";
                break;
            case 2:
                $bm = "晚报";
                break;
            default:
                $bm = "测试";
                return;
        }
        $nameexcel = "最高执行指挥中心首页舆情信息".substr($zipname,0,8).$bm;
        $namewordall = substr($zipname,0,8).$bm."_执行舆情监测";

        //dd($zipname,$name);
        $resualt = useful_news::where("reportform_id",$id)->get();
        //$resualt = DB::select("select *,concat(left(areacode,2),'0000') as areas from useful_news where reportform_id = $id");
        //dd($resualt);

        //$this->createwordc($tmppath,$path,$resualt);
        //$this->createexcel($tmppath,$path,$nameexcel,$resualt);
        $this->createwordall($tmppath,$path,$namewordall,$zipname,$r["type"],$resualt);

    }

    function createwordall($tmppath,$path,$name,$zipname,$type,$news){
        $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','tempall' ).'.docx';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessorRe($inputFileName);

        $templateProcessor->setValue('alltitle', $name);
        //dd(date("Y-m-d",strtotime($zipname)));
        $time = "";
        switch ($type) {
            case 0:
                $time = date("Y-m-d 18:00:00",strtotime("-1 day",strtotime($zipname)))." - ".date("Y-m-d 08:00:00",strtotime($zipname));
                break;
            case 1:
                $time = date("Y-m-d 8:00:00",strtotime($zipname))." - ".date("Y-m-d 12:00:00",strtotime($zipname));
                break;
            case 2:
            default:
                $time = date("Y-m-d 12:00:00",strtotime($zipname))." - ".date("Y-m-d 18:00:00",strtotime($zipname));
                break;
        }
        $templateProcessor->setValue('time', $time);
        $news1 = $news->where("orientation","正面");
        $count1 = $news1->count();
        $news2 = $news->where("orientation","中性");
        $count2 = $news2->count();
        $news3 = $news->where("orientation","负面");
        $count3 = $news3->count();
        $templateProcessor->setValue('count1', $count1);
        $templateProcessor->setValue('count2', $count2);
        $templateProcessor->setValue('count3', $count3);

        if($count3 == 0){
            $templateProcessor->deleteBlock("hasfumian");
            $templateProcessor->cloneBlock("nonefumian");
        }else{
            $templateProcessor->deleteBlock("nonefumian");
            $templateProcessor->cloneBlock("hasfumian");
            $templateProcessor->cloneRow("tid",$count3);
            $templateProcessor->cloneBlock("repeat",$count3);
        }

        $i = 1;
        foreach ($news3 as $new){
            $templateProcessor->setValue("tid#$i", $i);
            $templateProcessor->setValue("ttitle#$i", htmlentities($new->title));

            $areacodes = substr($new->areacode,0,2)."0000";
            $dq = Address::where("areacode",$areacodes)->first()->name;


            $templateProcessor->setValue("tarea#$i", $dq);
            $templateProcessor->setValue("tcourt#$i", $new->court);
            $templateProcessor->setValue("tyuqinginfo#$i", $new->yuqinginfo);
            $templateProcessor->setValue("tstarttime#$i", $new->starttime);

            $templateProcessor->setValue('cid', $i,1);
            $templateProcessor->setValue('ctitle', $new->title,1);
            $templateProcessor->setValue('clink', $new->link,2);
            $templateProcessor->setValue('cabstract', $new->abstract,1);
            $i++;
        }

        //表格
        $c1_00 = $c2_00 =              //最高
        $c1_11 = $c2_11 =               //北京
        $c1_12 = $c2_12 =               //天津
        $c1_13 = $c2_13 =               //河北
        $c1_14 = $c2_14 =               //山西
        $c1_15 = $c2_15 =                //内蒙
        $c1_21 = $c2_21 =               //辽宁
             0;


        //$bg_c1 = $news1->where('areacode','like','11%');
        $bg_c2 = $news2->where('areacode','like','11%');




       // dd($news1,$news2,$bg_c1,$bg_c2);

        $c2_00 = 1;
        //$templateProcessor->setValue('c1_00', $c1_00);
        $templateProcessor->setValueAndColor('c1_00', $c1_00);
        $templateProcessor->setValueAndColor('c2_00', $c2_00);

        $templateProcessor->saveAs($path.$name.".docx");

    }

    function createexcel($tmppath,$path,$name,$news){
        $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','temp' ).'.xlsx';
        //$inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','26template' ).'.xlsx';
        //dd($inputFileName);
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileName);
        //dd($spreadsheet);
        $worksheet0 = $spreadsheet->getSheet(0);

        $i = 1;
        foreach ($news as $new)
        {
            $i++;
            $worksheet0->setCellValue("A".$i,$new->title);
            $worksheet0->setCellValue("B".$i,$new->abstract);
            $worksheet0->setCellValue("C".$i,$new->starttime);

            //$areacode = $new->areacode;
            $areacodes = substr($new->areacode,0,2)."0000";
            $dq = Address::where("areacode",$areacodes)->first()->name;

            //dd($dq);
            $worksheet0->setCellValue("D".$i,$dq);

            $worksheet0->setCellValue("E".$i,$new->firstwebsite);
            $worksheet0->setCellValue("F".$i,$new->sitetype);
            $worksheet0->setCellValue("G".$i,$new->author);
            $worksheet0->setCellValue("H".$i,$new->visitnum);
            $worksheet0->setCellValue("I".$i,$new->replynum);
            $worksheet0->setCellValue("J".$i,$new->orientation);
            $worksheet0->setCellValue("K".$i,$new->link);
            $worksheet0->getCell("K".$i)->getHyperlink()->setUrl($new->link);

            $styleArray = [
                'font'=> [
                    'underline' => \PhpOffice\PhpSpreadsheet\Style\Font::UNDERLINE_SINGLE,
                    'color' => [
                        'rgb' => "0000FF"
                    ]
                ]

            ];
            $worksheet0->getCell("K".$i)->getStyle()->applyFromArray($styleArray);

            $worksheet0->setCellValue("L".$i,$new->ispush == 1?"是":"否");
            $worksheet0->setCellValue("M".$i,$new->court);
            $worksheet0->setCellValue("N".$i,$new->yuqinginfo);
            $worksheet0->getRowDimension($i)->setRowHeight(60);
        }
        //***********************画出单元格边框*****************************
        $styleArray = array(
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,//细边框
                ),
            ),
        );
        $worksheet0->getStyle('A2:N'.$i)->applyFromArray($styleArray);//这里就是画出从单元格A5到N5的边框，看单元格最右边在哪哪个格就把这个N改为那个字母替代
//***********************画出单元格边框结束*****************************
        $worksheet1 = $spreadsheet->getSheet(1);
        $i = 1;
        foreach ($news as $new)
        {
            $i++;
            $worksheet1->setCellValue("A".$i,$new->title."docx");
            $worksheet1->getRowDimension($i)->setRowHeight(60);
        }
        $worksheet1->getStyle('A2:B'.$i)->applyFromArray($styleArray);//这里就是画出从单元格A5到N5的边框，看单元格最右边在哪哪个格就把这个N改为那个字母替代

        $spreadsheet->setActiveSheetIndex(0);
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet,'Xlsx');
        $objWriter->save($path.$name.".xlsx");
    }

    function createwordc($tmppath,$path,$news){

        foreach ($news as $new){

            $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','tempc' ).'.docx';

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessorRe($inputFileName);
            $templateProcessor->setValue('time', htmlentities($new["starttime"]));
            $templateProcessor->setValue('url', htmlentities($new["link"]));
            $templateProcessor->setValue('title', htmlentities($new["title"]));

            $contentall = html_entity_decode($new["content"]);
            //$contentallst = trim(strip_tags($contentall));


            $contentall = preg_replace("/<(\/?font.*?)>/si","", $contentall);
            $contentall = preg_replace("/<(\/?span.*?)>/si","", $contentall);
            $contentall = preg_replace("/<(img.*?)>/si","", $contentall);
            $contentalls = preg_replace("/<(\/?p.*?)>/si"," ", $contentall);
            $contentalls = preg_replace("/<(\/?br.*?)>/si"," ", $contentalls);
            $contentalls = trim($contentalls);


            $contentalls = preg_replace('/[\n\r\t]+/', '', $contentalls);
            $contentalls = str_replace(chr(0xc2).chr(0xa0), ' ', $contentalls);
            $contentalls = preg_replace('/\s+/', '{{{explode}}}', $contentalls);

            $contents = explode("{{{explode}}}",$contentalls);

            $templateProcessor->cloneBlock('repeat', count($contents));
            foreach ($contents as $content){
                $templateProcessor->setValue('content', $content,1);
            }
            $templateProcessor->saveAs($path.$new["title"].'.docx');

        }
    }
}

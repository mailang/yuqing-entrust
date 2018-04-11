<?php

namespace App\Src;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use App\Models\News;
use App\Models\Reportform;
use App\Models\useful_news;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use App\Models\Court;

class CreateFile{
    //

    function createzip($id){
        $tmppath = resource_path("template/");
        $path = storage_path("tmp/");
        $zippath = storage_path("zip/");

        if (!file_exists($path)){
            mkdir ($path,0777,true);
        }
        if (!file_exists($zippath)){
            mkdir ($zippath,0777,true);
        }

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

        $fields = ['useful_news.*','court.province'];
        $resualt = DB::table("useful_news")->leftJoin("court","useful_news.court","=","court.name")
            ->where("useful_news.reportform_id","=",$id)
            ->where("useful_news.tag","=",1)
            ->orderBy('starttime')
            ->get($fields);
        $this->createwordc($tmppath,$path,$resualt);
        $this->createexcel($tmppath,$path,$nameexcel,$resualt);
        //$this->createwordall($tmppath,$path,$namewordall,$zipname,$r["type"],$resualt);
        $zippath = ($zippath.$zipname.'.zip');
        $zip = new \ZipArchive();
        if($zip->open($zippath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)){

            $this->addFileToZip($path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close();
        }
        $this->delFile($path);
//        $ftppath = env("FTP_DIR","");
//        if($ftppath !== "") {
//            if(file_exists($ftppath)){
//                copy($zippath,$ftppath.$zipname.'.zip');
//            }
//        }
        return true;
    }

    function push($id){
        $ftppath = env("FTP_DIR","");
        $zippath = storage_path("zip/");
        $r = Reportform::find($id);
        $zipname = $r["title"];
        $zippath = ($zippath.$zipname.'.zip');
        if($ftppath !== "") {
            if(file_exists($ftppath)){
                copy($zippath,$ftppath.$zipname.'.zip');
            }
        }
        return true;
    }

    function addFileToZip($path,$zip){
        $handler=opendir($path); //打开当前文件夹由$path指定。
        while(($filename=readdir($handler))!==false){
            if($filename != "." && $filename != ".."){//文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                    $this->addFileToZip($path."/".$filename, $zip);
                }else{ //将文件加入zip对象
                    $zip->addFile($path."/".$filename,$filename);
                }
            }
        }
        @closedir($path);
    }

    function delFile($path){
        $handler=opendir($path);
        while(($filename=readdir($handler))!==false){
            if($filename != "." && $filename != ".."){
                if(is_dir($path."/".$filename)){// 如果读取的某个对象是文件夹，则递归
                    $this->delFile($path."/".$filename);
                }else{ //将文件加入zip对象
                    File::delete($path."/".$filename);
                }
            }
        }
    }

    function createwordall($tmppath,$path,$name,$zipname,$type,$news){
        $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','tempall' ).'.docx';
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessorRe($inputFileName);

        $templateProcessor->setValue('alltitle', $name);
        //dd(date("Y-m-d",strtotime($zipname)));
        $datethis = substr($zipname,0,8);
        $time = "";
        switch ($type) {
            case 0:
                $time = date("Y-m-d 18:00:00",strtotime("-1 day",strtotime($datethis)))." - ".date("Y-m-d 08:00:00",strtotime($datethis));
                break;
            case 1:
                $time = date("Y-m-d 8:00:00",strtotime($datethis))." - ".date("Y-m-d 12:00:00",strtotime($datethis));
                break;
            case 2:
            default:
                $time = date("Y-m-d 12:00:00",strtotime($datethis))." - ".date("Y-m-d 18:00:00",strtotime($datethis));
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

            $templateProcessor->setValue("tarea#$i", $new->province);
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
        //$allprovince = ["000" => "最高","100" => "北京","200" => "天津","300" => "河北","400" => "山西","500" => "内蒙","600" => "辽宁","700" => ""];
        $fieldscp = ["code","province"];
        $courtp = Court::where("code","like","%00")
                ->orWhere("code","=","VI0")->get($fieldscp);
        foreach ($courtp as $p){
            $pc1 = $news1->where("province","=",$p->province)->count();
            $pc2 = $news2->where("province","=",$p->province)->count();
            $templateProcessor->setValueAndColor("c1_".$p->code,$pc1);
            $templateProcessor->setValueAndColor("c2_".$p->code,$pc2);
        }

        return $templateProcessor->save();
    }

    function createexcel($tmppath,$path,$name,$news){
        $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','temp' ).'.xlsx';
        //$inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','26template' ).'.xlsx';
        //dd($inputFileName);
        //dd($tmppath,$path,$name,$news);
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


            //dd($dq);
            $worksheet0->setCellValue("D".$i,$new->province);

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
            $worksheet1->setCellValue("A".$i,$new->title.".docx");
            $worksheet1->getRowDimension($i)->setRowHeight(60);
        }
        $worksheet1->getStyle('A2:B'.$i)->applyFromArray($styleArray);//这里就是画出从单元格A5到N5的边框，看单元格最右边在哪哪个格就把这个N改为那个字母替代

        $spreadsheet->setActiveSheetIndex(0);
        $objWriter = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet,'Xlsx');
        //dd($path.$name);
        $objWriter->save($path.$name.".xlsx");
    }

    function createwordc($tmppath,$path,$news){

        foreach ($news as $new){

            $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','tempc' ).'.docx';

            $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessorRe($inputFileName);
            $templateProcessor->setValue('time', htmlentities($new->starttime));
            $templateProcessor->setValue('url', htmlentities($new->link));
            $templateProcessor->setValue('title', htmlentities($new->title));

            $contentall = html_entity_decode($new->content);
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
            $templateProcessor->saveAs($path.$new->title.'.docx');

        }
    }

    function downloadzip($id){
        $zippath = storage_path("zip/");
        $r = Reportform::find($id);
        $filename = $zippath.$r->title.".zip";
        //dd($filename);
        if (File::exists($filename)){
            return response()->download($filename);
        }else{
            flash("文件没有生成",'error');
            return redirect()->back();
        }
    }

    function downloaddocx($id){
            $tmppath = resource_path("template/");
            $path = storage_path("report/");


            if (!file_exists($path)){
                mkdir ($path,0777,true);
            }

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

            $namewordall = substr($zipname,0,8).$bm."_执行舆情监测";

            $fields = ['useful_news.*','court.province'];
            $resualt = DB::table("useful_news")->leftJoin("court","useful_news.court","=","court.name")
                ->where("useful_news.reportform_id","=",$id)
                ->where("useful_news.tag","=",1)
                ->orderBy('starttime')
                ->get($fields);

            $name = $this->createwordall($tmppath,$path,$namewordall,$zipname,$r["type"],$resualt);

            return response()->download($name,$namewordall.".docx")->deleteFileAfterSend(true);
    }

    function person_createzip($newsid){
        $tmppath = resource_path("template/");
        $path = storage_path("tmp/");
        $zippath = storage_path("test/");

        if (!file_exists($path)){
            mkdir ($path,0777,true);
        }
        if (!file_exists($zippath)){
            mkdir ($zippath,0777,true);
        }
        $zipname = '临时报表'.date('Ymd').\Auth::guard('admin')->user()->username;

        $nameexcel = "最高执行指挥中心首页舆情信息".$zipname;
        //$namewordall = substr($zipname,0,8)."_执行舆情监测";

        $fields = ['useful_news.*','court.province'];
        $resualt = DB::table("useful_news")->leftJoin("court","useful_news.court","=","court.name")
           ->whereIn('useful_news.id',$newsid)
            ->get($fields);
        $this->createwordc($tmppath,$path,$resualt);
        $this->createexcel($tmppath,$path,$nameexcel,$resualt);
        $zippath = ($zippath.$zipname.'.zip');
        $zip = new \ZipArchive();
        if($zip->open($zippath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)){

            $this->addFileToZip($path, $zip); //调用方法，对要打包的根目录进行操作，并将ZipArchive的对象传递给方法
            $zip->close();
        }
        $this->delFile($path);
        if (File::exists($zippath)){
            return response()->download($zippath)->deleteFileAfterSend(true);
        }else{
            flash("文件没有生成",'error');
            return redirect()->back();
        }
        //return true;
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\News;

class TestController extends Controller
{
    //

    function index(){
        $path = storage_path("tmp/");
        if (!file_exists($path)){
            mkdir ($path,0777,true);
        }

        $resualt = News::where([])->orderBy("id")->limit(10)->get();

        $this->createwordc($path,$resualt);

//        foreach ($resualt as $new)
//        {
//
//        }
//
//
//        $path = resource_path("template/");
//        //dd($path);
//        $inputFileName = $path.iconv('UTF-8', 'GBK//IGNORE','tempc' ).'.docx';
//        //dd($inputFileName);
//        $phpWord = new PhpWord();
//        //$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($inputFileName);
//        $templateProcessor = $phpWord->loadTemplate($inputFileName);
//        $templateProcessor->setValue('{{{time}}}', '姓名');
//        $templateProcessor->setValue('{{{url}}}', '姓名');
//        $templateProcessor->setValue('{{{title}}}', '姓名');
//
//        $templateProcessor->saveAs(storage_path("1.docx"));
//
//
//        dd($templateProcessor);
    }

    function createwordc($path,$news){

        foreach ($news as $new){
//            $phpWord = new PhpWord();
//            $section = $phpWord->addSection();
//            $fontStyle = array('size'=>12,'');
//            $section->addText($new["starttime"],$fontStyle);
//
//            //$phpWord->save($this->path.iconv('UTF-8', 'GBK//IGNORE', $new["title"]).'.docx');
//            $phpWord->save($path.$new["title"].'.docx');
            //dd();
            $tmppath = resource_path("template/");
            $inputFileName = $tmppath.iconv('UTF-8', 'GBK//IGNORE','tempc' ).'.docx';
        //dd($inputFileName);
            $phpWord = new PhpWord();
            //$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($inputFileName);
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

    function createwordall($resualt){

    }

    function createexcel(){}

}

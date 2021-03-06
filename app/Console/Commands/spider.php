<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\News;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Exception\RequestException;

use QL\QueryList;
use Illuminate\Support\Facades\Log;

class spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spider:yuqing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'yuqing spider';


    protected $yuqing_url = 'http://yuqing.keeprisk.com/';
    protected $login_url = 'Login/doLogin';
    protected $referer = 'login/login';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $t1 = microtime(true);
        //
        //$this->info('hello');
        $client = new Client([
            'base_uri' => $this->yuqing_url,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:53.0) Gecko/20100101 Firefox/53.0',
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'zh-CN,zh;q=0.8'
            ],
            'cookies' => true,
            'http_errors' => true]);
        $res = $client->request('POST',$this->login_url , [
            'form_params' => [
                'userid' => '韩晓青测试',
                'password' => '000000'
            ],'headers' => [
                'Referer' => $this->yuqing_url.$this->referer
            ]
        ]);

        $this->handleall($client);
        $t2 = microtime(true);
        Log::info($t2-$t1);


    }

    function handleall($client){

        //'Browse/indexajax?cities=&province=&infoSourceLevel=&wechatInfoType=&abstractIsHideOrShow=1&kvHot=&hotname=&p=1&sourceattr=-1&kk_id=&noneUrl=&degree=-1&range=&id=&sid=&orientation=4&customFilter=&state=xx&tid=01&sourcetype=&repeat=1&isread=&time=&type=text&message=&pagesize=10&site=&btime=2018-01-24+21%3A04%3A02&kkname=&isyj=&classid=&jobid=&etime=2018-01-26+21%3A04%3A07&mate=&region=&position=&distance=&filter=&ignore_a=&ignore_loc=&ignore_topic=&channel=&column=';
//        $res1 = $client->request('GET','Browse/indexajax?cities=&province=&infoSourceLevel=&wechatInfoType=&abstractIsHideOrShow=1&kvHot=&hotname=&p=1&sourceattr=-1&kk_id=&noneUrl=&degree=-1&range=&id=&sid=&orientation=4&customFilter=&state=xx&tid=01&sourcetype=&repeat=1&isread=&time=&type=text&message=&pagesize=10&site=&btime=2018-01-24+21%3A04%3A02&kkname=&isyj=&classid=&jobid=&etime=2018-01-26+21%3A04%3A07&mate=&region=&position=&distance=&filter=&ignore_a=&ignore_loc=&ignore_topic=&channel=&column=' , [
//
//        ]);
        $p = 1;
        //$btime = date("Y-m-d+00:00:00",strtotime("-2 day"));

        $btime = date("Y-m-d+H:i:s",strtotime("-2 hour"));
        $etime = date("Y-m-d+H:i:s");

        while (true)
        {
            $url = $this->yuqing_url."Browse/indexajax?cities=&province=&infoSourceLevel=&wechatInfoType=&abstractIsHideOrShow=1&kvHot=&hotname=&p={$p}&sourceattr=-1&kk_id=&noneUrl=&degree=-1&range=&id=&sid=&orientation=4&customFilter=&state=xx&tid=01&sourcetype=&repeat=1&isread=&time=&type=text&message=&pagesize=10&site=&btime={$btime}&kkname=&isyj=&classid=&jobid=&etime={$etime}&mate=&region=&position=&distance=&filter=&ignore_a=&ignore_loc=&ignore_topic=&channel=&column=" ;

            //Log::info($url);

            $res1 = $client->request('GET',$url, [

            ]);

            \phpQuery::newDocumentHTML($res1->getBody());
            $lilist = pq('.message_list > ul > li');

            if ($lilist->length == 0)
            {
                break;
            }

            foreach ($lilist as $li){
                $href = pq($li)->find('.title a')->attr('href');
                $uuid = $this->getUrlKeyValue($href)['uuid'];
                //$abstract = pq($li)->find('.list_message')->text();
                $abstract = pq($li)->find('.list_message')->html();
                if ($uuid){
                    $new = News::where('uuid',$uuid)->first();
                    if ($new)
                        continue;
                }
                else{
                    $uuid = "";
                }
                //$href获取sourcetype;
                $media_type= $this->getUrlKeyValue($href)['sourcetype'];
                $reseach =  $client->request('GET',$href);
                $this->handleonehtml($reseach,$uuid,$abstract,$media_type);

            }
            $p ++;
        }


    }

    function handleonehtml($html,$uuid,$abstract,$media_type){
        \phpQuery::newDocumentHTML($html->getBody());

        $title = pq('.content h1')->text();
        $link= pq('.url a')->text();

        if (preg_match("/<a href=[\'\"]?([^\'\" ]+).*?>/",  pq('.url')->html(), $matches)){
            $link = $matches[1];
        }
        $content = pq('.content_wrap')->html();

        $keywordslist = pq('.keyword a');
        $klist = array();
        foreach ($keywordslist as $k)
        {
            array_push($klist,pq($k)->text());
        }
        $keywords = implode("|",$klist);

        $subject = pq('.special .div1 a')->text();

        $othermessage = pq('.information');

        $starttime = $othermessage->find('i:eq(0)')->text();

        $sitetype = $othermessage->find('i:eq(1)')->text();

        $orientation = explode("：",$othermessage->find('i:eq(2)')->text())[1];
        $transmit = explode("：",$othermessage->find('i:eq(3)')->text())[1];
        $author = explode("：",$othermessage->find('i:eq(4)')->text())[1];
        $firstwebsiteall = $othermessage->find('i:eq(5)')->text();

        $mr = preg_match('/【([\d\D]+?)】/', $firstwebsiteall, $matchs);
		if($mr==0)
		{
			$firstwebsite=$firstwebsiteall;
		}else
			$firstwebsite = $matchs[1];

        $new = new News();
        $new->title = $title;
        $new->link = $link;
        $new->abstract = $abstract;
        $new->content = htmlspecialchars($content);
        $new->keywords = $keywords;
        $new->subject = $subject;
        $new->starttime = $starttime;
        $new->uuid = $uuid;
        $new->sitetype = $sitetype;
        $new->orientation = $orientation;
        $new->transmit = $transmit;
        $new->author = $author;
        $new->firstwebsite = $firstwebsite;
        $new->media_type=$media_type==null?0:$media_type;
        try{
            $new->save();
        }
        catch (\Exception $e)
        {
            Log::error($e);
            Log::info($title);
            Log::info($link);
            Log::info($abstract);
            Log::info($content);
            Log::info($keywords);
            Log::info($subject);
            Log::info($starttime);
            Log::info($uuid);
            Log::info($sitetype);
            Log::info($orientation);
            Log::info($transmit);
            Log::info($author);
            Log::info($firstwebsite);
        }


//        echo $title;
//        echo $link;
//        echo $content;
//        echo $keyword;
//        echo $subject;
//        echo $starttime;
//        echo $uuid;
//        echo $sitetype;
//        echo $orientation;
//        echo $transmit;
//        echo  $author;
//        echo  $firstwebsite;

        array_shift(\phpQuery::$documents);


    }

    public function getUrlKeyValue($url)
    {
        $result = array();
        $mr = preg_match_all('/(\?|&)(.+?)=([^&?]*)/i', $url, $matchs);
        if ($mr !== false) {
            for ($i = 0; $i < $mr; $i++) {
                $result[$matchs[2][$i]] = $matchs[3][$i];
            }
        }
        return $result;
    }
}

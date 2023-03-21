<?php

namespace App\Http\Controllers;

use App\Models\CrawlerPage;
use App\Models\CrawlerPost;
use App\Models\CrawlerWebsite;
use Illuminate\Http\Request;
use Goutte\Client;
use Illuminate\Support\Facades\DB;


class TestController extends Controller
{
    public function crawler(){
        $websites = DB::table(CrawlerWebsite::TABLE)->where('status',CrawlerWebsite::ENABLE)->get();
        foreach ($websites as $website){
            $pages = DB::table(CrawlerPage::TABLE)->where('status',CrawlerPage::ENABLE)->get();
            foreach ($pages as $page){
                try {
                    DB::table('posts')->insert(['title'=>'1','content'=>'5']);
                    $client = new Client();
                    DB::table('posts')->insert(['title'=>'1','content'=>'7']);
//                    $client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
                    DB::table('posts')->insert(['title'=>'1','content'=>'8']);
                    $crawler = $client->request('GET', $page->url);
                    DB::table('posts')->insert(['title'=>'1','content'=>$client->getResponse()->getStatus()]);
                    $crawler->filter($page->crawler_condition)->each(function($node) use ($page,$website){
                        $pass = true;
                        DB::table('posts')->insert(['title'=>'1','content'=>'13']);
                        foreach($node->filter('*') as $vv){
                            DB::table('posts')->insert(['title'=>'1','content'=>'15']);
                            $arr = explode(",",$page->ignore_string);
                            DB::table('posts')->insert(['title'=>'1','content'=>'14']);
                            if(in_array($vv->textContent,$arr)){
                                $pass = false;
                            }
                        }
                        DB::table('posts')->insert(['title'=>'1','content'=>'11']);
                        if($pass){
                            $str = null;
                            $href = $node->filter("a")->eq(0)->attr('href');
                            $content = null;
                            foreach($node->filter("h3") as $vvv){
                                $str .= $vvv->textContent;
                            }DB::table('posts')->insert(['title'=>'1','content'=>'12']);
//                            var_dump($href);
                            var_dump($str);

                            if($str){
                                if(substr($href,0,1)=="/"){
                                    $href = $website->url.$href;
                                }
                                var_dump($href);
                                $client2 = new Client();
                                $crawler2 = $client2->request('GET', $href);
                                if($client2->getResponse()->getStatus()==200){
                                    foreach($crawler2->filter("article > .caas-body")->filter("p") as $qqq){
                                        $content .= $qqq->textContent;
                                    }
                                }else{
                                    //
                                }
                                DB::table('posts')->insert(['title'=>'1','content'=>'13']);
                                DB::table(CrawlerPost::TABLE)->insert([
                                    'crawler_page_id'=>$page->id,
                                    'title'=>$str,
                                    'content'=>$content,
                                    'url'=>$href,
                                    'status'=>CrawlerPost::ENABLE,
                                    'created_time'=>time(),
                                    'updated_time'=>time(),
                                ]);
                            }

                        }
                    });
                }catch (\Exception $e){
                    DB::table('posts')->insert(['title'=>'1','content'=>'4']);
                    var_dump($e->getMessage());
                }
            }
        }
        DB::table('posts')->insert(['title'=>'1','content'=>'3']);
exit();
        $websites = DB::table(CrawlerWebsite::TABLE)->where('status',CrawlerWebsite::ENABLE)->get();
        foreach ($websites as $website){
            $pages = DB::table(CrawlerPage::TABLE)->where('status',CrawlerPage::ENABLE)->get();
            foreach ($pages as $page){
                try {
                    $client = new Client();
                    $client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
                    $crawler = $client->request('GET', $page->url);
                    $crawler->filter($page->crawler_condition)->each(function($node) use ($page,$website){
                        $pass = true;
                        foreach($node->filter('*') as $vv){
                            $arr = explode(",",$page->ignore_string);
                            if(in_array($vv->textContent,$arr)){
                                $pass = false;
                            }
                        }
                        if($pass){
                            $str = null;
                            $href = $node->filter("a")->eq(0)->attr('href');
                            $content = null;
                            foreach($node->filter("h3") as $vvv){
                                $str .= $vvv->textContent;
                            }
//                            var_dump($href);
                            var_dump($str);

                            if($str){
                                if(substr($href,0,1)=="/"){
                                    $href = $website->url.$href;
                                }
                                var_dump($href);
                                $client2 = new Client();
                                $crawler2 = $client2->request('GET', $href);
                                if($client2->getResponse()->getStatus()==200){
                                    foreach($crawler2->filter("article > .caas-body")->filter("p") as $qqq){
                                        $content .= $qqq->textContent;
                                    }
                                }else{
                                    //
                                }
                                var_dump([
                                    'crawler_page_id'=>$page->id,
                                    'title'=>$str,
                                    'content'=>$content,
                                    'url'=>$href,
                                    'status'=>CrawlerPost::ENABLE,
                                ]);
                                DB::table(CrawlerPost::TABLE)->insert([
                                    'crawler_page_id'=>$page->id,
                                    'title'=>$str,
                                    'content'=>$content,
                                    'url'=>$href,
                                    'status'=>CrawlerPost::ENABLE,
                                    'created_time'=>time(),
                                    'updated_time'=>time(),
                                ]);
                            }

                        }
                    });
                }catch (\Exception $e){
                    var_dump($e->getMessage());
                }
            }
        }

        exit();
        $client = new Client();
        $start = microtime(true);
        var_dump("hihi");

        $client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");

        $crawler = $client->request('GET', 'https://hk.mobi.yahoo.com/news');

//        $ch = curl_init();
//        curl_setopt($ch, CURLOPT_URL, "https://www.youtube.com/");
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//        $rs = curl_exec($ch);
//        curl_close($ch);
//        var_dump($rs);

        $end = microtime(true);
        var_dump("Total use: ".($end-$start)."(ms)");
//        var_dump($crawler);
        $i = 0;

//        $code = file_get_contents("compress.zlib://https://hk.yahoo.com/");
//        $re = '/>(.*?)<u class="Stretch"><\/u>/';
//        preg_match_all($re, $code, $matches, PREG_SET_ORDER, 0);
//        var_dump($matches);
//        die();

        try{
//            print $crawler->filter('.Stretch')->count();
            #ntk-component a
//            $crawler->filter('#ntk-component a')->each(function($nnode){
                $crawler->filter('#news-always-tab-5-Stream a')->each(function($nnode){
//                $crawler->filter('.Col2 li.js-stream-content h3 a')->each(function($nnode){
                    $pass = true;
                    foreach($nnode->filter('*') as $vv){
                        if(in_array($vv->textContent,['Sponsored','即日熱搜'])){
                            $pass = false;
                        }
//                        var_dump();
                    }
                    if($pass){
//                        var_dump($nnode->text());
                        $str = null;
                        foreach($nnode->filter("h3") as $vvv){
                            $str .= $vvv->textContent;
                        }
                        var_dump($str);

                    }
//                var_dump("*");
//            if($node->siblings('h3')->eq(1)->html()){
//                echo    $node->filter('h3')->eq(0)->html();
//            }
//            var_dump($node->find("*")->eq(0)->text());
//            echo $node->html();
//                print $node->filter('h3')->text();
                $sstart = microtime(true);
//                $node->filter("a")->each(function($nnode){

//                    $url = $nnode->attr('href');
//                    if(substr($url, 0, 1)=="/"){
//
//                    }
//                    var_dump($url);
//                    $client2 = new Client();
//                    $crawler2 = $client2->request('GET', $url);
//                    $crawler2->filter("article > div")->filter("p")->each(function($node){
//                        print $node->text();
//                    });
//                });
                $eend = microtime(true);
                var_dump("Total use: ".($eend-$sstart)."(ms)");
//                var_dump($node->text());
//                var_dump("#");
//                var_dump("<br>");
//                var_dump("<br>");
//                var_dump("<br>");
//                var_dump("<br>");
//                var_dump("<br>");
//                var_dump("<br>");
            });

        } catch(Exception $e) { // I guess its InvalidArgumentException in this case
            // Node list is empty
        }

        exit();

        $crawler->filter('.Col2 > #Main > .today > .App-Bd > .App-Main > .js-applet-view-container-main > .today > .CarouselWrap')->each(function ($node) {
            $text = $node->text();
//            if($text == "新聞"){
//                var_dump($node->attr('href'));
//            }
//            echo $node->text()."<br>" ;
//            var_dump($node->html());
            var_dump("@");
        });
        var_dump("Total use: ".($end-$start)."(ms)");
    }
}

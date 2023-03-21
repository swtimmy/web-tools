<?php

namespace App\Console\Commands;

use App\Models\CrawlerPage;
use App\Models\CrawlerPost;
use App\Models\CrawlerWebsite;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class crawlerWebsitePagePost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmd:crawlerWebsitePagePost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawler Post';

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
        //Stop, now run in python
        exit();
        DB::table('posts')->insert(['title'=>'1','content'=>'---']);
        $client = new \GuzzleHttp\Client();

        $client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");

        $crawler = $client->request('GET', 'https://hk.mobi.yahoo.com/news');
        $crawler->filter('#news-always-tab-5-Stream a')->each(function($nnode){
            $pass = true;
            foreach($nnode->filter('*') as $vv){
                if(in_array($vv->textContent,['Sponsored','即日熱搜'])){
                    $pass = false;
                }
            }
            if($pass){
                $str = null;
                foreach($nnode->filter("h3") as $vvv){
                    $str .= $vvv->textContent;
                }
                DB::table('posts')->insert(['title'=>'1','content'=>$str]);
            }
        });
        DB::table('posts')->insert(['title'=>'1','content'=>'***']);
    }

//    public function crawler(){
//        $client = new Client();
//        $client->setHeader('user-agent', "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.101 Safari/537.36");
//    }
}

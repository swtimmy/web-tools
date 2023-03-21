<?php

namespace App\Http\Controllers;

use App\Models\CrawlerPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use mysql_xdevapi\Exception;


class GrepResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    const FIRST_GET_NUM = 50;
    const NEXT_GET_NUM = 20;

    public function index()
    {
//        $posts = DB::table('crawler_post')->orderByDesc('post_time')->where('status','=',CrawlerPost::ENABLE)->limit(20)->get()->toArray();
//        var_dump(Crypt::encryptString(0));exit();
        $posts = [];
        return view('grep_result', ['posts' => $posts]);
    }

    public function getNew(Request $request)
    {
        $data = $request->all();
        $num = self::checkCode($data['newer']);
        if($num === FALSE){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>''
            ]);
        }
        $posts = DB::table('crawler_post')->orderByDesc('id')->where('status','=',CrawlerPost::ENABLE)->limit($this::FIRST_GET_NUM)->get()->toArray();
        return response()->json(['status'=>200,
            'message'=>'Success',
            'data'=>[
                'post'=>array_reverse($posts),
                'newer'=>Crypt::encryptString($posts[0]->id),
                'older'=>Crypt::encryptString($posts[count($posts)-1]->id),
            ]
        ]);
    }

    public function getLastestNew(Request $request)
    {
        $data = $request->all();
        $num = self::checkCode($data['newer']);
        if($num === FALSE){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>''
            ]);
        }
        $posts = DB::table('crawler_post')->orderByDesc('id')->where('status','=',CrawlerPost::ENABLE)->where('id','>',$num)->get()->toArray();
        if($posts){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'post'=>array_reverse($posts),
                    'newer'=>Crypt::encryptString($posts[0]->id),
                ]
            ]);
        }else{
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>''
            ]);
        }
    }

    public function getOldestNew(Request $request)
    {
        $data = $request->all();
        $num = self::checkCode($data['older']);
        if($num === FALSE){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>''
            ]);
        }
        $posts = DB::table('crawler_post')->orderByDesc('id')->where('status','=',CrawlerPost::ENABLE)->where('id','<',$num)->limit($this::NEXT_GET_NUM)->get()->toArray();
        if($posts){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'post'=>$posts,
                    'older'=>Crypt::encryptString($posts[count($posts)-1]->id),
                ]
            ]);
        }else{
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>''
            ]);
        }
    }

    public function getInfo(Request $request)
    {
        $data = $request->all();
        if($data['k']!="c}CDpy>;:6{_ghgkLs6["){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'newer'=>'ed#f20ijf4ijevjg4i8237r42oiejfoiewfjwoe48f29348yt2r23fed#f20ijf4ijevjg4i8237r42oiejfoiewfjwoe48f29348yt2r23f',
                    'older'=>'ed#f20ijf4ijevjg4i8237r42oiejfoiewfjwoe48f29348yt2r23fed#f20ijf4ijevjg4i8237r42oiejfoiewfjwoe48f29348yt2r23f',
                ]
            ]);
        }
        $zero = Crypt::encryptString(0);
        return response()->json(['status'=>200,
            'message'=>'Success',
            'data'=>[
                'newer'=>$zero,
                'older'=>$zero,
            ]
        ]);
    }

    public static function checkCode($encryptString){
        try {
            $str = Crypt::decryptString($encryptString);
        } catch (DecryptException $e) {
            $str = "error";
        }
        if(!is_numeric($str)){
            return false;
        }else{
            return $str;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

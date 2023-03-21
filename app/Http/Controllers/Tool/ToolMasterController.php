<?php

namespace App\Http\Controllers\Tool;

use App\Models\ToolUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class ToolMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $tooluser;

    public function checkLogin()
    {
        $session_extend = 3600;
        $cookies_extend = 3600*24*30;
        $time = time();
        if($token = Cookie::get("token",false)){
            if($this->tooluser = ToolUser::select('id','email','last_login_time')->where("token","=",$token)->first()){
                if($this->tooluser->last_login_time + $cookies_extend > $time){
                    return $this->tooluser;
                }
                Cookie::queue(Cookie::forget("token"));
                $this->tooluser->token = null;
                $this->tooluser->save();
            }
        }else if($last_login_time = Session::get("user.last_login_time",false)){
            if($last_login_time + $session_extend > $time && ($email = Session::get("user.email",false))){
                if($this->tooluser = ToolUser::select('id','email','last_login_time')->where("email","=",$email)->first()){
                    return $this->tooluser;
                }
            }
        }
        return $this->goLogin();
    }

    public function goLogin(){
        Session::put('referral', $_SERVER['REQUEST_URI'], '/schedule');
        return redirect('login')->send();
    }
}

<?php

namespace App\Http\Controllers\Tool;

use App\Models\ToolUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use \Validator;


class ToolUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Cookie::queue(Cookie::forget("token"));
        Session::forget("user.last_login_time");
        return view('tools/tool_login');
    }

    public function login(Request $request){
        $data = $request->all();

        $rule = [
            'email' => 'required|max:255|email',
            'password' => 'required|min:8',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        $err = [
            'Login'=>['Login data incorrect']
        ];
        if(!$toolUser = ToolUser::where("email",'=',$data['email'])->first()){
            return response()->json(['status'=>400,'message'=>$err]);
        }
        if(!password_verify($data['password'],$toolUser->password)){
            return response()->json(['status'=>400,'message'=>$err]);
        }
        if(isset($data['remember_me'])){
            if(!$toolUser->token){
                $token = Str::random(60).md5(time());
                $toolUser->token = $token;
            }
            Cookie::queue("token", $toolUser->token, 60*24*30);
        }else{
            Cookie::queue(Cookie::forget("token"));
        }
        Session::put("user.email",$toolUser->email);
        Session::put("user.last_login_time",time());
        $toolUser->last_login_time = time();
        if(!$toolUser->save()){
            $err = [
                'Update'=>['Login data incorrect:939']
            ];
            return response()->json(['status'=>400,'message'=>$err]);
        }
        $ref = Session::get("referral","/schedule");
        Session::forget("referral");
        return response()->json(['status'=>200,'message'=>'Success','url'=>$ref]);
    }

    public function register(Request $request){
        $data = $request->all();

        $rule = [
            'email' => 'required|unique:tool_user|max:255|email',
            'password' => 'required|min:8',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'unique'    => 'The :attribute is exist.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
        ];

        $validator = Validator::make($data, $rule, $message);

        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }

        $toolUser = new ToolUser();
        $toolUser->email = $data['email'];
        $encrypt_password = password_hash($data['password'], PASSWORD_DEFAULT);
        $toolUser->password = $encrypt_password;
        $toolUser->status = 1;
        $toolUser->created_time = time();
        $toolUser->updated_time = time();
        $toolUser->save();

        return response()->json(['status'=>200,'message'=>'Success']);
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

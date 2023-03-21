<?php

namespace App\Http\Controllers\Tool;

use App\Models\DictionaryPractice;
use App\Models\Dictionary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;

class DictionaryController extends ToolMasterController
{
    public function __construct(Request $request) {
        $this->checkLogin($request);
        date_default_timezone_set('UTC');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_email = (isset($this->tooluser->email))?$this->tooluser->email:"--";
        return view('tools/tool_dictionary',compact('user_email'));
    }

    public function addText(Request $request){
        $data = $request->all();
        $rule = [
            'text'=>'required',
            'desc'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        $exist_dictionary = Dictionary::where("txt","=",strtolower($data['text']))->where("tool_user_id",$this->tooluser->id)->first();
        if($exist_dictionary){
            if($exist_dictionary->status==Dictionary::ENABLE){
                return response()->json(['status'=>400,'message'=>'The Text is exist.']);
            }
            $dictionary = $exist_dictionary;
        }else{
            $dictionary = new Dictionary();
            $dictionary->tool_user_id = $this->tooluser->id;
            $dictionary->created_time = time();
        }
        $dictionary->txt = strtolower($data['text']);
        $dictionary->desc = $data['desc'];
        $dictionary->status = Dictionary::ENABLE;
        $dictionary->updated_time = time();
        try{
            $dictionary->save();
            return response()->json(['status'=>200,'message'=>['dictionary'=>$dictionary->id,'text'=>$dictionary->txt,'description'=>$dictionary->desc]]);
        }catch (\Exception $exception){
            return response()->json(['status'=>400,'message'=>'Failure']);
        }
    }

    public function editText(Request $request){
        $data = $request->all();
        $rule = [
            'text'=>'required',
            'desc'=>'required',
            'dictionary'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        $exist_dictionary = Dictionary::where("id",$data['dictionary'])->where("tool_user_id",$this->tooluser->id)->first();
        if(!$exist_dictionary){
            return response()->json(['status'=>400,'message'=>'The Text is not exist.']);
        }
        $dictionary = $exist_dictionary;
        $dictionary->txt = strtolower($data['text']);
        $dictionary->desc = $data['desc'];
        $dictionary->updated_time = time();
        try{
            $dictionary->save();
            return response()->json(['status'=>200,'message'=>'Success']);
        }catch (\Exception $exception){
            return response()->json(['status'=>400,'message'=>'Failure']);
        }
    }

    public function getText(Request $request){
        $data = $request->all();
        if(isset($data['dictionary'])){
            $dictionary = Dictionary::select("id as dictionary", "txt as text", "desc as description")->where("tool_user_id",$this->tooluser->id)->where("status",Dictionary::ENABLE)->where("id",$data['dictionary'])->first();
            if(!$dictionary){
                return response()->json(['status'=>400,'message'=>'Dictionary Not Found']);
            }
        }else{
            $dictionary = Dictionary::select("id as dictionary", "txt as text", "desc as description")->where("tool_user_id",$this->tooluser->id)->where("status",Dictionary::ENABLE)->get()->toArray();
        }
        return response()->json(['status'=>200,'message'=>$dictionary]);
    }

    public function removeText(Request $request){
        $data = $request->all();
        if(!isset($data['dictionary'])) {
            return response()->json(['status' => 400, 'message' => 'Null Dictionary']);
        }
        $dictionary = Dictionary::where("tool_user_id",$this->tooluser->id)->where("id",$data['dictionary'])->first();
        if(!$dictionary){
            return response()->json(['status'=>400,'message'=>'Dictionary Not Found']);
        }else{
            $dictionary->status = Dictionary::DISABLE;
            try{
                $dictionary->save();
                return response()->json(['status'=>200,'message'=>"Removed"]);
            }catch (\Exception $exception){
                return response()->json(['status'=>400,'message'=>"Can Not Remove. Reload and Retry Again."]);
            }

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
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function show(Dictionary $dictionary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function edit(Dictionary $dictionary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dictionary $dictionary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dictionary  $dictionary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dictionary $dictionary)
    {
        //
    }
}

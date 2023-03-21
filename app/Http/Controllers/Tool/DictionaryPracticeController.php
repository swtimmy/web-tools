<?php

namespace App\Http\Controllers\Tool;

use App\Models\Dictionary;
use App\Models\DictionaryPractice;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class DictionaryPracticeController extends ToolMasterController
{
    public function __construct() {
        $this->checkLogin();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_email = $this->tooluser->email;
        return view('tools/tool_dictionary_practice_list',compact('user_email'));
    }

    public function getPracticeList(Request $request){
        $data = $request;
        $countOfData = 0;
        $practices = DictionaryPractice::where("tool_user_id",$this->tooluser->id);
        if($data['searchText']){
            $search = $data['searchText'];
            $practices = $practices->where(
                function($query) use ($search){
                    $query->where("created_at","like","%".$search."%")->orWhere("updated_at","like","%".$search."%");
                }
            );
        }
        if($data['sortName']){
            $sortName = $data['sortName'];
            $sortOrder = $data['sortOrder'];
            $practices = $practices->orderBy($sortName,$sortOrder);
        }
        $countOfData = $practices->count();
        if($data['pageSize']){
            $pageIndex = $data['pageindex'];
            $pageSize = $data['pageSize'];
            $practices = $practices->skip($pageIndex*$pageSize)->take($pageSize);
        }
        $practices = $practices->get()->toArray();
        $result = [];
        foreach($practices as $practice){
            $result[] = [
                'marks'=>$practice['marks'],
                'key'=>($practice['status']==DictionaryPractice::DONE)?Crypt::encryptString($practice['id']):$practice['status'],
                'created_at'=>$practice['created_at'],
                'updated_at'=>$practice['updated_at'],
            ];
        }
        $tableResult = ["total"=>$countOfData,"rows"=>$result];
        return response()->json($tableResult);
    }

    public function practice()
    {
        $user_email = $this->tooluser->email;
        return view('tools/tool_dictionary_practice',compact('user_email'));
    }

    public function getPractice(Request $request){
        $practice = DictionaryPractice::where("tool_user_id",$this->tooluser->id)->where("status",DictionaryPractice::ENABLE)->get()->first();
        if(!$practice){
            $practice = $this->generatePractice();
        }
        $question = [];
        $tips = json_decode($practice['answer'],true);
        $count = 0;
        foreach(json_decode($practice['question'],true) as $key=>$val){
            $val = urldecode($val);
            $question[$count]['text']=$val;
            $question[$count]['index']=$key;
//            hint
            $hint = urldecode($tips[$key]);
            if (mb_strlen($hint, mb_detect_encoding($hint)) != strlen($hint)) {
                $question[$count]['hint']="";
            }else{
                $str = strtoupper(substr($hint,0,1));
                if(strlen($hint)==1){
                    $str = "*";
                }else if(strlen($hint)<5){
                    for ($i=1;$i<strlen($hint);$i++){
                        if(substr($hint,$i,1)==" "){
                            $str .= " ";
                        }else{
                            $str .= "*";
                        }
                    }
                }else{
                    for ($i=1;$i<(strlen($hint))-1;$i++){
                        if(substr($hint,$i,1)==" "){
                            $str .= " ";
                        }else{
                            $str .= "*";
                        }
                    }
                    $str .= substr($hint,-1,1);
                }
                $question[$count]['hint'] = $str;
            }
            $count++;
        }
        return response()->json(['status'=>200,'message'=>$question,'start'=>date("Y-m-d h:ia",$practice->created_time)]);
    }

    public function submitPractice(Request $request){
        $data = $request->all();
        $practice = DictionaryPractice::where("tool_user_id",$this->tooluser->id)->where("status",DictionaryPractice::ENABLE)->get()->first();

        if(!$practice){
            return response()->json(['status'=>400,'message'=>'Practice Not Valid.']);
        }
        $submit = [];
        $marks = 0;
        $total = 0;
        foreach(json_decode($practice['answer'],true) as $key=>$val){
            $txt = urlencode(strtolower($data[$key]));
            if($val == $txt){
                $submit[$key]['pass']=true;
                $marks++;
                Dictionary::where("id",$key)->where("poor_level",">",0)->decrement('poor_level');
            }else{
                $submit[$key]['pass']=false;
                Dictionary::where("id",$key)->increment('poor_level');
            }
            $submit[$key]['text']=str_replace('+',' ',$txt);
            $total++;
        }
        $practice->marks = $marks;
        $practice->submit = json_encode($submit);
        $practice->updated_time = time();
        $practice->status = DictionaryPractice::DONE;
        $practice->save();
        return response()->json(['status'=>200,'message'=>['source'=>Crypt::encryptString($practice->id),'marks'=>$practice->marks,'total'=>$total]]);
    }

    public function practiceResult($id){
        try{
            $id = Crypt::decryptString($id);
            $practice = DictionaryPractice::where('id',$id)->where('tool_user_id',$this->tooluser->id)->get()->first();
            if(!$practice){
                $practice = false;
            }else{
                $submit = json_decode($practice['submit'],true);
                $answer = json_decode($practice['answer'],true);
                $record = [];
                foreach(json_decode($practice['question'],true) as $key=>$val){
                    $val = urldecode($val);
                    $record[$key]['question']=urldecode($val);
                    $record[$key]['submit']=urldecode($submit[$key]['text']);
                    $record[$key]['answer']=urldecode($answer[$key]);
                    $record[$key]['pass']=$submit[$key]['pass'];
                }
                $created_time = date("y-m-d h:ia",$practice->created_time);
            }
        }catch(DecryptException $e){
            $practice = false;
        }
        $number = 1;
        return view('tools/tool_dictionary_practice_result',compact('user_email','created_time','record','number'));
    }

    public function generatePractice(){
        $num = 20;
        $data = Dictionary::where("tool_user_id",$this->tooluser->id)->inRandomOrder()->limit($num)->get();
        $question = [];
        $answer = [];
        $submit = [];
        $correction = [];
        $count = 0;
        foreach($data as $row){
            $question[$row["id"]] = urlencode($row["desc"]);
            $answer[$row["id"]] = urlencode($row["txt"]);
            $submit[$row["id"]] = urlencode("");
            $correction[$row["txt"]] = urlencode("");
        }
        $practice = new DictionaryPractice();
        $practice->tool_user_id = $this->tooluser->id;
        $practice->question = json_encode($question);
        $practice->answer = json_encode($answer);
        $practice->submit = json_encode($submit);
        $practice->correction = json_encode($correction);
        $practice->status= DictionaryPractice::ENABLE;
        $practice->created_time = time();
        $practice->save();
        return $practice;
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

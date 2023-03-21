<?php

namespace App\Http\Controllers\Tool;

use App\Models\Schedule;
use App\Models\ScheduleRule;
use Illuminate\Http\Request;
use \Validator;

class ScheduleController extends ToolMasterController
{
    public function __construct() {
        $this->checkLogin();
        date_default_timezone_set('UTC');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_email = $this->tooluser->email;
        $schedule_rule = ScheduleRule::where('tool_user_id','=',$this->tooluser->id)->where('status','=',ScheduleRule::ENABLE);
        if(!$schedule_rule->first()){
            $schedule_rule = $this->createFirstRule()->where('tool_user_id','=',$this->tooluser->id);
        }
//        $schedule_rule = $schedule_rule->get()->toArray();
//        $schedule_event = Schedule::where('tool_user_id','=',$this->tooluser->id)->where('status','=',Schedule::ENABLE)->get()->toArray();
//        $duplicate_event_arr = array();
//        $day_diff = 0;
//        foreach($schedule_event as $id=>$event){
//            $schedule_event[$id]['start_time'] = Date("Y-m-d\TH:i:s\Z",$event['start_time'] + $day_diff);
//            $schedule_event[$id]['end_time'] = Date("Y-m-d\TH:i:s\Z",$event['end_time'] + $day_diff);
//        }
        return view('tools/tool_schedule',compact('user_email'));
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
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }

    public function createFirstRule(){
        $data = array(
            "name"=>ScheduleRule::DEFAULT_NAME,
            "tool_user_id"=>$this->tooluser->id,
            "status"=>ScheduleRule::ENABLE,
        );
        $time = time();
        $scheduleRule = new ScheduleRule($data);
        $scheduleRule->created_time = $time;
        $scheduleRule->updated_time = $time;
        $scheduleRule->save();
        return $scheduleRule;
    }

    public function addRule(Request $request){
        $data = $request->all();
        $user_id = $this->tooluser->id;
        $rule = [
            'name' => "required|max:255|unique:schedule_rule,name,NULL,id,tool_user_id,$user_id",
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'unique'    => 'The :attribute is exist.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        $scheduleRule = new ScheduleRule($data);
        $scheduleRule->tool_user_id = $user_id;
        $scheduleRule->status = ScheduleRule::ENABLE;
        $scheduleRule->created_time = time();
        $scheduleRule->updated_time = time();
        $scheduleRule->save();
        return response()->json(['status'=>200,'message'=>'Success']);
    }

    public function editRule(Request $request){
        $data = $request->all();
        $user_id = $this->tooluser->id;
        $rule = [
            'name' => "required|max:255|unique:schedule_rule,name,NULL,id,tool_user_id,$user_id",
            'id' => "required",
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'unique'    => 'The :attribute is exist.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        $scheduleRule = ScheduleRule::where("tool_user_id","=",$this->tooluser->id)->where("id",$data['id'])->where("status",Schedule::ENABLE)->first();
        if(!$scheduleRule){
            return response()->json(['status'=>400,'message'=>'Error::No Rule']);
        }
        $scheduleRule->name = $data['name'];
        $scheduleRule->updated_time = time();
        $scheduleRule->save();
        return response()->json(['status'=>200,'message'=>'Success']);
    }

    public function removeRule(Request $request){
        $data = $request->all();
        $rule = [
            'id'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }

        $scheduleRule = ScheduleRule::where('id','=',$data['id'])->where('tool_user_id','=',$this->tooluser->id)->first();
        if(!$scheduleRule){
            return response()->json(['status'=>400,'message'=>'Error::No Rule']);
        }
        $scheduleRule->updated_time = time();
        $scheduleRule->status = Schedule::DISABLE;
        $scheduleRule->update();

        return response()->json(['status'=>200,
            'message'=>'Success'
        ]);
    }

    public function removeEvent(Request $request){
        $data = $request->all();
        $rule = [
            'id'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }

        $event = Schedule::where('id','=',$data['id'])->where('tool_user_id','=',$this->tooluser->id)->first();
        if(!$event){
            return response()->json(['status'=>400,'message'=>'Error::No Event']);
        }
        $time = time();
        $event->updated_time = $time;
        $event->status = Schedule::DISABLE;
        $event->update();

        return response()->json(['status'=>200,
            'message'=>'Success'
        ]);
    }

    public function editEvent(Request $request){
        $data = $request->all();
        $rule = [
            'title' => "required|max:255",
            'id' => 'required',
            'rule' => 'required',
        ];
        if($data['recursive']=='true'){
            $rule['start_time']='required|date_format:"H:i"';
            $rule['end_time']='required|date_format:"H:i"';
            if(isset($data['begin'])){
                $rule['begin']='required|digits:10"';
                $rule['expire']='required|digits:10"';
                $rule['weekday']='required';
            }
        }else{
            $rule['start']='required|digits:10"';
            $rule['end']='required|digits:10"';
        }
        $message = [
            'digits' => 'The :attribute must be 10 integer.',
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
            'digits' => 'The Date is invalid',
            'date_format'=> 'The :attribute does not match the format',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        if(!ScheduleRule::where("tool_user_id","=",$this->tooluser->id)->where("id","=",$data['rule'])->first()){
            return response()->json(['status'=>400,'message'=>'Error::9394']);
        }
        $id = $data['id'];
        $event = Schedule::where("tool_user_id","=",$this->tooluser->id)->where("id",$id)->where("status",Schedule::ENABLE)->first();
        if(!$event){
            return response()->json(['status'=>400,'message'=>'Error::No Event']);
        }
        $time = time();
        $event->schedule_rule_id = $data['rule'];
        $event->tool_user_id = $this->tooluser->id;
        $event->title = $data['title'];
        if(isset($data['color'])){
            $event->color = $data['color'];
        }
        if(isset($data['color'])){
            $event->color = $data['color'];
        }
        if($data['recursive']=='true'){
            $event->start_time = $data['start_time'];
            $event->end_time = ($data['end_time']=="00:00")?"23:59":$data['end_time'];
            if(isset($data['begin'])){
                $event->begin_recurrsive = $data['begin'];
                $event->expire_recurrsive = $data['expire'];
                $event->recursive = Schedule::IS_RECURSIVE;
                $event->weekday = str_replace('7','0',implode(',',$data['weekday']));
            }
        }else{
            $event->start = $data['start'];
            $event->end = $data['end'];
            $event->recursive = Schedule::NOT_RECURSIVE;
        }
        $event->created_time = $time;
        $event->updated_time = $time;
        $event->save();
        if($data['recursive']=='true'){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'id'=>$event->id,
                    'groupId'=>$event->id,
                    'title'=>$event->title,
                    'resourceId'=>$event->schedule_rule_id,
                    'color'=>$event->color,
                    'startTime'=>$event->start_time.":00",
                    'endTime'=>$event->end_time.":00",
                    'startRecur'=>Date("Y-m-d\TH:i:s+00:00",$event->begin_recurrsive),
                    'endRecur'=>Date("Y-m-d\TH:i:s+00:00",$event->expire_recurrsive),
                    'daysOfWeek'=>explode(',',$event->weekday),
                ]
            ]);
        }else{
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'id'=>$event->id,
                    'title'=>$event->title,
                    'resourceId'=>$event->schedule_rule_id,
                    'color'=>$event->color,
                    'start'=>Date("Y-m-d\TH:i:s+00:00",$event->start),
                    'end'=>Date("Y-m-d\TH:i:s+00:00",$event->end),
                ]
            ]);
        }
    }

    public function addEvent(Request $request){
        $data = $request->all();
        $rule = [
            'title' => "required|max:255",
            'color' => 'required',
        ];
        if($data['recursive']=='true'){
            $rule['start_time']='required|date_format:"H:i"';
            $rule['end_time']='required|date_format:"H:i"';
            $rule['begin']='required|digits:10"';
            $rule['expire']='required|digits:10"';
            $rule['weekday']='required';
        }else{
            $rule['start']='required|digits:10"';
            $rule['end']='required|digits:10"';
        }
        $message = [
            'digits' => 'The :attribute must be 10 integer.',
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
            'digits' => 'The Date is invalid',
            'date_format'=> 'The :attribute does not match the format',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }
        if(!ScheduleRule::where("tool_user_id","=",$this->tooluser->id)->where("id","=",$data['rule'])->first()){
            return response()->json(['status'=>400,'message'=>'Error::9394']);
        }
        $time = time();
        $event = new Schedule();
        $event->status = Schedule::ENABLE;
        $event->schedule_rule_id = $data['rule'];
        $event->tool_user_id = $this->tooluser->id;
        $event->title = $data['title'];
        $event->color = $data['color'];
        if($data['recursive']=='true'){
            $event->start_time = $data['start_time'];
            $event->end_time = $data['end_time'];
            $event->begin_recurrsive = $data['begin'];
            $event->expire_recurrsive = $data['expire'];
            $event->recursive = Schedule::IS_RECURSIVE;
            $event->weekday = str_replace('7','0',implode(',',$data['weekday']));
        }else{
            $event->start = $data['start'];
            $event->end = $data['end'];
            $event->recursive = Schedule::NOT_RECURSIVE;
        }
        $event->created_time = $time;
        $event->updated_time = $time;
        $event->save();
        if($data['recursive']=='true'){
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'id'=>$event->id,
                    'groupId'=>$event->id,
                    'title'=>$event->title,
                    'resourceId'=>$event->schedule_rule_id,
                    'color'=>$event->color,
                    'startTime'=>$event->start_time.":00",
                    'endTime'=>$event->end_time.":00",
                    'startRecur'=>Date("Y-m-d\TH:i:s+00:00",$event->begin_recurrsive),
                    'endRecur'=>Date("Y-m-d\TH:i:s+00:00",$event->expire_recurrsive),
                    'daysOfWeek'=>explode(',',$event->weekday),
                ]
            ]);
        }else{
            return response()->json(['status'=>200,
                'message'=>'Success',
                'data'=>[
                    'id'=>$event->id,
                    'title'=>$event->title,
                    'resourceId'=>$event->schedule_rule_id,
                    'color'=>$event->color,
                    'start'=>Date("Y-m-d\TH:i:s+00:00",$event->start),
                    'end'=>Date("Y-m-d\TH:i:s+00:00",$event->end),
                ]
            ]);
        }
    }

    public function getEvents(Request $request){

        $getStart = $request->input('getStart');
        $getEnd = $request->input('getEnd');

//        $schedule_rule = $schedule_rule->get()->toArray();
//        $schedule_event = Schedule::where('tool_user_id','=',$this->tooluser->id)->where('status','=',Schedule::ENABLE)->get()->toArray();
//        $duplicate_event_arr = array();
//        $day_diff = 0;
//        foreach($schedule_event as $id=>$event){
//            $schedule_event[$id]['start_time'] = Date("Y-m-d\TH:i:s\Z",$event['start_time'] + $day_diff);
//            $schedule_event[$id]['end_time'] = Date("Y-m-d\TH:i:s\Z",$event['end_time'] + $day_diff);
//        }
        $events = Schedule::select('schedule.id','title','start','end','color','schedule_rule_id as resourceId','recursive','begin_recurrsive as startRecur','expire_recurrsive as endRecur','start_time as startTime','end_time as endTime','weekday as daysOfWeek')->join('schedule_rule',function($join){
            $join->on('schedule.schedule_rule_id','=','schedule_rule.id')->where('schedule_rule.status','=',ScheduleRule::ENABLE);
        })->where('schedule.tool_user_id','=',$this->tooluser->id)->where('schedule.status','=',Schedule::ENABLE)->where(function($query) use ($getStart,$getEnd){
            $query->where(function($query2) use ($getStart,$getEnd){
                $query2->where('start','<=',$getEnd)->where('end','>=',$getStart);
            })->orWhere(function($query3) use ($getStart,$getEnd){
                $query3->where('begin_recurrsive','<=',$getEnd)->where('expire_recurrsive','>=',$getStart);
            });
        })->get()->toArray();
        foreach($events as $id=>$event){
            if($event['recursive']==2){
                unset($events[$id]['start']);
                unset($events[$id]['end']);
                $events[$id]['startRecur'] = Date("Y-m-d\TH:i:s+00:00",$event['startRecur']);
                $events[$id]['endRecur'] = Date("Y-m-d\TH:i:s+00:00",$event['endRecur']);
                $events[$id]['groupId'] = $id;
            }else{
                unset($events[$id]['startTime']);
                unset($events[$id]['endTime']);
                unset($events[$id]['startRecur']);
                unset($events[$id]['endRecur']);
                unset($events[$id]['daysOfWeek']);
                $events[$id]['start'] = Date("Y-m-d\TH:i:s+00:00",$event['start']);
                $events[$id]['end'] = Date("Y-m-d\TH:i:s+00:00",$event['end']);
            }
        }
//        $events = array();
//        for($i=0;$i<3;$i++){
//            $events[] = [
//                'id'=>"$i",
//                'resourceId'=>'b',
//                'start'=>'2019-02-07 00:00:00',
//                'end'=>'2019-02-07 01:00:00',
//                'title'=>'hihi'.$i,
////                "color"=>"#000000",
//            ];
//            $events[] = [
//                'id'=>"$i",
//                'resourceId'=>'b',
//                'startTime'=>'03:00:00',
//                'endTime'=>'05:00:00',
//                'title'=>'hihi'.$i,
//                'startRecur'=>'2019-02-07 00:00:00',
//                'endRecur'=>'2019-04-20 00:00:00',
//                'daysOfWeek'=>[1,2,4,5],
////                "color"=>"#000000",
//            ];
//        }
        return response()->json(['status'=>200,'message'=>$events]);
    }

    public function getEvent(Request $request){
        $data = $request->all();
        if(!isset($data['offset'])||!is_numeric($data['offset'])){
            return response()->json(['status'=>400,'message'=>'no offset']);
        }
        $offset = $data['offset'] * -1 * 60;
        if(isset($data['id'])){
            $events = Schedule::select('id','title','start','end','color','schedule_rule_id as resourceId','recursive','begin_recurrsive as startRecur','expire_recurrsive as endRecur','start_time as startTime','end_time as endTime','weekday as daysOfWeek')->where('tool_user_id','=',$this->tooluser->id)->where('status','=',Schedule::ENABLE)->where('id','=',$data['id'])->get()->toArray();
        }
        if(!$events){
            return response()->json(['status'=>400,'message'=>'no event']);
        }
        foreach($events as $id=>$event){
            if($event['recursive']==2){
                unset($events[$id]['start']);
                unset($events[$id]['end']);
                $events[$id]['startRecur'] = Date("Y-m-d\TH:i:s+00:00",$event['startRecur']+$offset);
                $events[$id]['endRecur'] = Date("Y-m-d\TH:i:s+00:00",$event['endRecur']+$offset);
                $events[$id]['groupId'] = $id;
            }else{
                unset($events[$id]['start_time']);
                unset($events[$id]['end_time']);
                unset($events[$id]['startRecur']);
                unset($events[$id]['endRecur']);
                unset($events[$id]['daysOfWeek']);
                $events[$id]['start'] = Date("Y-m-d\TH:i:s+00:00",$event['start']+$offset);
                $events[$id]['end'] = Date("Y-m-d\TH:i:s+00:00",$event['end']+$offset);
            }
        }
        return response()->json(['status'=>200,'message'=>$events]);
    }

    public function getRule(Request $request){
        $schedule_rule = ScheduleRule::select('id','name as title')->where('tool_user_id','=',$this->tooluser->id)->where('status','=',ScheduleRule::ENABLE)->get()->toArray();
        return response()->json(['status'=>200,'message'=>$schedule_rule]);
    }
}

<?php

namespace App\Http\Controllers\Tool;

use App\Models\ToolUser;
use App\Models\WeekSchedule;
use App\Models\WeekScheduleRule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Validator;

class WeekScheduleController extends ToolMasterController
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
        $schedule_rule = WeekScheduleRule::where('tool_user_id','=',$this->tooluser->id)->where('status','=',WeekSchedule::ENABLE);
        if(!$schedule_rule->first()){
            $schedule_rule = $this->createFirstRule()->where('tool_user_id','=',$this->tooluser->id);
        }
        $schedule_rule = $schedule_rule->get()->toArray();
        $schedule_event = WeekSchedule::where('tool_user_id','=',$this->tooluser->id)->where('status','=',WeekSchedule::ENABLE)->get()->toArray();
        $duplicate_event_arr = array();
        $day_diff = 60*60*24 * 1;
        foreach($schedule_event as $id=>$event){
            $thur_timestamp = strtotime('Monday this week');
            $schedule_event[$id]['start_time'] = Date("Y-m-d\TH:i:s\Z",$thur_timestamp + $event['start_time'] + $day_diff);
            $schedule_event[$id]['end_time'] = Date("Y-m-d\TH:i:s\Z",$thur_timestamp + $event['end_time'] + $day_diff);
            for($i=0;$i<=1;$i++){
                $duplicate_event = $event;
                $week_diff = 60*60*24*7;
                $week_diff *= ($i==0)?-1:1;
                $duplicate_event['start_time'] = Date("Y-m-d\TH:i:s\Z",$thur_timestamp + $event['start_time'] + $week_diff + $day_diff);
                $duplicate_event['end_time'] = Date("Y-m-d\TH:i:s\Z",$thur_timestamp + $event['end_time'] + $week_diff + $day_diff);
                $duplicate_event_arr[] = $duplicate_event;
            }
        }
        $schedule_event = array_merge($schedule_event,$duplicate_event_arr);
        return view('tools/tool_schedule',compact('user_email','schedule_rule','schedule_event'));
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

    public function addOneDayEvent(Request $request){
        $data = $request->all();
        $rule = [
            'title' => "required|max:255",
            'start_time' => 'required|date_format:"H:i"',
            'end_time' => 'required|date_format:"H:i"',
            'start_week'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
            'date_format'=> 'The :attribute does not match the format',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }

        if(!WeekScheduleRule::where("tool_user_id","=",$this->tooluser->id)->where("id","=",$data['rule'])->first()){
            return response()->json(['status'=>400,'message'=>'Error::9394']);
        }

        $week_time = WeekSchedule::getWeekTimestamp($data['start_week']);
        $start_time = WeekSchedule::getTimestampWithoutDate(strtotime($data['start_time']),+8);
        $end_time = WeekSchedule::getTimestampWithoutDate(strtotime($data['end_time']),+8);
        if($data['end_time']=="00:00"){
            $end_time += 60*60*24;
        }
        $time = time();

        $event = new WeekSchedule($data);
        $event->status = WeekSchedule::ENABLE;
        $event->start_time = $week_time+$start_time;
        $event->end_time = $week_time+$end_time;
        $event->start_week = $data['start_week'];
        $event->end_week = $data['start_week'];
        $event->week_schedule_rule_id = $data['rule'];
        $event->tool_user_id = $this->tooluser->id;
        $event->created_time = $time;
        $event->updated_time = $time;
        $event->save();

        return response()->json(['status'=>200,
            'message'=>'Success',
            'data'=>[
                'id'=>$event->id,
                'title'=>$event->title,
                'color'=>$event->color
            ]
        ]);
    }

    public function editOneDayEvent(Request $request){
        $data = $request->all();
        $rule = [
            'id'=>'required',
            'start_time' => 'required|date_format:"H:i"',
            'end_time' => 'required|date_format:"H:i"',
            'start_week'=>'required',
        ];
        $message = [
            'required'    => 'The :attribute field is required.',
            'max' => 'The :attribute can\'t over :max length.',
            'email'      => 'The :attribute is invalid',
            'date_format'=> 'The :attribute does not match the format',
        ];
        $validator = Validator::make($data, $rule, $message);
        if ($validator->fails()) {
            return response()->json(['status'=>400,'message'=>$validator->messages()]);
        }

        $event = WeekSchedule::where('id','=',$data['id'])->where('tool_user_id','=',$this->tooluser->id)->first();

        $week_time = WeekSchedule::getWeekTimestamp($data['start_week']);
        $start_time = WeekSchedule::getTimestampWithoutDate(strtotime($data['start_time']),+8);
        $end_time = WeekSchedule::getTimestampWithoutDate(strtotime($data['end_time']),+8);
        if($data['end_time']=="00:00"){
            $end_time += 60*60*24;
        }
        $time = time();

        $event->start_time = $week_time+$start_time;
        $event->end_time = $week_time+$end_time;
        $event->start_week = $data['start_week'];
        $event->end_week = $data['start_week'];
        $event->title = $data['title'];
        $event->color = $data['color'];
        $event->week_schedule_rule_id = $data['rule'];
        $event->updated_time = $time;
        $event->update();

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

        $event = WeekSchedule::where('id','=',$data['id'])->where('tool_user_id','=',$this->tooluser->id)->first();
        $time = time();
        $event->updated_time = $time;
        $event->status = WeekSchedule::DISABLE;
        $event->update();

        return response()->json(['status'=>200,
            'message'=>'Success'
        ]);
    }

    public function addRule(Request $request){
        $data = $request->all();
        $rule = [
            'name' => "required|max:255|unique:week_schedule_rule,name,NULL,id,tool_user_id,$this->tooluser->id",
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
        $weekScheduleRule = new WeekScheduleRule($data);
        $weekScheduleRule->created_time = time();
        $weekScheduleRule->updated_time = time();
        $weekScheduleRule->save();
        return response()->json(['status'=>200,'message'=>'Success']);
    }

    public function createFirstRule(){
        $data = array(
            "name"=>WeekScheduleRule::DEFAULT_NAME,
            "tool_user_id"=>$this->tooluser->id,
            "status"=>WeekScheduleRule::ENABLE,
        );
        $time = time();
        $weekScheduleRule = new WeekScheduleRule($data);
        $weekScheduleRule->created_time = $time;
        $weekScheduleRule->updated_time = $time;
        $weekScheduleRule->save();
        return $weekScheduleRule;
    }
}

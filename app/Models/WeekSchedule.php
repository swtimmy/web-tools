<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekSchedule extends Model
{
    protected $table = 'week_schedule';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['tool_user_id','week_schedule_rule_id','title','color','start_time','end_time','start_week','end_week','start_datetime','end_datetime','status','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'week_schedule';
    const DISABLE = 0;
    const ENABLE = 1;

    public static function getTimestampWithoutDate($timestamp,$timezone){
        return ($timestamp + ($timezone*60*60)) % (60*60*24);
    }

    public static function getWeekTimestamp($week_number){
        // input :: 0 = sunday, 1 = monday, 2 = tuesday...
        if($week_number == 0){
            $week_number = 7;
        }
        return (($week_number - 1) % 7) * (60*60*24);
    }
}

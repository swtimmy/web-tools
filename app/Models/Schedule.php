<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedule';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['tool_user_id','schedule_rule_id','title','color','start','end','recurrsive','start_time','end_time','begin_recurrsive','expire_recurrsive','weekday','utc','utc_diff','start_unixtime','end_unixtime','status','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'week_schedule';
    const DISABLE = 0;
    const ENABLE = 1;
    const IS_RECURSIVE = 2;
    const NOT_RECURSIVE = 1;

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

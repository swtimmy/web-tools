<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeekScheduleRule extends Model
{
    protected $table = 'week_schedule_rule';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['tool_user_id','name','status','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'week_schedule_rule';
    const DISABLE = 0;
    const ENABLE = 1;
    const DEFAULT_NAME = 'Self';
}

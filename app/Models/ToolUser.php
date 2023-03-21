<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ToolUser extends Model
{
    protected $table = 'tool_user';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['email','password','status','token','created_time','updated_time','created_at','updated_at'];
//     protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'tool_user';
    const DISABLE = 0;
    const ENABLE = 1;


}

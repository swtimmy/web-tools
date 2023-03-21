<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $table = 'dictionary';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['tool_user_id','txt','desc','status','poor_level','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'dictionary';
    const DISABLE = 0;
    const ENABLE = 1;
    const IS_RECURSIVE = 2;
    const NOT_RECURSIVE = 1;
}

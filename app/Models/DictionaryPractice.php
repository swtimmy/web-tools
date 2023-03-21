<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DictionaryPractice extends Model
{
    protected $table = 'dictionary_practice';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['tool_user_id','question','answer','submit','correction','marks','status','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable','2'=>'Done'];
    }

    protected $casts = [
        'question' => 'json',
        'answer' => 'json',
        'submit' => 'json',
        'correction' => 'json',
    ];

    const TABLE = 'dictionary_practice';
    const DISABLE = 0;
    const ENABLE = 1;
    const DONE = 2;
}

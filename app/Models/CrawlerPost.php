<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class CrawlerPost extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'crawler_post';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['crawler_page_id','title','description','content','image','url','status','post_time','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    public static function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'crawler_post';
    const DISABLE = 0;
    const ENABLE = 1;
    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
//    public function setDatetimeAttribute($value) {
//        var_dump($value);exit();
//        $this->attributes['datetime'] = \Date::parse($value);
//    }
//    public function setDateAttribute( $value ) {
//        $this->attributes['date'] = (new Carbon($value))->format('d/m/y');
//    }
//    public function setDatetimeAttribute( $value ) {
//        $this->attributes['created_time'] = (new Carbon($value))->format('d/m/y');
//    }
    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}

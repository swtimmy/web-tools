<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class CrawlerWebsite extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'crawler_website';
    protected $primaryKey = 'id';
    // public $timestamps = false;
     protected $guarded = ['id'];
    protected $fillable = ['name','prefix','url','status','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    static public function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'crawler_website';
    const DISABLE = 0;
    const ENABLE = 1;

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

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
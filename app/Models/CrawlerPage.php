<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class CrawlerPage extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'crawler_page';
    protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['crawler_website_id','name','prefix','url','status','crawler_element','crawler_condition','crawler_title_element','crawler_content_element','crawler_remove_element','crawler_post_time_element','crawler_post_time_format','ignore_post_url','ignore_string','keep_string','created_time','updated_time','created_at','updated_at'];
    // protected $hidden = [];
    // protected $dates = [];
    static public function status(){
        return ['0'=>'Disable','1'=>'Enable'];
    }

    const TABLE = 'crawler_page';
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

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('index');
});

//GET
Route::get('/grep','GrepResultController@index');
Route::get('/login','Tool\ToolUserController@index');
//Route::get('/schedule','Tool\WeekScheduleController@index');
Route::get('/schedule','Tool\ScheduleController@index');
Route::get('/test','TestController@crawler');
Route::get('/timezoneTimeDiffUtcArray','Tool\TimeController@getTimeZoneTimeDiffUtcArray');
Route::get('/timezoneNameArray','Tool\TimeController@getTimeZoneNameArray');
Route::get('/timezoneArray','Tool\TimeController@getTimeZoneArray');

//POST
Route::post('/getGrepInfo','GrepResultController@getInfo');
Route::post('/getGrep','GrepResultController@getNew');
Route::post('/getGrepNewer','GrepResultController@getLastestNew');
Route::post('/getGrepOlder','GrepResultController@getOldestNew');

Route::post('/login','Tool\ToolUserController@login');
Route::post('/register','Tool\ToolUserController@register');
//Route::post('/addScheduleEvent','Tool\WeekScheduleController@addOneDayEvent');
//Route::post('/editScheduleEvent','Tool\WeekScheduleController@editOneDayEvent');
//Route::post('/removeScheduleEvent','Tool\WeekScheduleController@removeEvent');
Route::post('/getScheduleEvents','Tool\ScheduleController@getEvents');
Route::post('/getScheduleEvent','Tool\ScheduleController@getEvent');
Route::post('/getScheduleRule','Tool\ScheduleController@getRule');
Route::post('/addScheduleEvent','Tool\ScheduleController@addEvent');
Route::post('/addScheduleRule','Tool\ScheduleController@addRule');
Route::post('/editScheduleEvent','Tool\ScheduleController@editEvent');
Route::post('/editScheduleRule','Tool\ScheduleController@editRule');
Route::post('/removeScheduleEvent','Tool\ScheduleController@removeEvent');
Route::post('/removeScheduleRule','Tool\ScheduleController@removeRule');

//dictionary
Route::get('/dictionary','Tool\DictionaryController@index');
Route::post('/addDictionary','Tool\DictionaryController@addText');
Route::post('/editDictionary','Tool\DictionaryController@editText');
Route::post('/removeDictionary','Tool\DictionaryController@removeText');
Route::post('/getDictionary','Tool\DictionaryController@getText');

//dictionary practice
Route::get('/dictionaryPractice','Tool\DictionaryPracticeController@practice');
Route::post('/getPractice','Tool\DictionaryPracticeController@getPractice');
Route::post('/submitPractice','Tool\DictionaryPracticeController@submitPractice');
Route::get('/dictionaryPracticeResult/{id}','Tool\DictionaryPracticeController@practiceResult');
Route::get('/dictionaryPracticeList','Tool\DictionaryPracticeController@index');
Route::post('/getDictionaryPracticeList','Tool\DictionaryPracticeController@getPracticeList');


/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^(((?=(?!admin))(?=(?!\/)).))*$', 'subs' => '.*']);


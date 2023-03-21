<?php

namespace App\Http\Controllers\Tool;

use Illuminate\Http\Request;

class TimeController extends ToolMasterController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
//        $this->checkLogin();
    }

    public function index()
    {
        //
    }

    public function getTimeZoneNameArray(){
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $type = array();
            $type['time_str_0'] = date('P', $timestamp);
            $type['time_str_1'] = date('O', $timestamp);
            $second = date('Z', $timestamp);
            $type['hour'] = $second/60/60;
            $type['minute'] = $second/60;
            $type['second'] = $second;
            $zones_array[$zone] = $type;
        }
        return $zones_array;
    }

    public function getTimeZoneTimeDiffUtcArray(){
        $zones_array = array();
        $timestamp = time();
        foreach(timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $type = array();
            $type['time_str_0'] = date('P', $timestamp);
            $type['time_str_1'] = date('O', $timestamp);
            $type['hour'] = date('Z', $timestamp)/60/60;
            $type['minute'] = date('Z', $timestamp)/60;
            $type['second'] = date('Z', $timestamp);
            $zones_array[$zone] = $type;
        }
        return $zones_array;
    }

    public function getTimeZoneArray(){
        echo json_encode(\DateTimeZone::listIdentifiers());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

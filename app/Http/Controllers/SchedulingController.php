<?php

namespace App\Http\Controllers;

use App\event_registration;
use App\scheduling;
use App\sub_event_master;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\scheduling  $scheduling
     * @return \Illuminate\Http\Response
     */
    public function show(scheduling $scheduling)
    {
        //
    }

    public function showEacScheduling()
    {
        $subEvent = sub_event_master::get();
        $ary = array();
        $a = "";
        foreach ($subEvent as $key => $value) {
            array_push($ary, "sum(case when sem.s_e_name ='" . $value->s_e_name . "' THEN case when er.status = 1 THEN 1 else 0 end end) as '" . $value->s_e_name . "'");
        }
        $a .= 'select er.u_id,um.f_name,um.l_name,um.enrollmentno';
        for ($i = 0; $i < count($ary); $i++) {
            $a .= ',' . $ary[$i];
        }
        $a .= ' from event_registrations er join user_masters um on er.u_id = um.u_id join sub_event_masters sem on sem.s_e_id = er.s_e_id group by er.u_id,um.f_name,um.l_name,um.enrollmentno';
        $ans = DB::select($a);
        $keys = array();
        foreach ($ans as $key => $value) {
            foreach ($value as $key => $value) {
                array_push($keys, $key);
            }
        }
        return view('eac.viewScheduling')->with(['data' => $ans, 'keys' => $key, 'subevent' => $subEvent]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\scheduling  $scheduling
     * @return \Illuminate\Http\Response
     */
    public function edit(scheduling $scheduling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\scheduling  $scheduling
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, scheduling $scheduling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\scheduling  $scheduling
     * @return \Illuminate\Http\Response
     */
    public function destroy(scheduling $scheduling)
    {
        //
    }
}

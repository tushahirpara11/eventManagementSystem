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
        $userData = DB::select('select * from user_masters u, event_registrations e where u.u_id=e.u_id');
        $subEvent = sub_event_master::get();
        $eventRegistration = event_registration::get();
        return view('eac.viewScheduling')->with(['user' => $userData, 'subevent' => $subEvent, 'registerEvet' => $eventRegistration]);
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

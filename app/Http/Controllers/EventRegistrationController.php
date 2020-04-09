<?php

namespace App\Http\Controllers;

use App\event_registration;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class EventRegistrationController extends Controller
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
        $check=event_registration::where('s_e_id','=',$request->s_e_id)->where('u_id','=',$request->user_id)->get();
        if(count($check) > 0 )
        {
            return redirect('/student/events')->with('error','You Already Registered For This Event !!!');
        }
        else
        {
        event_registration::create([
            's_e_id' => $request->s_e_id,
            'u_id' => $request->user_id,
            'g_id' => $request->g_id,
            'r_id' => $request->role_id,
            'status' => 1,
        ]);
        return redirect('/student/events')->with('success','Event Registration Successfull !!!');
        }
    }
    public function coordinator_store(Request $request)
    {
        $check=event_registration::where('s_e_id','=',$request->s_e_id)->where('u_id','=',$request->user_id)->get();
        if(count($check) > 0 )
        {
            return redirect('/student_coordinator/events')->with('error','You Already Registered For This Event !!!');
        }
        else
        {
        event_registration::create([
            's_e_id' => $request->s_e_id,
            'u_id' => $request->user_id,
            'g_id' => $request->g_id,
            'r_id' => $request->role_id,
            'status' => 1,
        ]);
        return redirect('/student_coordinator/events')->with('success','Event Registration Successfull !!!');
        } 
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\event_registration  $event_registration
     * @return \Illuminate\Http\Response
     */
    public function show(event_registration $event_registration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_registration  $event_registration
     * @return \Illuminate\Http\Response
     */
    public function edit(event_registration $event_registration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_registration  $event_registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, event_registration $event_registration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_registration  $event_registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_registration $event_registration)
    {
        //
    }
}

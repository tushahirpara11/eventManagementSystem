<?php

namespace App\Http\Controllers;

use App\event_master;
use Illuminate\Http\Request;

class EventMasterController extends Controller
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
     * @param  \App\event_master  $event_master
     * @return \Illuminate\Http\Response
     */
    public function show(event_master $event_master)
    {
        return view('admin/viewEvent')->with('data',event_master::get());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\event_master  $event_master
     * @return \Illuminate\Http\Response
     */
    public function edit(event_master $event_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\event_master  $event_master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, event_master $event_master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\event_master  $event_master
     * @return \Illuminate\Http\Response
     */
    public function destroy(event_master $event_master)
    {
        //
    }
}

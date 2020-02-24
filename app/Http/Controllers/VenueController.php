<?php

namespace App\Http\Controllers;

use App\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VenueController extends Controller
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
        $count = venue::where('v_name', $request->get('v_name'))->get();
        if (count($count) == 0) {
            $insertBranch = new venue(['v_name' => $request->get('v_name'), 'v_address' => $request->get('v_address')]);
            $insertBranch->save();
            return Redirect::back()->with('success', 'Venue Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Venue Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(venue $venue)
    {
        return view('admin/viewVenue')->with(['data' => venue::get()]);        
    }
    
    function delete($id)
    {
        $refresh = DB::delete('delete from venues where v_id=' . $id);
        return Redirect::back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(venue $venue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, venue $venue)
    {
        DB::update('update venues set v_name = "' . $request->get('v_name') . '", v_address = "' . $request->get('v_address') . '" where v_id = ' . $request->v_id);
        return redirect('/admin/venue');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(venue $venue)
    {
        //
    }
}

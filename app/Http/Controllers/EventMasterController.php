<?php

namespace App\Http\Controllers;

use App\branchMaster;
use App\event_master;
use App\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

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
        $count = event_master::where('e_name', $request->get('e_name'))->get();
        if (count($count) == 0) {
            $insertEvent = new event_master([
                'e_name' => $request->get('e_name'), 'e_discription' => $request->get('e_discription'),
                'e_status' => $request->get('e_status'), 'e_start_date' => $request->get('e_start_date'),
                'e_end_date' => $request->get('e_end_date'), 'b_id' => $request->get('b_id'),
                'v_id' => $request->get('v_id')
            ]);
            $insertEvent->save();
            return Redirect::back()->with('success', 'Event Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Event Already Exists...');
        }
    }

    public function storeEacEvent(Request $request)
    {
        $count = event_master::where('e_name', $request->get('e_name'))->get();
        if (count($count) == 0) {
            $insertEvent = new event_master([
                'e_name' => $request->get('e_name'), 'e_discription' => $request->get('e_discription'),
                'e_status' => $request->get('e_status'), 'e_start_date' => $request->get('e_start_date'),
                'e_end_date' => $request->get('e_end_date'), 'b_id' => $request->get('b_id'),
                'v_id' => $request->get('v_id')
            ]);
            $insertEvent->save();
            return Redirect::back()->with('success', 'Event Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Event Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\event_master  $event_master
     * @return \Illuminate\Http\Response
     */
    public function show(event_master $event_master)
    {
        return view('admin/viewEvent')->with(['data' => event_master::get(), 'venue' => venue::get(), 'branch' => branchMaster::get()]);
    }
    public function showEacEvent(event_master $event_master)
    {
        return view('eac/viewEvent')->with(['data' => event_master::get(), 'venue' => venue::get(), 'branch' => branchMaster::get()]);
    }

    public function delete($id)
    {
        DB::delete('delete from event_masters where e_id=' . $id);
        return Redirect::back();
    }

    public function deleteEacEvent ($id)
    {
        DB::delete('delete from event_masters where e_id=' . $id);
        return Redirect::back();
    }

    function updatestatus($eid, $status)
    {
        DB::update('update event_masters set e_status = "' . $status . '" where e_id = ' . $eid);
        return redirect('/admin/event');
    }
    function updatestatusEacEvent($eid, $status)
    {
        DB::update('update event_masters set e_status = "' . $status . '" where e_id = ' . $eid);
        return redirect('/eac/event');
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
    public function update(Request $request)
    {
        DB::update('update event_masters set b_id = ' . $request->get('b_id') . ', v_id = ' . $request->get('v_id') .
            ', e_name = "' . $request->get('e_name') . '", e_discription = "' . $request->get('e_discription') .
            '", e_start_date = "' . $request->get('e_start_date') . '", e_end_date = "' . $request->get('e_end_date') .
            '" where e_id = ' . $request->e_id);
        return redirect('/admin/event');
    }
    public function updateEacEvent(Request $request)
    {
        DB::update('update event_masters set b_id = ' . $request->get('b_id') . ', v_id = ' . $request->get('v_id') .
            ', e_name = "' . $request->get('e_name') . '", e_discription = "' . $request->get('e_discription') .
            '", e_start_date = "' . $request->get('e_start_date') . '", e_end_date = "' . $request->get('e_end_date') .
            '" where e_id = ' . $request->e_id);
        return redirect('/eac/event');
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

<?php

namespace App\Http\Controllers;

use App\event_master;
use App\sub_event_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class SubEventMasterController extends Controller
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
        $count = sub_event_master::where('s_e_name', $request->get('s_e_name'))->get();
        if (count($count) == 0) {
            $insertSubEvent = new sub_event_master([
                's_e_name' => $request->get('s_e_name'), 's_e_discription' => $request->get('s_e_discription'),
                'status' => $request->get('status'), 's_e_duration' => $request->get('s_e_duration'),
                'e_id' => $request->get('e_id')
            ]);
            $insertSubEvent->save();
            return Redirect::back()->with('success', 'Sub Event Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Sub Event Already Exists...');
        }
    }

    public function storeEacSubEvent(Request $request)
    {
        $count = sub_event_master::where('s_e_name', $request->get('s_e_name'))->get();
        if (count($count) == 0) {
            $insertSubEvent = new sub_event_master([
                's_e_name' => $request->get('s_e_name'), 's_e_discription' => $request->get('s_e_discription'),
                'status' => $request->get('status'), 's_e_duration' => $request->get('s_e_duration'),
                'e_id' => $request->get('e_id')
            ]);
            $insertSubEvent->save();
            return Redirect::back()->with('success', 'Sub Event Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Sub Event Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sub_event_master  $sub_event_master
     * @return \Illuminate\Http\Response
     */
    public function show(sub_event_master $sub_event_master)
    {
        return view('admin/viewSubEvent')->with([
            'data' => sub_event_master::get(),
            'event' => event_master::where(['e_status' => 1])->get()
        ]);
    }

    public function showEacSubEvent(sub_event_master $sub_event_master)
    {
        return view('eac/viewSubEvent')->with([
            'data' => sub_event_master::where(['e_id' => session('e_id')])->get(),
            'event' => event_master::where(['e_id' => session('e_id'), 'e_status' => 1])->get()
        ]);
    }

    public function delete($id)
    {
        DB::delete('delete from sub_event_masters where s_e_id=' . $id);
        return Redirect::back();
    }

    public function deleteEacSubEvent($id)
    {
        DB::delete('delete from sub_event_masters where s_e_id=' . $id);
        return Redirect::back();
    }

    function updatestatus($eid, $status)
    {
        DB::update('update sub_event_masters set status = "' . $status . '" where s_e_id = ' . $eid);
        return redirect('/admin/subevent');
    }

    function updatestatusEacSubEvent($eid, $status)
    {
        DB::update('update sub_event_masters set status = "' . $status . '" where s_e_id = ' . $eid);
        return redirect('/eac/subevent');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sub_event_master  $sub_event_master
     * @return \Illuminate\Http\Response
     */
    public function edit(sub_event_master $sub_event_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sub_event_master  $sub_event_master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::update('update sub_event_masters set e_id = ' . $request->get('e_id') . ', s_e_name = "' . $request->get('s_e_name') . '"
        , s_e_discription = "' . $request->get('s_e_discription') . '", s_e_duration = "' . $request->get('s_e_duration') . '"
         where s_e_id = ' . $request->s_e_id);
        return redirect('/admin/subevent');
    }

    public function updateEacSubEvent(Request $request)
    {
        DB::update('update sub_event_masters set e_id = ' . $request->get('e_id') . ', s_e_name = "' . $request->get('s_e_name') . '"
        , s_e_discription = "' . $request->get('s_e_discription') . '", s_e_duration = "' . $request->get('s_e_duration') . '"
         where s_e_id = ' . $request->s_e_id);
        return redirect('/eac/subevent');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sub_event_master  $sub_event_master
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}

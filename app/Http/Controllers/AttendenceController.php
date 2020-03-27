<?php

namespace App\Http\Controllers;

use App\attendence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendenceController extends Controller
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
     * @param  \App\attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function showEacAttendence()
    {
        $data = DB::select('select * from attendences a, user_masters u, sub_event_masters s where a.s_e_id = 
        s.s_e_id and a.u_id=u.u_id');
        return view('eac.viewAttendence')->with(['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $date)
    {
        $data = DB::select('select * from user_masters where u_id IN (SELECT u_id FROM event_registrations where status=' . 1 . ' and s_e_id =' . $id . ')');
        $attendence = DB::select('select * from attendences where s_e_id =' . $id . ' and date = "' . $date . '"');
        $a = json_decode($attendence[0]->present, true);
        return view('eac.updateAttendence')->with(['data' => $data, 'present' => $a, 'attendence' => $attendence]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function updateEacAttendence(Request $request)
    {
        if ($request->ajax()) {
            $ans = DB::table('attendences')
                ->where('date', $request->date)->where('s_e_id', $request->s_e_id)
                ->update(['present' => json_encode($request->present)]);
            return response()->json(['flag' => $ans]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\attendence  $attendence
     * @return \Illuminate\Http\Response
     */
    public function destroy(attendence $attendence)
    {
        //
    }
}

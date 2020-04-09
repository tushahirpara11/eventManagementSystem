<?php

namespace App\Http\Controllers;

use App\costume;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CostumeController extends Controller
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
    public function storeFcCostumes(Request $request)
    {
        $user = user_master::where('email', $request->get('u_id'))->get();
        $costumeStore = new costume([
            'u_id' => $request->get('u_id'),
            'issuer' => $request->get('issuer'),
            'returner' => $request->get('returner'),
            'issue_date' => $request->get('issue_date'),
            'return_date' => $request->get('return_date'),
            'status' => $request->get('status'),
            's_e_id' => $request->get('s_e_id'),
            'u_id' => $user[0]->u_id,
            'issuer' => $request->get('issuer'),
            'returner' => $request->get('returner')
        ]);
        if ($costumeStore->save()) {
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\costume  $costume
     * @return \Illuminate\Http\Response
     */
    public function showFcCostumes()
    {
        $data = DB::select('select * from costumes c,user_masters um, sub_event_masters sem where c.issuer=um.u_id and c.returner=um.u_id and c.u_id=um.u_id and c.s_e_id=
        sem.s_e_id and c.s_e_id=' . Session::get('f_s_e_id'));
        $studentList = DB::select('select u.u_id,u.f_name,u.l_name,u.enrollmentno,u.email,u.phone from user_masters u,event_registrations er where u.u_id=er.u_id and er.s_e_id =' . Session::get('f_s_e_id'));
        return view('fc.viewCostume')->with(['data' => $data, 'studentList' => $studentList]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\costume  $costume
     * @return \Illuminate\Http\Response
     */
    public function edit(costume $costume)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\costume  $costume
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, costume $costume)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\costume  $costume
     * @return \Illuminate\Http\Response
     */
    public function destroy(costume $costume)
    {
        //
    }
}

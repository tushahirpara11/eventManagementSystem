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
        $user = user_master::where('email', $request->get('issuer'))->get();
        $count = costume::where(['u_id' => $request->get('u_id'), 's_e_id' => $request->get('s_e_id')])->get();
        if (count($count) == 0) {
            $costumeStore = new costume([
                'u_id' => $request->get('u_id'),
                'issuer' => $user[0]->u_id,
                'returner' => $request->get('returner'),
                'issue_date' => $request->get('issue_date'),
                'return_date' => $request->get('return_date'),
                'status' => $request->get('status'),
                's_e_id' => $request->get('s_e_id'),
            ]);
            if ($costumeStore->save()) {
                return back()->with('success', 'Costume Issued Successfully.');
            } else {
                return back()->with('success', 'Costume not Issued.');
            }
        } else {
            return back()->with('error', 'Costume Already isssued.');
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
        $data = DB::select('select c.costume_id,s.s_e_id,s.s_e_name,u.u_id,u.f_name,u.l_name,c.issuer,c.returner,c.issue_date,c.return_date,c.status from costumes c, sub_event_masters s, user_masters u where c.u_id=u.u_id and c.s_e_id=s.s_e_id and c.s_e_id=' . Session::get('f_s_e_id'));
        $student = user_master::get();
        $studentList = DB::select('select u.u_id,u.f_name,u.l_name,u.enrollmentno,u.email,u.phone from user_masters u,event_registrations er where u.u_id=er.u_id and er.s_e_id =' . Session::get('f_s_e_id'));
        return view('fc.viewCostume')->with(['data' => $data, 'student' => $student, 'studentList' => $studentList]);
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
    public function updateFcCostumes(Request $request, costume $costume)
    {        
        $user = user_master::where('email', $request->get('u_id'))->get();
        if ($request->get('status') == 0) {
            $update = DB::update('update costumes set returner=NULL, return_date=NULL, status=0 where s_e_id=' . $request->get('s_e_id') . ' and costume_id=' . $request->get('costume_id'));
            if (count($update) == 1) {
                return back()->with('success', 'Costume Updated Successfully');
            } else {
                return back()->with('error', 'Costume not Updated');
            }
        } else {
            $update = DB::update('update costumes set returner=' . $user[0]->u_id . ', return_date="' . date('Y-m-d') . '", status=1 where s_e_id=' . $request->get('s_e_id') . ' and costume_id=' . $request->get('costume_id'));
            if (count($update) == 1) {
                return back()->with('success', 'Costume Updated Successfully');
            } else {
                return back()->with('error', 'Costume not Updated');
            }
        }
    }
    public function deleteFcCostumes($costume_id)
    {
        $delete = DB::delete('delete from costumes where costume_id=' . $costume_id);
        if($delete) {
            return back()->with('success','COstume Deleted Successfully');
        } else {
            return back()->with('error','Cosume not Deleted');
        }
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

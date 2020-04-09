<?php

namespace App\Http\Controllers;

use App\practice_schedule;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Mail\PracticeScheduleMailable;
use App\sub_event_master;
use Illuminate\Support\Facades\Mail;


class PracticeScheduleController extends Controller
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
    public function storeFcPracticeSchedule(Request $request)
    {
        $checkSchedule = practice_schedule::where([
            'date' => $request->get('date'),
            's_e_id' => $request->get('s_e_id')
        ])->get();

        if (count($checkSchedule) == 0) {
            $email = DB::select('select um.email,um.u_id from user_masters um,event_registrations er where um.u_id=er.u_id and er.status = 1 and er.s_e_id=' . Session::get('f_s_e_id'));
            $emailArray = array();
            $userArray = array();

            foreach ($email as $key => $value) {
                array_push($emailArray, $value->email);
                array_push($userArray, $value->u_id);
            }
            Mail::to($emailArray)->send(new PracticeScheduleMailable($request->get('description')));
            if (count(Mail::failures()) > 0) {
                return back()->with('error', 'Something went wrong please try again after sometimes');
            } else {
                $user = user_master::where('email', $request->get('u_id'))->get();
                $storeData = new practice_schedule([
                    's_e_id' => $request->get('s_e_id'),
                    'participants' => json_encode($userArray),
                    'u_id' => $user[0]->u_id,
                    'description' => $request->get('description'),
                    'date' => $request->get('date'),
                    'time' => $request->get('time')
                ]);
                if ($storeData->save()) {
                    return back()->with('success', 'Mails send Successfully');
                } else {
                    return back()->with('error', 'Schedule not added Successfully');
                }
            }
        } else {
            return back()->with('error', 'Schedule Already Generated on that day');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\practice_schedule  $practice_schedule
     * @return \Illuminate\Http\Response
     */
    public function showFcPracticeSchedule()
    {
        $user = user_master::where('email', Session::get('fc'))->get();
        $data = DB::select('select * from user_masters um, practice_schedules p,sub_event_masters sm where um.u_id = p.u_id and p.s_e_id=sm.s_e_id and p.u_id=' . $user[0]->u_id);
        return view('fc.viewPracticeSchedule')->with('data', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\practice_schedule  $practice_schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(practice_schedule $practice_schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\practice_schedule  $practice_schedule
     * @return \Illuminate\Http\Response
     */
    public function updateFcPracticeSchedule(Request $request)
    {
        $email = DB::select('select um.email,um.u_id from user_masters um,event_registrations er where um.u_id=er.u_id and er.status = 1 and er.s_e_id=' . Session::get('f_s_e_id'));

        $emailArray = array();
        $userArray = array();

        foreach ($email as $key => $value) {
            array_push($emailArray, $value->email);
            array_push($userArray, $value->u_id);
        }
        Mail::to($emailArray)->send(new PracticeScheduleMailable($request->get('description')));
        if (count(Mail::failures()) > 0) {
            return back()->with('error', 'Something went wrong please try again after sometimes');
        } else {
            $updateData = practice_schedule::where('p_id', $request->get('p_id'))->update([
                'participants' => json_encode($userArray),
                'description' => $request->get('description'),
                'date' => $request->get('date'),
                'time' => $request->get('time'),
            ]);
            if ($updateData) {
                return back()->with('success', 'Mails send Successfully');
            } else {
                return back()->with('success', 'Schedule not updated Successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\practice_schedule  $practice_schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(practice_schedule $practice_schedule)
    {
        //
    }
}

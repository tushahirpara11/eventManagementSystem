<?php

namespace App\Http\Controllers;

use App\user_master;
use App\branchMaster;
use App\stream_master;
use App\division_master;
use App\event_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;

class UserMasterController extends Controller
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
        user_master::create([
            'f_name'=>$request->f_name,
            'l_name'=>$request->l_name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>encrypt($request->password),
            'dob'=>$request->dob,
            'gender'=>$request->gender,
            'u_type'=>$request->u_type,
            'enrollmentno'=>$request->enrollment,
            'b_id'=>$request->branch,
            's_id'=>$request->stream,
            'd_id'=>$request->division,
        ]);
        return Redirect::back()->with('success', 'Registration successfull !!! Please Login');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function show(user_master $user_master)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function edit(user_master $user_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user_master $user_master)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function destroy(user_master $user_master)
    {
        //
    }
    public function get_data()
    {
        $branches=branchMaster::all();
        $streams=stream_master::all();
        $divisions=division_master::all();
        return view('/student/registration',compact('branches','streams','divisions'));
    }
    public function validateUser(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $data= DB::table('user_masters')->where('email','=',$email)->get();
        if(empty($data[0]->email))
        {
            return redirect::back()->with('error','Invalid EmailID !!!!');
        }
        else
        {
            if($password == decrypt($data[0]->password))
            {
                session(['user'=>$data[0]->f_name]);
                session(['id'=>$data[0]->u_id]);
                return redirect('/student/events');
            }
            else
            {
                return redirect::back()->with('error','Invalid Password !!!!');
            }
        }
    }
    public function getEvents()
    {
        $events=event_master::all();
        return view('/student/event_list',compact('events'));
    }
}
<?php

namespace App\Http\Controllers;

use App\user_master;
use App\branchMaster;
use App\stream_master;
use App\division_master;
use App\event_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
<<<<<<< HEAD
use Illuminate\Support\Facades\Cookie;
use DB;
=======
use Illuminate\Support\Facades\DB;
>>>>>>> cf8c4185307e805fa8709a37ebfb0f813f23a1ae

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
        $check=user_master::where('email', $request->email)->orwhere('phone', $request->phone)->get();
        if(count($check) == 0)
        {
            user_master::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => encrypt($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender,
                'u_type' => $request->u_type,
                'enrollmentno' => $request->enrollment,
                'b_id' => $request->branch,
                's_id' => $request->stream,
                'd_id' => $request->division,
            ]);
            return Redirect::back()->with('success', 'Registration successfull !!! Please Login');
        }
        else
        {
        return Redirect::back()->with('error', 'Email Address of Phone already Exists!!!');  
        }
    }

    public function adminStore(Request $request)
    {
        // dd($count);
        $count = user_master::where(['email' => $request->get('email'), 'phone' => $request->get('phone')])->get();
        if (count($count) == 0) {
            user_master::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => encrypt($request->password),
                'dob' => $request->dob,
                'gender' => $request->gender,
                'u_type' => 2,
                'b_id' => $request->b_id,
            ]);
            return Redirect::back()->with('success', 'User Added Successfull.');
        } else {
            return Redirect::back()->with('error', 'User Already exists.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function show(user_master $user_master)
    {
        return view('admin/viewUser')->with(['data' => user_master::where('u_type', 2)->get(), 'branch' => branchMaster::get()]);
    }

    function delete($id)
    {
        $refresh = DB::delete('delete from user_masters where u_id=' . $id);
        return Redirect::back();
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
    public function update(Request $request)
    {
<<<<<<< HEAD
        DB::update('update user_masters set f_name = "' . $request->get('f_name') . '",     
        l_name = "' . $request->get('l_name') . '",
        email = "' . $request->get('email') . '",
        phone = "' . $request->get('phone') . '",
        gender = "' . $request->get('gender') . '",
        dob = "' . $request->get('dob') . '",
        enrollmentno = "' . $request->get('enrollment') . '",
        b_id = "' . $request->get('branch') . '",
        s_id = "' . $request->get('stream') . '",
        d_id = "' . $request->get('division') . '" where u_id = ' . $request->get('id'));
        return Redirect::back()->with('success', 'Update Profile Successfull');
=======
        DB::update('update user_masters set f_name = "' . $request->get('f_name') . '", l_name = "' . $request->get('l_name') .
            '", email = "' . $request->get('email') . '", phone = "' . $request->get('phone') .
            '", dob = "' . $request->get('dob') . '", b_id = ' . $request->get('b_id') .
            ' where u_id = ' . $request->get('u_id'));
        return redirect('/admin/user');
>>>>>>> cf8c4185307e805fa8709a37ebfb0f813f23a1ae
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
        $branches = branchMaster::all();
        $streams = stream_master::all();
        $divisions = division_master::all();
        return view('/student/registration', compact('branches', 'streams', 'divisions'));
    }
    public function getStream(Request $request)
    {
        if ($request->ajax()) {
            $data = stream_master::where('b_id', '=', $request->b_id)->get();
            return response()->json(['option' => $data]);
        }
    }
    public function getDivision(Request $request)
    {
        if ($request->ajax()) {
            $data = division_master::where('s_id', '=', $request->s_id)->get();
            return response()->json(['option' => $data]);
        }
    }
    public function validateUser(Request $request)
    {
        $email = $request->email;
        $password = $request->password;
        $data = DB::table('user_masters')->where('email', '=', $email)->get();
        if (empty($data[0]->email)) {
            return redirect::back()->with('error', 'Invalid EmailID !!!!');
        } else {
            if ($password == decrypt($data[0]->password)) {
                session(['user' => $data[0]->f_name]);
                session(['id' => $data[0]->u_id]);
                return redirect('/student/events');
            } else {
                return redirect::back()->with('error', 'Invalid Password !!!!');
            }
        }
    }
    public function getEvents()
    {
        $events = event_master::where('e_status', '=', 1)->get();
        return view('/student/event_list', compact('events'));
    }
    public function userProfile()
    {
        $branch = branchMaster::all();
        $stream = stream_master::all();
        $division = division_master::all();
        $profile=user_master::where('u_id', '=', session('id'))->get();
        return view('/student/profile',compact('profile','branch','stream','division'));
    }
    public function logout(Request $request)
    {
        if (session()->has('user')) {
            $request->session()->flush('user');
            $cookie = Cookie::forget('user');
            return redirect('student/login')->withCookie($cookie);
            // return redirect(URL::previous());
        }
    }
    public function change_password(Request $request)
    {
        $data=user_master::where('u_id','=',session('id'))->get();
        if(decrypt($data[0]->password) == $request->oldpassword)
        {
            $pass=encrypt($request->get('newpassword'));
            DB::update('update user_masters set password = "' . $pass . '" where u_id = ' . session('id'));
            return Redirect::back()->with('success', 'Password Change Successfully !!!!!');
        }
        else
        {
            return Redirect::back()->with('error', 'Old Password Does Not Match !!!!!');        }
    }
}

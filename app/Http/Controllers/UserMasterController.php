<?php

namespace App\Http\Controllers;

use App\user_master;
use App\branchMaster;
use App\stream_master;
use App\division_master;
use App\event_master;
use App\sub_event_master;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
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
    public function getSubevent(Request $request)
    {
        $e_id=$request->e_id;
        $sub_event=sub_event_master::where('e_id','=',$e_id)->get();
        return view('/student/event_registration',compact('sub_event'));
    }
    public function mail(Request $request)
    {
        $check=user_master::where('email','=',$request->email)->get();
        $name="http://127.0.0.1:8000/student/reset_password";
        if(count($check) > 0)
        {
            session(['email'=>$request->email]);
            Mail::to($request->email)->send(new SendMailable($name));
            return Redirect::back()->with('success','Check Your Mail!!!');   
        }
        else
        {
            return Redirect::back()->with('error','You Are Not Registered !!!!! ');
        }
    }
    public function reset_password_form()
    {
        return view('/student/reset_password');
    }
    public function resetPassword(Request $request)
    {
        $mail = $request->email;
        $password=encrypt($request->password);
        $check=DB::update('update user_masters set password = "' . $password . '" where email = "' . $mail.'"');
        if($check)
        {
            return redirect('/student/login')->with('success','Password Reset Successfully !!! Please Login');
        }
        else
        {
            return Redirect::back()->with('error','Something Went Wrong !!!!');
        }
    }
} 

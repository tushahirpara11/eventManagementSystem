<?php

namespace App\Http\Controllers;

use App\user_master;
use App\branchMaster;
use App\stream_master;
use App\division_master;
use App\event_master;
use App\group;
use App\role;
use App\sub_event_master;
use App\event_registration;
use App\venue;
use App\expence_type;
use App\Mail\SendMailable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

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
		$check = user_master::where('email', $request->email)->orwhere('phone', $request->phone)->get();
		if (count($check) == 0) {
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
		} else {
			return Redirect::back()->with('error', 'Email Address of Phone already Exists!!!');
		}
	}

	public function adminStore(Request $request)
	{
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
	public function show()
	{
		return view('admin/viewUser')->with(['data' => user_master::where('u_type', 2)->get(), 'branch' => branchMaster::get()]);
	}

	public function showEacUser()
	{
		return view('eac/viewUser')->with([
			'data' => DB::select('select * from user_masters u,branch_masters b where u.b_id=b.b_id and u.email !="' . Session::get('fc') . '" and u.b_id=' . Session::get('b_id')),
			'branch' => branchMaster::get()
		]);
	}

	public function showFcUser()
	{
		return view('fc/viewUser')->with([
			'data' => DB::select('select * from user_masters u,branch_masters b,stream_masters sm,division_masters dm,event_registrations er where b.b_id=u.b_id and sm.s_id=u.s_id and dm.d_id=sm.s_id=u.d_id and u.u_id=er.u_id and er.s_e_id =' . Session::get('f_s_e_id')),
			'branch' => branchMaster::get(),
			'stream' => stream_master::get(),
			'division' => division_master::get()
		]);
	}

	function delete($id)
	{
		$deleteUser = DB::delete('delete from user_masters where u_id=' . $id);
		if ($deleteUser) {
			return Redirect::back()->with('success', "User Deleted Successfully");
		} else {
			return Redirect::back()->with('error', "User not Deleted");
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\user_master  $user_master
	 * @return \Illuminate\Http\Response
	 */
	public function edit()
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
	public function updateAdmin(Request $request)
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

	public function updateEacUser(Request $request)
	{
		$update = DB::update('update user_masters set f_name = "' . $request->get('f_name') . '", l_name = "' . $request->get('l_name') .
			'", email = "' . $request->get('email') . '", gender="' . $request->input('gender') . '", phone = "' . $request->get('phone') .
			'", dob = "' . $request->get('dob') . '", b_id = ' . $request->get('b_id') .
			' where u_id = ' . $request->get('u_id'));
		if ($update) {
			return redirect('/eac/user')->with('success', "User Updated Successfully");
		} else {
			return redirect('/eac/user')->with('error', "User Not Updated");
		}
	}

	public function updateFcUser(Request $request)
	{
		$update = DB::update('update user_masters set u_type = ' . $request->get('u_type') .
			' where u_id = ' . $request->get('u_id'));
		if ($update) {
			return redirect('/fc/user')->with('success', "User Updated Successfully");
		} else {
			return redirect('/fc/user')->with('error', "User Not Updated");
		}
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function destroyEac()
    {
        if (session()->has('eac')) {
            session()->flush('eac');
            $cookie = Cookie::forget('eac');
            return redirect('eac/')->withCookie($cookie);
        }
    }
    public function destroyFc()
    {
        if (session()->has('fc')) {
            session()->flush('fc');
            $cookie = Cookie::forget('fc');
            return redirect('fc/')->withCookie($cookie);
        }
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
                $cdata = DB::table('event_registrations')->where('u_id','=',session('id'))->get();
                if(count($cdata) == 0)
                {
                    return redirect('student/events');
                }
                else
                {
                    if($cdata[0]->r_id == 4)
                    {
                        return redirect('student/events');
                    }
                    else
                    {
                        session(['r_id' => 3]);
                        session(['coordinator' => $data[0]->u_id]);
                        session(['s_e_id' => $cdata[0]->s_e_id]);
                        return redirect('student_coordinator/events');
                    }
                }
            } else {
                return redirect::back()->with('error', 'Invalid Password !!!!');
            }
        }
    }
    function validateEacLogin(Request $request)
    {
        $count = user_master::where([
            'email' => $request->get('email'), 'u_type' => $request->get('u_type')
        ])->get();
        if (count($count) == 1) {
            if ($request->get('password') == decrypt($count[0]->password)) {
                $group = group::where(['u_id' => $count[0]->u_id])->get();
                if (count($group) == 1) {
                    $role = role::where(['r_id' => $group[0]->r_id])->get();
                    if (count($role) == 1 && $role[0]->r_name == 'SEC') {
                        session(['eac' => $count[0]->email]);
                        session(['e_id' => $group[0]->e_id]);
                        session(['b_id' => $count[0]->b_id]);
                        return redirect('/eac/choreographer');
                    } else {
                        return Redirect::back()->with('error', 'You have not Permission to access routes!');
                    }
                } else {
                    return Redirect::back()->with('error', 'You have not Provide to access this routes!');
                }
            } else {
                return redirect::back()->with('error', 'Invalid Password..!');
            }
        } else {
            return Redirect::back()->with('error', 'Invalid Credential..!');
        }
    }

	function validateFcLogin(Request $request)
	{
		$count = user_master::where([
			'email' => $request->get('email'), 'u_type' => $request->get('u_type')
		])->get();
		if (count($count) == 1) {
			if ($request->get('password') == decrypt($count[0]->password)) {
				$group = group::where(['u_id' => $count[0]->u_id])->get();
				if (count($group) == 1) {
					$role = role::where(['r_id' => $group[0]->r_id])->get();
					if (count($role) == 1 && $role[0]->r_name == 'FC') {
						session(['fc' => $count[0]->email]);
						session(['f_s_e_id' => $group[0]->s_e_id]);
						session(['f_b_id' => $count[0]->b_id]);
						return redirect('/fc/user');
					} else {
						return Redirect::back()->with('error', 'You have not Permission to access routes!');
					}
				} else {
					return Redirect::back()->with('error', 'You have not Provide to access this routes!');
				}
			} else {
				return redirect::back()->with('error', 'Invalid Password..!');
			}
		} else {
			return Redirect::back()->with('error', 'Invalid Credential..!');
		}
	}

    public function getEvents()
    {
        $events = event_master::where('e_status', '=', 1)->get();
            return view('/student/event_list', compact('events'));
    }
    public function get_coordinator_Events()
    {
        $events = event_master::where('e_status', '=', 1)->get();
        return view('/student_coordinator/event_list', compact('events'));
    }
    public function userProfile()
    {
        $branch = branchMaster::all();
        $stream = stream_master::all();
        $division = division_master::all();
        $profile=user_master::where('u_id', '=', session('id'))->get();
        return view('/student/profile',compact('profile','branch','stream','division'));
    }
    public function get_coordinator_Profile()
    {
        $branch = branchMaster::all();
        $stream = stream_master::all();
        $division = division_master::all();
        $profile=user_master::where('u_id', '=', session('id'))->get();
        return view('/student_coordinator/profile',compact('profile','branch','stream','division'));
    }
    public function logout(Request $request)
    {
        if (session()->has('user')) {
            $request->session()->flush('user');
            $request->session()->flush('coordinator');
            $cookie = Cookie::forget('user');
            return redirect('student/login')->withCookie($cookie);
        }
    }
    public function change_password(Request $request)
    {
        $data = user_master::where('u_id', '=', session('id'))->get();
        if (decrypt($data[0]->password) == $request->oldpassword) {
            $pass = encrypt($request->get('newpassword'));
            DB::update('update user_masters set password = "' . $pass . '" where u_id = ' . session('id'));
            return Redirect::back()->with('success', 'Password Change Successfully !!!!!');
        } else {
            return Redirect::back()->with('error', 'Old Password Does Not Match !!!!!');
        }
    }
    public function getSubevent(Request $request)
    {
        $e_id=$request->e_id;
        $sub_event=sub_event_master::where('e_id','=',$e_id)->get();
        return view('/student/event_registration',compact('sub_event'));
    }
    public function get_coordinator_Subevent(Request $request)
    {
        $e_id=$request->e_id;
        $sub_event=sub_event_master::where('e_id','=',$e_id)->get();
        return view('/student_coordinator/event_registration',compact('sub_event'));
    }
    public function mail(Request $request)
    {
        $check = user_master::where('email', '=', $request->email)->get();
        $name = "http://127.0.0.1:8000/student/reset_password";
        if (count($check) > 0) {
            session(['email' => $request->email]);
            Mail::to($request->email)->send(new SendMailable($name));
            return Redirect::back()->with('success', 'Check Your Mail!!!');
        } else {
            return Redirect::back()->with('error', 'You Are Not Registered !!!!! ');
        }
    }
    public function reset_password_form()
    {
        return view('/student/reset_password');
    }
    public function change_password_form()
    {
        return view('/student/change_password');
    }
    public function coordinator_change_password_form()
    {
        return view('/student_coordinator/change_password');
    }
    public function get_login_form()
    {
        return view('/student/login');
    }
    public function get_forgot_password_form()
    {
        return view('/student/forgot_password');
    }
    public function get_student_coordinator_form()
    {
        return view('/student_coordinator/index');
    }
    public function resetPassword(Request $request)
    {
        $mail = $request->email;
        $password = encrypt($request->password);
        $check = DB::update('update user_masters set password = "' . $password . '" where email = "' . $mail . '"');
        if ($check) {
            return redirect('/student/login')->with('success', 'Password Reset Successfully !!! Please Login');
        } else {
            return Redirect::back()->with('error', 'Something Went Wrong !!!!');
        }
    }

    public function registered_events()
    {
        $event_registration=event_registration::where('u_id','=',session('id'))->get();
        $sub_events=sub_event_master::all();
        $events=event_master::all();
        $vanue=venue::all();
        return view('/student/registered_events',compact('event_registration','sub_events','events','vanue'));
    }
    public function get_coordinator_registered_events()
    {
        $event_registration=event_registration::where('u_id','=',session('id'))->get();
        $sub_events=sub_event_master::all();
        $events=event_master::all();
        $vanue=venue::all();
        return view('/student_coordinator/registered_events',compact('event_registration','sub_events','events','vanue'));
    }
    public function get_expence_form()
    {
        $expence_type=expence_type::all();
        $events=event_master::all();
        $sub_events=sub_event_master::all();
        return view('/student_coordinator/add_expence',compact('expence_type','events','sub_events'));
    }
}

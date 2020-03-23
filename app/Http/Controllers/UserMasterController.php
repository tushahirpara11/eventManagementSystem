<?php

namespace App\Http\Controllers;

use App\user_master;
use App\branchMaster;
use App\stream_master;
use App\division_master;
use App\event_master;
use App\group;
use App\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    public function show(user_master $user_master)
    {
        return view('admin/viewUser')->with(['data' => user_master::where('u_type', 2)->get(), 'branch' => branchMaster::get()]);
    }

    public function showEacUser(user_master $user_master)
    {
        return view('eac/viewUser')->with([
            'data' => DB::select('select * from user_masters u,branch_masters b where u.b_id=b.b_id and u.email !="' . Session::get('eac') . '" and u.b_id=' . Session::get('b_id')),
            'branch' => branchMaster::get()
        ]);
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
        DB::update('update user_masters set f_name = "' . $request->get('f_name') . '", l_name = "' . $request->get('l_name') .
            '", email = "' . $request->get('email') . '", gender="' . $request->input('gender') . '", phone = "' . $request->get('phone') .
            '", dob = "' . $request->get('dob') . '", b_id = ' . $request->get('b_id') .
            ' where u_id = ' . $request->get('u_id'));
        return redirect('/admin/user');
    }

    public function updateEacUser(Request $request)
    {
        DB::update('update user_masters set f_name = "' . $request->get('f_name') . '", l_name = "' . $request->get('l_name') .
            '", email = "' . $request->get('email') . '", gender="' . $request->input('gender') . '", phone = "' . $request->get('phone') .
            '", dob = "' . $request->get('dob') . '", b_id = ' . $request->get('b_id') .
            ' where u_id = ' . $request->get('u_id'));
        return redirect('/eac/user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\user_master  $user_master
     * @return \Illuminate\Http\Response
     */
    public function destroyEac(user_master $request)
    {
        if (session()->has('eac')) {
            session()->flush('eac');
            $cookie = Cookie::forget('eac');
            return redirect('eac/')->withCookie($cookie);
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
                return redirect('/student/events');
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

    public function getEvents()
    {
        $events = event_master::where('e_status', '=', 1)->get();
        return view('/student/event_list', compact('events'));
    }
}

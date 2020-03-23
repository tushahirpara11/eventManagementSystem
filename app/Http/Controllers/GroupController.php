<?php

namespace App\Http\Controllers;

use App\branchMaster;
use App\event_master;
use App\group;
use App\role;
use App\sub_event_master;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class GroupController extends Controller
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
        $count = DB::select(
            'select * from groups where e_id = ' .
                $request->get('e_id') .
                ' and s_e_id = ' .
                $request->get('s_e_id') .
                ' and u_id = ' .
                $request->get('u_id') .
                ' and r_id = ' .
                $request->get('r_id')
        );
        if (count($count) == 0) {
            $storeGroup = new group([
                'e_id' => $request->get('e_id'),
                's_e_id' => $request->get('s_e_id'),
                'u_id' => $request->get('u_id'),
                'r_id' => $request->get('r_id')
            ]);
            $storeGroup->save();
            return Redirect::back()->with('success', 'Group Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Group Already Exists...');
        }
    }

    public function storeEacGroup(Request $request)
    {
        $count = DB::select(
            'select * from groups where e_id = ' .
                $request->get('e_id') .
                ' and s_e_id = ' .
                $request->get('s_e_id') .
                ' and u_id = ' .
                $request->get('u_id') .
                ' and r_id = ' .
                $request->get('r_id')
        );
        if (count($count) == 0) {
            $storeGroup = new group([
                'e_id' => $request->get('e_id'),
                's_e_id' => $request->get('s_e_id'),
                'u_id' => $request->get('u_id'),
                'r_id' => $request->get('r_id')
            ]);
            $storeGroup->save();
            return Redirect::back()->with('success', 'Group Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Group Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $event = event_master::where('e_status', 1)->get();
        $subevent = sub_event_master::where('status', 1)->get();
        $user = user_master::where('u_type', 2)->get();
        return view('admin/viewGroup')->with(['data' => group::get(), 'event' =>  $event, 'sub_event' => $subevent, 'user' => $user, 'role' => role::get()]);
    }

    public function showEacGroup()
    {
        $event = event_master::where(['e_id' => Session::get('e_id'), 'e_status' => 1])->get();
        $subevent = sub_event_master::where(['e_id' => $event[0]->e_id, 'status' => 1])->get();
        $user = DB::select("select * from user_masters where email = '" . Session::get('eac') . "' and u_type =" . 2);
        $data = DB::select('select * from groups g, user_masters u,event_masters e,sub_event_masters s, roles r 
        where g.s_e_id = s.s_e_id and g.e_id = e.e_id and g.r_id = r.r_id and g.u_id = u.u_id and u.u_type =' . 2 . ' and g.e_id = ' . Session::get('e_id'));
        return view('eac/viewGroup')->with(['data' => $data, 'event' =>  $event, 'sub_event' => $subevent, 'user' => $user, 'role' => role::get()]);
    }

    public function getsubevent(Request $request)
    {
        if ($request->ajax()) {
            $branchData = event_master::where('e_id', $request->e_id)->get();
            $sub_event = sub_event_master::where('e_id', $request->e_id)->get();
            $data = user_master::where('b_id', $branchData[0]->b_id)->get();
            return response()->json(['option' => $data, 'sub_event' => $sub_event]);
        }
    }

    public function delete($id)
    {
        DB::delete('delete from groups where g_id=' . $id);
        return Redirect::back();
    }
    public function deleteEacGroup($id)
    {
        DB::delete('delete from groups where g_id=' . $id);
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit(group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $count = DB::select(
            'select * from groups where e_id = ' .
                $request->get('e_id') .
                ' and s_e_id = ' .
                $request->get('s_e_id') .
                ' and u_id = ' .
                $request->get('u_id') .
                ' and r_id = ' .
                $request->get('r_id')
        );
        if (count($count) == 0) {
            DB::update('update groups set e_id = ' . $request->get('e_id') . ', s_e_id = ' . $request->get('s_e_id') .
                ', u_id = ' . $request->get('u_id') . ', r_id = ' . $request->get('r_id') .
                ' where g_id = ' . $request->get('g_id'));
            return Redirect::back()->with('success', 'Group Update Successfully.');
        } else {
            return Redirect::back()->with('error', "Group Can't be Updated Because of it's already exists...");
        }
    }

    public function updateEacGroup(Request $request)
    {
        $count = DB::select(
            'select * from groups where e_id = ' .
                $request->get('e_id') .
                ' and s_e_id = ' .
                $request->get('s_e_id') .
                ' and u_id = ' .
                $request->get('u_id') .
                ' and r_id = ' .
                $request->get('r_id')
        );
        if (count($count) == 0) {
            DB::update('update groups set e_id = ' . $request->get('e_id') . ', s_e_id = ' . $request->get('s_e_id') .
                ', u_id = ' . $request->get('u_id') . ', r_id = ' . $request->get('r_id') .
                ' where g_id = ' . $request->get('g_id'));
            return Redirect::back()->with('success', 'Group Update Successfully.');
        } else {
            return Redirect::back()->with('error', "Group Can't be Updated Because of it's already exists...");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(group $group)
    {
        //
    }
}

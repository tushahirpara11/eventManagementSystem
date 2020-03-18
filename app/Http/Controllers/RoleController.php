<?php

namespace App\Http\Controllers;

use App\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
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
        $count = role::where(['r_name' => $request->get('r_name')])->get();
        if (count($count) == 0) {
            $role = new role(['r_name' => $request->get('r_name')]);
            $role->save();
            return Redirect::back()->with('success', 'Role Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Role Already Exists...');
        }
    }

    public function storeEacRole(Request $request)
    {
        $count = role::where(['r_name' => $request->get('r_name')])->get();
        if (count($count) == 0) {
            $role = new role(['r_name' => $request->get('r_name')]);
            $role->save();
            return Redirect::back()->with('success', 'Role Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Role Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('/admin/viewRole')->with('data', role::get());
    }

    public function showEacRole()
    {
        return view('/eac/viewRole')->with('data', role::get());
    }
    
    function delete($id)
    {
        $refresh = DB::delete('delete from roles where r_id=' . $id);
        return Redirect::back();
    }

    function deleteEacRole($id)
    {
        $refresh = DB::delete('delete from roles where r_id=' . $id);
        return Redirect::back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\role  $role
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
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::update('update roles set r_name = "' . $request->get('r_name') . '" where r_id = ' . $request->r_id);
        return redirect('/admin/role');
    }

    public function updateEacRole(Request $request)
    {
        DB::update('update roles set r_name = "' . $request->get('r_name') . '" where r_id = ' . $request->r_id);
        return redirect('/eac/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role)
    {
        //
    }
}

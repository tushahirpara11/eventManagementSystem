<?php

namespace App\Http\Controllers;

use App\division_master;
use App\stream_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class DivisionMasterController extends Controller
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
        $count = division_master::where('d_name', $request->get('d_name'))->get();
        if (count($count) == 0) {
            $insertBranch = new division_master(['s_id' => $request->get('s_id'), 'd_name' => $request->get('d_name')]);
            $insertBranch->save();
            return Redirect::back()->with('success', 'Divison Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Division Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\division_master  $division_master
     * @return \Illuminate\Http\Response
     */
    public function show(division_master $division_master)
    {        
        return view('admin/viewDivision')->with(['data' => division_master::get(), 'stream' => stream_master::get()]);
    }
    
    function delete($id)
    {
        $refresh = DB::delete('delete from division_masters where d_id=' . $id);
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\division_master  $division_master
     * @return \Illuminate\Http\Response
     */
    public function edit(division_master $division_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\division_master  $division_master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        DB::update('update division_masters set s_id = ' . $request->get('s_id') . ', d_name = "' . $request->get('d_name') . '" where d_id = ' . $request->d_id);
        return redirect('/admin/division');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\division_master  $division_master
     * @return \Illuminate\Http\Response
     */
    public function destroy(division_master $division_master)
    {
        //
    }
}

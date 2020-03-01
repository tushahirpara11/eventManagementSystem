<?php

namespace App\Http\Controllers;

use App\choreographer;
use App\sub_event_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class ChoreographerController extends Controller
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
        $count = choreographer::where(['s_e_id' => $request->get('s_e_id'), 'c_phone' => $request->get('c_phone'), 'c_email' => $request->get('c_email')])->get();
        if (count($count) == 0) {
            $insertChoreo = new choreographer([
                's_e_id' => $request->get('s_e_id'), 'c_name' => $request->get('c_name'),
                'c_phone' => $request->get('c_phone'), 'c_email' => $request->get('c_email')
            ]);
            $insertChoreo->save();
            return Redirect::back()->with('success', 'Choreographer Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Choreographer Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\choreographer  $choreographer
     * @return \Illuminate\Http\Response
     */
    public function show(choreographer $choreographer)
    {
        return view('admin/viewChoreographer')->with(['data' => choreographer::get(), 'subevent' => sub_event_master::where('status', 1)->get()]);
    }

    public function delete($id)
    {
        $refresh = DB::delete('delete from choreographers where c_id=' . $id);
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\choreographer  $choreographer
     * @return \Illuminate\Http\Response
     */
    public function edit(choreographer $choreographer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\choreographer  $choreographer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        DB::update('update choreographers set s_e_id = ' . $request->get('s_e_id') . ',     
        c_name = "' . $request->get('c_name') . '",
        c_email = "' . $request->get('c_email') . '",
        c_phone = "' . $request->get('c_phone') . '" where c_id = ' . $request->get('c_id'));
        return redirect('/admin/choreographer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\choreographer  $choreographer
     * @return \Illuminate\Http\Response
     */
    public function destroy(choreographer $choreographer)
    {
        //
    }
}

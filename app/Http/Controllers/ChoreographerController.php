<?php

namespace App\Http\Controllers;

use App\choreographer;
use App\event_master;
use App\sub_event_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

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

    public function storeEacChoreo(Request $request)
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
    public function show()
    {
        return view('admin/viewChoreographer')->with(['data' => choreographer::get(), 'subevent' => sub_event_master::where('status', 1)->get()]);
    }

    public function showEacChoreo()
    {
        $data = DB::select("select c.c_id, c.s_e_id, c.c_name, c.c_phone, c.c_email from choreographers c, sub_event_masters s where c.s_e_id = s.s_e_id and s.e_id = " . Session::get('e_id') . " and s.status = " . 1);
        $subevent = DB::select("select * from sub_event_masters s
         where s.e_id = " . Session::get('e_id') . " and s.status = " . 1);
        return view('eac/viewChoreographer')->with(['data' => $data, 'subevent' => $subevent]);
    }

    public function delete($id)
    {
        $refresh = DB::delete('delete from choreographers where c_id=' . $id);
        return Redirect::back();
    }
    public function deleteEacChoreo($id)
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
    public function updateEacChoreo(Request $request)
    {
        DB::update('update choreographers set s_e_id = ' . $request->get('s_e_id') . ',     
        c_name = "' . $request->get('c_name') . '",
        c_email = "' . $request->get('c_email') . '",
        c_phone = "' . $request->get('c_phone') . '" where c_id = ' . $request->get('c_id'));
        return redirect('/eac/choreographer');
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

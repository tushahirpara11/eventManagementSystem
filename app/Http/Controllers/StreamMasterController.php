<?php

namespace App\Http\Controllers;

use App\branchMaster;
use App\stream_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StreamMasterController extends Controller
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
        $count = stream_master::where('s_name', $request->get('s_name'))->get();
        if (count($count) == 0) {
            $insertBranch = new stream_master(['b_id' => $request->get('b_id'), 's_name' => $request->get('s_name')]);
            $insertBranch->save();
            return Redirect::back()->with('success', 'Branch Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Branch Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\stream_master  $stream_master
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin/viewStream')->with(['data' => stream_master::get(), 'branch' => branchMaster::get()]);
    }

    function delete($id)
    {
        $refresh = DB::delete('delete from stream_masters where s_id=' . $id);
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\stream_master  $stream_master
     * @return \Illuminate\Http\Response
     */
    public function edit(stream_master $stream_master)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\stream_master  $stream_master
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {        
        DB::update('update stream_masters set b_id = ' . $request->get('b_id') . ', s_name = "' . $request->get('s_name') . '" where s_id = ' . $request->s_id);
        return redirect('/admin/stream');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\stream_master  $stream_master
     * @return \Illuminate\Http\Response
     */
    public function destroy(stream_master $stream_master)
    {
        //
    }
}

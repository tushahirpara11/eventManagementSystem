<?php

namespace App\Http\Controllers;

use App\expence_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenceTypeController extends Controller
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
        $countExpence = expence_type::where('name', '=', ucfirst($request->get('name')))->get();
        if (count($countExpence) == 0) {
            $storeData = new expence_type([
                'name' => ucfirst($request->get('name'))
            ]);
            if ($storeData->save()) {
                return back()->with('success', "Expence Type added Successfully");
            } else {
                return back()->with('error', "Expence Type not added");
            }
        } else {
            return back()->with('error', "Expence Type already Exists");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\expence_type  $expence_type
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin.viewExpenceType')->with(['data' => expence_type::get()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\expence_type  $expence_type
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
     * @param  \App\expence_type  $expence_type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cntUpdate = DB::update('update expence_types set name="' . ucfirst($request->get('name')) . '" where e_t_id=' . $request->get('e_t_id'));
        if (count($cntUpdate) == 1) {
            return back()->with('success', 'Expence Type Updated Successfully');
        } else {
            return back()->with('error', 'Expence Type not Updated');
        }
    }

    public function delete($id)
    {
        $cntUpdate = DB::delete('delete from expence_types where e_t_id=' . $id);
        if (count($cntUpdate) == 1) {
            return back()->with('success', 'Expence Type Deleted Successfully');
        } else {
            return back()->with('error', 'Expence Type not Delete');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\expence_type  $expence_type
     * @return \Illuminate\Http\Response
     */
    public function destroy(expence_type $expence_type)
    {
        //
    }
}

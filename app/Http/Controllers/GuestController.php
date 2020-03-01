<?php

namespace App\Http\Controllers;

use App\guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class GuestController extends Controller
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
        $count = guest::where(['phome' => $request->get('phome'), 'email' => $request->get('email')])->get();
        if (count($count) == 0) {
            $insertChoreo = new guest([
                'name' => $request->get('name'),
                'phome' => $request->get('phome'), 'email' => $request->get('email')
            ]);
            $insertChoreo->save();
            return Redirect::back()->with('success', 'Guest Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Guest Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin/viewGuest')->with(['data' => guest::get()]);
    }

    public function delete($id)
    {
        $refresh = DB::delete('delete from guests where guest_id=' . $id);
        return Redirect::back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function edit(guest $guest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, guest $guest)
    {     
        DB::update('update guests set name = "' . $request->get('name') . '",
        email = "' . $request->get('email') . '",
        phome = "' . $request->get('phome') . '" where guest_id = ' . $request->get('guest_id'));
        return redirect('/admin/guest');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\guest  $guest
     * @return \Illuminate\Http\Response
     */
    public function destroy(guest $guest)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\expence;
use App\expence_type;
use App\sub_event_master;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ExpenceController extends Controller
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
		expence::create([
			'e_id' => $request->get('event'),
			's_e_id' => $request->get('sub_event'),
			'e_t_id' => $request->get('expence_type'),
			'u_id' => $request->get('u_id'),
			'amount' => $request->get('amount'),
			'description' => $request->get('desc'),
			'status' => $request->get('status'),
		]);
		return Redirect::back()->with('success', 'Expence Add Successfully');
	}
	public function storeFcExpence(Request $request)
	{
		$e_id = sub_event_master::where('s_e_id', $request->get('s_e_id'))->get(['e_id']);
		$u_id = user_master::where('email', $request->get('u_id'))->get(['u_id']);
		$storeData = new expence([
			'e_t_id' => $request->get('e_t_id'),
			'e_id' => $e_id[0]['e_id'],
			's_e_id' => $request->get('s_e_id'),
			'u_id' => $u_id[0]['u_id'],
			'description' => $request->get('description'),
			'amount' => $request->get('amount'),
			'status' => 0
		]);
		if ($storeData->save()) {
			return back()->with('success', 'Expence Added Successfully');
		} else {
			return back()->with('error', 'Expence not Added');
		}
	}

	public function showFcExpence()
	{
		$data = DB::select('select e.expence_id,et.e_t_id,et.name,em.e_id,sm.s_e_id,um.u_id,um.f_name,um.l_name,e.description,e.amount,
        e.status,em.e_name,sm.s_e_name from expences e,event_masters em,sub_event_masters sm,user_masters um, expence_types et
        where e.s_e_id=sm.s_e_id and e.e_id=em.e_id and e.e_t_id= et.e_t_id and e.u_id=um.u_id and e.s_e_id=' . Session::get('f_s_e_id'));
		return view('fc.viewExpence')->with([
			'data' => $data,
			'subEvent' => sub_event_master::where(
				's_e_id',
				Session::get('f_s_e_id')
			)->get(),
			'expenceType' => expence_type::get()
		]);
	}
	public function showEacExpence()
	{
		$data = DB::select('select e.expence_id,et.e_t_id,et.name,em.e_id,sm.s_e_id,um.u_id,um.f_name,um.l_name,e.description,e.amount,
        e.status,em.e_name,sm.s_e_name from expences e,event_masters em,sub_event_masters sm,user_masters um, expence_types et
        where e.s_e_id=sm.s_e_id and e.e_id=em.e_id and e.e_t_id= et.e_t_id and e.u_id=um.u_id and e.e_id=' . Session::get('e_id'));
		return view('eac.viewExpence')->with([
			'data' => $data,
			'subEvent' => sub_event_master::where(
				'e_id',
				Session::get('e_id')
			)->get(),
			'expenceType' => expence_type::get()
		]);
	}

	public function showStudentCoExpence()
	{
		$data = DB::select('select e.expence_id,et.e_t_id,et.name,em.e_id,sm.s_e_id,um.u_id,um.f_name,um.l_name,e.description,e.amount,
        e.status,em.e_name,sm.s_e_name from expences e,event_masters em,sub_event_masters sm,user_masters um, expence_types et
				where e.s_e_id=sm.s_e_id and e.e_id=em.e_id and e.e_t_id= et.e_t_id and e.u_id=um.u_id and e.s_e_id=' . Session::get('c_s_e_id'));
		return view('/student_coordinator/view_expense')->with(['data' => $data]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\expence  $expence
	 * @return \Illuminate\Http\Response
	 */
	public function show(expence $expence)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\expence  $expence
	 * @return \Illuminate\Http\Response
	 */
	public function edit(expence $expence)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\expence  $expence
	 * @return \Illuminate\Http\Response
	 */
	public function updateEacExpence($status, $id)
	{
		$update = DB::update('update expences set status=' . $status . ' where expence_id=' . $id);
		if ($update) {
			return back()->with('success', 'Expence Approved Successfully');
		} else {
			return back()->with('error', 'Expence not Approved');
		}
	}

	public function updateEacStatus(Request $request)
	{
		$update = DB::update('update expences set status=' . $request->get('status') . ' where expence_id=' . $request->get('expence_id'));
		if ($update) {
			return back()->with('success', 'Expence Approved Successfully');
		} else {
			return back()->with('error', 'Expence not Approved');
		}
	}

	public function deleteEacExpence($id)
	{
		$delete = DB::delete('delete from expences where expence_id=' . $id);
		if ($delete) {
			return back()->with('success', 'Expence Deleted Successfully');
		} else {
			return back()->with('error', 'Expence is not Deleted');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\expence  $expence
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(expence $expence)
	{
		//
	}
	public function get_sub_event(Request $request)
	{
		if ($request->ajax()) {
			$data = sub_event_master::where('e_id', '=', $request->e_id)->get();
			return response()->json(['option' => $data]);
		}
	}
}

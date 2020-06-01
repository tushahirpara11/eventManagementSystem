<?php

namespace App\Http\Controllers;

use App\branchMaster;
use App\event_master;
use App\user_master;
use App\venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EventMasterController extends Controller
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

	public function adminDashboadrd()
	{
		$branch = DB::select('select count(*) as count from branch_masters');
		$stream = DB::select('select count(*) as count from stream_masters');
		$division = DB::select('select count(*) as count from division_masters');
		$venue = DB::select('select count(*) as count from venues');
		$events = DB::select('select count(*) as count from event_masters');
		$subEvents = DB::select('select count(*) as count from sub_event_masters');
		$role = DB::select('select count(*) as count from roles');
		$choreographer = DB::select('select count(*) as count from choreographers');
		$user = DB::select('select count(*) as count from user_masters');
		$group = DB::select('select count(*) as count from groups');
		$guest = DB::select('select count(*) as count from guests');
		$expence_type = DB::select('select count(*) as count from expence_types');		
		return view('admin.dashboard')->with([
			'branch' => $branch, 'stream' => $stream, 'venue' => $venue,
			'division' => $division, 'events' => $events, 'subEvents' => $subEvents,
			'role' => $role, 'choreographer' => $choreographer,
			'expence_type' => $expence_type, 'user' => $user, 'group' => $group,
			'guest' => $guest
		]);
	}

	public function dashboadrd()
	{
		$subEvents = DB::select('select count(*) as count from sub_event_masters where e_id=' . Session::get('e_id'));
		$choreographer = DB::select('select count(*) as count from choreographers');
		$user = DB::select('select count(*) as count from user_masters');
		$group = DB::select('select count(*) as count from groups');
		$schedule = DB::select('select count(*) as count from schedulings where e_id=' . Session::get('e_id'));
		$expence = DB::select('select count(*) as count from expences where e_id=' . Session::get('e_id'));
		$guest = DB::select('select count(*) as count from guests');
		return view('eac.dashboard')->with([
			'subEvents' => $subEvents, 'choreographer' => $choreographer,
			'user' => $user, 'group' => $group, 'schedule' => $schedule,
			'expence' => $expence, 'guest' => $guest
		]);
	}

	public function fcdashboard()
	{
		$user = DB::select('select count(*) as count from event_registrations where s_e_id=' . Session::get('f_s_e_id'));
		$attendence = DB::select('select count(*) as count from attendences where s_e_id=' . Session::get('f_s_e_id'));
		$expence = DB::select('select count(*) as count from expences where s_e_id=' . Session::get('f_s_e_id'));
		$practiceSchedule = DB::select('select count(*) as count from practice_schedules where s_e_id=' . Session::get('f_s_e_id'));
		$costumes = DB::select('select count(*) as count from costumes where s_e_id=' . Session::get('f_s_e_id'));
		return view('fc.dashboard')->with([
			'user' => $user, 'attendence' => $attendence, 'expence' => $expence,
			'practiceSchedule' => $practiceSchedule, 'costumes' => $costumes,
		]);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$count = event_master::where('e_name', $request->get('e_name'))->get();
		if (count($count) == 0) {
			$insertEvent = new event_master([
				'e_name' => $request->get('e_name'), 'e_discription' => $request->get('e_discription'),
				'e_status' => $request->get('e_status'), 'e_start_date' => $request->get('e_start_date'),
				'e_end_date' => $request->get('e_end_date'), 'b_id' => $request->get('b_id'),
				'v_id' => $request->get('v_id')
			]);
			$insertEvent->save();
			return Redirect::back()->with('success', 'Event Added Successfully.');
		} else {
			return Redirect::back()->with('error', 'Event Already Exists...');
		}
	}

	public function storeEacEvent(Request $request)
	{
		$count = event_master::where('e_name', $request->get('e_name'))->get();
		if (count($count) == 0) {
			$insertEvent = new event_master([
				'e_name' => $request->get('e_name'), 'e_discription' => $request->get('e_discription'),
				'e_status' => $request->get('e_status'), 'e_start_date' => $request->get('e_start_date'),
				'e_end_date' => $request->get('e_end_date'), 'b_id' => $request->get('b_id'),
				'v_id' => $request->get('v_id')
			]);
			$insertEvent->save();
			return Redirect::back()->with('success', 'Event Added Successfully.');
		} else {
			return Redirect::back()->with('error', 'Event Already Exists...');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\event_master  $event_master
	 * @return \Illuminate\Http\Response
	 */
	public function show(event_master $event_master)
	{
		return view('admin/viewEvent')->with(['data' => event_master::get(), 'venue' => venue::get(), 'branch' => branchMaster::get()]);
	}
	public function showEacEvent(event_master $event_master)
	{
		return view('eac/viewEvent')->with(['data' => event_master::get(), 'venue' => venue::get(), 'branch' => branchMaster::get()]);
	}

	public function delete($id)
	{
		DB::delete('delete from event_masters where e_id=' . $id);
		return Redirect::back();
	}

	public function deleteEacEvent($id)
	{
		DB::delete('delete from event_masters where e_id=' . $id);
		return Redirect::back();
	}

	function updatestatus($eid, $status)
	{
		DB::update('update event_masters set e_status = "' . $status . '" where e_id = ' . $eid);
		return redirect('/admin/event');
	}
	function updatestatusEacEvent($eid, $status)
	{
		DB::update('update event_masters set e_status = "' . $status . '" where e_id = ' . $eid);
		return redirect('/eac/event');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\event_master  $event_master
	 * @return \Illuminate\Http\Response
	 */
	public function edit(event_master $event_master)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\event_master  $event_master
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		DB::update('update event_masters set b_id = ' . $request->get('b_id') . ', v_id = ' . $request->get('v_id') .
			', e_name = "' . $request->get('e_name') . '", e_discription = "' . $request->get('e_discription') .
			'", e_start_date = "' . $request->get('e_start_date') . '", e_end_date = "' . $request->get('e_end_date') .
			'" where e_id = ' . $request->e_id);
		return redirect('/admin/event');
	}
	public function updateEacEvent(Request $request)
	{
		DB::update('update event_masters set b_id = ' . $request->get('b_id') . ', v_id = ' . $request->get('v_id') .
			', e_name = "' . $request->get('e_name') . '", e_discription = "' . $request->get('e_discription') .
			'", e_start_date = "' . $request->get('e_start_date') . '", e_end_date = "' . $request->get('e_end_date') .
			'" where e_id = ' . $request->e_id);
		return redirect('/eac/event');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\event_master  $event_master
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(event_master $event_master)
	{
		//
	}
}

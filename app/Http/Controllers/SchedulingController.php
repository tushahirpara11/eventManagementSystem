<?php

namespace App\Http\Controllers;

use App\event_registration;
use App\scheduling;
use App\sub_event_master;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

$eventArray = array();
class SchedulingController extends Controller
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
		$data = new scheduling([
			'e_id' => $request->get('e_id'),
			'sched_details' => $request->get('sched_details'),
			'time' => date('Y/m/d H:i:s')
		]);
		if ($data->save()) {
			return redirect('/eac/viewSchedule')->with('success', 'Event Scheduled Successfully.');
		} else {
			return redirect('/eac/viewSchedule')->with('error', 'Event Not Scheduled.');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\scheduling  $scheduling
	 * @return \Illuminate\Http\Response
	 */
	public function show()
	{
		$data = DB::select('select * from schedulings s,event_masters em where s.e_id=em.e_id and em.e_id=' . Session::get('e_id'));
		return view('eac.viewDynamicScheduling')->with(['data' => $data]);
	}

	public function getEvents()
	{
		return view('eac.addDynamicScheduling')->with(['data' => sub_event_master::get()]);
	}

	public function addOverlap(Request $request)
	{
		$scheduleData = array();
		if ($request->ajax()) {
			if ($request->s_e_id != null) {
				if (count($request->s_e_id) == 1) {
					$data = DB::select('select sem.s_e_id,sem.s_e_name,sem.s_e_duration,0 as overlap from sub_event_masters sem,event_registrations er where sem.s_e_id = er.s_e_id and er.s_e_id=' . $request->s_e_id[0]);
					if (count($data) == 0) {
						$eventA = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $request->s_e_id[0]);
						return response()->json(['data' => $eventA]);
					}
					return response()->json(['data' => $data]);
				} else {
					$pairArray = array();
					for ($i = 0; $i < count($request->s_e_id); $i++) {
						$temp = $i + 1;
						if ($temp < count($request->s_e_id)) {
							array_push($pairArray, [$request->s_e_id[$i], ($request->s_e_id[$temp])]);
						}
					}					
					$startingdata = DB::select('select sem.s_e_id,sem.s_e_name,sem.s_e_duration,0 as overlap from sub_event_masters sem,event_registrations er where sem.s_e_id = er.s_e_id and er.s_e_id=' . $request->s_e_id[0]);
					if (count($startingdata) == 0) {
						$firstData = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $request->s_e_id[0]);
						array_push($scheduleData, $firstData);
					} else {
						array_push($scheduleData, $startingdata);
					}
					for ($k = 0; $k < count($pairArray); $k++) {
						$data = DB::select('select sem.s_e_id,sem.s_e_name,sem.s_e_duration,count(er.u_id) as overlap from sub_event_masters sem,event_registrations er where sem.s_e_id = er.s_e_id and er.s_e_id=' . $pairArray[$k][0] . ' and er.u_id in ( SELECT u_id FROM event_registrations Where s_e_id=' . $pairArray[$k][1] . ') group by sem.s_e_id,sem.s_e_name,sem.s_e_duration,er.u_id');
						if (count($data) == 0) {
							$eventA = event_registration::where('s_e_id', $pairArray[$k][0])->get();
							$eventB = event_registration::where('s_e_id', $pairArray[$k][1])->get();
							if (count($eventA) == 0) {
								$statusZeroEventA = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $pairArray[$k][1]);
								array_push($scheduleData, $statusZeroEventA);
							}
							if (count($eventB) == 0) {
								$statusZeroEventB = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $pairArray[$k][1]);
								array_push($scheduleData, $statusZeroEventB);
							}
						} else {
							array_push($scheduleData, $data);
						}
					}
					return response()->json(['data' => $scheduleData]);
				}
			} else {
				return response()->json(['data' => []]);
			}
		}
	}

	public function showEacScheduling()
	{
		$subEvent = sub_event_master::get();
		$ary = array();
		$a = "";
		foreach ($subEvent as $key => $value) {
			array_push($ary, "sum(case when sem.s_e_name ='" . $value->s_e_name . "' THEN case when er.status = 1 THEN 1 else 0 end end) as '" . $value->s_e_name . "'");
		}
		$a .= 'select er.u_id,um.f_name,um.l_name,um.enrollmentno';
		for ($i = 0; $i < count($ary); $i++) {
			$a .= ',' . $ary[$i];
		}
		$a .= ' from event_registrations er join user_masters um on er.u_id = um.u_id join sub_event_masters sem on sem.s_e_id = er.s_e_id group by er.u_id,um.f_name,um.l_name,um.enrollmentno';
		$ans = DB::select($a);
		$keys = array();
		foreach ($ans as $key => $value) {
			foreach ($value as $key => $value) {
				array_push($keys, $key);
			}
		}
		return view('eac.viewScheduling')->with(['data' => $ans, 'keys' => $key, 'subevent' => $subEvent]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\scheduling  $scheduling
	 * @return \Illuminate\Http\Response
	 */
	public function edit(Request $request)
	{
		$data = scheduling::where('sched_id', $request->get('sched_id'))->get();
		$ary =  mb_split("\,", $data[0]->sched_details);
		$pairArray = array();
		for ($i = 0; $i < count($ary); $i++) {
			$temp = $i + 1;
			if ($temp < count($ary)) {
				array_push($pairArray, [$ary[$i], ($ary[$temp])]);
			}
		}
		$scheduleData = array();
		$startingdata = DB::select('select sem.s_e_id,sem.s_e_name,sem.s_e_duration,0 as overlap from sub_event_masters sem,event_registrations er where sem.s_e_id = er.s_e_id and er.s_e_id=' . $ary[0]);
		if (count($startingdata) == 0) {
			$firstData = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $ary[0]);
			array_push($scheduleData, $firstData);
		} else {
			array_push($scheduleData, $startingdata);
		}
		for ($k = 0; $k < count($pairArray); $k++) {
			$data = DB::select('select sem.s_e_id,sem.s_e_name,sem.s_e_duration,count(er.u_id) as overlap from sub_event_masters sem,event_registrations er where sem.s_e_id = er.s_e_id and er.s_e_id=' . $pairArray[$k][1] . ' and er.u_id in ( SELECT u_id FROM event_registrations Where s_e_id=' . $pairArray[$k][0] . ') group by sem.s_e_id,sem.s_e_name,sem.s_e_duration,er.u_id');
			if (count($data) == 0) {
				$eventA = event_registration::where('s_e_id', $pairArray[$k][0])->get();
				$eventB = event_registration::where('s_e_id', $pairArray[$k][1])->get();
				if (count($eventA) == 0) {
					$statusZeroEventA = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $pairArray[$k][1]);
					array_push($scheduleData, $statusZeroEventA);
				}
				if (count($eventB) == 0) {
					$statusZeroEventB = DB::select('select s_e_id,s_e_name,s_e_duration,0 as overlap from sub_event_masters where s_e_id=' . $pairArray[$k][1]);
					array_push($scheduleData, $statusZeroEventB);
				}
			} else {
				array_push($scheduleData, $data);
			}
		}
		return view('eac.updateDynamicScheduling')->with(['data' => $scheduleData, 'sched_id' => $request->get('sched_id'), 'eventSequence' => json_encode($ary), 'sub_event' => sub_event_master::get()]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\scheduling  $scheduling
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$update = DB::table('schedulings')
			->where('sched_id', $request->get('sched_id'))
			->update(['sched_details' => $request->get('sched_details')]);		
		if ($update == 1) {
			return redirect('/eac/viewSchedule')->with('success', 'Event Schedule Updated Successfully.');
		} else {
			return redirect('/eac/viewSchedule')->with('error', 'Event Schedule Not Updated.');
		}
	}
	public function delete($id)
	{
		$refresh = DB::delete('delete from schedulings where sched_id=' . $id);
		if ($refresh) {
			return Redirect::back()->with('success', "Schedule Deleted Successfully");;
		} else {
			return Redirect::back()->with('error', "Schedule not Deleted");;
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\scheduling  $scheduling
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(scheduling $scheduling)
	{
		//
	}
}

<?php

namespace App\Http\Controllers;

use App\attendence;
use App\practice_schedule;
use App\user_master;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AttendenceController extends Controller
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
	public function storeFcAttendence(Request $request)
	{
		$user = user_master::where('email', $request->fc)->get();
		$checkAttendence = attendence::where('date', date("Y-m-d"))
			->where('s_e_id', $request->s_e_id)
			->get();
		if (count($checkAttendence) == 0) {
			$storedAtt = new attendence([
				's_e_id' => $request->s_e_id,
				'u_id' => $user[0]->u_id,
				'present' => json_encode('[' . $request->present . ']'),
				'date' => date("Y-m-d")
			]);
			if ($storedAtt->save()) {
				return back()->with('success', 'Attendence added Successfully');
			} else {
				return back()->with('error', 'Attendence not Added');
			}
		} else {
			return back()->with('error', "Today's Attendence Already Taken");
		}
	}
	public function show_coordinator_attendance()
	{
		$students = DB::select('select * from user_masters u, event_registrations e where u.u_id = e.u_id and e.s_e_id = ' . Session::get('c_s_e_id'));
		return view('/student_coordinator/attendance', compact('students'));
	}
	public function store_coordinator_attendance(Request $request)
	{
		$checkAttendence = attendence::where('date', date("Y-m-d"))
			->where('s_e_id', $request->s_e_id)
			->get();
		if (count($checkAttendence) == 0) {
			$storedAtt = new attendence([
				's_e_id' => $request->s_e_id,
				'u_id' => $request->u_id,
				'present' => json_encode('[' . $request->present . ']'),
				'date' => date("Y-m-d")
			]);
			if ($storedAtt->save()) {
				return back()->with('success', 'Attendence added Successfully');
			} else {
				return back()->with('error', 'Attendence not Added');
			}
		} else {
			return back()->with('error', "Today's Attendence Already Taken");
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\attendence  $attendence
	 * @return \Illuminate\Http\Response
	 */
	public function showEacAttendence()
	{
		$data = DB::select('select * from attendences a, user_masters u, sub_event_masters s where a.s_e_id = s.s_e_id and a.u_id=u.u_id');
		return view('eac.viewAttendence')->with(['data' => $data]);
	}
	public function showStudentCoAttendence()
	{
		$data = DB::select('select * from attendences a, user_masters u, sub_event_masters s where a.s_e_id = s.s_e_id and a.u_id=u.u_id and a.s_e_id=' . Session::get('c_s_e_id'));
		return view('student_coordinator.view_attendence')->with(['data' => $data]);
	}
	public function showFcAttendence()
	{
		$data = DB::select('select * from attendences a, user_masters u, sub_event_masters s where a.s_e_id = 
			s.s_e_id and a.u_id=u.u_id and a.s_e_id=' . Session::get('f_s_e_id'));
		$student = DB::select('select * from user_masters u,branch_masters b,stream_masters sm,division_masters dm,event_registrations er where b.b_id=u.b_id and sm.s_id=u.s_id and dm.d_id=u.d_id and u.u_id=er.u_id and er.s_e_id =' . Session::get('f_s_e_id'));
		if (DB::select('select * from attendences')) {
			$attendece = DB::select('select count(*) as count from attendences a,practice_schedules p where a.s_e_id=p.s_e_id and a.date=p.date and a.s_e_id =' . Session::get('f_s_e_id') . ' and a.date = "' . date("Y-m-d") . '"');
		} else {
			$attendece = [];
		}
		return view('fc.viewAttendence')->with(['data' => $data, 'student' => $student, 'attendence' => $attendece]);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\attendence  $attendence
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id, $date)
	{
		$data = DB::select('select * from user_masters where u_id IN (SELECT u_id FROM event_registrations where status=' . 1 . ' and s_e_id =' . $id . ')');
		$attendence = DB::select('select * from attendences where s_e_id =' . $id . ' and date = "' . $date . '"');
		$a = json_decode($attendence[0]->present, true);
		$b = [];
		for ($i = 0; $i < count($a); $i++) {
			array_push($b, (int) $a[$i]);
		}
		return view('eac.updateAttendence')->with(['data' => $data, 'present' => $b, 'attendence' => $attendence]);
	}

	public function editFc($id, $date)
	{
		$data = DB::select('select * from user_masters where u_id IN (SELECT u_id FROM event_registrations where status=' . 1 . ' and s_e_id =' . $id . ')');
		$attendence = DB::select('select * from attendences where s_e_id =' . $id . ' and date = "' . $date . '"');
		$a = json_decode($attendence[0]->present, true);
		$b = [];
		for ($i = 0; $i < count($a); $i++) {
			array_push($b, (int) $a[$i]);
		}
		return view('fc.updateAttendence')->with(['data' => $data, 'present' => $b, 'attendence' => $attendence]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\attendence  $attendence
	 * @return \Illuminate\Http\Response
	 */
	public function updateEacAttendence(Request $request)
	{
		if ($request->ajax()) {
			$ans = DB::table('attendences')
				->where('date', $request->date)->where('s_e_id', $request->s_e_id)
				->update(['present' => json_encode($request->present)]);
			return response()->json(['flag' => $ans]);
		}
	}
	public function deleteFcAttendence($id)
	{
		$refresh = DB::delete('delete from attendences where a_id=' . $id);
		if($refresh) {
			return Redirect::back()->with('success', 'Attendence Deleted Successfully.');
		} else {
			return Redirect::back()->with('error', 'Attendence not Deleted.');
		}
	}

	public function deleteEacAttendence($id)
	{
		$refresh = DB::delete('delete from attendences where a_id=' . $id);
		if($refresh) {
			return Redirect::back()->with('success', 'Attendence Deleted Successfully.');
		} else {
			return Redirect::back()->with('error', 'Attendence not Deleted.');
		}
	}

	public function updatefcAttendence(Request $request)
	{
		if ($request->ajax()) {
			$ans = DB::table('attendences')
				->where('date', $request->date)->where('s_e_id', $request->s_e_id)
				->update(['present' => json_encode($request->present)]);
			return response()->json(['flag' => $ans]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\attendence  $attendence
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(attendence $attendence)
	{
		//
	}
}

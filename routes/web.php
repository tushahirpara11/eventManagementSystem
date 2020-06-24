<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Admin Routes */

Route::get('/admin', function () {
	if (session()->has('admin') == 0) {
		return view('admin/index');
	} else {
		return redirect('/admin/dashboard');
	}
})->name('login');

Route::post('/admin/authenticate', 'BranchMasterController@checkLogin');

Route::group(['middleware' => ['admin']], function () {
	Route::get('/admin/dashboard', 'EventMasterController@adminDashboadrd')->name('admin.dashboard');
	/*Branch Master */
	Route::get('/admin/branch', 'BranchMasterController@show')->name('admin.branch');
	Route::post('/admin/branch', 'BranchMasterController@store')->name('admin.addbranch');
	Route::post('/admin/updatebranch', 'BranchMasterController@update')->name('admin.updatebranch');
	Route::delete('/admin/deletebranch/{id}', 'BranchMasterController@delete')->name('admin.deletebranch');

	/*Stream Master */
	Route::get('/admin/stream', 'StreamMasterController@show')->name('admin.stream');
	Route::post('/admin/stream', 'StreamMasterController@store')->name('admin.addstream');
	Route::post('/admin/updatestream', 'StreamMasterController@update')->name('admin.updatestream');
	Route::delete('/admin/deletestream/{id}', 'StreamMasterController@delete')->name('admin.deletestream');

	/*Division Master */
	Route::get('/admin/division', 'DivisionMasterController@show')->name('admin.division');
	Route::post('/admin/division', 'DivisionMasterController@store')->name('admin.adddivision');
	Route::post('/admin/updatedivision', 'DivisionMasterController@update')->name('admin.updatedivision');
	Route::delete('/admin/deletedivision/{id}', 'DivisionMasterController@delete')->name('admin.deletedivision');

	/*Venue Master */
	Route::get('/admin/venue', 'VenueController@show')->name('admin.venue');
	Route::post('/admin/venue', 'VenueController@store')->name('admin.addvenue');
	Route::post('/admin/updatevenue', 'VenueController@update')->name('admin.updatevenue');
	Route::delete('/admin/deletevenue/{id}', 'VenueController@delete')->name('admin.deletevenue');

	/*Event Master */
	Route::get('/admin/event', 'EventMasterController@show')->name('admin.event');
	Route::post('/admin/event', 'EventMasterController@store')->name('admin.addevent');
	Route::post('/admin/updateevent', 'EventMasterController@update')->name('admin.updateevent');
	Route::post('/admin/updatestatus/{eid}/{status}', 'EventMasterController@updatestatus')->name('admin.updatestatus');
	Route::delete('/admin/deleteevent/{id}', 'EventMasterController@delete')->name('admin.deleteevent');

	/*Sub Event Master */
	Route::get('/admin/subevent', 'SubEventMasterController@show')->name('admin.subevent');
	Route::post('/admin/subevent', 'SubEventMasterController@store')->name('admin.addsubevent');
	Route::post('/admin/updatesubevent', 'SubEventMasterController@update')->name('admin.updatesubevent');
	Route::post('/admin/updatesubeventstatus/{eid}/{status}', 'SubEventMasterController@updatestatus')->name('admin.updatesubeventstatus');
	Route::delete('/admin/deletesubevent/{id}', 'SubEventMasterController@delete')->name('admin.deletesubevent');

	/*Role Master */
	Route::get('/admin/role', 'RoleController@show')->name('admin.role');
	Route::post('/admin/role', 'RoleController@store')->name('admin.addrole');
	Route::post('/admin/updaterole', 'RoleController@update')->name('admin.updaterole');
	Route::delete('/admin/deleterole/{id}', 'RoleController@delete')->name('admin.deleterole');

	/*Choreographer */
	Route::get('/admin/choreographer', 'ChoreographerController@show')->name('admin.choreographer');
	Route::post('/admin/choreographer', 'ChoreographerController@store')->name('admin.addchoreographer');
	Route::post('/admin/updatechoreographer', 'ChoreographerController@update')->name('admin.updatechoreographer');
	Route::delete('/admin/deletechoreographer/{id}', 'ChoreographerController@delete')->name('admin.deletechoreographer');

	/*Guest*/
	Route::get('/admin/guest', 'GuestController@show')->name('admin.guest');
	Route::post('/admin/guest', 'GuestController@store')->name('admin.addguest');
	Route::post('/admin/updateguest', 'GuestController@update')->name('admin.updateguest');
	Route::delete('/admin/deleteguest/{id}', 'GuestController@delete')->name('admin.deleteguest');

	/*Manage user*/
	Route::get('/admin/user', 'UserMasterController@show')->name('admin.user');
	Route::post('/admin/user', 'UserMasterController@adminStore')->name('admin.adduser');
	Route::post('/admin/updateuser', 'UserMasterController@updateAdmin')->name('admin.updateuser');
	Route::delete('/admin/deleteuser/{id}', 'UserMasterController@delete')->name('admin.deleteuser');

	/*Manage Group*/
	Route::get('/admin/group', 'GroupController@show')->name('admin.group');
	Route::post('/admin/group', 'GroupController@store')->name('admin.addgroup');
	Route::post('/admin/updategroup', 'GroupController@update')->name('admin.updategroup');
	Route::delete('/admin/deletegroup/{id}', 'GroupController@delete')->name('admin.deletegroup');
	Route::get('/ajaxAdminSubEvent', 'GroupController@getsubevent')->name('ajaxAdminSubEvent');

	/*Expence Type */
	Route::get('/admin/expence', 'ExpenceTypeController@show')->name('admin.Expence');
	Route::post('/admin/expence', 'ExpenceTypeController@store')->name('admin.addExpence');
	Route::post('/admin/updateexpence', 'ExpenceTypeController@update')->name('admin.updateExpence');
	Route::delete('/admin/deleteexpence/{id}', 'ExpenceTypeController@delete')->name('admin.deleteExpence');

	/*Session Expire*/
	Route::get('/admin/logout', 'BranchMasterController@destroy');
});

/* Event Handler */

Route::get('/eac', function () {
	if (session()->has('eac') == 0) {
		return view('eac/index');
	} else {
		return redirect('/eac/dashboard');
	}
})->name('login');

Route::post('/eac/authenticate', 'UserMasterController@validateEacLogin');

Route::get('/eac/forgotpassword', 'UserMasterController@validateEacForgotPassword')->name('forgotpassword');
Route::post('/eac/forgotpassword', 'UserMasterController@EacSendForgotPassword')->name('mail');
Route::get('/eac/resetPassword', 'UserMasterController@EacResetPassword');
Route::post('/eac/resetPassword', 'UserMasterController@EacUpdatePassword')->name('resetPassword');

Route::group(['middleware' => ['eac']], function () {

	Route::get('/eac/dashboard', 'EventMasterController@dashboadrd')->name('eac.dashboard');
	
	/*Reports */
	Route::get('/eac/EventWiseReport', 'SubEventMasterController@genederReport')->name('eac.eventReport');
	Route::get('/eac/Expense', 'SubEventMasterController@expenseReport')->name('eac.expenseReport');


	/*Sub Event Master */
	Route::get('/eac/subevent', 'SubEventMasterController@showEacSubEvent')->name('eac.subevent');
	Route::post('/eac/subevent', 'SubEventMasterController@storeEacSubEvent')->name('eac.addsubevent');
	Route::post('/eac/updatesubevent', 'SubEventMasterController@updateEacSubEvent')->name('eac.updatesubevent');
	Route::post('/eac/updatesubeventstatus/{eid}/{status}', 'SubEventMasterController@updatestatusEacSubEvent')->name('eac.updatesubeventstatus');
	Route::delete('/eac/deletesubevent/{id}', 'SubEventMasterController@deleteEacSubEvent')->name('eac.deletesubevent');

	/*Choreographer */
	Route::get('/eac/choreographer', 'ChoreographerController@showEacChoreo')->name('eac.choreographer');
	Route::post('/eac/choreographer', 'ChoreographerController@storeEacChoreo')->name('eac.addchoreographer');
	Route::post('/eac/updatechoreographer', 'ChoreographerController@updateEacChoreo')->name('eac.updatechoreographer');
	Route::delete('/eac/deletechoreographer/{id}', 'ChoreographerController@deleteEacChoreo')->name('eac.deletechoreographer');

	/*Guest*/
	Route::get('/eac/guest', 'GuestController@showEacGuest')->name('eac.guest');
	Route::post('/eac/guest', 'GuestController@storeEacGuest')->name('eac.addguest');
	Route::post('/eac/updateguest', 'GuestController@updateEacGuest')->name('eac.updateguest');
	Route::delete('/eac/deleteguest/{id}', 'GuestController@deleteEacGuest')->name('eac.deleteguest');

	/*Manage user*/
	Route::get('/eac/user', 'UserMasterController@showEacUser')->name('eac.user');
	Route::post('/eac/adduser', 'UserMasterController@eacStore')->name('eac.adduser');
	Route::post('/eac/updateuser', 'UserMasterController@updateEacUser')->name('eac.updateuser');
	Route::delete('/eac/deleteuser/{id}', 'UserMasterController@deleteEacUser')->name('eac.deleteuser');

	/*Manage Group*/
	Route::get('/eac/group', 'GroupController@showEacGroup')->name('eac.group');
	Route::post('/eac/group', 'GroupController@storeEacGroup')->name('eac.addgroup');
	Route::post('/eac/updategroup', 'GroupController@updateEacGroup')->name('eac.updategroups');
	Route::delete('/eac/deletegroup/{id}', 'GroupController@deleteEacGroup')->name('eac.deletegroup');
	Route::get('/ajaxSubEvent', 'GroupController@getsubevent')->name('ajaxSubEvent');

	/*Manage Attendence*/
	Route::get('/eac/attendence', 'AttendenceController@showEacAttendence')->name('eac.attendence');
	Route::get('/eac/edit/{id}/{date}', 'AttendenceController@edit')->name('eac.ediAttendence');
	Route::post('/eac/updateattendence', 'AttendenceController@updateEacAttendence')->name('eac.updateattendence');
	Route::delete('/eac/deleteattendence/{id}', 'AttendenceController@deleteEacAttendence')->name('eac.deleteattendence');

	/*Manage Expence*/
	Route::get('/eac/expence', 'ExpenceController@showEacExpence')->name('eac.Expence');
	Route::post('/eac/updateexpence/{status}/{id}', 'ExpenceController@updateEacExpence')->name('eac.updateExpence');
	Route::post('/eac/updatestatus', 'ExpenceController@updateEacStatus')->name('eac.updateStatus');
	Route::delete('/eac/deleteexpence/{id}', 'ExpenceController@deleteEacExpence')->name('eac.deleteExpence');

	/*Manage Scedhuling*/
	// /* sample */ Route::get('/eac/scheduling', 'SchedulingController@showEacScheduling')->name('eac.scheduling');
	// Route::get('/eac/dynamicscheduling', 'SchedulingController@getEvents')->name('eac.dynamicScheduling');
	Route::get('/eac/schedule', 'SchedulingController@getEvents')->name('eac.getschedule');
	Route::post('/eac/addSchedule', 'SchedulingController@store')->name('eac.schedule');
	Route::post('/eac/addoverlap', 'SchedulingController@addOverlap')->name('eac.countOverlap');
	Route::post('/eac/edit/', 'SchedulingController@edit')->name('eac.editSchedule');
	Route::post('/eac/update/', 'SchedulingController@update')->name('eac.updateSchedule');
	Route::delete('/eac/delete/{id}', 'SchedulingController@delete')->name('eac.deleteSchedule');
	Route::get('/eac/viewSchedule', 'SchedulingController@show')->name('eac.showschedule');

	/*Session Expire*/
	Route::get('/eac/logout', 'UserMasterController@destroyEac')->name('eac.logout');
});

/* Faculty Co-ordinator Handler */

Route::get('/fc', function () {
	if (session()->has('fc') == 0) {
		return view('fc/index');
	} else {
		return redirect('fc/dashboard');
	}
})->name('login');

Route::post('/fc/authenticate', 'UserMasterController@validateFcLogin');

Route::get('/fc/forgotpassword', 'UserMasterController@validateFcForgotPassword')->name('fcForgotpassword');
Route::post('/fc/forgotpassword', 'UserMasterController@FcSendForgotPassword')->name('fcMail');
Route::get('/fc/resetPassword', 'UserMasterController@FcResetPassword');
Route::post('/fc/resetPassword', 'UserMasterController@FcUpdatePassword')->name('fcResetPassword');

Route::group(['middleware' => ['fc']], function () {

	Route::get('/fc/dashboard', 'EventMasterController@fcdashboard')->name('fc.dashboard');	
	
	/*Manage user*/
	Route::get('/fc/user', 'UserMasterController@showFcUser')->name('fc.user');
	Route::post('/fc/updateuser', 'UserMasterController@updateFcUser')->name('fc.updateuser');
	Route::post('/fc/updateuser/{status}/{s_e_id}/{id}', 'EventRegistrationController@updateStatus')->name('fc.updateEventRegisterStatus');
	
	/*Manage Attendence*/
	Route::get('/fc/attendence', 'AttendenceController@showFcAttendence')->name('fc.attendence');
	Route::post('/fc/addAttendence', 'AttendenceController@storeFcAttendence')->name('fc.addAttendence');
	Route::post('/fc/updateattendence', 'AttendenceController@updateFcAttendence')->name('fc.updateattendence');
	Route::get('/fc/edit/{id}/{date}', 'AttendenceController@editFc')->name('fc.ediAttendence');
	Route::delete('/fc/deleteattendence/{id}', 'AttendenceController@deleteFcAttendence')->name('fc.deleteattendence');

	/*Manage Expence*/
	Route::get('/fc/expence', 'ExpenceController@showFcExpence')->name('fc.Expence');
	Route::post('/fc/expence', 'ExpenceController@storeFcExpence')->name('fc.addExpence');
	Route::post('/fc/updateexpence', 'ExpenceController@updateFcExpence')->name('fc.updateExpence');
	Route::delete('/fc/deleteexpence/{id}', 'ExpenceController@deleteFcExpence')->name('fc.deleteExpence');

	/*Manage Practice Schedule*/
	Route::get('/fc/practiceschedule', 'PracticeScheduleController@showFcPracticeSchedule')->name('fc.practiceSchedule');
	Route::post('/fc/practiceschedule', 'PracticeScheduleController@storeFcPracticeSchedule')->name('fc.addPracticeSchedule');
	Route::post('/fc/updatepracticeschedule', 'PracticeScheduleController@updateFcPracticeSchedule')->name('fc.updatePracticeSchedule');
	Route::delete('/fc/deletepracticeschedule/{id}', 'PracticeScheduleController@deleteFcPracticeSchedule')->name('fc.deletePracticeSchedule');

	/*Manage Costumes*/
	Route::get('/fc/costumes', 'CostumeController@showFcCostumes')->name('fc.costumes');
	Route::post('/fc/costumes', 'CostumeController@storeFcCostumes')->name('fc.addCostumes');
	Route::post('/fc/updatecostumes', 'CostumeController@updateFcCostumes')->name('fc.updateCostumes');
	Route::delete('/fc/deletecostumes/{costume_id}', 'CostumeController@deleteFcCostumes')->name('fc.deleteCostumes');

	/*Session Expire*/
	Route::get('/fc/logout', 'UserMasterController@destroyFc')->name('fc.logout');
});

/* Student Route */
Route::middleware('student')->group(function () {

	Route::get('/student/events', 'UserMasterController@getEvents');
	Route::post('/student/update', 'UserMasterController@update');
	Route::get('/student/logout', 'UserMasterController@logout');
	Route::get('/student/profile', 'UserMasterController@userProfile');
	Route::get('/student/change_password', 'UserMasterController@change_password_form');
	Route::post('/student/change_password', 'UserMasterController@change_password');
	Route::get('/student/registered_events', 'UserMasterController@registered_events');
	Route::post('/student/event_registration', 'EventRegistrationController@store');
	Route::post('/student/sub_event_list', 'UserMasterController@getSubevent');
});
Route::get('/student/registration', 'UserMasterController@get_data');
Route::post('/student/register', 'UserMasterController@store');
Route::get('/student/login', 'UserMasterController@get_login_form');
Route::post('/student/login', 'UserMasterController@validateUser');
Route::post('/ajaxbranch', 'UserMasterController@getStream')->name('ajaxbranch');
Route::post('/ajaxstream', 'UserMasterController@getDivision')->name('ajaxstream');
Route::get('/student/forgot_password', 'UserMasterController@get_forgot_password_form');
Route::post('/send/email', 'UserMasterController@mail');
Route::get('student/reset_password', 'UserMasterController@reset_password_form');
Route::post('/student/reset_password', 'UserMasterController@resetPassword');
Route::post('/ajaxGroup', 'GroupController@getGroup')->name('ajaxGroup');


/* Student Coordinator */
Route::middleware('coordinator')->group(function()
{
    Route::get('/student_coordinator/index','UserMasterController@get_student_coordinator_form');
    Route::get('/student_coordinator/events','UserMasterController@get_coordinator_Events');
    Route::get('/student_coordinator/registered_events','UserMasterController@get_coordinator_registered_events');
    Route::get('/student_coordinator/profile','UserMasterController@get_coordinator_Profile');
    Route::post('/student_coordinator/update', 'UserMasterController@update');
    Route::get('/student_coordinator/change_password','UserMasterController@coordinator_change_password_form');
    Route::post('/student_coordinator/change_password','UserMasterController@change_password');
    Route::post('/student_coordinator/sub_event_list','UserMasterController@get_coordinator_Subevent');
    Route::post('/student_coordinator/event_registration','EventRegistrationController@coordinator_store');
    Route::get('/student_coordinator/add_expence','UserMasterController@get_expence_form');
    Route::post('/student_coordinator/add_expence','ExpenceController@store');
    Route::get('/student_coordinator/take_attendance','AttendenceController@show_coordinator_attendance');
    Route::post('/ajaxevent','ExpenceController@get_sub_event')->name('ajaxevent');
		Route::post('/student_coordinator/add_attendance','AttendenceController@store_coordinator_attendance');
    Route::get('/student_coordinator/view_attendance','AttendenceController@showStudentCoAttendence');
    Route::get('/student_coordinator/view_expense','ExpenceController@showStudentCoExpence');
});

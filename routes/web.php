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
        return redirect('/admin/branch');
    }
})->name('login');

Route::post('/admin/authenticate', 'BranchMasterController@checkLogin');

Route::group(['middleware' => ['admin']], function () {
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
    Route::get('/ajaxSubEvent', 'GroupController@getsubevent')->name('ajaxSubEvent');

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
        return redirect('eac/choreographer');
    }
})->name('login');

Route::post('/eac/authenticate', 'UserMasterController@validateEacLogin');

Route::group(['middleware' => ['eac']], function () {

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
    Route::post('/eac/updateuser', 'UserMasterController@updateEacUser')->name('eac.updateuser');
    Route::delete('/eac/deleteuser/{id}', 'UserMasterController@deleteEacUser')->name('eac.deleteuser');

    /*Manage Group*/
    Route::get('/eac/group', 'GroupController@showEacGroup')->name('eac.group');
    Route::post('/eac/group', 'GroupController@storeEacGroup')->name('eac.addgroup');
    Route::post('/eac/updategroup', 'GroupController@updateEacGroup')->name('eac.updategroups');
    Route::delete('/eac/deletegroup/{id}', 'GroupController@deleteEacGroup')->name('eac.deletegroup');
    Route::post('/ajaxSubEvent', 'GroupController@getsubevent')->name('ajaxSubEvent');

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
    Route::get('/eac/scheduling', 'SchedulingController@showEacScheduling')->name('eac.scheduling');

    /*Session Expire*/
    Route::get('/eac/logout', 'UserMasterController@destroyEac')->name('eac.logout');
});

/* Faculty Co-ordinator Handler */

Route::get('/fc', function () {
    if (session()->has('fc') == 0) {
        return view('fc/index');
    } else {
        return redirect('fc/user');
    }
})->name('login');

Route::post('/fc/authenticate', 'UserMasterController@validateFcLogin');

Route::group(['middleware' => ['fc']], function () {

    /*Manage user*/
    Route::get('/fc/user', 'UserMasterController@showFcUser')->name('fc.user');
    Route::post('/fc/updateuser', 'UserMasterController@updateFcUser')->name('fc.updateuser');
    Route::post('/fc/updateuser/{status}/{s_e_id}/{id}', 'EventRegistrationController@updateStatus')->name('fc.updateEventRegisterStatus');

    /*Manage Attendence*/
    Route::get('/fc/attendence', 'AttendenceController@showFcAttendence')->name('fc.attendence');
    Route::post('/fc/addAttendence', 'AttendenceController@storeFcAttendence')->name('fc.addAttendence');
    Route::post('/fc/updateattendence', 'AttendenceController@updateFcAttendence')->name('fc.updateattendence');
    Route::get('/fc/edit/{id}/{date}', 'AttendenceController@edit')->name('fc.ediAttendence');
    Route::delete('/fc/deleteattendence/{id}', 'AttendenceController@deleteFcAttendence')->name('fc.deleteattendence');

    /*Manage Expence*/
    Route::get('/fc/expence', 'ExpenceController@showFcExpence')->name('fc.Expence');
    Route::post('/fc/expence', 'ExpenceController@storeFcExpence')->name('fc.addExpence');
    Route::post('/fc/updateexpence', 'ExpenceController@updateFcExpence')->name('fc.updateExpence');
    Route::delete('/fc/deleteexpence/{id}', 'ExpenceController@deleteFcExpence')->name('fc.deleteExpence');

    /*Session Expire*/
    Route::get('/fc/logout', 'UserMasterController@destroyFc')->name('fc.logout');
});

/* Student Route */
Route::middleware('session.has.user')->group(function () {

    Route::get('/student/events', 'UserMasterController@getEvents');
    Route::post('/student/update', 'UserMasterController@update');
    Route::get('/student/logout', 'UserMasterController@logout');
    Route::get('/student/profile', 'UserMasterController@userProfile');
    Route::get('/student/change_password', function () {
        return view('student/change_password');
    });
    Route::post('/student/change_password', 'UserMasterController@change_password');
});
Route::get('/student/registration', 'UserMasterController@get_data');
Route::post('/student/register', 'UserMasterController@store');
Route::get('/student/login', function () {
    return view('student/login');
});
Route::post('/student/login', 'UserMasterController@validateUser');
Route::post('/ajaxbranch', 'UserMasterController@getStream')->name('ajaxbranch');
Route::post('/ajaxstream', 'UserMasterController@getDivision')->name('ajaxstream');
Route::post('/student/sub_event_list', 'UserMasterController@getSubevent');
Route::get('/student/forgot_password', function () {
    return view('student/forgot_password');
});
Route::post('/send/email', 'UserMasterController@mail');
Route::get('student/reset_password', 'UserMasterController@reset_password_form');
Route::post('/student/reset_password', 'UserMasterController@resetPassword');

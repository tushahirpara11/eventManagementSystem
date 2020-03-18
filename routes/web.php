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
    Route::post('/admin/updateuser', 'UserMasterController@update')->name('admin.updateuser');
    Route::delete('/admin/deleteuser/{id}', 'UserMasterController@delete')->name('admin.deleteuser');

    /*Manage Group*/
    Route::get('/admin/group', 'GroupController@show')->name('admin.group');
    Route::post('/admin/group', 'GroupController@store')->name('admin.addgroup');
    Route::post('/admin/updategroup', 'GroupController@update')->name('admin.updategroup');
    Route::delete('/admin/deletegroup/{id}', 'GroupController@delete')->name('admin.deletegroup');
    Route::post('/ajaxSubEvent', 'GroupController@getsubevent')->name('ajaxSubEvent');

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
    Route::post('/eac/user', 'UserMasterController@StoreEacUser')->name('eac.adduser');
    Route::post('/eac/updateuser', 'UserMasterController@updateEacUser')->name('eac.updateuser');
    Route::delete('/eac/deleteuser/{id}', 'UserMasterController@deleteEacUser')->name('eac.deleteuser');

    /*Manage Group*/
    Route::get('/eac/group', 'GroupController@show')->name('eac.group');
    Route::post('/eac/group', 'GroupController@store')->name('eac.addgroup');
    Route::post('/eac/updategroup', 'GroupController@update')->name('eac.updategroup');
    Route::delete('/eac/deletegroup/{id}', 'GroupController@delete')->name('eac.deletegroup');
    Route::post('/ajaxSubEvent', 'GroupController@getsubevent')->name('ajaxSubEvent');

    /*Session Expire*/
    Route::get('/eac/logout', 'UserMasterController@destroyEac');
});

/* Student Route */
Route::get('/student/registration', 'UserMasterController@get_data');
Route::post('/student/register', 'UserMasterController@store');
Route::get('/student/login', function () {
    return view('student/login');
});
Route::post('/student/login', 'UserMasterController@validateUser');
Route::get('/student/events', 'UserMasterController@getEvents');
Route::post('/ajaxbranch', 'UserMasterController@getStream')->name('ajaxbranch');
Route::post('/ajaxstream', 'UserMasterController@getDivision')->name('ajaxstream');

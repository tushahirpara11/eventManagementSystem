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
});

Route::post('/admin/authenticate', 'BranchMasterController@checkLogin');

Route::middleware('session.has.admin')->group(function () {
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
    Route::delete('/admin/deleteevent/{id}', 'EventMasterController@delete')->name('admin.deleteevent');

    /*Session Expire*/
    Route::get('/admin/logout', 'BranchMasterController@destroy'); 
    
});
/* Student Route */
Route::get('/student/registration','UserMasterController@get_data');
Route::post('/student/register','UserMasterController@store');
Route::get('/student/login',function(){
    return view('student/login');
});
Route::post('/student/login','UserMasterController@validateUser');
Route::get('/student/events','UserMasterController@getEvents');
Route::post('/ajaxbranch','UserMasterController@getStream')->name('ajaxbranch');
Route::post('/ajaxstream','UserMasterController@getDivision')->name('ajaxstream');

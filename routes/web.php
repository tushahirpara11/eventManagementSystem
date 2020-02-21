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
    // Route::get('/admin/addBranch', 'BranchMasterController@addBranch');
    Route::get('/admin/branch', 'BranchMasterController@show');
    Route::post('/admin/branch', 'BranchMasterController@store')->name('admin.addbranch');
    Route::delete('/admin/deletebranch/{id}', 'BranchMasterController@delete')->name('admin.deletebranch');
    Route::post('/admin/updatebranch', 'BranchMasterController@update')->name('admin.updatebranch');
    Route::get('/admin/logout', 'BranchMasterController@destroy');
});

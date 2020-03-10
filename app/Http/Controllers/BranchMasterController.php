<?php

namespace App\Http\Controllers;

use App\branchMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\type;

class BranchMasterController extends Controller
{
    public function __construct()
    {
        if(session('admin') == 'admin')
        {
            return redirect('/admin/branch');
        }
        else{
            return redirect()->route('login');
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    function checkLogin(Request $request)
    {
        if ($request->get('username') == 'admin' && $request->get('password') == 'admin') {
            session(['admin' => $request->get('username')]);            
            return redirect('/admin/branch');
        } else {            
            return Redirect::back()->with('error', 'Invalid Credential..!');
        }
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

    public function addBranch()
    {
        return view('admin/addBranch');
    }

    public function store(Request $request)
    {
        $count = branchMaster::where('b_code', $request->get('b_code'))->orWhere('b_name', $request->get('b_name'))->get();
        if (count($count) == 0) {
            $insertBranch = new branchMaster(['b_code' => $request->get('b_code'), 'b_name' => $request->get('b_name')]);
            $insertBranch->save();
            return Redirect::back()->with('success', 'Branch Added Successfully.');
        } else {
            return Redirect::back()->with('error', 'Branch Already Exists...');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\branchMaster  $branchMaster
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('admin/viewBranch')->with('data', branchMaster::get());
    }

    public function delete($id)
    {
        $refresh = DB::delete('delete from branch_masters where b_id=' . $id);
        return Redirect::back();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\branchMaster  $branchMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(branchMaster $branchMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\branchMaster  $branchMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::update('update branch_masters set b_name = "' . $request->get('b_name') . '" where b_code = ' . $request->b_code);
        return redirect('/admin/branch');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\branchMaster  $branchMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (session()->has('admin')) {
            $request->session()->flush('admin');
            $cookie = Cookie::forget('admin');
            return redirect('admin/')->withCookie($cookie);
        }
    }
}

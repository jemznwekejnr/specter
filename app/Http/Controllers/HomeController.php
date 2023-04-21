<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class HomeController extends Controller
{
    //

    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(){

        

        if($this->checkstatus(Auth::user()->id) != "Active"){

            Auth::logout();

            return redirect('login');

        }else if($this->checkprofile(Auth::user()->profileid) == "Incomplete"){



            $staff = DB::table('profile')->where('id', Auth::user()->profileid)->get();

            $offices = DB::table('offices')->orderBy('offices', 'asc')->get();

            $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

            $departments = DB::table('departments')->orderBy('departments', 'asc')->get();

            $designations = DB::table('designations')->orderBy('designations', 'asc')->get();

            return view('update-profile', ["staff" => $staff, 'offices' => $offices, 'banks' => $banks, 'departments' => $departments, 'designations' => $designations, "profileinfo" => "Complete Profile Update to Proceed"]);

        }else{

            $pvs = DB::table('pv')->orderBy('created_at', 'desc')->limit(6)->get();

            return view('dashboard', ['pvs' => $pvs]);

        }

    }
}

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

        }else{

            return view('dashboard');

        }

    }
}

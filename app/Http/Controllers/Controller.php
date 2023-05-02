<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use DB;
use Auth;
use DateTime;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function staffname($user){

        return DB::table('user')->where('id', $user)->value('name');
    }


    public static function staffemail($user){

        return DB::table('profile')->where('id', $user)->value('email');

    }
    
    public static function getrolename($role){
        
        return DB::table('role')->where('id', $role)->value('role');
    }

    public static function url(){

        return "http://3.220.58.151:8501";
    }


    //generate password token for new user
    public static function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }
    
        return $token;
    }


    public static function checkuser($user){

        return DB::table('users')->where('profileid', $user)->get();
    }

    public static function profileemail($user){

        return DB::table('profile')->where('id', $user)->value('email');
    }


    //send notification on the system
    public static function createnotification($staff, $type, $title, $status, $location){

        $data = array();

        $data['staff'] = $staff;
        $data['type'] = $type;
        $data['title'] = $title;
        $data['status'] = $status;
        $data['location'] = $location;
        $data['created_at'] = date('Y-m-d H:i:s');

        return DB::table('notifications')->insert($data);

    }

    
    //log event
    public static function logevent($action){

        //log the event

        $logs = array();

        $logs['user'] = Auth::user()->id;
        $logs['action'] = $action;
        $logs['created_at'] = date('Y-m-d H:i:s');
        $logs['updated_at'] = date('Y-m-d H:i:s');

        return $createlogs = DB::table('logs')->insert($logs);


    }

    public static function datediffs($date1, $date2){

        $date1 = new DateTime($date1);
        $date2 = new DateTime($date2);
        $interval = $date1->diff($date2);

        return $interval->d." days ";
    }

    public static function staffimage($staff){

        return DB::table('profile')->where('id', $staff)->value('image');
    }


    public static function getaction($action){

        return DB::table('actions')->where('id', $action)->value('action');
    }

    public static function checkprocess($role, $process, $action){

        if(DB::table('privileges')->where([['role', $role], ['privilege', $process], ['action', $action]])->count() == 1){

            return "found";
        }

    }


    public static function checkrole($role, $process, $action){

        if(DB::table('privileges')->where([['role', $role], ['privilege', $process], ['action', $action]])->count() == 1){

            return "allow";
        }
    }

    //check if user account is active
    public static function checkstatus($user){

        return DB::table('users')->where('id', $user)->value('status');

    }


    public static function notifications(){

        return DB::table('notifications')->where([['staff', Auth::user()->profileid],['status', 'Unread']])->orderBy('created_at', 'desc')->get();
    }

    public static function duration($startdate){

        $enddate = date('Y-m-d H:i:s');

        $date1 = new DateTime($enddate);
        $date2 = new DateTime($startdate);
        $interval = $date1->diff($date2);
        //echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 

        $year = $interval->y;
        $month = $interval->m;
        $days = $interval->d;
        $hours = $interval->h;
        $minutes = $interval->i;
        $seconds = $interval->s;

        if($year == 1){
            return $year . " year ";
        }else if($year > 1){
            return $year . " years ";
        }else if($month == 1){
            return $month . " month ";
        }else if($month > 1){
            return $month . " months ";
        }else if($days == 1){
            return $days . " day ";
        }else if($days > 1){
            return $days . " days ";
        }else if($hours == 1){
            return $hours . " hour ";
        }else if($hours > 1){
            return $hours . " hours ";
        }else if($minutes == 1){
            return $minutes . " minute ";
        }else if($minutes > 1){
            return $minutes . " minutes ";
        }else if($seconds == 1){
            return $seconds . " second ";
        }else if($seconds > 1){
            return $seconds . " seconds ";
        }else{
            return $seconds . " seconds "; 
        }
        
    }


}

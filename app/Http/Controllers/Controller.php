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

        $staff = DB::table('profile')->where('id', $user)->get();

        return $staff[0]->firstname." ".$staff[0]->surname." ".$staff[0]->othername;
    }


    public static function staffemail($user){

        return DB::table('profile')->where('id', $user)->value('email');

    }
    
    public static function getrolename($role){
        
        return DB::table('role')->where('id', $role)->value('role');
    }

    public static function staffpics($user){

        return DB::table('profile')->where('id', $user)->value('image');

    }


    public static function staffsignature($user){

        return DB::table('profile')->where('id', $user)->value('signature');

    }

    public static function staffpdfsignature($user){

        $signature = DB::table('profile')->where('id', $user)->value('signature');

        return base64_encode(file_get_contents(public_path($signature)));

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

    public static function profileemail($staff){

        $staff = DB::table('profile')->where('id', $staff)->get();

        return $staff[0]->email;
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

    public static function staffdesignation($staff){

        return DB::table('profile')->where('id', $staff)->value('designation');
    }

    public static function projectname($project){

        return DB::table('projects')->where('id', $project)->value('title');
    }

    public static function projectdetail($project){

        return DB::table('projects')->where('id', $project)->get();
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


    public static function clientpayments($project){

        return DB::table('invoice')->where([['project', $project], ['status', 'Paid']])->sum('sumamounts');
    }

    //get project progress from the tasks
    public static function projectprogress($project){

        $total = DB::table('task')->where('projectid', $project)->count();

        $completed = DB::table('task')->where([['projectid', $project],['status', 'completed']])->count();

        if($total == 0){
            return 0;
        }else{
            $progress = $completed / $total * 100;

            if($progress == 100){ //update project status

                $status = DB::table('projects')->where('projectid', $project)->update(['status' => 'Completed', 'updated_at' => date('Y-m-d H:i:s')]);

            }

            return $progress;
        }

        
    }


    public static function officename($office){

        $info = DB::table('companyinfo')->where('id', $office)->get();

        if($info->count() == 0){
            return "Office not found, edit this page to select office";
        }else{
            return $info[0]->address.', '.$info[0]->city.' '.$info[0]->state;
        }
    }


    public static function getfulloffice($office){

        $info = DB::table('companyinfo')->where('id', $office)->get();

        if($info->count() == 0){
            return "Office not found, edit this page to select office";
        }else{
            return $info;
        }
    }

    

    //get project expenses
    public static function projectexpenses($project){

        return DB::table('pv')->where([['project', $project], ['status', 'Paid']])->sum('totalnet');
    }

    //get task percentage
    public static function taskpercent($project, $category){

        $total = DB::table('task')->where('projectid', $project)->count();

        $category = DB::table('task')->where([['projectid', $project], ['status', $category]])->count();

        if($total == 0){
            return 0;
        }else{
            return $category / $total * 100;
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

    //check if staff profile is completed
    public static function checkprofile($staff){

        $check = DB::table('profile')->where('id', $staff)->get();

        if(empty($check[0]->staffid) || empty($check[0]->surname) || empty($check[0]->firstname) || empty($check[0]->email) || empty($check[0]->phone) || empty($check[0]->dob) || empty($check[0]->doe) || empty($check[0]->department) || empty($check[0]->designation) || empty($check[0]->office) || empty($check[0]->gender) || empty($check[0]->image) || empty($check[0]->signature)){

            return "Incomplete";

        }else{

            return "Complete";
        }
    }


    public static function getactions($action){

        return DB::table('actions')->where('id', $action)->value('action');
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


    public static function circularrecipients($circular){


        return DB::table('circular_recipeint')->where('circularid', $circular)->get();

    }


    public static function circulartitle($circular){

        return DB::table('circular')->where('id', $circular)->value('title');
    }
    
    public static function expensesthisyear(){
        
        return DB::table('pv')->where([['status', 'Approved'], ['created_at', 'LIKE', date('Y').'%']])->sum('totalnet');
    }
    
    public static function expensesthismonth(){
        
        return DB::table('pv')->where([['status', 'Approved'], ['created_at', 'LIKE', date('Y-m').'%']])->sum('totalnet');
    }

}

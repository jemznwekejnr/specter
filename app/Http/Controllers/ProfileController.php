<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;
use Hash;

class ProfileController extends Controller
{
    //Staff Profile Backend

    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createstaff(){
        
        if($this->checkrole(Auth::user()->role, 4, 6) == "allow"){

        $offices = DB::table('offices')->orderBy('offices', 'asc')->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        $departments = DB::table('departments')->orderBy('departments', 'asc')->get();

        $designations = DB::table('designations')->orderBy('designations', 'asc')->get();

        return view('add-staff', ['offices' => $offices, 'banks' => $banks, 'departments' => $departments, 'designations' => $designations]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }

    }

    public function profilepics(){

        return view('upload-pics');
    }

    public function addsignature(){

        return view('upload-signature');
    }


    public function designations(){
        
        if($this->checkrole(Auth::user()->role, 8, 2) == "allow"){

        $designations = DB::table('designations')->orderBy('designations', 'asc')->get();

        return view('designations', ['designations' => $designations]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function departments(){
        
        if($this->checkrole(Auth::user()->role, 8, 2) == "allow"){

        $departments = DB::table('departments')->orderBy('departments', 'asc')->get();

        return view('departments', ['departments' => $departments]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function banks(){
        
        if($this->checkrole(Auth::user()->role, 8, 2) == "allow"){

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        return view('banks', ['banks' => $banks]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    public function offices(){
        
        if($this->checkrole(Auth::user()->role, 8, 2) == "allow"){

        $offices = DB::table('offices')->orderBy('offices', 'asc')->get();

        return view('offices', ['offices' => $offices]);
        
        return view('banks', ['banks' => $banks]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function staffprofile(Request $request){
        
        if($this->checkrole(Auth::user()->role, 4, 7) == "allow"){

        $staff = DB::table('profile')->where('id', $request->id)->get();

        return view('staffprofile', ['staff' => $staff]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    //add new department to the database

    public function submitdepartment(Request $request){

        $departments = $request->departments;
        $deptid = $request->deptid;

        if(!empty($deptid)){

         $check = DB::table('departments')->where('departments', $departments)->count();

        if($check == 1){

            //log the event

            $this->logevent("Attempted to update department ".$departments." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Department, '.$departments." already exist"
            ]);
        }


        $data = array();

        $data['departments'] = $departments;
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

            $update = DB::table('departments')->where('id', $deptid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated department ".$departments." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Department, '.$departments." successfully updated"
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update department ".$departments." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Could not update department, '.$departments." at the moment, please try again."
            ]);

        }

        }else{


        //check if department already added to the database

        $check = DB::table('departments')->where('departments', $departments)->count();

        if($check == 1){

            //log the event

            $this->logevent("Attempted to add new department ".$departments." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Department, '.$departments." already exist"
            ]);
        }

        $data = array();

        $data['departments'] = $departments;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

            $create = DB::table('departments')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($create){

            
            //log the event

            $this->logevent("Added new department ".$departments." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Department, '.$departments." successully added."
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to add new department ".$departments." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Could not add the Department, '.$departments." at the moment please try again."
            ]);

        }

        }
    }




    //add new designation to the database

    public function submitdesignation(Request $request){

        $designations = $request->designations;


        if(!empty($request->desid)){

        //check if designation already added to the database

        $check = DB::table('designations')->where('designations', $designations)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to add new designation ".$designations." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Designation already exist'
            ]);
        }

        $data = array();

        $data['designations'] = $designations;
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $update = DB::table('designations')->where('id', $request->desid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated designation ".$designations." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Designation successfully updated'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update designation ".$designations." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Error updating designation, please again.'
            ]);

        }


        }else{

        //check if designation already added to the database

        $check = DB::table('designations')->where('designations', $designations)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to add new designation ".$designations." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error'
            ]);
        }

        $data = array();

        $data['designations'] = $designations;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $create = DB::table('designations')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again'
                ]);
            }

        if($create){

            
            //log the event

            $this->logevent("Added new designation ".$designations." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Designation successfully created'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to add new designation ".$designations." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Error creating designation, please try again'
            ]);

        }

    }

    }


    public function showdesignations(){
        
        if($this->checkrole(Auth::user()->role, 8, 2) == "allow"){

        $designations = DB::table('designations')->orderBy('designations', 'asc')->get();

        return view('process.designation', ['designations' => $designations]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }




    //add new office to the database

    public function submitoffices(Request $request){

        $offices = $request->offices;

        if(!empty($request->ofid)){

            //check if office already added to the database

        $check = DB::table('offices')->where('offices', $offices)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to add new office ".$offices." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => "Office ".$offices." already exist in the database"
            ]);
        }

        $data = array();

        $data['offices'] = $offices;
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

            $update = DB::table('offices')->where('id', $request->ofid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated office ".$offices." in the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Office successfully updated.'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update office ".$offices." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Office update failed please try again.'
            ]);

        }

        }else{

        //check if office already added to the database

        $check = DB::table('offices')->where('offices', $offices)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to add new office ".$offices." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Office already exist'
            ]);
        }

        $data = array();

        $data['offices'] = $offices;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

            $create = DB::table('offices')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($create){

            
            //log the event

            $this->logevent("Added new office ".$offices." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Office successfully created'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to add new office ".$offices." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Could not create office at the moment, please try again.'
            ]);

        }

    }

    }




    //add new office to the database

    public function submitbank(Request $request){

        $banks = $request->banks;

        if(!empty($request->bkid)){

        //check if bank already added to the database

        $check = DB::table('banks')->where('banks', $banks)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to update bank ".$banks." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Bank already exist.'
            ]);
        }

        $data = array();

        $data['banks'] = $banks;
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $update = DB::table('banks')->where('id', $request->bkid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated bank ".$banks." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Bank successfully updated.'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update bank ".$banks." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Error updating bank to the database, kindly try again.'
            ]);

        }

        }else{

        //check if bank already added to the database

        $check = DB::table('banks')->where('banks', $banks)->count();

        if($check == 1){

            
            //log the event

            $this->logevent("Attempted to add new bank ".$banks." to the database, but failed because the event exist");


            return response()->json([
                'message' => 'error',
                'info' => 'Bank already exist.'
            ]);
        }

        $data = array();

        $data['banks'] = $banks;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $create = DB::table('banks')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($create){

            
            //log the event

            $this->logevent("Added new bank ".$banks." to the database");

            return response()->json([
                'message' => 'success',
                'info' => 'Bank successfully added to the database.'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to add new bank ".$banks." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Error adding bank to the database, kindly try again.'
            ]);

        }

    }

    }


    public function submitstaff(Request $request){

        $fname = $request->fname;
        $staffid = $request->staffid;
        $onames = $request->onames;
        $sname = $request->sname;
        $doe = $request->doe;
        $department = $request->department;
        $gender = $request->gender;
        $designation = $request->designation;
        $dob = $request->dob;
        $office = $request->office;
        $email = $request->email;
        $accountno = $request->accountno;
        $phone = $request->phone;
        $bank = $request->bank;


        //check if the email provided is already in use
        $checkemail = DB::table('profile')->where('email', $email)->count();

        if($checkemail == 1){

            
            //log the event

            $this->logevent("Attempted to add new staff with email ".$email." to the database, but failed because the email is already in use");


            return response()->json([
                'message' => 'error',
                'info' => 'Email address provided already in use by another staff'
            ]);

        }else{

            //check if the staff already exist using staff id
            $checkemail = DB::table('profile')->where('staffid', $staffid)->count();


            if($checkemail == 1){

            
            //log the event

            $this->logevent("Attempted to add new staff with staff id ".$staffid." to the database, but failed because the staff id is already in use");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff already registered or staff id is in use by another staff'
            ]);
            
            }

        }


        $data = array();

        $data['staffid'] = $staffid;
        $data['surname'] = $sname;
        $data['firstname'] = $fname;
        $data['othername'] = $onames;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['dob'] = $dob;
        $data['doe'] = $doe;
        $data['department'] = $department;
        $data['designation'] = $designation;
        $data['office'] = $office;
        $data['gender'] = $gender;
        $data['accountno'] = $accountno;
        $data['bankname'] = $bank;
        $data['employmentstatus'] = 'Active Employment';
        $data['datechanged'] = $doe;
        $data['created_at'] = date('Y-m-d H:i:s');


        
        try {

            $create = DB::table('profile')->insertGetId($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }


        if($create){

            
            //log the event

            $this->logevent("Added new staff with ".$staffid." and email ".$email." to the database");


            //send email to the staff

            //send password and public key to admin email
            $username = $fname;
            $useremail = $email;
            
            try{
                //send email to the person concerned
                Mail::send('emails.newprofileemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                $message->to($useremail, $username)->subject('New profile created for you at Relia Energy ERP');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }

            return response()->json([
                'message' => 'success',
                'id' => $create,
                'info' => 'New staff account successfully created '.$username.' '.$useremail
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to add new staff with ".$staffid." and email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Could not create staff account at the moment, please try again.'
            ]);

        }




    }



    //upload staff profile pics

    public function submitpics(Request $request){

        $pics = $request->file('pics');
        $user = $request->user;

        $email = DB::table('profile')->where('id', $user)->value('email');

        try{
            $picsurl = $pics->store('assets/profile');
        } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading profile pics, reduce the file size of try a different file.'
                    ]);
                }

        
        try {

            $update = DB::table('profile')->where('id', $user)->update(['image' => $picsurl]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated the profile image of the staff  with the email ".$email." in the database");

            return response()->json([
                'message' => 'success',
                'id' => $user
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update the profile image of the staff with the email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error'
            ]);

        }
    }


    //upload staff signature

    public function submitsignature(Request $request){

        $pics = $request->file('pics');
        $user = $request->user;

        $email = DB::table('profile')->where('id', $user)->value('email');

        try{
            $picsurl = $pics->store('assets/profile');
        } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading attachment, reduce the file size of try a different file.'
                    ]);
                }

        try {

            $update = DB::table('profile')->where('id', $user)->update(['signature' => $picsurl]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated the signature of the staff  with the email ".$email." in the database");

            return response()->json([
                'message' => 'success',
                'id' => $user
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update the signature of the staff with the email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error'
            ]);

        }
    }


    public function editstaff(Request $request){
        
        if($this->checkrole(Auth::user()->role, 4, 7) == "allow"){


        $staff = DB::table('profile')->where('id', $request->id)->get();


        $offices = DB::table('offices')->orderBy('offices', 'asc')->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        $departments = DB::table('departments')->orderBy('departments', 'asc')->get();

        $designations = DB::table('designations')->orderBy('designations', 'asc')->get();


        return view('edit-staff', ['staff' => $staff, 'offices' => $offices, 'banks' => $banks, 'departments' => $departments, 'designations' => $designations]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }

    }


    public function convertuser(Request $request){

        $staff = DB::table('profile')->where('id', $request->id)->get();

        $password = $this->getToken(10);

        $data = array();

        $data['profileid'] = $staff[0]->id;
        $data['name'] = $staff[0]->firstname.' '.$staff[0]->surname.'  '.$staff[0]->othername;
        $data['email'] = $staff[0]->email;
        $data['role'] = DB::table('role')->where('role', 'Staff')->value('id');
        $data['status'] = 'Active';
        $data['password'] = Hash::make($password);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $convert = DB::table('users')->insertGetId($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }


        if($convert){

            //update staff profile with user id
            $update = DB::table('profile')->where('id', $staff[0]->id)->update(['userid' => $convert]);


            //Email user login credentials
            $username = $staff[0]->firstname;
            $useremail = $staff[0]->email;
            
            try{
                //send email to the person concerned
                Mail::send('emails.newuseremail', ['username' => $username, 'useremail' => $useremail, 'password' => $password], function ($message) use ($username, $useremail, $password) {
                $message->to($useremail, $username)->subject('Login Credentials for Relia Energy ERP');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }


            
            //log the event

            $this->logevent("Successfully converted the staff with the email ".$useremail." to a user");

            return response()->json([
                'message' => 'success',
                'info' => 'Staff successfully converted to user'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to convert the staff with the email ".$email." to a user, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff successfully converted to user'
            ]);
        }
        

    }


    public function submiteditstaff(Request $request){

        $fname = $request->fname;
        $staffid = $request->staffid;
        $onames = $request->onames;
        $sname = $request->sname;
        $doe = $request->doe;
        $department = $request->department;
        $gender = $request->gender;
        $designation = $request->designation;
        $dob = $request->dob;
        $office = $request->office;
        $email = $request->email;
        $accountno = $request->accountno;
        $phone = $request->phone;
        $bank = $request->bank;
        $employmentstatus = $request->employmentstatus;
        $datechanged = $request->datechanged;

        //check if the email provided is already in use
        $checkemail = DB::table('profile')->where([['email', $email],['id', '!=', $request->id]])->count();

        if($checkemail == 1){

            //log the event

            $logs = array();

            $logs['user'] = Auth::user()->id;
            $logs['action'] = "Attempted update staff with email ".$email." to the database, but failed because the email is already in use by another staff";
            $logs['created_at'] = date('Y-m-d H:i:s');
            $logs['updated_at'] = date('Y-m-d H:i:s');

            $createlogs = DB::table('logs')->insert($logs);


            return response()->json([
                'message' => 'error',
                'info' => 'Email address provided is currently in use by another staff'
            ]);

            }else{

            //check if the staff already exist using staff id
            $checkemail = DB::table('profile')->where([['staffid', $staffid],['id', '!=', $request->id]])->count();


            if($checkemail == 1){

            
            //log the event

            $this->logevent("Attempted to update staff with staff id ".$staffid." to the database, but failed because the staff id is already in use by another staff");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff ID provided is currently in use by another staff'
            ]);
            
            }

        }


        $data = array();

        $data['staffid'] = $staffid;
        $data['surname'] = $sname;
        $data['firstname'] = $fname;
        $data['othername'] = $onames;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['dob'] = $dob;
        $data['doe'] = $doe;
        $data['department'] = $department;
        $data['designation'] = $designation;
        $data['office'] = $office;
        $data['gender'] = $gender;
        $data['accountno'] = $accountno;
        $data['bankname'] = $bank;
        $data['employmentstatus'] = $employmentstatus;
        $data['datechanged'] = $datechanged;
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $update = DB::table('profile')->where('id', $request->id)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }


        if($update){

            //update user table name and email incase it changed

            $userdata = array();

            $userdata['name'] = $fname.' '.$sname.' '.$onames;
            $userdata['email'] = $email;

            $updateuser = DB::table('users')->where('profileid', $request->id)->update($userdata);

            
            //log the event

            $this->logevent("Updated staff data of staff with staff id ".$staffid." and email ".$email." to the database");


            //send email to the staff

            //send password and public key to admin email
            $username = $fname;
            $useremail = $email;
            
            try{
                //send email to the person concerned
                Mail::send('emails.editprofileemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                $message->to($useremail, $username)->subject('Your profile was updated at Relia Energy ERP');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }

            return response()->json([
                'message' => 'success',
                'id' => $request->id,
                'info' => 'Staff profile successfully updated'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update staff profile for staff with ".$staffid." and email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff update could not be completed at the moment, please try again'
            ]);

        }

    }


    public function stafftable(){
        
    if($this->checkrole(Auth::user()->role, 4, 2) == "allow"){

        $staffs = DB::table('profile')->orderBy('firstname')->get();
        //dd($staffs);

        return view('stafftable', ['staffs' => $staffs]);
        
    }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    public function usertable(){
        
    if($this->checkrole(Auth::user()->role, 4, 2) == "allow"){

        $users = DB::table('users')->orderBy('name')->get();

        return view('usertable', ['users' => $users]);
        
    }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    public function userprofile(Request $request){


        $user = DB::table('users')->where('id', $request->id)->get();

        $roles = DB::table('role')->orderBy('role', 'asc')->get();

        return view('edit-user', ['user' => $user, 'roles' => $roles]);

    }


    public function submitedituser(Request $request){

        $role = $request->role;
        $status = $request->status;

        $data = array();

        $data['role'] = $role;
        $data['status'] = $status;
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $update = DB::table('users')->where('id', $request->id)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Updated user data of user with user id ".$request->id);


            return response()->json([
                'message' => 'success',
                'info' => 'User data successfully updated'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update user data for user with user id ".$staffid." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'User update could not be completed at the moment, please try again'
            ]);

        }
    }


    public function updateprofile(){

        $staff = DB::table('profile')->where('id', Auth::user()->profileid)->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        return view('update-profile', ['banks' => $banks, 'staff' => $staff]);
    }


    public function submitupdateprofile(Request $request){


        $fname = $request->fname;
        $staffid = $request->staffid;
        $onames = $request->onames;
        $sname = $request->sname;
        $doe = $request->doe;
        $department = $request->department;
        $gender = $request->gender;
        $designation = $request->designation;
        $dob = $request->dob;
        $office = $request->office;
        $email = $request->email;
        $accountno = $request->accountno;
        $phone = $request->phone;
        $bank = $request->bank;
        $employmentstatus = $request->employmentstatus;
        $datechanged = $request->datechanged;

        //check if the email provided is already in use
        $checkemail = DB::table('profile')->where([['email', $email],['id', '!=', Auth::user()->profileid]])->count();

        if($checkemail == 1){

            
            //log the event

            $this->logevent("Attempted update staff profile with email ".$email." to the database, but failed because the email is already in use by another staff");


            return response()->json([
                'message' => 'error',
                'info' => 'Email address provided is currently in use by another staff'
            ]);

            }else{

            //check if the staff already exist using staff id
            $checkemail = DB::table('profile')->where([['staffid', $staffid],['id', '!=', Auth::user()->profileid]])->count();


            if($checkemail == 1){

            
            //log the event

            $this->logevent("Attempted to update staff with staff id ".$staffid." to the database, but failed because the staff id is already in use by another staff");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff ID provided is currently in use by another staff'
            ]);
            
            }

        }


        $data = array();

        $data['staffid'] = $staffid;
        $data['surname'] = $sname;
        $data['firstname'] = $fname;
        $data['othername'] = $onames;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['dob'] = $dob;
        $data['doe'] = $doe;
        $data['department'] = $department;
        $data['designation'] = $designation;
        $data['office'] = $office;
        $data['gender'] = $gender;
        $data['accountno'] = $accountno;
        $data['bankname'] = $bank;
        $data['employmentstatus'] = $employmentstatus;
        $data['datechanged'] = $datechanged;
        $data['updated_at'] = date('Y-m-d H:i:s');

        
        try {

            $update = DB::table('profile')->where('id', Auth::user()->profileid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }


        if($update){

            //update user table name and email incase it changed

            $userdata = array();

            $userdata['name'] = $fname.' '.$sname.' '.$onames;
            $userdata['email'] = $email;

            $updateuser = DB::table('users')->where('profileid', Auth::user()->profileid)->update($userdata);

            
            //log the event

            $this->logevent("Updated staff data of staff with staff id ".$staffid." and email ".$email." to the database");


            //send email to the staff

            //send password and public key to admin email
            $username = $fname;
            $useremail = $email;
            
            try{
                //send email to the person concerned
                Mail::send('emails.editprofileemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                $message->to($useremail, $username)->subject('Your profile was updated at Relia Energy ERP');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }

            return response()->json([
                'message' => 'success',
                'id' => $request->id,
                'info' => 'Staff profile successfully updated'
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update staff profile for staff with ".$staffid." and email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Staff update could not be completed at the moment, please try again'
            ]);

        }

    }


    //upload staff profile pics

    public function submitmypics(Request $request){

        $pics = $request->file('pics');
        $user = Auth::user()->profileid;

        $email = DB::table('profile')->where('id', $user)->value('email');

        try{
            $picsurl = $pics->store('assets/profile');
        } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading signature, reduce the file size of try a different file.'
                    ]);
                }

        
        try {

            $update = DB::table('profile')->where('id', $user)->update(['image' => $picsurl]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated the profile image of the staff  with the email ".$email." in the database");

            return response()->json([
                'message' => 'success',
                'id' => $user
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update the profile image of the staff with the email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error'
            ]);

        }
    }


    //upload staff signature

    public function submitmysignature(Request $request){

        $pics = $request->file('pics');
        $user = Auth::user()->profileid;

        $email = DB::table('profile')->where('id', $user)->value('email');

        try{
            $picsurl = $pics->store('assets/profile');
        } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading signature, reduce the file size of try a different file.'
                    ]);
                }

        
        try {

            $update = DB::table('profile')->where('id', $user)->update(['signature' => $picsurl]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }

        if($update){

            
            //log the event

            $this->logevent("Successfully updated the signature of the staff  with the email ".$email." in the database");

            return response()->json([
                'message' => 'success',
                'id' => $user
            ]);

        }else{

            
            //log the event

            $this->logevent("Attempted to update the signature of the staff with the email ".$email." to the database, but failed");


            return response()->json([
                'message' => 'error'
            ]);

        }
    }


    public function uploadmysignature(){

        return view('upload-mysignature');
    }


    public function uploadmypics(){

        return view('upload-mypics');
    }

    public function changepassword(){

        return view('changepassword');
    }


    public function submitpassword(Request $request){

        $currentpassword = $request->currentpassword;
        $newpasswrod = $request->newpassword;
        $newpasswordagain = $request->newpasswordagain;

        $systempassword = DB::table('users')->where('id', Auth::user()->id)->value('password');

        if($newpasswrod != $newpasswordagain){

            
            //log the event

            $this->logevent("Attempted to change password but could not complete the process because new password did not match");


            return response()->json([
                'message' => 'error',
                'info' => 'New password did not match'
            ]);

        }else if(!Hash::check($currentpassword, $systempassword)){

            
            //log the event

            $this->logevent("Attempted to change password but could not complete the process because the current password provided did not match the database password");


            return response()->json([
                'message' => 'error',
                'info' => 'Current password provided did not match the password stored for this user in the database'
            ]);

        }else{

            
            try {

            $update = DB::table('users')->where('id', Auth::user()->id)->update(['password' => Hash::make($newpasswrod), 'updated_at' => date('Y-m-d H:i:s')]);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                ]);
            }


            if($update){

            
            //log the event

            $this->logevent("User successfully updated their password");


            //send email to the staff
            $username = Auth::user()->name;
            $useremail = Auth::user()->email;
            
            try{
                //send email to the person concerned
                Mail::send('emails.passwordchangeemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                $message->to($useremail, $username)->subject('Your password at the Relia Energy ERP was successly chaged.');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }

            return response()->json([
                'message' => 'success',
                'info' => 'Password successfully changed'
            ]);
            }

        }
    }


    public function deletedepartment(Request $request){

        $department = DB::table('departments')->where('id', $request->id)->value('departments');

        try {

            $delete = DB::table('departments')->where('id', $request->id)->limit(1)->delete();

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, please try again'
                ]);
            }

        if($delete){

            //log the event

            $this->logevent("Successfully deleted the department ".$department." from the database");

            return response()->json([
                "message" => "success",
                "info" => "Department ".$department." successfully removed from the database"
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to delete the department ".$department." from the database but failed");

            return response()->json([
                "message" => "error",
                "info" => "Error deleting Department ".$department." please try again."
            ]);
        }

        
    }



    public function deletedesignation(Request $request){

        $designation = DB::table('designations')->where('id', $request->id)->value('designations');

        try {

            $delete = DB::table('designations')->where('id', $request->id)->limit(1)->delete();

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, please try again'
                ]);
            }

        if($delete){

            //log the event

            $this->logevent("Successfully deleted the designation ".$designation." from the database");

            return response()->json([
                "message" => "success",
                "info" => "Designation ".$designation." successfully removed from the database"
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to delete the designation ".$designation." from the database but failed");

            return response()->json([
                "message" => "error",
                "info" => "Error deleting Designation ".$designation." please try again."
            ]);
        }
    }



    public function deleteoffice(Request $request){

        $office = DB::table('offices')->where('id', $request->id)->value('offices');

        try {

            $delete = DB::table('offices')->where('id', $request->id)->limit(1)->delete();

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, please try again'
                ]);
            }

        if($delete){

            //log the event

            $this->logevent("Successfully deleted the office ".$office." from the database");

            return response()->json([
                "message" => "success",
                "info" => "Office ".$office." successfully removed from the database"
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to delete office ".$office." from the database but failed");

            return response()->json([
                "message" => "error",
                "info" => "Error deleting office ".$office." please try again."
            ]);
        }
    }





    public function deletebank(Request $request){

        $bank = DB::table('banks')->where('id', $request->id)->value('banks');

        try {

            $delete = DB::table('banks')->where('id', $request->id)->limit(1)->delete();

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, please try again'
                ]);
            }

        if($delete){

            //log the event

            $this->logevent("Successfully deleted bank ".$bank." from the database");

            return response()->json([
                "message" => "success",
                "info" => "Bank ".$bank." successfully removed from the database"
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to delete bank ".$bank." from the database but failed");

            return response()->json([
                "message" => "error",
                "info" => "Error deleting bank ".$bank." please try again."
            ]);
        }
    }


    public function companyinfo(){

        $infos = DB::table('companyinfo')->get();

        return view('companyinfo', ['infos' => $infos]);
    }


    public function submitinfo(Request $request){

        $address = $request->address;
        $email = $request->email;
        $phone = $request->phone;
        $city = $request->city;
        $rc = $request->rc;
        $state = $request->state;
        $website = $request->website;
        $tin = $request->tin;
        $logo = $request->file('logo');

        $data = array();

        $data['address'] = $address;
        $data['city'] = $city;
        $data['state'] = $state;
        $data['rc'] = $rc;
        $data['email'] = $email;
        $data['phone'] = $phone;
        $data['website'] = $website;
        $data['tin'] = $tin;
        if(!empty($logo)){
            $logourl = $logo->store('assets/images');
            $data['logo'] = $logourl;
        }
        
        $create = DB::table('companyinfo')->insert($data);

        if($create){
            return response()->json([
                "message" => "success",
                "info" => "Company info successfully created"
            ]);
        }
    }


    public function deleteinfo(Request $request){

        $info = DB::table('companyinfo')->where('id', $request->id)->value('city');

        try {

            $delete = DB::table('companyinfo')->where('id', $request->id)->limit(1)->delete();

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, please try again.'
                ]);
            }

        if($delete){

            //log the event

            $this->logevent("Successfully deleted company info for ".$info." office");

            return response()->json([
                "message" => "success",
                "info" => "Company info for ".$info." office successfully removed from the database"
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to delete company info for ".$info." office from the database but failed");

            return response()->json([
                "message" => "error",
                "info" => "Error deleting company info for ".$info." office, please try again."
            ]);
        }

    }

    
}

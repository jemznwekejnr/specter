<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;

class CircularController extends Controller
{
    //Circular Backend

    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createcircular(){
        
        if($this->checkrole(Auth::user()->role, 3, 6) == "allow"){

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        return view('createcircular', ['staffs' => $staffs]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function circulardetails(Request $request){
        
        if($this->checkrole(Auth::user()->role, 3, 2) == "allow"){

        $circular = DB::table('circular')->where('id', $request->id)->get();

        $actions = DB::table('processes')->where('process', 'Circulars')->value('actions');

        return view('circulardetails', ['circular' => $circular, 'actions' => $actions]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function listcirculars(){
        
        if($this->checkrole(Auth::user()->role, 10, 2) == "allow"){

        $circluars = DB::table('circular')->orderBy('created_at', 'desc')->get();

        return view('listcirculars', ['circluars' => $circluars]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function mycirculars(){
        
        if($this->checkrole(Auth::user()->role, 3, 2) == "allow"){

        $circluars = DB::table('circular_recipeint')->where('recipient', Auth::user()->profileid)->orderBy('created_at', 'desc')->get();

        return view('mycirculars', ['circluars' => $circluars]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }

    }


    public function submitcircularstatus(Request $request){

        $data = array();

        $data['status'] = $request->status;
        $data['reacted_by'] = Auth::user()->profileid;
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

        $update = DB::table('circular')->where('id', $request->id)->update($data);

        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return response()->json([
                'message' => 'error',
                'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
            ]);
        }

        if($update){

            if($request->status == "Approved"){

                //get the recipients of the circular
                $recipients = DB::table('circular_recipeint')->where('circularid', $request->id)->get();

                foreach($recipients as $recipient){

                    //send email to recipients
                    $username = $this->staffname($recipient->recipient);
                    $useremail = $this->staffemail($recipient->recipient);
                    
                    try{
                        //send email to the person concerned
                        Mail::send('emails.circularemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New circular has been created at Relia Energy ERP.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //send notification message to every staff
                    $this->createnotification($recipient->id, 'Circular', $request->title, 'Unread', 'mycirculars');
                }

                //log the event

                    $this->logevent("Successfully approved a circular with id ".$request->id);

                    return response()->json([
                        'message' => 'success',
                        'info' => 'Circular successfully approved'
                    ]);

            }else if($request->status == "Rejected"){

                //get the recipients of the circular
                $sender = DB::table('circular')->where('id', $request->id)->value('sentform');

                

                    //send email to recipients
                    $username = $this->staffname($sender);
                    $useremail = $this->staffemail($sender);
                    
                    try{
                        //send email to the person concerned
                        Mail::send('emails.circularreactemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('Your circular was rejected.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //send notification message to every staff
                    $this->createnotification($sender, 'Circular', $request->title, 'Unread', 'mycirculars');

                    //log the event

                    $this->logevent("Successfully rejected a circular with id ".$request->id);

                    return response()->json([
                        'message' => 'success',
                        'info' => 'Circular rejected successfully'
                    ]);
                
            }

        }

    }


    public function submitcircular(Request $request){

        $title = $request->title;
        $body = $request->body;
        $recipient = $request->recipient;
        $attachment = $request->attachment;


        if($recipient[0] == "All Staff"){

            $staffs = DB::table('profile')->where('employmentstatus', 'Active Employment')->get();


                $data = array();

                $data['sentform'] = Auth::user()->profileid;
                $data['title'] = $title;
                $data['body'] = $body;
                $data['total_recipient'] = $staffs->count();
                if(!empty($attachment)){
                    try{
                        $attachmenturl = $attachment->store('assets/attachment');
                        $data['attachment'] = $attachmenturl;
                    } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading attachment, reduce the file size of try a different file.'
                    ]);
                }
                }
                $data['status'] = "Pending";
                $data['created_at'] = date('Y-m-d H:i:s');

                try {

                $create = DB::table('circular')->insertGetId($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                    ]);
                }

            if($create){

                foreach($staffs as $staff){

                    $datas = array();

                    $datas['circularid'] = $create;
                    $datas['recipient'] = $staff->id;

                    $datas['created_at'] = date('Y-m-d H:i:s');

                    try {

                    $insert = DB::table('circular_recipeint')->insert($datas);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }


                    
                }


                $getstaffs = DB::table('privileges')
                        ->where([
                                    ['privilege', 3],
                                    ['action', 1]
                                ])
                        ->orWhere([
                                    ['privilege', 3],
                                    ['action', 3]
                                ])
                        ->get();

                foreach($getstaffs as $getstaff){

                    //send email to actors
                    $username = DB::table('users')->where([['role', $getstaff->role],['status', 'Active']])->value('name');
                    $useremail = DB::table('users')->where([['role', $getstaff->role],['status', 'Active']])->value('email');
                    
                    try{
                        //send email to the person concerned
                        Mail::send('emails.circularstatusemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New circular created, awaiting your approval.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //send notification message to every staff
                    $this->createnotification($staff->id, 'Circular', $title, 'Unread', 'listcirculars');



                    }



                    //log the event

                    $this->logevent("Successfully created new circular ".$title);

                    return response()->json([
                        'message' => 'success',
                        'info' => 'Circular successfully created'
                    ]);

            }else{


                //log the event

                $this->logevent("Attempted to create new circular ".$title." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Unable to create circular at the moment, please try again'
                ]);


            }

        }else{

            

                $data = array();

                $data['sentform'] = Auth::user()->profileid;
                $data['title'] = $title;
                $data['body'] = $body;
                $data['total_recipient'] = count($recipient);
                if(!empty($attachment)){
                    try{
                        $attachmenturl = $attachment->store('assets/attachment');
                        $data['attachment'] = $attachmenturl;
                    } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading attachment, reduce the file size of try a different file.'
                    ]);
                }
                }
                $data['status'] = "Pending";
                $data['created_at'] = date('Y-m-d H:i:s');

                try {

                $create = DB::table('circular')->insertGetId($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again'
                    ]);
                }


                if($create){

                    for($i=0; $i<count($recipient); $i++){

                    $datas = array();

                    $datas['circularid'] = $create;
                    $datas['recipient'] = $recipient[$i];

                    $datas['created_at'] = date('Y-m-d H:i:s');

                    try {

                    $insert = DB::table('circular_recipeint')->insert($datas);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }
                    
                }


                $getstaffs = DB::table('privileges')
                        ->where([
                                    ['privilege', 3],
                                    ['action', 1]
                                ])
                        ->orWhere([
                                    ['privilege', 3],
                                    ['action', 3]
                                ])
                        ->get();

                foreach($getstaffs as $getstaff){

                    //send email to actors
                    $username = DB::table('users')->where([['role', $getstaff->role],['status', 'Active']])->value('name');
                    $useremail = DB::table('users')->where([['role', $getstaff->role],['status', 'Active']])->value('email');
                    
                    try{
                        //send email to the person concerned
                        Mail::send('emails.circularstatusemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New circular created, awaiting your approval.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //send notification message to every staff
                    $this->createnotification($staff->id, 'Circular', $title, 'Unread', 'listcirculars');


                    }


                    //log the event

                    $this->logevent("Successfully created new circular ".$title);

                    return response()->json([
                        'message' => 'success',
                        'info' => 'Circular successfully created'
                    ]);

            }else{

                //log the event

                $this->logevent("Attempted to create new circular ".$title." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Unable to create circular at the moment, please try again'
                ]);


            }
        }

    }
}

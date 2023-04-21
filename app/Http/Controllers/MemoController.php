<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;

class MemoController extends Controller
{
    //Memo backend here

    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function creatememo(){
        
        if($this->checkrole(Auth::user()->role, 1, 6) == "allow"){

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        return view('creatememo', ['staffs' => $staffs]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    

    public function memoinbox(){
        
        if($this->checkrole(Auth::user()->role, 1, 2) == "allow"){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Memo'],['location', 'memoinbox']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $memos = DB::table('memo')
                    ->where('sendto', Auth::user()->profileid)
                    ->orWhere('copies', 'LIKE', '%'.Auth::user()->profileid.'%')->get();

        return view('memoinbox', ['memos' => $memos]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function sentmemo(){
        
        if($this->checkrole(Auth::user()->role, 1, 2) == "allow"){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Memo'],['location', 'sentmemo']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $memos = DB::table('memo')->where('sentform', Auth::user()->profileid)->get();

        return view('sentmemo', ['memos' => $memos]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function allmemo(){
        
        if($this->checkrole(Auth::user()->role, 5, 2) == "allow"){

        $memos = DB::table('memo')->orderBy('created_at', 'desc')->get();

        return view('allmemo', ['memos' => $memos]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function submitmemo(Request $request){

        $title = $request->title;
        $body = $request->memobody;
        $recipient = $request->sendto;
        $copies = $request->copies;
        $attachment = $request->attachment;
        $sender = Auth::user()->profileid;
        $status = 'Pending';


        //check if this memo was submitted earlier incase of network failure

        $checkmemo = DB::table('memo')
                    ->where([
                            ['sentform', $sender],
                            ['title', $title],
                            ['body', $body],
                            ['status', $status],
                            ['sendto', $sender],
                            ['copies', $copies]
                    ])->count();

        if($checkmemo == 1){

            $this->logevent("Attempted to create new memo but failed because the memo has been created earlier");


            return response()->json([
                'message' => 'error',
                'info' => 'Memo creation failed because the memo already exist in the database'
            ]);

        }else{


            

            //insert memo in to the database
            $data = array();

            $data['sentform'] = $sender;
            $data['title'] = $title;
            $data['body'] = $body;
            $data['status'] = $status;
            $data['sendto'] = $recipient;
            if(!empty($copies)){
            $data['copies'] = implode($copies, ",");
            }
            if(!empty($attachment)){
                try{
                    $attachmenturl = $attachment->store('assets/attachments');
                    $data['attachment'] = $attachmenturl;
                } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading attachment, reduce the file size of try a different file.'
                    ]);
                }
            }
            $data['created_at'] = date('Y-m-d H:i:s');

            try {

            $create = DB::table('memo')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

            if($create){

                //send email to actors
                $username = $this->staffname($recipient);
                $useremail = $this->profileemail($recipient);
                
                try{
                    //send email to the person concerned
                    Mail::send('emails.sentmemoemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                    $message->to($useremail, $username)->subject('New memo requires your attention.');
                    $message->from('erp@reliaenergy.com', 'ERP');
                    });
                }catch(\Exception $e){
                    
                }

                //create recipient notification

                $this->createnotification($recipient, 'Memo', $title, 'Unread', 'memoinbox');

                //send email to copies
                if(!empty($copies)){
                $total = count($copies);

                for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($copies[$i]);
                $useremail = $this->profileemail($copies[$i]);
                
                    try{
                        //send email to the person concerned
                        Mail::send('emails.sentmemoemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New memo requires your attention.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }

                }


                //create copies notifications
                for($j=0; $j<$total; $j++){

                    $this->createnotification($copies[$j], 'Memo', $title, 'Unread', 'memoinbox');

                }

                }


                

                //log the event
                $this->logevent("Created new memo ".$title);

                return response()->json([
                    'message' => 'success',
                    'info' => 'Memo successfully created'
                ]);


                
            }
            
        }


    }



    public function memodetails(Request $request){

    if($this->checkrole(Auth::user()->role, 1, 2) == "allow"){

        $memo = DB::table('memo')->where('id', $request->id)->get();

        $actions = DB::table('processes')->where('process', 'Memo')->value('actions');

        $memotrails = DB::table('memotrail')->where('memoid', $request->id)->orderBy('created_at', 'desc')->get();

        return view('memodetails', ['memo' => $memo, 'memotrails' => $memotrails, 'actions' => $actions]);
        
    }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    public function memoreaction(Request $request){

        $status = $request->status;
        $remarks = $request->remarks;
        $sentfrom = $request->sentfrom;
        $title = $request->title;

        $data = array();

        $data['status'] = $status;
        $data['updated_at'] = date('Y-m-d H:i:s');

        try {

            $update = DB::table('memo')->where('id', $request->id)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }


        if($update){

        $data['memoid'] = $request->id;
        $data['remark'] = $remarks;
        $data['actor'] = Auth::user()->profileid;
        $data['actor_type'] = 'Recipient';
        $data['created_at'] = date('Y-m-d H:i:s');
        
        try {

            $trail = DB::table('memotrail')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

        //send email to owner of the memo
        $username = $this->staffname($sentfrom);
        $useremail = $this->profileemail($sentfrom);
        
        try{
            //send email to the person concerned
            Mail::send('emails.memoreplyemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
            $message->to($useremail, $username)->subject('Update on one of your memo.');
            $message->from('erp@reliaenergy.com', 'ERP');
            });
        }catch(\Exception $e){
            
        }


        //create recipient notification

        $this->createnotification($sentfrom, 'Memo', $title, 'Unread', 'sentmemo');

        //log the event

        $this->logevent("Successfully updated a memo with the title ".$title);


        return response()->json([
            'message' => 'success',
            'info' => 'Memo successfully updated'
        ]);
         

        }

    }



    public function editmemo(Request $request){

        if($this->checkrole(Auth::user()->role, 1, 7) == "allow"){
            
            $memo = DB::table('memo')->where('id', $request->id)->get();

            return view('editmemo',['memo' => $memo]);
            
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
        
    }


    public function submiteditmemo(Request $request){

        
        $memodetails = DB::table('memo')->where('id', $request->id)->get();

        //dd($memodetails);

        $olddata = array();

        $olddata['memoid'] = $request->id;
        $olddata['title'] = $memodetails[0]->title;
        $olddata['body'] = $memodetails[0]->body;
        $olddata['attachment'] = $memodetails[0]->attachment;
        $olddata['actor'] = Auth::user()->profileid;
        $olddata['actor_type'] = 'Sender';
        $olddata['created_at'] = date('Y-m-d H:i:s');


        
        try {

            $trail = DB::table('memotrail')->insert($olddata);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again'
                ]);
            }

        
        $data = array();

        $data['title'] = $request->title;
        $data['body'] = $request->memobody;
        if(!empty($request->attachment)){
            try{
                $attachment = $request->file('attachment');
                $attachmenturl = $attachment->store('assets/attachments');
                $data['attachment'] = $attachmenturl;
            } catch (\Exception $e) {
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error uploading attachment, reduce the file size of try a different file.'
                    ]);
                }
        }

        
        try {

            $update = DB::table('memo')->where('id', $request->id)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }


        if($update){

        //send email to actors
        $username = $this->staffname($memodetails[0]->sendto);
        $useremail = $this->profileemail($memodetails[0]->sendto);
        
        try{
            //send email to the person concerned
            Mail::send('emails.editmemoemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
            $message->to($useremail, $username)->subject('A memo sent to you was updated.');
            $message->from('erp@reliaenergy.com', 'ERP');
            });
        }catch(\Exception $e){
            
        }

        //create recipient notification

        $this->createnotification($memodetails[0]->sendto, 'Memo', $request->title, 'Unread', 'memoinbox');

        //send email to copies
        $copies = $memodetails[0]->copies;

        if(!empty($copies)){

        $totalcopy = explode(",", $copies);

        $total = count($totalcopy);

        for($i=0; $i<$total; $i++){

            //send email to actors
        $username = $this->staffname($totalcopy[$i]);
        $useremail = $this->profileemail($totalcopy[$i]);
        
            try{
                //send email to the person concerned
                Mail::send('emails.editmemoemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                $message->to($useremail, $username)->subject('A memo you were copied was updated.');
                $message->from('erp@reliaenergy.com', 'ERP');
                });
            }catch(\Exception $e){
                
            }

            //create copies notifications

            $this->createnotification($totalcopy[$i], 'Memo', $request->title, 'Unread', 'memoinbox');

        }

        }

        //log the event

        $this->logevent("Successfully updated a memo with the title ".$request->title);


        return response()->json([
            'message' => 'success',
            'info' => 'Memo successfully updated'
        ]); 



    }

}


    
}

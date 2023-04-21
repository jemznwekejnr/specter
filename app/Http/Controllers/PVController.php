<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;

class PVController extends Controller
{
    //Payment Voucher Backend

    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function paymentvoucher(){
        
        if($this->checkrole(Auth::user()->role, 2, 6) == "allow"){

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        $projects = DB::table('projects')->where('status', 'Ongoing')->orderBy('title', 'asc')->get();

        return view('paymentvoucher', ['staffs' => $staffs, 'banks' => $banks, 'projects' => $projects]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function pvdetails(Request $request){
        
        if($this->checkrole(Auth::user()->role, 2, 2) == "allow"){

        $pvs = DB::table('pv')->where('id', $request->id)->get();

        $vsheets = DB::table('vouchersheet')->where('pvid', $pvs[0]->id)->get();

        $actions = DB::table('processes')->where('process', 'Payment Voucher')->value('actions');

        $pvtrails = DB::table('pvtrail')->where('pvid', $pvs[0]->id)->orderBy('created_at', 'desc')->get();

        return view('pvdetails', ['pvs' => $pvs, 'vsheets' => $vsheets, 'pvtrails' => $pvtrails, 'actions' => $actions]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }

    public function allpvs(Request $reqtuest){
        
        if($this->checkrole(Auth::user()->role, 6, 2) == "allow"){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Payment Voucher'],['location', 'allpvs']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $pvs = DB::table('pv')->orderBy('created_at', 'desc')->get();


        return view('allpvs', ['pvs' => $pvs]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }


    public function editpv(Request $reqtuest){
        
        if($this->checkrole(Auth::user()->role, 2, 7) == "allow"){

        $pvs = DB::table('pv')->orderBy('created_at', 'desc')->get();

        $vsheets = DB::table('vouchersheet')->where('pvid', $pvs[0]->id)->get();

        return view('editpv', ['pvs' => $pvs, 'vsheets' => $vsheets]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }

    }


    public function submitpv(Request $request){

        //dd($request);

        $title = $request->title;
        $sendto = $request->sendto;
        $copies = $request->copies;
        $body = $request->body;
        $attachment = $request->attachment;
        $bankname = $request->bankname;
        $accountnumber = $request->accountnumber;
        $accountname = $request->accountname;
        $amountinwords = $request->amountinwords;
        $project = $request->project;

        $data = array();

        $data['sentform'] = Auth::user()->profileid;
        $data['title'] = $title;
        $data['sendto'] = $sendto;
        if(!empty($copies)){
        $data['copies'] = implode($copies, ",");
        }
        $data['body'] = $body;
        $data['status'] = 'Pending';

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
        $data['bank'] = $bankname;
        $data['accountno'] = $accountnumber;
        $data['accountname'] = $accountname;

        $data['totalprice'] = $request->totalprices;
        $data['totalamount'] = $request->totalamounts;
        $data['totalvat'] = $request->totalvats;
        $data['totalgross'] = $request->totalgrosses;
        $data['totalwht'] = $request->totalwhts;
        $data['totalnet'] = $request->totalnets;
        $data['amountinwords'] = $request->amountinwords;
        $data['project'] = $request->project;
        $data['created_at'] = date('Y-m-d H:i:s');


        
        try {

            $create = DB::table('pv')->insertGetId($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

        if($create){

            $count = count($request->description);

            for($i=0; $i<$count; $i++){

                $description = $request->description;
                $qty = $request->qty;
                $price = $request->price;
                $amounts = $request->amounts;
                $vatp = $request->vatp;
                $vata = $request->vata;
                $gross = $request->gross;
                $whtp = $request->whtp;
                $whta = $request->whta;
                $net = $request->net;

                $sdata = array();

                $sdata['pvid'] = $create;
                $sdata['description'] = $description[$i];
                $sdata['qty'] = $qty[$i];
                $sdata['unitprice'] = $price[$i];
                $sdata['amount'] = $amounts[$i];
                $sdata['vatpercent'] = $vatp[$i];
                $sdata['vatamount'] = $vata[$i];
                $sdata['grossamount'] = $gross[$i];
                $sdata['whtpercent'] = $whtp[$i];
                $sdata['whtamount'] = $whta[$i];
                $sdata['netamount'] = $net[$i];
                $sdata['created_at'] = date('Y-m-d H:i:s');

                
                try {

                $addsheet = DB::table('vouchersheet')->insert($sdata);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                    ]);
                }

            }


            //send email to actors
            $username = $this->staffname($sendto);
            $useremail = $this->profileemail($sendto);


            try{
                    //send email to the person concerned
                    Mail::send('emails.sentpvemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                    $message->to($useremail, $username)->subject('New payment voucher requires your attention.');
                    $message->from('erp@reliaenergy.com', 'ERP');
                    });
                }catch(\Exception $e){
                    
                }

            //send notification to the actors on the system

            //create recipient notification

            $this->createnotification($sendto, 'Payment Voucher', $title, 'Unread', 'allpvs');

            if(!empty($copies)){
            $total = count($copies);

            for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($copies[$i]);
                $useremail = $this->profileemail($copies[$i]);

                try{
                        //send email to the person concerned
                        Mail::send('emails.sentpvemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New payment voucher requires your attenction.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                $this->createnotification($copies[$i], 'Payment Voucher', $title, 'Unread', 'allpvs');

            }

        }


            

            //log the event

            $this->logevent("Successfully created new payment voucher with the title ".$title);


            return response()->json([
                'message' => 'success',
                'info' => 'Payment Voucher successfully created'
            ]); 


        }else{


            //log the event

            $this->logevent("Attempted to create new payment voucher ".$title." but failed ");


            return response()->json([
                'message' => 'error',
                'info' => 'Payment voucher creation failed, please try again.'
            ]); 


        }
        
    }


    public function submiteditpv(Request $request){

        //dd($request);

        $title = $request->title;
        $sendto = $request->sendto;
        $copies = $request->copies;
        $body = $request->body;
        $attachment = $request->attachment;
        $bankname = $request->bankname;
        $accountnumber = $request->accountnumber;
        $accountname = $request->accountname;
        $amountinwords = $request->amountinwords;
        $project = $request->project;

        $data = array();

        
        $data['title'] = $title;
        $data['body'] = $body;

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
        $data['bank'] = $bankname;
        $data['accountno'] = $accountnumber;
        $data['accountname'] = $accountname;

        $data['totalprice'] = $request->totalprices;
        $data['totalamount'] = $request->totalamounts;
        $data['totalvat'] = $request->totalvats;
        $data['totalgross'] = $request->totalgrosses;
        $data['totalwht'] = $request->totalwhts;
        $data['totalnet'] = $request->totalnets;
        $data['amountinwords'] = $amountinwords;
        $data['project'] = $project;
        $data['updated_at'] = date('Y-m-d H:i:s');


        
        try {

            $update = DB::table('pv')->where('id', $request->id)->update($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                    ]);
                }

        if($update){

            $delete = DB::table('vouchersheet')->where('pvid', $request->id)->delete();

            $count = count($request->description);

            for($i=0; $i<$count; $i++){

                $description = $request->description[$i];
                $qty = $request->qty[$i];
                $price = $request->price[$i];
                $amounts = $request->amounts[$i];
                $vatp = $request->vatp[$i];
                $vata = $request->vata[$i];
                $gross = $request->gross[$i];
                $whtp = $request->whtp[$i];
                $whta = $request->whta[$i];
                $net = $request->net[$i];

                $sdata = array();

                $sdata['pvid'] = $request->id;
                $sdata['description'] = $description;
                $sdata['qty'] = $qty;
                $sdata['unitprice'] = $price;
                $sdata['amount'] = $amounts;
                $sdata['vatpercent'] = $vatp;
                $sdata['vatamount'] = $vata;
                $sdata['grossamount'] = $gross;
                $sdata['whtpercent'] = $whtp;
                $sdata['whtamount'] = $whta;
                $sdata['netamount'] = $net;
                $sdata['created_at'] = date('Y-m-d H:i:s');

                
                try {

                $addsheet = DB::table('vouchersheet')->insert($sdata);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                    ]);
                }

            }


            //create pv trail
            $pdata = array();

            $pdata['pvid'] = $request->id;
            $pdata['changes'] = $request->changes;
            $pdata['actor'] = Auth::user()->profileid;
            $pdata['actor_type'] = "Sender";
            $pdata['created_at'] = date('Y-m-d H:i:s');

            $pvtrail = DB::table('pvtrail')->insert($pdata);


            //send email to actors
            $username = $this->staffname($sendto);
            $useremail = $this->profileemail($sendto);


            try{
                    //send email to the person concerned
                    Mail::send('emails.editpvemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                    $message->to($useremail, $username)->subject('One of the payment voucher addressed to you have been updated.');
                    $message->from('erp@reliaenergy.com', 'ERP');
                    });
                }catch(\Exception $e){
                    
                }

                //create recipient notification
                $this->createnotification($sendto, 'Payment Voucher', $title, 'Unread', 'sentpvs');

            if(!empty($copies)){
            $total = count($copies);

            for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($copies[$i]);
                $useremail = $this->profileemail($copies[$i]);

                try{
                        //send email to the person concerned
                        Mail::send('emails.editpvemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('One of the payment voucher addressed to you have been updated.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }

                //create copies notifications
                $this->createnotification($copies[$i], 'Payment Voucher', $title, 'Unread', 'allpvs');

            }


            }
            

            //log the event

            $this->logevent("Successfully updated existing payment voucher with the title ".$title);


            return response()->json([
                'message' => 'success',
                'info' => 'Payment Voucher successfully updated.'
            ]); 


        }else{


            //log the event

            $this->logevent("Attempted to update existing payment voucher with ".$title." but failed ");


            return response()->json([
                'message' => 'error',
                'info' => 'Payment voucher update failed.'
            ]); 


        }

    }


    public function submitpvstatus(Request $request){

        $pvid = $request->pvid;
        $status = $request->status;
        $remark = $request->remark;
        $sentfrom = $request->sentfrom;
        $title = $request->title;
        //dd($request);

        try {
            $update = DB::table('pv')->where('id', $pvid)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

            } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                    ]);
                }

        if($update){
        

        $data = array();

        $data['pvid'] = $pvid;
        $data['status'] = $status;
        $data['remark'] = $remark;
        $data['actor'] = Auth::user()->profileid;
        $data['actor_type'] = "Recipient";
        $data['created_at'] = date('Y-m-d H:i:s');

        
        try {

                $insert = DB::table('pvtrail')->insert($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again, please try again'
                    ]);
                }

        if($update){

            //send email to the owner of the pv
            $username = $this->staffname($sentfrom);
            $useremail = $this->profileemail($sentfrom);

            try{
                    //send email to the person concerned
                    Mail::send('emails.statuspvemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                    $message->to($useremail, $username)->subject('Your Payment voucher has an update.');
                    $message->from('erp@reliaenergy.com', 'ERP');
                    });
                }catch(\Exception $e){
                    
                }


            //create recipient notification

            $this->createnotification($sentfrom, 'Payment Voucher', $title, 'Unread', 'sentpvs');

            //log the event

            $this->logevent("successfully update existing payment voucher with ".$title);


            return response()->json([
                'message' => 'success',
                'info' => 'Payment voucher update successful.'
            ]);

        }else{

            //log the event

            $this->logevent("Attempted to update payment voucher with title ".$title." but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Payment voucher update failed, please try again'
            ]);
        }

    }else{

        //log the event

            $this->logevent("Attempted to update payment voucher with title ".$title." but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Payment voucher update failed, please try again.'
            ]);
    }
    }


    public function sentpvs(){
        
        if($this->checkrole(Auth::user()->role, 2, 2) == "allow"){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Payment Voucher'],['location', 'sentpvs']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $pvs = DB::table('pv')->orderBy('created_at', 'desc')->where('sentform', Auth::user()->profileid)->get();

        return view('sentpvs', ['pvs' => $pvs]);
        
        }else{
            
            Auth::logout();
            
            return redirect('login');
        }
    }
}

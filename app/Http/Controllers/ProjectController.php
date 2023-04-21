<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Mail;

class ProjectController extends Controller
{
    //Project Backend
    //Authenticate user
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function projects(){

        $projects = DB::table('projects')->orderBy('created_at', 'desc')->get();

        return view('projects', ['projects' => $projects]);
    }

    public function createproject(){

        return view('createproject');
    }



    public function addtask(){

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        return view('addtask', ['staffs' => $staffs]);
    }


    public function submitproject(Request $request){


        $title = $request->title;
        $client = $request->client;
        $amount = $request->amount;
        $budget = $request->budget;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $attachment = $request->attachment;
        $description = $request->description;
        $created_by = Auth::user()->profileid;


         $checkproject = DB::table('projects')
                    ->where([
                            ['title', $title],
                            ['client', $client],
                            ['amount', $amount],
                            ['budget', $budget],
                            ['startdate', $startdate],
                            ['enddate', $enddate],
                            ['attachment', $attachment],
                            ['description', $description],
                    ])->count();


        if($checkproject > 0){

            $this->logevent("Attempted to create new project ".$title." but failed because the project already exist in the database");


            return response()->json([
                'message' => 'error',
                'info' => 'Project creation failed because the project already exist in the database'
            ]);

        }

        $data = array();

        $data['title'] = $title;
        $data['client'] = $client;
        $data['amount'] = $amount;
        $data['budget'] = $budget;
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['description'] = $description;
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
        $data['status'] = 'Ongoing';
        $data['created_by'] = $created_by;
        $data['created_at'] = date('Y-m-d H:i:s');

        try{

            $create = DB::table('projects')->insertGetId($data);

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error creating project, make sure all the required fields are provided then try again.'
                ]);
            }


        if($create){

                //log the event
                $this->logevent("Created new project ".$title);

                return response()->json([
                    'message' => 'success',
                    'info' => 'Project successfully created',
                    'pjid' => $create
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to create new project ".$title." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error creating project, please try again'
                ]);

        }
    }


    //submit task
    public function submittask(Request $request){

        //dd($request);

            $projectid = $request->projectid;
            $taskname = $request->taskname;
            $assignees = implode($request->assignees, ",");
            $startdate = $request->startdate;
            $enddate = $request->enddate;
            $description = $request->description;
            $priority = $request->priority;
            $attachment = $request->file('attachment');


            //check of this task has been created,
            $checktask = DB::table('task')
                    ->where([
                        ['projectid', $projectid],
                        ['taskname', $taskname],
                        ['assignees', $assignees],
                        ['startdate', $startdate],
                        ['enddate', $enddate],
                        ['description', $description]
                    ])->count();

            if($checktask > 0){

                $this->logevent("Attempted to create new task ".$taskname." for the project ".$this->projectname($projectid)." but failed because the project already exist in the database");


                return response()->json([
                    'message' => 'error',
                    'info' => 'Task creation failed because this task already exist in the database'
                ]);

            }

            $data = array();

            $data['projectid'] = $projectid;
            $data['taskname'] = $taskname;
            $data['assignees'] = $assignees;
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['description'] = $description;
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
            $data['priority'] = $priority;
            $data['status'] = "Pending";
            $data['created_by'] = Auth::user()->profileid;
            $data['created_at'] = date('Y-m-d H:i:s');

            try{
            
                $create = DB::table('task')->insert($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error creating task, make sure all the required fields are provided then try again.'
                ]);
            }


        if($create){

                //send email to copies
                $staffs = $request->assignees;
                $total = count($staffs);

                for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($staffs[$i]);
                $useremail = $this->profileemail($staffs[$i]);
                
                    try{
                        //send email to the person concerned
                        Mail::send('emails.taskassignemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New task requires your attention.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //create copies notifications
                    $this->createnotification($staffs[$i], 'Task', $taskname, 'Unread', 'projectdetails?id='.$projectid);

                }


                

                //log the event
                $this->logevent("Created new task ".$taskname." for the project ".$this->projectname($projectid));

                return response()->json([
                    'message' => 'success',
                    'info' => 'Task successfully created',
                    'pjid' => $projectid
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to create new task ".$taskname." for the project ".$this->projectname($projectid)." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error creating task, please try again'
                ]);

        }
        
    }


    //display project details
    public function projectdetails(Request $request){

        //update notification to read
        $update = DB::table('notifications')
                    ->where([['staff', Auth::user()->id], ['type', 'Task'], ['location', 'LIKE', '%id='.$request->pj]])
                    ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        
        //fetch project data
        $project = DB::table("projects")->where('id', $request->pj)->get();

        $tasks = DB::table("task")->where('projectid', $project[0]->id)->get();

        return view("projectdetails", ['project' => $project, 'tasks' => $tasks]);
    }


    //display task details
    public function taskdetails(Request $request){

        $tasks = DB::table("task")->where('id', $request->tk)->get();

        $actions = DB::table("processes")->where('process', "Task")->value('actions');

        $tasktrails = DB::table("tasktrail")->where('taskid', $request->tk)->orderBy('created_at', 'desc')->get();

        return view("taskdetails", ['tasks' => $tasks, 'actions' => $actions, 'tasktrails' => $tasktrails]);
    }


    //submit task update
    public function submittaskupdate(Request $request){

        $status = $request->status;
        $remarks = $request->remarks;
        $taskid = $request->taskid;

        $data = array();

        $data['taskid'] = $taskid;
        $data['status'] = $status;
        $data['remarks'] = $remarks;
        $data['actor'] = Auth::user()->profileid;
        if($request->owner == Auth::user()->profileid){
            $data['actor_type'] = 'Creator';
        }else{
            $data['actor_type'] = 'Assignee';
        }
        $data['created_at'] = date('Y-m-d H:i:s');

        try{

            $create = DB::table('tasktrail')->insert($data);

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating task, make sure all the required fields are provided then try again.'
                ]);
            }

        if($create){
            //update task table
            try{
                $update = DB::table('task')->where('id', $request->taskid)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating task, make sure all the required fields are provided then try again.'
                ]);
            }

            if($update){
                //send emails and create notifications
                if($request->owner == Auth::user()->profileid){ //send notification to the assignees

                    //send email to copies
                    $staffs = explode(",", $request->assignees);
                    $total = count($staffs);

                    for($i=0; $i<$total; $i++){

                    //send email to actors
                    $username = $this->staffname($staffs[$i]);
                    $useremail = $this->profileemail($staffs[$i]);
                    
                        try{
                            //send email to the person concerned
                            Mail::send('emails.taskupdateemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                            $message->to($useremail, $username)->subject('There is an update on a task assigned to you');
                            $message->from('erp@reliaenergy.com', 'ERP');
                            });
                        }catch(\Exception $e){
                            
                        }


                        //create copies notifications
                        $this->createnotification($staffs[$i], 'Task', $request->taskname, 'Unread', 'projectdetails?id='.$request->projectid);

                    }

                }else{ //send notification to the creator

                //send email to actors
                $username = $this->staffname($request->owner);
                $useremail = $this->profileemail($request->owner);
                
                    try{
                        //send email to the person concerned
                        Mail::send('emails.taskupdateemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('There is an update on a task you created at Relia Energy ERP.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //create copies notifications
                    $this->createnotification($request->owner, 'Task', $request->taskname, 'Unread', 'projectdetails?id='.$request->projectid);


                }


                //log the event
                $this->logevent("Successfully updated task ".$request->taskname." for the project ".$this->projectname($request->projectid));

                return response()->json([
                    'message' => 'success',
                    'info' => 'Task successfully updated'
                ]);
            }else{
                //log the event
                $this->logevent("Attempted to updated task ".$request->taskname." for the project ".$this->projectname($request->projectid).", but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating Task'
                ]);
            }
        }
        
    }


    public function edittask(Request $request){

        $task = DB::table('task')->where('id', $request->tk)->get();
        $staffs = DB::table('profile')->orderBy('firstname')->get();

        return view('edittask', ['task' => $task, 'staffs' => $staffs]);
    }


    public function submitedittask(Request $request){

            $projectid = $request->projectid;
            $taskname = $request->taskname;
            $assignees = implode($request->assignees, ",");
            $startdate = $request->startdate;
            $enddate = $request->enddate;
            $description = $request->description;
            $priority = $request->priority;
            $attachment = $request->file('attachment');


            $data = array();


            $data['projectid'] = $projectid;
            $data['taskname'] = $taskname;
            $data['assignees'] = $assignees;
            $data['startdate'] = $startdate;
            $data['enddate'] = $enddate;
            $data['description'] = $description;
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
            $data['priority'] = $priority;
            $data['status'] = "Pending";
            $data['updated_at'] = date('Y-m-d H:i:s');

            try{
            
                $update = DB::table('task')->where('id', $request->taskid)->update($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating task, make sure all the required fields are provided then try again.'
                ]);
            }


        if($update){

                //send email to assignees
                $staffs = $request->assignees;
                $total = count($staffs);

                for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($staffs[$i]);
                $useremail = $this->profileemail($staffs[$i]);
                
                    try{
                        //send email to the person concerned
                        Mail::send('emails.taskeditmail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('A task assigned to you was modified.');
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                    //create copies notifications
                    $this->createnotification($staffs[$i], 'Task', $taskname, 'Unread', 'projectdetails?id='.$projectid);

                }


                

                //log the event
                $this->logevent("Updated task ".$taskname." for the project ".$this->projectname($projectid));

                return response()->json([
                    'message' => 'success',
                    'info' => 'Task successfully Modified',
                    'tk' => $request->taskid
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to modify task ".$taskname." for the project ".$this->projectname($projectid)." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error editing task, please try again'
                ]);

        }
    }


    //delete task
    public function deletetask(Request $request){

        $task = DB::table('task')->where('id', $request->id)->get();

        $delete = DB::table('task')->where('id', $request->id)->limit(1)->delete();

        if($delete){

            //log the event
                $this->logevent("Deleted task ".$task[0]->taskname." from the project ".$this->projectname($task[0]->projectid));

                return response()->json([
                    'message' => 'success',
                    'info' => 'Task successfully Deleted',
                    'pjid' => $task[0]->projectid
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to delete task ".$task[0]->taskname." from the project ".$this->projectname($task[0]->projectid)." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error deleting task, please try again'
                ]);
        }
    }



    //edit project
    public function editproject(Request $request){

        $project = DB::table('projects')->where('id', $request->pj)->get();

        return view('editproject', ['project' => $project]);
    }


    //modify project
    public function submiteditproject(Request $request){

        $title = $request->title;
        $client = $request->client;
        $amount = $request->amount;
        $budget = $request->budget;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $attachment = $request->attachment;
        $description = $request->description;
        $created_by = Auth::user()->profileid;


        $data = array();

        $data['title'] = $title;
        $data['client'] = $client;
        $data['amount'] = $amount;
        $data['budget'] = $budget;
        $data['startdate'] = $startdate;
        $data['enddate'] = $enddate;
        $data['description'] = $description;
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
        $data['updated_at'] = date('Y-m-d H:i:s');

        try{

            $update = DB::table('projects')->where('id', $request->projectid)->update($data);

        } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating project, make sure all the required fields are provided then try again.'
                ]);
            }


        if($update){

                //log the event
                $this->logevent("Updated project ".$title);

                return response()->json([
                    'message' => 'success',
                    'info' => 'Project successfully updated.',
                    'pj' => $request->projectid
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to update project ".$title." but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error updating project, please try again.'
                ]);

        }

    }

    //delete project
    public function deleteproject(Request $request){

        $project = DB::table('projects')->where('id', $request->id)->get();


        $delete = DB::table('projects')->where('id', $request->id)->limit(1)->delete();

        if($delete){

            //delete all the task associated to it
            $remove = DB::table('task')->where('projectid', $request->id)->delete();

            //log the event
                $this->logevent("Deleted project ".$project[0]->title." and all the tasks assigned to it.");

                return response()->json([
                    'message' => 'success',
                    'info' => 'Project successfully Deleted'
                ]);

        }else{

            //log the event
                $this->logevent("Attempted to delete project ".$project[0]->title." and all the tasks assigned to it but failed.");

                return response()->json([
                    'message' => 'error',
                    'info' => 'Error deleting project, please try again'
                ]);
        }
    }


    public function createinvoice(){

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        $projects = DB::table('projects')->orderBy('created_at', 'desc')->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        $infos = DB::table('companyinfo')->get();

        return view('createinvoice', ['staffs' => $staffs, 'projects' => $projects, 'banks' => $banks, 'infos' => $infos]);
    }


    public function submitinvoice(Request $request){

        $currency = $request->currency;
        $project = $request->project;
        $office = $request->office;
        $copies = $request->copies;
        $bankname = $request->bankname;
        $accountnumber = $request->accountnumber;
        $accountname = $request->accountname;
        $amountinwords = $request->amountinwords;
        $clientdata = $request->clientdata;
        $vatp = $request->vatp;
        $whtp = $request->whtp;
        $branch = $request->branch;
        $sortcode = $request->sortcode;
        $ibanno = $request->ibanno;
        $invoicetype = $request->invoicetype;
        $refno = $request->refno;

        $data = array();

        $data['sentform'] = Auth::user()->profileid;
        $data['clientinfo'] = $clientdata;
        $data['office'] = $office;
        $data['invoicetype'] = $invoicetype;
        $data['currency'] = $currency;
        $data['refno'] = $refno;
        if(!empty($copies)){
        $data['copies'] = implode($copies, ",");
        }
        $data['status'] = 'Unpaid';
        $data['bank'] = $bankname;
        $data['accountno'] = $accountnumber;
        $data['accountname'] = $accountname;

        $data['branch'] = $branch;
        $data['sortcode'] = $sortcode;
        $data['ibanno'] = $ibanno;

        if($invoicetype == "Sheet 1"){
            $data['totalprice'] = $request->totalprices1;
            $data['totalamount'] = $request->totalamounts1;
            $data['totalvat'] = $request->vatamounts1;
            $data['totalwht'] = $request->whtamounts1;
            $data['vatp'] = $request->vatp1;
            $data['whtp'] = $request->whtp1;
            $data['sumamounts'] = $request->sumamounts1;
        }else if($invoicetype == "Sheet 2"){
            $data['totalprice'] = $request->totalprices2;
            $data['totalamount'] = $request->totalamounts2;
            $data['totalvat'] = $request->vatamounts2;
            $data['totalwht'] = $request->whtamounts2;
            $data['vatp'] = $request->vatp2;
            $data['whtp'] = $request->whtp2;
            $data['sumamounts'] = $request->sumamounts2;
        }else if($invoicetype == "Sheet 3"){
            $data['totalprice'] = $request->totalprices3;
            $data['totalamount'] = $request->totalamounts3;
            $data['totalvat'] = $request->vatamounts3;
            $data['totalwht'] = $request->whtamounts3;
            $data['vatp'] = $request->vatp3;
            $data['whtp'] = $request->whtp3;
            $data['sumamounts'] = $request->sumamounts3;
        }else if($invoicetype == "Sheet 4"){
            $data['totalprice'] = $request->totalprices4;
            $data['totalamount'] = $request->totalamounts4;
            $data['totalvat'] = $request->vatamounts4;
            $data['totalwht'] = $request->whtamounts4;
            $data['vatp'] = $request->vatp4;
            $data['whtp'] = $request->whtp4;
            $data['sumamounts'] = $request->sumamounts4;
        }

        
        $data['amountinwords'] = $request->amountinwords;
        $data['project'] = $request->project;
        $data['created_at'] = date('Y-m-d H:i:s');
        
        try {

            $create = DB::table('invoice')->insertGetId($data);

            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
                return response()->json([
                    'message' => 'error',
                    'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                ]);
            }

        if($create){

            $update = DB::table('invoice')->where('id', $create)->update(['invoiceno' => date('Y').date('m').date('d').$create]);

            if($invoicetype == "Sheet 1"){

                $count = count($request->description1);

                for($i=0; $i<$count; $i++){

                    $description = $request->description1;
                    $qty = $request->qty1;
                    $price = $request->price1;
                    $amounts = $request->amounts1;

                    $sdata = array();

                    $sdata['pvid'] = $create;
                    $sdata['description'] = $description[$i];
                    $sdata['qty'] = $qty[$i];
                    $sdata['unitprice'] = $price[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet1')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 2"){

                $count = count($request->description2);

                for($i=0; $i<$count; $i++){

                    $description = $request->description2;
                    $period = $request->period2;
                    $rate = $request->rate2;
                    $hours = $request->hours2;
                    $amounts = $request->amounts2;

                    $sdata = array();

                    $sdata['pvid'] = $create;
                    $sdata['description'] = $description[$i];
                    $sdata['period'] = $period[$i];
                    $sdata['rate'] = $rate[$i];
                    $sdata['hours'] = $hours[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet2')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 3"){

                $count = count($request->name3);

                for($i=0; $i<$count; $i++){

                    $name = $request->name3;
                    $designation = $request->designation3;
                    $location = $request->location3;
                    $amounts = $request->amounts3;

                    $sdata = array();

                    $sdata['pvid'] = $create;
                    $sdata['name'] = $name[$i];
                    $sdata['designation'] = $designation[$i];
                    $sdata['location'] = $location[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet3')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 4"){
            
                $count = count($request->description4);

                for($i=0; $i<$count; $i++){

                    $description = $request->description4;
                    $date = $request->date4;
                    $amounts = $request->amounts4;

                    $sdata = array();

                    $sdata['pvid'] = $create;
                    $sdata['description'] = $description[$i];
                    $sdata['date'] = $date[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet4')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }


            



            if(!empty($copies)){
            $total = count($copies);

            for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($copies[$i]);
                $useremail = $this->profileemail($copies[$i]);

                try{
                        //send email to the person concerned
                        Mail::send('emails.sentinvoiceemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('New client invoice created by '.Auth::user()->name);
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }


                $this->createnotification($copies[$i], 'Client Invoice', $clientdata, 'Unread', 'allinvoice');

            }

        }


            

            //log the event

            $this->logevent("Successfully created new client invoice for client ".$clientdata);


            return response()->json([
                'message' => 'success',
                'info' => 'Client invoice successfully created.',
                'iv' => $create
            ]); 


        }else{


            //log the event

            $this->logevent("Attempted to create new client invoice for client ".$clientdata." but failed ");


            return response()->json([
                'message' => 'error',
                'info' => 'Client invoice creation failed, please try again.'
            ]); 

        }
    }


    public function getclientinfo(Request $request){

        $clientdata = DB::table('projects')->where('id', $request->id)->value('client');

        return response()->json([
            'clientdata' => $clientdata
        ]);
    }


    public function allinvoices(){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Client Invoice'],['location', 'allinvoices']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $invoices = DB::table('invoice')->where('status', 'Unpaid')->orderBy('created_at', 'desc')->get();


        return view('allinvoices', ['invoices' => $invoices]);
    }


    public function invoicedetails(Request $request){

        $invoices = DB::table('invoice')->where('id', $request->id)->get();

        if($invoices[0]->invoicetype == "Sheet 1"){

            $invoicesheets = DB::table('invoicesheet1')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 2"){

            $invoicesheets = DB::table('invoicesheet2')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 3"){

            $invoicesheets = DB::table('invoicesheet3')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 4"){

            $invoicesheets = DB::table('invoicesheet4')->where('pvid', $request->id)->get();

        }

        $infos = DB::table('companyinfo')->get();

        $actions = DB::table('processes')->where('process', 'Client Invoice')->value('actions');

        $invoicetrails = DB::table('invoicetrail')->where('invoiceid', $request->id)->orderBy('created_at', 'desc')->get();

        return view('invoicedetails', ['invoices' => $invoices, 'vsheets' => $invoicesheets, 'pvtrails' => $invoicetrails, 'actions' => $actions, 'infos' => $infos]);
    }


    public function receiptdetails(Request $request){

        $invoices = DB::table('invoice')->where([['id', $request->id], ['status', 'Paid']])->get();

        if($invoices[0]->invoicetype == "Sheet 1"){

            $invoicesheets = DB::table('invoicesheet1')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 2"){

            $invoicesheets = DB::table('invoicesheet2')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 3"){

            $invoicesheets = DB::table('invoicesheet3')->where('pvid', $request->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 4"){

            $invoicesheets = DB::table('invoicesheet4')->where('pvid', $request->id)->get();

        }

        $infos = DB::table('companyinfo')->get();

        $actions = DB::table('processes')->where('process', 'Client Invoice')->value('actions');

        $invoicetrails = DB::table('invoicetrail')->where('invoiceid', $request->id)->orderBy('created_at', 'desc')->get();

        return view('receiptdetails', ['invoices' => $invoices, 'vsheets' => $invoicesheets, 'pvtrails' => $invoicetrails, 'actions' => $actions, 'infos' => $infos]);

    }


    public function submitinvoicestatus(Request $request){

        $invoiceid = $request->invoiceid;
        $invoicetype = $request->invoicetype;
        $status = $request->status;
        $remark = $request->remark;
        $sentfrom = $request->sentfrom;
        $project = $request->project;
        //dd($request);

        try {
            $update = DB::table('invoice')->where('id', $invoiceid)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);

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

        $data['invoiceid'] = $invoiceid;
        $data['invoicetype'] = $invoicetype;
        $data['status'] = $status;
        $data['remark'] = $remark;
        $data['actor'] = Auth::user()->profileid;
        $data['actor_type'] = "Recipient";
        $data['created_at'] = date('Y-m-d H:i:s');

        
        try {

                $insert = DB::table('invoicetrail')->insert($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                    ]);
                }

        if($update){

            $copies = explode(",", $request->copies);

            for($i=0; $i<count($copies); $i++){

            //send email to the owner of the pv
            $username = $this->staffname($copies[$i]);
            $useremail = $this->profileemail($copies[$i]);

            try{
                    //send email to the person concerned
                    Mail::send('emails.statusinvoiceemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                    $message->to($useremail, $username)->subject('Status of an invoice was updated to '.$status);
                    $message->from('erp@reliaenergy.com', 'ERP');
                    });
                }catch(\Exception $e){
                    
                }


            //create recipient notification
            if($status == "Paid"){
                $this->createnotification($copies[$i], 'CLient Receipt', $this->projectname($project), 'Unread', 'allreceipts');
            }else{
                $this->createnotification($copies[$i], 'CLient Invoice', $this->projectname($project), 'Unread', 'allinvoices');
            }
            

            //log the event

            $this->logevent("successfully update client invoice for the project ".$this->projectname($project));


            return response()->json([
                'message' => 'success',
                'info' => 'Client invoice update successfully.',
                'iv' => $invoiceid,
                'status' => $status
            ]);

        }

        }else{

            //log the event

            $this->logevent("Attempted to update client invoice for the project ".$this->projectname($project)." but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Client invoice update failed, please try again'
            ]);
        }

    }else{

        //log the event

            $this->logevent("Attempted to update client invoice for the project ".$this->projectname($project)." but failed");


            return response()->json([
                'message' => 'error',
                'info' => 'Client invoice update failed, please try again.'
            ]);
    }
    }

    public function allreceipts(){

        //update notification to read
        $update = DB::table('notifications')
                        ->where([['staff', Auth::user()->profileid],['type', 'Client Receipt'],['location', 'allreceipts']])
                        ->update(['status' => 'Read', 'updated_at' => date('Y-m-d H:i:s')]);

        $invoices = DB::table('invoice')->where('status', 'Paid')->orderBy('created_at', 'desc')->get();


        return view('allreceipts', ['invoices' => $invoices]);
    }



    public function editinvoice(Request $request){

        $pvs = DB::table('invoice')->where('id', $request->id)->get();

        if($pvs[0]->invoicetype == "Sheet 1"){

            $vsheets = DB::table('invoicesheet1')->where('pvid', $request->id)->get();

        }else if($pvs[0]->invoicetype == "Sheet 2"){

            $vsheets = DB::table('invoicesheet2')->where('pvid', $request->id)->get();

        }else if($pvs[0]->invoicetype == "Sheet 3"){

            $vsheets = DB::table('invoicesheet3')->where('pvid', $request->id)->get();

        }else if($pvs[0]->invoicetype == "Sheet 4"){

            $vsheets = DB::table('invoicesheet4')->where('pvid', $request->id)->get();

        }

        $staffs = DB::table('profile')->orderBy('firstname')->get();

        $projects = DB::table('projects')->orderBy('created_at', 'desc')->get();

        $banks = DB::table('banks')->orderBy('banks', 'asc')->get();

        $infos = DB::table('companyinfo')->get();

        return view('editinvoice', ['pvs' => $pvs, 'vsheets' => $vsheets, 'staffs' => $staffs, 'projects' => $projects, 'banks' => $banks, 'infos' => $infos]);
    }


    public function submiteditinvoice(Request $request){

        $currency = $request->currency;
        $project = $request->project;
        $office = $request->office;
        $copies = $request->copies;
        $bankname = $request->bankname;
        $accountnumber = $request->accountnumber;
        $accountname = $request->accountname;
        $amountinwords = $request->amountinwords;
        $clientdata = $request->clientdata;
        $vatp = $request->vatp;
        $whtp = $request->whtp;
        $branch = $request->branch;
        $sortcode = $request->sortcode;
        $ibanno = $request->ibanno;
        $invoicetype = $request->invoicetype;
        $refno = $request->refno;

        $data = array();

        $data['sentform'] = Auth::user()->profileid;
        $data['clientinfo'] = $clientdata;
        $data['office'] = $office;
        $data['invoicetype'] = $invoicetype;
        $data['currency'] = $currency;
        $data['refno'] = $refno;
        if(!empty($copies)){
        $data['copies'] = implode($copies, ",");
        }
        $data['status'] = 'Unpaid';
        $data['bank'] = $bankname;
        $data['accountno'] = $accountnumber;
        $data['accountname'] = $accountname;

        $data['branch'] = $branch;
        $data['sortcode'] = $sortcode;
        $data['ibanno'] = $ibanno;

        if($invoicetype == "Sheet 1"){
            $data['totalprice'] = $request->totalprices1;
            $data['totalamount'] = $request->totalamounts1;
            $data['totalvat'] = $request->vatamounts1;
            $data['totalwht'] = $request->whtamounts1;
            $data['vatp'] = $request->vatp1;
            $data['whtp'] = $request->whtp1;
            $data['sumamounts'] = $request->sumamounts1;
        }else if($invoicetype == "Sheet 2"){
            $data['totalprice'] = $request->totalprices2;
            $data['totalamount'] = $request->totalamounts2;
            $data['totalvat'] = $request->vatamounts2;
            $data['totalwht'] = $request->whtamounts2;
            $data['vatp'] = $request->vatp2;
            $data['whtp'] = $request->whtp2;
            $data['sumamounts'] = $request->sumamounts2;
        }else if($invoicetype == "Sheet 3"){
            $data['totalprice'] = $request->totalprices3;
            $data['totalamount'] = $request->totalamounts3;
            $data['totalvat'] = $request->vatamounts3;
            $data['totalwht'] = $request->whtamounts3;
            $data['vatp'] = $request->vatp3;
            $data['whtp'] = $request->whtp3;
            $data['sumamounts'] = $request->sumamounts3;
        }else if($invoicetype == "Sheet 4"){
            $data['totalprice'] = $request->totalprices4;
            $data['totalamount'] = $request->totalamounts4;
            $data['totalvat'] = $request->vatamounts4;
            $data['totalwht'] = $request->whtamounts4;
            $data['vatp'] = $request->vatp4;
            $data['whtp'] = $request->whtp4;
            $data['sumamounts'] = $request->sumamounts4;
        }

        $data['amountinwords'] = $request->amountinwords;
        $data['project'] = $request->project;
        $data['updated_at'] = date('Y-m-d H:i:s');


        
        try {

                $update = DB::table('invoice')->where('id', $request->id)->update($data);

                } catch (\Exception $e) {
                    DB::rollback();
                    // something went wrong
                    return response()->json([
                        'message' => 'error',
                        'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                    ]);
                }

        if($update){

            if($invoicetype == "Sheet 1"){

                $delete = DB::table('invoicesheet1')->where('pvid', $request->id)->delete();

                $count = count($request->description);

                for($i=0; $i<$count; $i++){

                    $description = $request->description;
                    $qty = $request->qty;
                    $price = $request->price;
                    $amounts = $request->amounts;

                    $sdata = array();

                    $sdata['pvid'] = $request->id;
                    $sdata['description'] = $description[$i];
                    $sdata['qty'] = $qty[$i];
                    $sdata['unitprice'] = $price[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['updated_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet1')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 2"){



                $delete = DB::table('invoicesheet2')->where('pvid', $request->id)->delete();

                $count = count($request->description2);

                for($i=0; $i<$count; $i++){

                    $description = $request->description2;
                    $period = $request->period2;
                    $rate = $request->rate2;
                    $hours = $request->hours2;
                    $amounts = $request->amounts2;

                    $sdata = array();

                    $sdata['pvid'] = $request->id;
                    $sdata['description'] = $description[$i];
                    $sdata['period'] = $period[$i];
                    $sdata['rate'] = $rate[$i];
                    $sdata['hours'] = $hours[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet2')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 3"){

                $delete = DB::table('invoicesheet3')->where('pvid', $request->id)->delete();

                $count = count($request->name3);

                for($i=0; $i<$count; $i++){

                    $name = $request->name3;
                    $designation = $request->designation3;
                    $location = $request->location3;
                    $amounts = $request->amounts3;

                    $sdata = array();

                    $sdata['pvid'] = $request->id;
                    $sdata['name'] = $name[$i];
                    $sdata['designation'] = $designation[$i];
                    $sdata['location'] = $location[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet3')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }else if($invoicetype == "Sheet 4"){

                $delete = DB::table('invoicesheet4')->where('pvid', $request->id)->delete();

                $count = count($request->description4);

                for($i=0; $i<$count; $i++){

                    $description = $request->description4;
                    $date = $request->date4;
                    $amounts = $request->amounts4;

                    $sdata = array();

                    $sdata['pvid'] = $request->id;
                    $sdata['description'] = $description[$i];
                    $sdata['date'] = $date[$i];
                    $sdata['amount'] = $amounts[$i];
                    $sdata['created_at'] = date('Y-m-d H:i:s');

                    
                    try {

                    $addsheet = DB::table('invoicesheet4')->insert($sdata);

                    } catch (\Exception $e) {
                        DB::rollback();
                        // something went wrong
                        return response()->json([
                            'message' => 'error',
                            'info' => 'Error performing this action, make sure all the required fields are provided then try again.'
                        ]);
                    }

                }

            }
            


            //create invoice trail
            $pdata = array();

            $pdata['invoiceid'] = $request->id;
            $pdata['invoicetype'] = $invoicetype;
            $pdata['changes'] = $request->changes;
            $pdata['actor'] = Auth::user()->profileid;
            $pdata['actor_type'] = "Sender";
            $pdata['created_at'] = date('Y-m-d H:i:s');

            $invoicetrail = DB::table('invoicetrail')->insert($pdata);


            if(!empty($copies)){
            $total = count($copies);

            for($i=0; $i<$total; $i++){

                //send email to actors
                $username = $this->staffname($copies[$i]);
                $useremail = $this->profileemail($copies[$i]);

                try{
                        //send email to the person concerned
                        Mail::send('emails.editinvoiceemail', ['username' => $username, 'useremail' => $useremail], function ($message) use ($username, $useremail) {
                        $message->to($useremail, $username)->subject('A client invoice was modified by '.Auth::user()->name);
                        $message->from('erp@reliaenergy.com', 'ERP');
                        });
                    }catch(\Exception $e){
                        
                    }

                //create copies notifications
                $this->createnotification($copies[$i], 'Client Invoice', $this->projectname($project), 'Unread', 'allinvoices');

            }


            }
            

            //log the event

            $this->logevent("Successfully updated existing client invoice for the project ".$this->projectname($project));


            return response()->json([
                'message' => 'success',
                'info' => 'Client invoice successfully updated.',
                'iv' => $request->id
            ]); 


        }else{


            //log the event

            $this->logevent("Attempted to update existing client invoice for the project ".$this->projectname($project)." but failed.");


            return response()->json([
                'message' => 'error',
                'info' => 'Client invoice update failed.'
            ]); 


        }
    }


    //delete invoice
    public function deleteinvoice(Request $request){

        $invoicedetails = DB::table('invoice')->where('id', $request->id)->get();

        $delete = DB::table('invoice')->where('id', $request->id)->limit(1)->delete();


        if($delete){ //delete invoice sheet

            if($invoicedetails[0]->invoicetype == "Sheet 1"){
                $deletesheet = DB::table('invoicesheet1')->where('pvid', $request->id)->delete();
            }else if($invoicedetails[0]->invoicetype == "Sheet 2"){
                $deletesheet = DB::table('invoicesheet2')->where('pvid', $request->id)->delete();
            }else if($invoicedetails[0]->invoicetype == "Sheet 3"){
                $deletesheet = DB::table('invoicesheet3')->where('pvid', $request->id)->delete();
            }else if($invoicedetails[0]->invoicetype == "Sheet 4"){
                $deletesheet = DB::table('invoicesheet4')->where('pvid', $request->id)->delete();
            }

            //delete invoice trail
            $deletetrail = DB::table('invoicetrail')->where('invoiceid', $request->id)->delete();

            

            if(!empty($invoicedetails[0]->copies)){

                $copies = explode(",", $invoicedetails[0]->copies);

                

                $total = count($copies);

                for($i=0; $i<$total; $i++){

                    //send email to actors
                    $username = $this->staffname($copies[$i]);
                    $useremail = $this->profileemail($copies[$i]);

                    try{
                            //send email to the person concerned
                            Mail::send('emails.deleteinvoiceemail', ['username' => $username, 'useremail' => $useremail, 'staff' => Auth::user()->name], function ($message) use ($username, $useremail, $staff) {
                            $message->to($useremail, $username)->subject('A client invoice was deleted by '.Auth::user()->name);
                            $message->from('erp@reliaenergy.com', 'ERP');
                            });
                        }catch(\Exception $e){
                            
                        }

                }

            }

            

            //log the event

            $this->logevent("Successfully deleted client invoice for the project ".$this->projectname($invoicedetails[0]->project));


            return response()->json([
                'message' => 'success',
                'info' => 'Client invoice successfully deleted.'
            ]); 

        }else{


            //log the event

            $this->logevent("Attempted to delete client invoice for the project ".$this->projectname($invoicedetails[0]->project)." but failed.");


            return response()->json([
                'message' => 'error',
                'info' => 'Client invoice could not be deleted at the moment, please try again.'
            ]); 


        }

    }
}

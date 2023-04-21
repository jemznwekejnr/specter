@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3"><a href="{{ url('projects') }}">Projects</a></div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page"><a href="{{ url('projectdetails?pj='.$tasks[0]->projectid) }}">{{ app\Http\Controllers\Controller::projectname($tasks[0]->projectid) }}</a></li>
							</ol>
						</nav>
					</div>
					@if(Auth::user()->profileid == $tasks[0]->created_by)
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">
								<a class="dropdown-item" href="{{ url('edittask?tk='.$tasks[0]->id) }}">Edit Task</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item deletetask" id="{{ $tasks[0]->id }}" href="#">Delete Task</a>
							</div>
						</div>
					</div>
					@endif
				</div>

				<!--end breadcrumb-->
		<div class="card" style="padding-bottom: 30px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Task Name: <b>{{ $tasks[0]->taskname }}</b></h4>
						</div>
						<!--<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="javascript:;">Action</a>
								</li>
								<li><a class="dropdown-item" href="javascript:;">Another action</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="javascript:;">Something else here</a>
								</li>
							</ul>
						</div>-->
					</div>
				</div>
				  <div class="card-body" style="padding-top: 30px;">
				  	<div class="form-body">
					 
					 	<div class="col-sm-12">
					 		@php 
					 				$assignees = explode(",", $tasks[0]->assignees);
					 				$total = count($assignees); 
					 			@endphp
					 		<div class="" style="display: inline-flex;">
					 		<h5 class="" style="margin-right: 5px;"><b>Assignees: </b></h5>
					 			
					 			
					 			@for($i=0; $i<$total; $i++)
					 				<p class="" class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
									<img src="@if(!is_null(app\Http\Controllers\Controller::staffimage($assignees[$i]))){{ asset(app\Http\Controllers\Controller::staffimage($assignees[$i])) }} @else {{ asset('assets/images/default-avatar.png') }} @endif" class="user-img" alt="user avatar">
									<div class="user-info ps-3">
										<p class="user-name mb-0">{{ app\Http\Controllers\Controller::staffname($assignees[$i]) }}</p>
										<p class="designattion mb-0">{{ app\Http\Controllers\Controller::staffdesignation($assignees[$i]) }}</p>
									</div>
								</p>
					 			@endfor
					 			</div>
					 		
					 	</div><br />

					 	<div class="col-sm-4">
					 	<div class="" style="display: inline-flex;">
					 		@php $date=date_create($tasks[0]->startdate); @endphp
					 		<h5 class="" style="margin-right: 5px;"><b>Start Date: </b> {{ date_format($date, "d/m/Y"); }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
							  <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
							  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
							</svg></h5>
					 	</div>
						</div>

						<div class="col-sm-4">
					 	<div class="" style="display: inline-flex;">
					 		@php $date=date_create($tasks[0]->enddate); @endphp
					 		<h5 class="" style="margin-right: 5px;"><b>Due Date: </b> {{ date_format($date, "d/m/Y"); }} <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
							  <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4V.5zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2zm-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
							</svg></h5>
					 	</div>
						</div>

						<div class="col-sm-4">
					 	<div class="" style="display: inline-flex;">
					 		@if($tasks[0]->priority == "Low")
					 		<h5 class="" style="margin-right: 5px;"><b>Priority: </b> </h5><div class="p-1 border border-3 border-dark text-center rounded bg-light" >{{ $tasks[0]->priority }}</div> 
					 		@elseif($tasks[0]->priority == "Medium")
					 		<h5 class="" style="margin-right: 5px;"><b>Priority: </b> </h5><div class="p-1 border border-3 border-warning text-center rounded bg-light">{{ $tasks[0]->priority }}</div> 
					 		@else
					 		<h5 class="" style="margin-right: 5px;"><b>Priority: </b> </h5><div class="p-1 border border-3 border-danger text-center rounded bg-light" >{{ $tasks[0]->priority }}</div>  
					 		@endif
					 		
					 		
					 	</div>
						</div>
					 	<div class="col-sm-12">
					 		<div class="" >
					 		<h5 class=""><b>Description: </b></h5> {{ $tasks[0]->description }}
					 		
					 	</div>
					 	</div>

					 	<div class="">
						@if(!empty($tasks[0]->attachment))
					 	<div class="col-sm-12" style="margin-top: 10px;">
					 	<button class="btn btn-info" type="button" id="showattachment">Display Attachment</button>
					 	</div><br /><br />
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($tasks[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
						@endif
					</div><br /><br />
					<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature(Auth::user()->profileid)) }}" width="150px"></p>
							<p id="sender"><b>{{ app\Http\Controllers\Controller::staffname($tasks[0]->created_by) }}</b><br />
							{{ app\Http\Controllers\Controller::staffdesignation($tasks[0]->created_by) }}</p>
								
					 	</div>
					 	</div>
					 	</div>
					 	</div>
					 	</div>
					 	</div>
					
					<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Task Update</h4>
						</div>
						<hr/>
						<form class="row g-3" action="submittaskupdate" id="submittaskupdate" method="post" enctype="multipart/form-data">
					 	@csrf
					<input type="hidden" name="taskid" value="{{ $tasks[0]->id }}">
					<input type="hidden" name="owner" value="{{ $tasks[0]->created_by }}">	
					<input type="hidden" name="projectid" value="{{ $tasks[0]->projectid }}">
					<input type="hidden" name="taskname" value="{{ $tasks[0]->taskname }}">
					<input type="hidden" name="assignees" value="{{ $tasks[0]->assignees }}">
						<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" id="status" class="form-control" required>
									<option>{{ $tasks[0]->status }}</option>
									@php $actioned = explode(",", $actions) @endphp
									@php $total = count($actioned) @endphp
									@for($i=0; $i < $total; $i++)
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Pending" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Ongoing" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Completed")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@endfor
								</select>
							</div>
							<div class="col-sm-8">
						 		<label for="inputFirstName" class="form-label">Comment</label>
								<input type="text" name="remarks" class="form-control" placeholder="Remark" required>
							</div>
						 	<div class="col-sm-1 text-right float-right">
						 		<label for="inputFirstName" class="form-label"><br /></label>
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
							</div>
						</div>
						</div>
						</form>
						</div>
					</div>


				<div class="card" style="padding-bottom: 30px;">
				<div class="col-12 col-lg-12">
		          <div class=" radius-10">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Task Trail</h4>
						</div>
						<hr/>
				@foreach($tasktrails as $tasktrail)
					@if($tasktrail->actor_type == "Assignee")
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-warning" style="height: 150px; width: 60%; overflow: scroll;">
						 		<h5>{{ $tasktrail->status }}</h5>
						 		<p>{{ $tasktrail->remarks }}</p><br />
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($tasktrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($tasktrail->actor) @endphp</b></p>
								<p>{{ $tasktrail->created_at }}</p>
							</div><br /><br />
						</div>
					</div>
					@else
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-info float-right" style="height: 150px; width: 60%; overflow: scroll; margin-left: 40%;">
						 		
						 		<p>{{ $tasktrail->remarks }}</p>
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($tasktrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($tasktrail->actor) @endphp</b></p>
								<p>{{ $tasktrail->created_at }}</p>
							</div>
						</div>
					</div><br /><br />
					@endif
					
				@endforeach
					<br /><br />
					</div>
				</div><br /><br />
						
					 
					 </div>
				  </div>
				  </div>
				  </div>
			  </div>
		   </div>
		</div>
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include('process.project')
@include("layouts.app-title")
<body>
<style>

.progress {
  width: 70px;
  height: 70px;
  background: none;
  position: relative;
  border: transparent !important;
  border-width: 0px !important;
  box-shadow: 0px 0px 0px 0px #fff;
}

.progress::after {
  content: "";
  width: 100%;
  height: 100%;
  border-radius: 50%;
  border: 6px solid #eee;
  position: absolute;
  top: 0;
  left: 0;
}

.progress>span {
  width: 50%;
  height: 100%;
  overflow: hidden;
  position: absolute;
  top: 0;
  z-index: 1;
}

.progress .progress-left {
  left: 0;
}

.progress .progress-bar {
  width: 100%;
  height: 100%;
  background: none;
  border-width: 6px;
  border-style: solid;
  position: absolute;
  top: 0;
}

.progress .progress-left .progress-bar {
  left: 100%;
  border-top-right-radius: 80px;
  border-bottom-right-radius: 80px;
  border-left: 0;
  -webkit-transform-origin: center left;
  transform-origin: center left;
}

.progress .progress-right {
  right: 0;
}

.progress .progress-right .progress-bar {
  left: -100%;
  border-top-left-radius: 80px;
  border-bottom-left-radius: 80px;
  border-right: 0;
  -webkit-transform-origin: center right;
  transform-origin: center right;
}

.progress .progress-value {
  position: absolute;
  top: 0;
  left: 0;
}
</style>
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
								<li class="breadcrumb-item active" aria-current="page"><a href="{{ url('createproject') }}">Create New Project</a></li>
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
								<a class="dropdown-item" href="{{ url('editproject?pj='.$project[0]->id) }}">Edit Project</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item deleteproject" id="{{ $project[0]->id }}" href="#">Delete Project</a>
							</div>
						</div>
					</div>
					@endif
				</div>
				<!--end breadcrumb-->
		<div class="card" style="padding: 20px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="">
					<div class="">
						<div class="row" style="margin-bottom: 20px; margin-top: 20px;">
							<div class="col-sm-4">
								<lable class=" customfont1"><b>Project Name</b></lable>
								<h4 class="mb-0 customfont1" style="line-height: 1.5"><b>{{ $project[0]->title }}  @if(!empty($project[0]->attachment)) <a href="{{ url($project[0]->attachment) }}" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg></a> @endif</b></h4>
							</div>
							<!--calculate percentage progress -->
							@php $progress = app\Http\Controllers\Controller::projectprogress($project[0]->id) @endphp
							<div class="col-sm-2">
								<lable><b>Status</b></lable>
								@if($progress == 100)
								<h4 class="mb-0" style="color: #18A558;"><b>Completed</b></h4>
								@else
								<h4 class="mb-0" style="color: #0E86D4"><b>Ongoing - {{ number_format($progress) }}%</b></h4>
								@endif
							</div>
							<div class="col-sm-2">
								<lable><b>Duration</b></lable>
								<h4 class="mb-0"><b>@php echo app\Http\Controllers\Controller::datediffs($project[0]->startdate, $project[0]->enddate) @endphp</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Start Date</b></lable>
								<h4 class="mb-0"><b>{{ $project[0]->startdate }}</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Due Date</b></lable>
								<h4 class="mb-0"><b>{{ $project[0]->enddate }}</b></h4>
							</div>
							
						</div>
						
						<div class="row" style="margin-bottom: 30px; margin-top: 0px;">
							<div class="col-sm-2">
								<lable class=""><b>Date Created</b></lable>
								<h5 class="mb-0"><b>{{ $project[0]->created_at }}</b></h5>
							</div>
							<!--calculate percentage progress -->
							
							<div class="col-sm-2">
								<lable><b>Project Cost (&#8358;)</b></lable>
								<h4 class="mb-0" style="color: #0E86D4;"><b>{{ number_format($project[0]->amount,2) }}</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Project Budget (&#8358;)</b></lable>
								<h4 class="mb-0" style="color: #FFA500;"><b>{{ number_format($project[0]->budget,2) }}</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Project Expenses (&#8358;)</b></lable>
								<h4 class="mb-0" style="color: #ff0000;"><b>{{ number_format(app\Http\Controllers\Controller::projectexpenses($project[0]->id),2) }}</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Client Payments (&#8358;)</b></lable>
								<h4 class="mb-0" style="color: #18A558;"><b>{{ number_format(app\Http\Controllers\Controller::clientpayments($project[0]->id),2) }}</b></h4>
							</div>
							<div class="col-sm-2">
								<lable><b>Client Balances (&#8358;)</b></lable>
								<h4 class="mb-0" style="color: #ff0000;"><b>{{ number_format($project[0]->amount - app\Http\Controllers\Controller::projectexpenses($project[0]->id),2) }}</b></h4>
							</div>
							
						</div>

						<div class="row" style="margin-top: 10px;">
							<div class="col-sm-10">
								<lable><b>Description</b></lable>
								<h5 class="mb-0" style="line-height: 1.5">{{ $project[0]->description }}</h5>
							</div>
							<div class="col-sm-2">
								
							<div style="margin-top: 0px; margin-right: 50px;">
    
						      @if($progress < 25)
						      	<!-- Progress bar 2 -->
						        <div class="progress mx-auto" data-value='{{ number_format($progress) }}'>
						          <span class="progress-left">
						                        <span class="progress-bar border-danger"></span>
						          </span>
						          <span class="progress-right">
						                        <span class="progress-bar border-danger"></span>
						          </span>
						          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
						            <div class="h3 font-weight-bold">{{ number_format($progress) }}<sup class="small">%</sup></div>
						          </div>
						        </div>
						        <!-- END -->
						      @elseif($progress < 50)
						      <!-- Progress bar 4 -->
						        <div class="progress mx-auto" data-value='{{ number_format($progress) }}'>
						          <span class="progress-left">
						                        <span class="progress-bar border-warning"></span>
						          </span>
						          <span class="progress-right">
						                        <span class="progress-bar border-warning"></span>
						          </span>
						          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
						            <div class="h3 font-weight-bold">{{ number_format($progress) }}<sup class="small">%</sup></div>
						          </div>
						        </div>
						        <!-- END -->

						      @elseif($progress < 75)
						      <!-- Progress bar 1 -->
						        <div class="progress mx-auto" data-value='{{ number_format($progress) }}'>
						          <span class="progress-left">
						                        <span class="progress-bar border-primary"></span>
						          </span>
						          <span class="progress-right">
						                        <span class="progress-bar border-primary"></span>
						          </span>
						          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
						            <div class="h3 font-weight-bold">{{ number_format($progress) }}<sup class="small">%</sup></div>
						          </div>
						        </div>
						        <!-- END -->

						      @elseif($progress <= 100)
        
						      	<!-- Progress bar 3 -->
						        <div class="progress mx-auto" data-value='{{ number_format($progress) }}'>
						          <span class="progress-left">
						                        <span class="progress-bar border-success"></span>
						          </span>
						          <span class="progress-right">
						                        <span class="progress-bar border-success"></span>
						          </span>
						          <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
						            <div class="h3 font-weight-bold">{{ number_format($progress) }}<sup class="small">%</sup></div>
						          </div>
						        </div>
						        <!-- END -->
						       @endif
        						
							<h2 class="h6 font-weight-bold text-center mb-4">Overall progress</h2>
    						</div>
							</div>
							
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
				  



			  </div>
		   </div>
		</div>
		<div class="row">
			<div class="col-sm-4">
				<div class="card" style="padding: 20px;">
		       <div class="col-12 col-lg-12" style="margin-bottom: 30px;">
		          <div class=" radius-10" >
					<div class="card-header">
						<div class="row">
							<div class="col-sm-10">
								<h4 style="color: #ff0000;"><b>Pending Tasks ({{ number_format(app\Http\Controllers\Controller::taskpercent($project[0]->id, "Pending")) }}%)</b></h4>
							</div>
							
							<div class="col-sm-2 text-right float-right">
								<a href="{{ url('addtask?pj='.$project[0]->id) }}"><svg title="Click to add a new row" id="" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg></a>
							</div>
						</div>
					</div>
					<div class="card-body">
						@foreach($tasks as $task)
						@if($task->status == "Pending")
						<p class="alert alert-danger">
							 <a href="{{ url('taskdetails?tk='.$task->id) }}" style="color: inherit;">{{ $task->taskname }}</a> @if(!empty($task->attachment)) <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg> @endif
						</p>
						@endif
						@endforeach
					</div>
			  </div>
		   </div>
		</div>
			</div>


			<div class="col-sm-4">
				<div class="card" style="padding: 20px;">
		       <div class="col-12 col-lg-12" style="margin-bottom: 30px;">
		          <div class=" radius-10" >
					<div class="card-header">
						<h4 style="color: #0E86D4"><b>Ongoing Tasks ({{ number_format(app\Http\Controllers\Controller::taskpercent($project[0]->id, "Ongoing")) }}%)</b></h4>
					</div>
					<div class="card-body">
						@foreach($tasks as $task)
						@if($task->status == "Ongoing")
						<p class="alert alert-info">
							 <a href="{{ url('taskdetails?tk='.$task->id) }}" style="color: inherit;">{{ $task->taskname }}</a> @if(!empty($task->attachment)) <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg> @endif
						</p>
						@endif
						@endforeach
					</div>
			  </div>
		   </div>
		</div>
			</div>



			<div class="col-sm-4">
				<div class="card" style="padding: 20px;">
		       <div class="col-12 col-lg-12" style="margin-bottom: 30px;">
		          <div class=" radius-10" >
					<div class="card-header">
						<h4 style="color: #18A558;"><b>Completed Tasks ({{ number_format(app\Http\Controllers\Controller::taskpercent($project[0]->id, "Completed")) }}%)</b></h4>
					</div>
					<div class="card-body">
						@foreach($tasks as $task)
						@if($task->status == "Completed")
						<p class="alert alert-success">
							 <a href="{{ url('taskdetails?tk='.$task->id) }}" style="color: inherit;">{{ $task->taskname }}</a> @if(!empty($task->attachment)) <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15"><path fill="currentColor" d="M0 4.5V0h1v4.5a1.5 1.5 0 1 0 3 0v-3a.5.5 0 0 0-1 0V5H2V1.5a1.5 1.5 0 1 1 3 0v3a2.5 2.5 0 0 1-5 0Z"/><path fill="currentColor" fill-rule="evenodd" d="M12.5 0H6v4.5A3.5 3.5 0 0 1 2.5 8H1v5.5A1.5 1.5 0 0 0 2.5 15h10a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 0ZM11 4H7v1h4V4Zm0 3H7v1h4V7Zm-7 3h7v1H4v-1Z" clip-rule="evenodd"/></svg> @endif
						</p>
						@endif
						@endforeach
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
<script>
	$(function() {

  $(".progress").each(function() {

    var value = $(this).attr('data-value');
    var left = $(this).find('.progress-left .progress-bar');
    var right = $(this).find('.progress-right .progress-bar');

    if (value > 0) {
      if (value <= 50) {
        right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
      } else {
        right.css('transform', 'rotate(180deg)')
        left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
      }
    }

  })

  function percentageToDegrees(percentage) {

    return percentage / 100 * 360

  }

});
</script>
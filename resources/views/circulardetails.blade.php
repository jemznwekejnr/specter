@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Circulars</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Create New Circular</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
				<div class="card" style="padding-bottom: 30px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Circular Details</h4>
						</div>
						<!--<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
								<li><a class="dropdown-item" href="javascript:;">Edit Circular</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="javascript:;">Back to Dashboard</a>
								</li>
							</ul>
						</div>-->
					</div>
				</div>
				  <div class="card-body">
				  	<div class="form-body">
					 
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Circular Title</label>
							<p class="form-control" name="title">{{ $circular[0]->title }}</p>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
						 	<div class="col-sm-12">
								<label for="inputFirstName" class="form-label">Circular Recipient</label>

								@php $recipients = app\Http\Controllers\Controller::circularrecipients($circular[0]->id) @endphp
								
								<p class="form-control" name="title">
									@foreach($recipients as $recipient)
									{{ app\Http\Controllers\Controller::staffname($recipient->recipient) }},
									@endforeach
								</p>
							</div>
						</div>
					</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Circular Body</label>
							<p name="title" class="form-control" style="height: 500px; overflow: scroll;">{{ $circular[0]->body }}</p>
								
					 	</div>
					 	@if(!empty($circular[0]->attachment))
					 	<p class="col-sm-12">
					 	<button class="btn btn-info" type="button" id="showattachment">Attachment Display</button>
					 	</p>
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($circular[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
						@endif<br /><br />
						<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($circular[0]->sentform)) }}" width="150px"></p>
							<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($circular[0]->sentform) @endphp</b></p>
								
					 	</div>
					 
					 </div>
				  </div>
			  </div>
		   </div>
		</div>
        @if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 3, 1) == "allow" || app\Http\Controllers\Controller::checkrole(Auth::user()->role, 3, 3) == "allow")
		<form class="row g-3" action="submitcircularstatus" id="submitcircularstatus" method="post">
		@csrf
		<input type="hidden" name="id" value="{{ $circular[0]->id }}">
		<input type="hidden" name="title" value="{{ $circular[0]->title }}">
		<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Circular Status</h4>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" id="status" class="form-control">
									<option value="">Select Status</option>
									@php $actioned = explode(",", $actions) @endphp
									@php $total = count($actioned) @endphp
									@for($i=0; $i < $total; $i++)
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected")
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 3, 1) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 3, 3) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@endif
									@endfor
								</select>
							</div>
							<div class="col-sm-6">
						 		
							</div>
						 	<div class="col-sm-2 text-right float-right">
						 		<label for="inputFirstName" class="form-label"><br /></label>
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
							</div>
						</div>
					</div><br /><br />
					</div>
				</div>
			</form>
		    @endif
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.circular")
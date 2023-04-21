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
								<li class="breadcrumb-item active" aria-current="page">Create New Project</li>
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
							<h4 class="mb-0">Register New Project</h4>
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
					 <form class="row g-3" action="submiteditproject" id="submiteditproject" method="post" enctype="multipart/form-data">
					 	@csrf
					 	<input type="hidden" name="projectid" value="{{ $project[0]->id }}">
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Project Title <span class="required" >*</span></label>
							<input type="text" class="form-control" id="title" name="title" value="{{ $project[0]->title }}" maxlength="225" required>
					 	</div><br />
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Client Information <span class="required" >*</span></label>
							<input type="text" class="form-control" id="client" name="client" value="{{ $project[0]->client }}" required>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
							<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">Contract Amount <span class="required" >*</span></label>
								<input type="number" name="amount" class="form-control" value="{{ $project[0]->amount }}" required>
							</div>
							<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">Project Budget <span class="required" >*</span></label>
								<input type="number" name="budget" class="form-control" value="{{ $project[0]->budget }}" required>
							</div>
						 	<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">Start Date <span class="required" >*</span></label required>
								<input type="date" name="startdate" id="startdate" value="{{ $project[0]->startdate }}" class="form-control">
							</div>
						 	<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">End Date <span class="required" ></span></label required>
								<input type="date" name="enddate" id="enddate" value="{{ $project[0]->enddate }}" class="form-control">
							</div>
						</div>
					</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Project Description <span class="required" >*</span></label required>
							<textarea class="form-control" id="body" name="description" placeholder="Brief description of the project" maxlength="5000" style="height: 200px;">{{ $project[0]->description }}</textarea>
					 	</div>
					 	<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6">
						 		<label for="inputFirstName" class="form-label">Replace Documents</label>
								<input type="file" id="pics" name="attachment" class="form-control" accept=".pdf" placeholder="Select Attachment">
							</div>
						 	<div class="col-sm-6 text-right float-right">
								
							</div>
						</div>
					</div>
					@if(!empty($project[0]->attachment))
					 	<div class="col-sm-12" style="margin-top: 10px;">
					 	<button class="btn btn-info" type="button" id="showattachment">Display Attachment</button>
					 	</div><br /><br />
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($project[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
					@endif<br /><br />
					<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature(Auth::user()->profileid)) }}" width="150px"></p>
							<p id="sender"><b>{{ app\Http\Controllers\Controller::staffname(Auth::user()->profileid) }}</b><br />
								{{ app\Http\Controllers\Controller::staffdesignation(Auth::user()->profileid) }}</p>
								
					 	</div>
					 	<br /><br />
						<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6">
								
							</div>
						 	<div class="col-sm-6 text-right float-right">
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
							</div>
						</div>
					</div><br /><br />
						
					 </form>
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
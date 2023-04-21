@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Staff</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Staff Profile</li>
							</ol>
						</nav>
					</div>
				</div>
				<!--end breadcrumb-->
		<div class="row">
		       <div class="col-12 col-lg-12">
		          <div class="card radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h6 class="mb-0" id="button">Staff Profile</h6>
						</div>
						<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
							    @if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 8, 7) == "allow")
								<li><a class="dropdown-item" href="{{ url('editstaff?id='.$_GET['id']) }}">Edit Profile</a>
								</li>
								@endif
								@if(app\Http\Controllers\Controller::checkuser($_GET['id'])->count() == 0)
								@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 7, 9) == "allow")
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item convertuser" id="{{ $_GET['id'] }}" href="{{ url('convertuser?id='.$_GET['id']) }}">Convert to User</a>
								</li>
								@endif
								@endif
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="{{ url('dashboard?id='.$_GET['id']) }}">Back to Dashboard</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				  <div class="card-body">
				  	<div class="form-body">
					 <form class="row g-3">
					 	<div class="col-sm-4">
					 	<center>



					 		<!--image upload starts here--->
	                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
	                    <div class="fileinput-new  avatar border-gray">
	                      <img src="@if(!is_null($staff[0]->image)) {{ asset($staff[0]->image) }} @else {{ asset('assets/images/default-avatar.png') }} @endif" width="250px" alt="...">
	                    </div>
	                    <div class="fileinput-preview fileinput-exists avatar border-gray">
	                      <img src="@if(!is_null($staff[0]->image)) {{ asset($staff[0]->image) }} @else {{ asset('assets/images/default-avatar.png') }} @endif" width="250px" alt="...">
	                    </div>
	                    <div>
	                    	
	                      <!--<span class="btn btn-round btn-rose btn-file">
	                        <span class="fileinput-new">Add Photo</span>
	                        <span class="fileinput-exists">Change</span>
	                        <input type="file" name="pics" id="pics" />
	                      </span>
	                      <br />
	                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>-->
	                    </div>
	                    
	                  </div><br /><br />




	                  <div class="fileinput fileinput-new text-center" data-provides="fileinput">
	                    <div class="fileinput-new  border-gray">
	                      <img src="@if(!is_null($staff[0]->signature)) {{ asset($staff[0]->signature) }} @else {{ asset('assets/images/signature.jpg') }} @endif" width="250px" alt="...">
	                    </div>
	                    <div class="fileinput-preview fileinput-exists  border-gray">
	                      <img src="@if(!is_null($staff[0]->signature)) {{ asset($staff[0]->signature) }} @else {{ asset('assets/images/signature.jpg') }} @endif" width="250px" alt="...">
	                    </div>
	                    <div>
	                    <!--<label>Signature</label>
	                      <span class="btn btn-round btn-rose btn-file">
	                        <span class="fileinput-new">Add Photo</span>
	                        <span class="fileinput-exists">Change</span>
	                        <input type="file" name="pics" id="pics" />
	                      </span>
	                      <br />
	                      <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>-->
	                    </div>
	                    
	                  </div>


					 		
						</center>
					 	</div>
					 	<div class="col-sm-8">
					 	<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">First Name</label>
								<p class="form-control" id="fname">{{ $staff[0]->firstname }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Staff ID</label>
								<p class="form-control" id="staffid">{{ $staff[0]->staffid }}</p>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Other Names</label>
								<p class="form-control" id="onames">{{ $staff[0]->othername }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Date of Employment</label>
								<p class="form-control" id="doe">{{ $staff[0]->doe }}</p>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Surname</label>
								<p class="form-control" id="sname">{{ $staff[0]->surname }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Department</label>
								<p class="form-control" id="department">{{ $staff[0]->department }}</p>
							</div>
						</div>
						<br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Gender</label>
								<p class="form-control" id="gender">{{ $staff[0]->gender }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Designation</label>
								<p class="form-control" id="designation">{{ $staff[0]->designation }}</p>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Date of Birth</label>
								<p class="form-control" id="dob">{{ $staff[0]->dob }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Office</label>
								<p class="form-control" id="offices">{{ $staff[0]->office }}</p>
							</div>
						</div><br /><div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Email Address</label>
								<p class="form-control" id="email">{{ $staff[0]->email }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Account Number</label>
								<p class="form-control" id="accountnumber">{{ $staff[0]->accountno }}</p>
							</div>
						</div><br /><div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Phone Number</label>
								<p class="form-control" id="phone">{{ $staff[0]->phone }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Bank Name</label>
								<p class="form-control" id="bank">{{ $staff[0]->bankname }}</p>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Employment Status</label>
								<p class="form-control" id="phone">{{ $staff[0]->employmentstatus }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Employment Status Since</label>
								<p class="form-control" id="bank">{{ $staff[0]->datechanged }}</p>
							</div>
						</div><br />
						</div>
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
@include("process.staffprofile")

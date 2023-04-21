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
								<li class="breadcrumb-item active" aria-current="page">Add New Staff</li>
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
							<h6 class="mb-0">Edit Staff Data</h6>
						</div>
						<div class="dropdown ms-auto">
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
						</div>
					</div>
				</div>
				  <div class="card-body" style="padding-top: 40px;">
				  	<div class="form-body">
					 <form class="row g-3" action="submiteditstaff" id="submiteditstaff" method="post">
					 	@csrf
					 	<div class="col-sm-4">
					 		<input type="hidden" name="id" value="{{ $_GET['id'] }}">
					 	<center>



					 		<!--image upload starts here--->
	                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
	                    <div class="fileinput-new  avatar border-gray">
	                      <a href="{{ url('profilepics?id='.$staff[0]->id) }}"><img src="@if(!is_null($staff[0]->image)) {{ asset($staff[0]->image) }} @else {{ asset('assets/images/default-avatar.png') }} @endif" width="250px" alt="..."></a>
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
	                      <a href="{{ url('addsignature?id='.$staff[0]->id) }}"><img src="@if(!is_null(asset($staff[0]->signature))) {{ asset($staff[0]->signature) }} @else {{ asset('assets/images/signature.jpg') }} @endif" width="250px" alt="..."></a>
	                    </div>
	                    <div class="fileinput-preview fileinput-exists  border-gray">
	                      <img src="@if(!is_null(asset($staff[0]->signature))) {{ asset($staff[0]->signature) }} @else {{ asset('assets/images/signature.jpg') }} @endif" width="250px" alt="...">
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
								<input type="text" class="form-control" id="fname" name="fname" value="{{ $staff[0]->firstname }}" placeholder="First Name" required>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Staff ID</label>
								<input type="text" class="form-control" id="staffid" name="staffid" value="{{ $staff[0]->staffid }}" placeholder="Staff ID" required>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Other Names</label>
								<input type="text" class="form-control" id="onames" name="onames" value="{{ $staff[0]->othername }}" placeholder="Other Names">
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Date of Employment</label>
								<input type="date" class="form-control" id="doe" name="doe" value="{{ $staff[0]->doe }}" placeholder="Date of Employment" max="{{ date('Y-m-d') }}" required>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Surname</label>
								<input type="text" class="form-control" id="sname" name="sname" value="{{ $staff[0]->surname }}" placeholder="Surname" required>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Department</label>
								<select class="form-control" id="department" name="department" required>
									<option>{{ $staff[0]->department }}</option>
									@foreach($departments as $department)
									<option>{{ $department->departments }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Gender</label>
								<select class="form-control" id="gender" name="gender" required>
									<option>{{ $staff[0]->gender }}</option>
									<option>Male</option>
									<option>Female</option>
								</select>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Designation</label>
								<select class="form-control" id="designation" name="designation" required>
									<option>{{ $staff[0]->designation }}</option>
									@foreach($designations as $designation)
									<option>{{ $designation->designations }}</option>
									@endforeach
								</select>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Date of Birth</label>
								@php $today = date('Y-m-d') @endphp
								@php $date = strtotime($today.' -15 year') @endphp
								<input type="date" class="form-control" id="dob" name="dob" value="{{ $staff[0]->dob }}" max="{{ date('Y-m-d', $date) }}" required>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Office</label>
								<select class="form-control" id="office" name="office">
									<option>{{ $staff[0]->office }}</option>
									@foreach($offices as $office)
									<option>{{ $office->offices }}</option>
									@endforeach
								</select>
							</div>
						</div><br /><div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Email Address</label>
								<input type="email" class="form-control" id="email" value="{{ $staff[0]->email }}" name="email" placeholder="Email Address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Account Number</label>
								<input type="number" class="form-control" id="accountno" name="accountno" value="{{ $staff[0]->accountno }}" maxlength="10" min="0" placeholder="Account Number">
							</div>
						</div><br /><div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Phone Number</label>
								<input type="text" class="form-control" id="phone" name="phone" value="{{ $staff[0]->phone }}" placeholder="Phone Number" required>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Bank Name</label>
								<select class="form-control" id="bank" name="bank">
									<option>{{ $staff[0]->bankname }}</option>
									@foreach($banks as $bank)
									<option>{{ $bank->banks }}</option>
									@endforeach
								</select>
							</div>
						</div><br /><div class="row">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Employment Status</label>
								<select class="form-control" id="employmentstatus" name="employmentstatus" required>
									<option>{{ $staff[0]->employmentstatus }}</option>
									<option>Active Employment</option>
									<option>Resigned</option>
									<option>Retired</option>
									<option>Suspended</option>
									<option>Sacked</option>
								</select>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Employment Status Since</label>
								<input type="date" class="form-control" id="datechanged" name="datechanged" value="{{ $staff[0]->datechanged }}" required>
							</div>
						</div><br />
						<div class="row">
						 	<div class="col-sm-6">
								
							</div>
						 	<div class="col-sm-6 text-right float-right">
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
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
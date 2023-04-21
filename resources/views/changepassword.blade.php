@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Users</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-user"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Manage User</li>
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
							<h6 class="mb-0">Change User Password</h6>
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
				  <div class="card-body" style="padding-top: 40px;">
				  	<div class="form-body">
					 <form action="submitpassword" id="submitpassword" method="post">
					 	@csrf
					 	
					 	<div class="row g-3">
					 		<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">Current Password</label>
								<input type="password" placeholder="Enter Current Password" name="currentpassword" class="form-control" required>
							</div>
						 	<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">New Password</label>
								<input type="password" placeholder="Enter New Password" name="newpassword" class="form-control" required>
							</div>
							<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">New Password Again</label>
								<input type="password" placeholder="Re-enter Password" name="newpasswordagain" class="form-control" required>
							</div>
						</div><br />
						<div class="row g-3">
					 		<div class="col-sm-3">
								
							</div>
						 	<div class="col-sm-3">
								
							</div>
							<div class="col-sm-3 text-right float-right">
								<label><br /><br /></label>
								
							</div>
							<div class="col-sm-3 text-right float-right">
								<label><br /><br /><br /></label>
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
								
							</div>
						</div><br />
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
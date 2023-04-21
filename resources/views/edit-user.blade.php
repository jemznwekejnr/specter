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
							<h6 class="mb-0">Edit User Data</h6>
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
					 <form action="submitedituser" id="submitedituser" method="post">
					 	@csrf
					 	<input type="hidden" name="id" value="{{ $user[0]->id }}">
					 	<div class="row g-3">
					 		<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">Name</label>
								<p class="form-control">{{ $user[0]->name }}</p>
							</div>
						 	<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">Email</label>
								<p class="form-control">{{ $user[0]->email }}</p>
							</div>
							<div class="col-sm-2">
								<label for="inputFirstName" class="form-label">Role</label>
								<select name="role" class="form-control">
									<option value="{{ $user[0]->role }}">{{ app\Http\Controllers\Controller::getrolename($user[0]->role) }}</option>
									@foreach($roles as $role)
									<option value="{{ $role->id }}">{{ $role->role }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-2">
								<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" class="form-control">
									<option>{{ $user[0]->status }}</option>
									<option>Active</option>
									<option>Suspended</option>
								</select>
							</div>
						</div><br />
						<div class="row g-3">
					 		<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">Date Converted</label>
								<p class="form-control">{{ $user[0]->created_at }}</p>
							</div>
						 	<div class="col-sm-3">
								<label for="inputFirstName" class="form-label">Last Update</label>
								<p class="form-control">{{ $user[0]->updated_at }}</p>
							</div>
							<div class="col-sm-3 text-right float-right">
								<label><br /><br /></label>
								
							</div>
							<div class="col-sm-3 text-right float-right">
								<label><br /><br /><br /></label>
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
								<a href="{{ url('staffprofile?id='.$user[0]->profileid) }}" class="btn btn-warning">View Profile</a>
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
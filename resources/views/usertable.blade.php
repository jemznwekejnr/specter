@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Tables</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">User Table</li>
							</ol>
						</nav>
					</div>
					<!--<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>-->
				</div>
				<!--end breadcrumb
				<h6 class="mb-0 text-uppercase">Application User Table</h6>-->
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example" class="table table-striped table-bordered" style="width:100%">
								<thead>
									<tr>
										<th>Name</th>
										<th>Email</th>
										<th>Role</th>
										<th>Account Status</th>
										<th>Date Converted</th>
										@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 7, 7) == "allow")
										<th>Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach($users as $user)
									@if($user->id != 1)
									<tr>
										<td>{{ $user->name }}</td>
										<td>{{ $user->email }}</td>
										<td>{{ app\Http\Controllers\Controller::getrolename($user->role) }}</td>
										<td>@if($user->status == 'Active') <button type="button" class="btn btn-success">{{ $user->status }}</button> @else<button type="button" class="btn btn-danger">{{ $user->status }}</button>@endif </td>
										<td>{{ $user->created_at }}</td>
										@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 7, 7) == "allow")
										<td><a href="{{ url('userprofile?id='.$user->id) }}" class="btn btn-dark px-5">View Details</a></td>
										@endif
									</tr>
									@endif
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>


@include("layouts.app-footer")
@include("process.staffprofile")

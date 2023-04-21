@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Memo</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Create New Memo</li>
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
							<h4 class="mb-0">Memo Details</h4>
						</div>
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
								@if($memo[0]->sentform == Auth::user()->profileid)
								@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 7) == "allow")
								<li><a class="dropdown-item" href="{{ url('editmemo?id='.$memo[0]->id) }}">Edit Memo</a>
								</li>
								@endif
								@endif
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="{{ url('dashboard') }}">Back to Dashboard</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				  <div class="card-body">
				  	<div class="form-body">
					 
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Memo Title</label>
							<p class="form-control" name="title">{{ $memo[0]->title }}</p>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Memo Recipient</label>
								<p class="form-control" name="title">{{ app\Http\Controllers\Controller::staffname($memo[0]->sendto) }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Memo CC</label>
								<p class="form-control" name="title">
									@if(!empty($memo[0]->copies)) |
											@php $copy = explode(",", $memo[0]->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }} |
											@endfor
									@endif

							</div>
						</div>
					</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Memo Body</label>
							<p name="title" class="form-control" style="height: 500px; overflow: scroll;">{{ $memo[0]->body }}</p>
								
					 	</div>
					 	@if(!empty($memo[0]->attachment))
					 	<p class="col-sm-12">
					 	<button class="btn btn-info" type="button" id="showattachment">Attachment Display</button>
					 	</p>
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($memo[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
						@endif<br /><br />
						<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($memo[0]->sentform)) }}" width="150px"></p>
							<p id="sender"><b>{{ app\Http\Controllers\Controller::staffname($memo[0]->sentform) }}</b></p>
								
					 	</div>
					 
					 </div>
				  </div>
			  </div>
		   </div>
		</div>

		@if($memo[0]->sentform != Auth::user()->profileid)
		@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 1) == "allow" || app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 3) == "allow" || app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 4) == "allow")
		<form action="memoreaction" id="memoreaction" method="post">
		@csrf
		<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Memo Status</h4>
						</div>
						<hr/>
						<input type="hidden" name="id" value="{{ $memo[0]->id }}">
						<input type="hidden" name="sentfrom" value="{{ $memo[0]->sentform }}">
						<input type="hidden" name="title" value="{{ $memo[0]->title }}">
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" id="status	" class="form-control" required>
									<option value="">Select Status</option>
									@php $actioned = explode(",", $actions) @endphp
									@php $total = count($actioned) @endphp
									@for($i=0; $i < $total; $i++)
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Verified")
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 1) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 3) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 1, 4) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@endif
									@endfor
								</select>
							</div>
							<div class="col-sm-8">
						 		<label for="inputFirstName" class="form-label">Remark</label>
								<input type="text" name="remarks" class="form-control" placeholder="Remark" required>
							</div>
						 	<div class="col-sm-1 text-right float-right">
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
		@endif

		<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Memo Trail</h4>
						</div>
						<hr/>
				@foreach($memotrails as $memotrail)
					@if($memotrail->actor_type == "Sender")
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-warning" style="height: 150px; width: 60%; overflow: scroll;">
						 		<h5>{{ $memotrail->title }}</h5>
						 		<p>{{ $memotrail->body }}</p><br />
						 		@if(!empty($memotrail->attachment))<a href="{{ $memotrail->attachment }}" target="_blank" class="btn btn-primary"> Download Attachment</a>@endif
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($memotrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($memotrail->actor) @endphp</b></p>
								<p>{{ $memotrail->created_at }}</p>
							</div><br /><br />
						</div>
					</div>
					@else
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-info float-right" style="height: 150px; width: 60%; overflow: scroll; margin-left: 40%;">
						 		<h5>@if($memotrail->status == 'Pending') <button class="btn btn-warning px-5">{{ $memotrail->status }}</button> @elseif($memotrail->status == 'Approved') <button class="btn btn-success px-5">{{ $memotrail->status }}</button> @elseif($memotrail->status == 'Rejected') <button class="btn btn-danger px-5">{{ $memotrail->status }}</button> 
										@else <button class="btn btn-primary px-5 convertuser">{{ $memotrail->status }}</button> 
										@endif</h5>
						 		<p>{{ $memotrail->remark }}</p>
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($memotrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($memotrail->actor) @endphp</b></p>
								<p>{{ $memotrail->created_at }}</p>
							</div>
						</div>
					</div><br /><br />
					@endif
					
				@endforeach
					<br /><br />
					</div>
				</div>
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.memo")
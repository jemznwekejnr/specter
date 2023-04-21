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
							<h4 class="mb-0">Compose Memo</h4>
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
					 <form class="row g-3" action="submiteditmemo" id="submiteditmemo" method="post" enctype="multipart/form-data">
					 	@csrf
					 	<div class="col-sm-12">
					 		<input type="hidden" name="id" value="{{ $memo[0]->id }}">
					 		<label for="inputFirstName" class="form-label">Memo Title</label>
							<input type="text" class="form-control" id="title" name="title" placeholder="Memo Title" value="{{ $memo[0]->title }}" required>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
						 	<div class="col-sm-4">
								<label for="inputFirstName" class="form-label">Memo Recipient</label>
								<p class="form-control" name="title">{{ app\Http\Controllers\Controller::staffname($memo[0]->sendto) }}</p>
							</div>
						 	<div class="col-sm-8">
								<label for="inputFirstName" class="form-label">Memo CC</label>
								<p class="form-control" name="title">@if(!empty($memo[0]->copies)) |
											@php $copy = explode(",", $memo[0]->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }} |
											@endfor
									@endif</p>
							</div>
						</div>
						</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Memo Body</label>
							
								<textarea id="" class="form-control" rows="20" name="memobody" required>
									{{ $memo[0]->body }}
								</textarea>

								
					 	</div>
					 	@if(!empty($memo[0]->attachment))
					 	<p class="col-sm-12">
					 	<button class="btn btn-info" type="button" id="showattachment">Attachment Display</button>
					 	</p>
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($memo[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
						@endif<br /><br />
						<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6">
								<input type="file" id="pics" name="attachment" class="form-control" accept=".pdf" placeholder="Select Attachment">
							</div>
						 	<div class="col-sm-6 text-right float-right">
								
							</div>
						</div>
					</div><br /><br />
						<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature(Auth::user()->profileid)) }}" width="150px"></p>
							<p id="sender"><b>{{ app\Http\Controllers\Controller::staffname(Auth::user()->profileid) }}</b></p>
								
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
@include('process.memo')
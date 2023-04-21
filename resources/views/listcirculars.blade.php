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
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Circulars</h4>
						</div>
						<hr/>

					
						@foreach($circluars as $circluar)
							<a href="{{ url('circulardetails?id='.$circluar->id) }}">
								<div class="col alert alert-info" style="height: 150px; overflow: scroll;">
								<div class="shadow p-4 rounded">
									<div class="row">
										<div class="col-sm-10">
						 					{{ $circluar->title }}<br /><br />
										</div>
										@if($circluar->sentform == Auth::user()->profileid)
									 	<div class="col-sm-2 text-right float-right">
									 		@if($circluar->status == "Approved")
											<button class="btn btn-success" type="button" id="button">{{ $circluar->status }}</button>
											@elseif($circluar->status == "Rejected")
											<button class="btn btn-danger" type="button" id="button">{{ $circluar->status }}</button>
											@else
											<button class="btn btn-warning" type="button" id="button">{{ $circluar->status }}</button>
											@endif
										</div>
										@endif
									</div> 
									

									<small>{{ $circluar->created_at }}</small> | <small>Total Recipients {{ $circluar->total_recipient }}</small>
								</div>
								
							</div></a><br /><br />
						@endforeach
							
					</div>
				</div>

		
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
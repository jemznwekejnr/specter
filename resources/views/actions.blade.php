@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<div class="card">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Add New Action</h4>
						</div>
					</div>
				</div>
				  <div class="card-body">
				  	<div class="form-body">
					 <form class="row g-2" method="POST" action="submiaction" id="submiaction">
					 	@csrf
					 	<div class="col-sm-8">
					 		<input type="hidden" name="actid" id="actid" value="">
					 		<input type="text" name="action" id="action" class="form-control" placeholder="Enter Action Name" required>
						
					 	</div>
					 	<div class="col-sm-4">
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
						</div>
					 </form>
					 </div>
				  </div>
			  </div>
		   </div>
		</div>

		<div class="card">
					<div class="card-body">
						<div class="card-title">
							<h4 class="mb-0">Available Actions</h4>
						</div>
						<hr/>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>SN</th>
										<th>Actions</th>
										<th>Action</th>

										<th>Created At</th>
									</tr>
								</thead>
								<tbody>
									@php $i=1 @endphp
									@foreach($actions as $action)
									<tr>
										<td>{{ $i++ }}</td>
										<td>{{ $action->action }}</td>
										<td>
											
											<a href="{{ $action->id }}" class="editaction" id="{{ $action->action }}"><svg title="Click to edit row" class="vouchericon" id="editrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg></a>

											<a href="{{ $action->id }}" class="deleteaction" id="{{ $action->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>

										</td>
										<td>{{ $action->created_at }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.access-control")
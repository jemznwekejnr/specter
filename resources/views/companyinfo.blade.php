@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
	    @if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 8, 6) == "allow")
		<div class="card">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Add Company Info</h4>
						</div>
					</div>
				</div>
				  <div class="card-body">
				  	<div class="form-body">
					 <form class="row g-2" method="POST" action="submitinfo" id="submitinfo">
					 	@csrf
					 	<div class="col-sm-6" style="margin-bottom: 10px;">
					 		<label>Address</label>
					 		<input type="hidden" name="ofid" id="ofid" value="">
					 		<input type="text" name="address" id="address" class="form-control" maxlength="100" placeholder="Address" required>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>City</label>
					 		<input type="text" name="city" id="city" class="form-control" maxlength="50" placeholder="City" required>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>State</label>
					 		<select class="form-control" name="state" id="state">
							    <option disabled selected>--Select State--</option>
							    <option value="Abia">Abia</option>
							    <option value="Adamawa">Adamawa</option>
							    <option value="Akwa Ibom">Akwa Ibom</option>
							    <option value="Anambra">Anambra</option>
							    <option value="Bauchi">Bauchi</option>
							    <option value="Bayelsa">Bayelsa</option>
							    <option value="Benue">Benue</option>
							    <option value="Borno">Borno</option>
							    <option value="Cross River">Cross River</option>
							    <option value="Delta">Delta</option>
							    <option value="Ebonyi">Ebonyi</option>
							    <option value="Edo">Edo</option>
							    <option value="Ekiti">Ekiti</option>
							    <option value="Enugu">Enugu</option>
							    <option value="FCT">Federal Capital Territory</option>
							    <option value="Gombe">Gombe</option>
							    <option value="Imo">Imo</option>
							    <option value="Jigawa">Jigawa</option>
							    <option value="Kaduna">Kaduna</option>
							    <option value="Kano">Kano</option>
							    <option value="Katsina">Katsina</option>
							    <option value="Kebbi">Kebbi</option>
							    <option value="Kogi">Kogi</option>
							    <option value="Kwara">Kwara</option>
							    <option value="Lagos">Lagos</option>
							    <option value="Nasarawa">Nasarawa</option>
							    <option value="Niger">Niger</option>
							    <option value="Ogun">Ogun</option>
							    <option value="Ondo">Ondo</option>
							    <option value="Osun">Osun</option>
							    <option value="Oyo">Oyo</option>
							    <option value="Plateau">Plateau</option>
							    <option value="Rivers">Rivers</option>
							    <option value="Sokoto">Sokoto</option>
							    <option value="Taraba">Taraba</option>
							    <option value="Yobe">Yobe</option>
							    <option value="Zamfara">Zamfara</option>
							</select>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>TIN</label>
					 		<input type="text" name="tin" id="tin" maxlength="20" class="form-control" placeholder="TIN" required>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>RC</label>
					 		<input type="text" name="rc" id="rc" maxlength="30" class="form-control" placeholder="RC No" required>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>Phone</label>
					 		<input type="text" name="phone" id="phone" maxlength="30" class="form-control" placeholder="Phone" required>
						
					 	</div>
					 	<div class="col-sm-3" style="margin-bottom: 10px;">
					 		<label>Email</label>
					 		<input type="text" name="email" id="email" maxlength="50" class="form-control" placeholder="Email" required>
						
					 	</div>
					 	<div class="col-sm-2" style="margin-bottom: 10px;">
					 		<label>Website</label>
					 		<input type="text" name="website" id="website" maxlength="50" class="form-control" placeholder="Website" required>
						
					 	</div>
					 	<div class="col-sm-3" style="margin-bottom: 10px;">
					 		<label>Logo</label>
					 		<input type="file" name="logo" id="logo" class="form-control" placeholder="Logo" required>
						
					 	</div>
					 	<div class="col-sm-12 text-right float-right" style="margin-bottom: 10px;">
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
						</div>
					 </form>
					 </div>
				  </div>
			  </div>
		   </div>
		</div>
        @endif
        @if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 8, 2) == "allow")
		<div class="card">
					<div class="card-body">
						<div class="card-title">
							<h4 class="mb-0">Company Info</h4>
						</div>
						<hr/>
						<div class="table-responsive">
							<table class="table">
								<thead>
									<tr>
										<th>RC</th>
										<th>Address</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Website</th>
										<th>TIN</th>
										<th>Logo</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@php $i=1 @endphp
									@foreach($infos as $info)
									<tr>
										<td>{{ $info->rc }}</td>
										<td>{{ $info->address }}, <br />{{ $info->city }} {{ $info->state }}</td>
										<td>{{ $info->email }}</td>
										<td>{{ $info->phone }}</td>
										<td>{{ $info->website }}</td>
										<td>{{ $info->tin }}</td>
										<td><a href="{{ $info->logo }}" target="_blank" class="btn btn-info btn-sm">Download</a></td>
										<td>
                                        @if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 8, 8) == "allow")
											<a href="{{ $info->id }}" class="deleteinfo" id="{{ $info->id }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M7 21q-.825 0-1.413-.588T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.588 1.413T17 21H7ZM17 6H7v13h10V6ZM9 17h2V8H9v9Zm4 0h2V8h-2v9ZM7 6v13V6Z"/></svg></a>
                                        @endif
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endif
	</div>
</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.components")
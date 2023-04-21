@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Payment Voucher</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Payment Voucher Details</li>
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
							<h4 class="mb-0">Payment Voucher (PV) Info</h4>
						</div>
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">
								@if($pvs[0]->sentform == Auth::user()->profileid)
								@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 7) == "allow")
								<li><a class="dropdown-item" href="{{ url('editpv?id='.$pvs[0]->id) }}">Edit PV</a>
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
				  <div class="card-body" style="padding-top: 30px;">
				  	<div class="form-body">
					 
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">PV Title</label>
							<p class="form-control" id="title">{{ $pvs[0]->title }}</p>
					 	</div><br />
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Project</label>
							<p class="form-control" id="title">{{ app\Http\Controllers\Controller::projectname($pvs[0]->project) }}</p>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">PV Recipient</label>
								<p class="form-control" id="pvrecipient">{{ app\Http\Controllers\Controller::staffname($pvs[0]->sendto) }}</p>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">PV CC</label>
								<p class="form-control" id="pvcc">@if(!empty($pvs[0]->copies))
											@php $copy = explode(",", $pvs[0]->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }},
											@endfor
											@endif</p>
							</div>
						</div>
					</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">PV Body</label>
							<p class="form-control" id="" style="height: 100px !important; overflow: scroll;">{{ $pvs[0]->body }}</p>
								
					 	</div>

					 	@if(!empty($pvs[0]->attachment))
					 	<p class="col-sm-12">
					 	<button class="btn btn-info" type="button" id="showattachment">Attachment Display</button>
					 	</p>
					 	<div class="col-sm-12" id="hideattachment" style="display: none;">
						 	<iframe src="{{ asset($pvs[0]->attachment) }}" width="100%" height="1000px"></iframe>
						</div>
						@endif<br /><br />
						
					 
					 </div>
				  </div>
			  </div>
		   </div>
		</div>


		<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-10">
									<h4 class="mb-0">Voucher Sheet</h4>
								</div>
								
							</div>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
							<div class="table-responsive">
							<table class="table" style="width:100%">
							<thead>
								<tr>	
							 		<th class="tdsn"><b>SN</b></th>
							 		<th class="tdds"><b>Description</b></th>
							 		<th class="tdqt"><b>QTY</b></th>
							 		<th class="tdpr"><b>Price (&#8358;)</b></th>
							 		<th class="tdam"><b>Amount (&#8358;)</b></th>
							 		<th class="tdva"><b>VAT (%)</b></th>
							 		<th class="tdvt"><b>VAT (&#8358;)</b></th>
							 		<th class="tdgr"><b>Gross (&#8358;)</b></th>
							 		<th class="tdwh"><b>WHT (%)</b></th>
							 		<th class="tdwt"><b>WHT (&#8358;)</b></th>
							 		<th class="tdnt"><b>Net (&#8358;)</b></th>
							</thead>
							<tbody id="sheetdata">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn">{{ $x++ }}</p></td>
									<td><p id="description[]">{{ $vsheet->description }}</p></td>
									<td><p id="qty[]">{{ $vsheet->qty }}</p></td>
									<td><p id="price[]">{{ $vsheet->unitprice }}</p></td>
									<td><p id="amount[]">{{ $vsheet->amount }}</p>
									<td><p id="vatp[]">{{ $vsheet->vatpercent }}</p></td>
									<td><p id="amount[]">{{ $vsheet->vatamount }}</p></td>
									<td><p id="amount[]">{{ $vsheet->grossamount }}</p></td>
									<td><p id="whtp[]">{{ $vsheet->whtpercent }}</p></td>
									<td><p id="amount[]">{{ $vsheet->whtamount }}</p></td>
									<td><p id="amount[]">{{ $vsheet->netamount }}</p></td>
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b>Total</b></th>
							 		<th class="tdqt"><b></b></th>
							 		<th class="tdpr"><b>{{ $pvs[0]->totalprice }} </b></th>
							 		<th class="tdam"><b>{{ $pvs[0]->totalamount }} </b></th>
							 		<th class="tdva"><b></b></th>
							 		<th class="tdvt"><b>{{ $pvs[0]->totalvat }}</b></th>
							 		<th class="tdgr"><b>{{ $pvs[0]->totalgross }} </b></th>
							 		<th class="tdwh"><b></b></th>
							 		<th class="tdwt"><b>{{ $pvs[0]->totalwht }} </b></th>
							 		<th class="tdnt"><b>{{ $pvs[0]->totalnet }} </b></th>
							 	</tr>

							</tfoot>
						</table>
					</div>
						</div>
						<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Net Amount in Words</label>
							<p class="form-control" id="title">{{ $pvs[0]->amountinwords }}</p>
					 	</div><br />
					</div>
					<br /><br />
						<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($pvs[0]->sentform)) }}" width="150px"></p>
							<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($pvs[0]->sentform) @endphp</b></p>
								
					 	</div>
				</div>

	</div>


	<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Beneficiary Bank Details</h4>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Bank Name</label>
								<p class="form-control" id="title">{{ $pvs[0]->bank }}</p>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Number</label>
								<p class="form-control" id="title">{{ $pvs[0]->accountno }}</p>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Name</label>
								<p class="form-control" id="title">{{ $pvs[0]->accountname }}</p>
							</div>
						</div>
					</div><br /><br />
					</div>
				</div>

				@if($pvs[0]->sentform != Auth::user()->profileid)
				@if(app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 1) == "allow" || app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 3) == "allow" || app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 4) == "allow")
				<form action="submitpvstatus" id="submitpvstatus" method="post">
					@csrf
					<input type="hidden" name="title" value="{{ $pvs[0]->title }}">
					<input type="hidden" name="pvid" value="{{ $pvs[0]->id }}">
					<input type="hidden" name="sentfrom" value="{{ $pvs[0]->sentform }}">
				<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">PV Status</h4>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" id="status" class="form-control" required>
									<option value="">Select Status</option>
									@php $actioned = explode(",", $actions) @endphp
									@php $total = count($actioned) @endphp
									@for($i=0; $i < $total; $i++)
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Verified" || app\Http\Controllers\Controller::getactions($actioned[$i]) == "Paid")
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Approved" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 1) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Rejected" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 3) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Verified" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 4) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@if(app\Http\Controllers\Controller::getactions($actioned[$i]) == "Paid" && app\Http\Controllers\Controller::checkrole(Auth::user()->role, 2, 5) == "allow")
									<option>{{ app\Http\Controllers\Controller::getactions($actioned[$i]) }}</option>
									@endif
									@endif
									@endfor
								</select>
							</div>
							<div class="col-sm-8">
						 		<label for="inputFirstName" class="form-label">Remark</label>
								<input type="text" name="remark" class="form-control" placeholder="Remark" required>
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
							<h4 class="mb-0">PV Trail</h4>
						</div>
						<hr/>
					@foreach($pvtrails as $pvtrail)
					@if($pvtrail->actor_type == "Sender")
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-warning" style="height: 150px; width: 60%; overflow: scroll;">
						 		<p>{{ $pvtrail->changes }}</p><br />
						 		@if(!empty($pvtrail->attachment))<a href="{{ $pvtrail->attachment }}" target="_blank" class="btn btn-primary"> Download Attachment</a>@endif
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($pvtrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($pvtrail->actor) @endphp</b></p>
								<p>{{ $pvtrail->created_at }}</p>
							</div><br /><br />
						</div>
					</div>
					@else
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-6 form-control alert alert-info float-right" style="height: 150px; width: 60%; overflow: scroll; margin-left: 40%;">
						 		<h5>@if($pvtrail->status == 'Pending') <button class="btn btn-warning px-5">{{ $pvtrail->status }}</button> @elseif($pvtrail->status == 'Approved') <button class="btn btn-primary px-5">{{ $pvtrail->status }}</button> @elseif($pvtrail->status == 'Rejected') <button class="btn btn-danger px-5">{{ $pvtrail->status }}</button> 
										@else <button class="btn btn-success px-5 convertuser">{{ $pvtrail->status }}</button> 
										@endif</h5>
						 		<p>{{ $pvtrail->remark }}</p>
						 		<br /><br />
						 		<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($pvtrail->actor)) }}" width="100px"></p>
								<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($pvtrail->actor) @endphp</b></p>
								<p>{{ $pvtrail->created_at }}</p>
							</div>
						</div>
					</div><br /><br />
					@endif
					
				@endforeach
					<br /><br />
					</div>
				</div>

</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.paymentvoucher")
@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Client Receipt</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Client Receipt Details</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-success">{{ $invoices[0]->status }}</button>
							
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
		<div class="card" style="padding-bottom: 30px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Invoice Info</h4>
						</div>
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">

								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" target="_blank" id="" href="{{ url('receiptpdf?invoice='.$invoices[0]->id) }}">Generate PDF</a>
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

					 		<label for="inputFirstName" class="form-label">Project</label>
							<p class="form-control" id="title">{{ app\Http\Controllers\Controller::projectname($invoices[0]->project) }}</p>
					 	</div>

					 	<div class="col-sm-12">

					 		<label for="inputFirstName" class="form-label">Relia Energy Office</label>
							<p class="form-control" id="title">{{ app\Http\Controllers\Controller::officename($invoices[0]->office) }}</p>
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
					 		<div class="col-sm-7">
								<label for="inputFirstName" class="form-label">Client Info</label>
								<p class="form-control" style="height: 100px; overflow: scroll;" id="pvrecipient">{{ $invoices[0]->clientinfo }}</p>
							</div>
						 	<div class="col-sm-5">
								<label for="inputFirstName" class="form-label">Invoice CC</label>
								<p class="form-control" style="height: 100px; overflow: scroll;" id="pvcc">@if(!empty($invoices[0]->copies))
											@php $copy = explode(",", $invoices[0]->copies) @endphp
											@php $x=1 @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ $x++ }}. {{ app\Http\Controllers\Controller::staffname($copy[$j]) }}<br />
											@endfor
											@endif</p>
							</div>
						</div>
					</div><br /><br />
						
					 
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
									<h4 class="mb-0">Transaction Details</h4>
								</div>
								
							</div>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
							<div class="table-responsive">
							<table class="table" style="width:100%">
							@if($invoices[0]->invoicetype == "Sheet 1")
							<thead>
								<tr>	
							 		<th class="tdsn"><b>SN</b></th>
							 		<th class="tdds"><b>Description</b></th>
							 		<th class="tdqt"><b>QTY</b></th>
							 		<th class="tdpr"><b>Price ({{ $invoices[0]->currency }})</b></th>
							 		<th class="tdam"><b>Amount ({{ $invoices[0]->currency }})</b></th>
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
								</tr>
								@endforeach
							</tbody>
							@elseif($invoices[0]->invoicetype == "Sheet 2")
							<thead>
								<tr>	
							 		<th class="tdsn"><b>SN</b></th>
							 		<th class="tdds"><b>Description</b></th>
							 		<th class="tdqt"><b>Period</b></th>
							 		<th class="tdpr"><b>Rate ({{ $invoices[0]->currency }})</b></th>
							 		<th class="tdqt"><b>Hours</b></th>
							 		<th class="tdam"><b>Amount ({{ $invoices[0]->currency }})</b></th>
							</thead>
							<tbody id="sheetdata">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn">{{ $x++ }}</p></td>
									<td><p id="description[]">{{ $vsheet->description }}</p></td>
									<td><p id="qty[]">{{ $vsheet->period }}</p></td>
									<td><p id="price[]">{{ $vsheet->rate }}</p></td>
									<td><p id="price[]">{{ $vsheet->hours }}</p></td>
									<td><p id="amount[]">{{ $vsheet->amount }}</p>
								</tr>
								@endforeach
							</tbody>
							@elseif($invoices[0]->invoicetype == "Sheet 3")
							<thead>
								<tr>	
							 		<th class="tdsn"><b>SN</b></th>
							 		<th class="tdds"><b>Name</b></th>
							 		<th></th>
							 		<th class="tdqt"><b>Designation</b></th>
							 		<th class="tdpr"><b>Location</b></th>
							 		<th class="tdam"><b>Amount ({{ $invoices[0]->currency }})</b></th>
							</thead>
							<tbody id="sheetdata">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn">{{ $x++ }}</p></td>
									<td><p id="description[]">{{ $vsheet->name }}</p></td>
									<td></td>
									<td><p id="qty[]">{{ $vsheet->designation }}</p></td>
									<td><p id="price[]">{{ $vsheet->location }}</p></td>
									<td><p id="amount[]">{{ $vsheet->amount }}</p>
								</tr>
								@endforeach
							</tbody>
							@elseif($invoices[0]->invoicetype == "Sheet 4")
							<thead>
								<tr>	
							 		<th class="tdsn"><b>SN</b></th>
							 		<th class="tdds"><b>Description</b></th>
							 		<th></th>
							 		<th class="tdqt"><b>Date</b></th>
							 		<th></th>
							 		<th class="tdam"><b>Amount ({{ $invoices[0]->currency }})</b></th>
							</thead>
							<tbody id="sheetdata">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn">{{ $x++ }}</p></td>
									<td><p id="description[]">{{ $vsheet->description }}</p></td>
									<td></td>
									<td><p id="qty[]">{{ $vsheet->date }}</p></td>
									<td></td>
									<td><p id="amount[]">{{ $vsheet->amount }}</p>
								</tr>
								@endforeach
							</tbody>
							@endif
							<tfoot>

								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>Sub Total ({{ $invoices[0]->currency }})</b></th>
							 		<th class="tdpr totalsum" class="form-control"><p id="totalprice">{{ $invoices[0]->totalprice }}</p></th>
							 		<input type="hidden" name="totalprices" id="totalprices" value="0">
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount">{{ $invoices[0]->totalamount }}</p></th>
							 		<input type="hidden" name="totalamounts" id="totalamounts" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>VAT ({{ $invoices[0]->vatp }}%)</b></th>
							 		<th class="tdpr totalsum"></th>
							 		<th class="tdam totalsum">{{ $invoices[0]->totalvat }}</th>
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>WHT ({{ $invoices[0]->whtp }}%)</b></th>
							 		<th class="tdpr totalsum"></th>
							 		<th class="tdam totalsum">{{ $invoices[0]->totalwht }}</th>
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><h4><b>Total ({{ $invoices[0]->currency }})</b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b>{{ $invoices[0]->sumamounts }}</b></h4></th>
							 	</tr>

							</tfoot>
						</table>
					</div>
						</div>
						<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Total Amount in Words</label>
							<p class="form-control" id="title">{{ $invoices[0]->amountinwords }}</p>
					 	</div><br />
					</div>
					<br /><br />
						<div class="col-sm-12" style="margin-top: 50px;">
					 		
							<p id="signature"><img src="{{ asset(app\Http\Controllers\Controller::staffsignature($invoices[0]->sentform)) }}" width="150px"></p>
							<p id="sender"><b>@php echo app\Http\Controllers\Controller::staffname($invoices[0]->sentform) @endphp</b><br />
								{{ app\Http\Controllers\Controller::staffdesignation($invoices[0]->sentform) }}<br />
								{{ $invoices[0]->created_at }}</p>
								
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
								<p class="form-control" id="title">{{ $invoices[0]->bank }}</p>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Number</label>
								<p class="form-control" id="title">{{ $invoices[0]->accountno }}</p>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Name</label>
								<p class="form-control" id="title">{{ $invoices[0]->accountname }}</p>
							</div>
						</div>
					</div><br /><br />
					</div>
				</div>

				
				<form action="submitinvoicestatus" id="submitinvoicestatus" method="post">
					@csrf
					<input type="hidden" name="invoiceid" value="{{ $invoices[0]->id }}">
					<input type="hidden" name="invoicetype" value="{{ $invoices[0]->invoicetype }}">
					<input type="hidden" name="sentfrom" value="{{ $invoices[0]->sentform }}">
					<input type="hidden" name="copies" value="{{ $invoices[0]->copies }}">
					<input type="hidden" name="project" value="{{ $invoices[0]->project }}">
				<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Invoice Status</h4>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Status</label>
								<select name="status" id="status" class="form-control" required>
									<option>{{ $invoices[0]->status }}</option>
									@if($invoices[0]->status == 'Unpaid')
									<option>Paid</option>
									@else
									<option>Unpaid</option>
									@endif
								</select>
							</div>
							<div class="col-sm-8">
						 		<label for="inputFirstName" class="form-label">Remark</label>
								<input type="text" name="remark" class="form-control" placeholder="Remark">
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
				

				<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Invoice Trail</h4>
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
						 		<h5>@if($pvtrail->status == 'Paid') <button class="btn btn-success px-5">{{ $pvtrail->status }}</button>@elseif($pvtrail->status == 'Unpaid') <button class="btn btn-danger px-5">{{ $pvtrail->status }}</button> 
										@else <button class="btn btn-warning px-5 ">{{ $pvtrail->status }}</button> 
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
@include("process.project")
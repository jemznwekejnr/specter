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
								<li class="breadcrumb-item active" aria-current="page">Create New Payment Voucher</li>
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

								<li><a class="dropdown-item" href="{{ url('sentpvs') }}">My PVs</a>
								</li>
								<li>
									<hr class="dropdown-divider">
								</li>
								<li><a class="dropdown-item" href="{{ url('dashboard') }}">Dashboard</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<form class="row g-3" method="post" action="submiteditpv" enctype="multipart/form-data" id="submiteditpv">
		 		@csrf
				  <div class="card-body" style="padding-top: 30px;">
				  	<div class="form-body">
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">PV Title</label>
							<input type="text" class="form-control" id="title" name="title" value="{{ $pvs[0]->title }}" required>
							<input type="hidden" class="form-control" id="id" name="id" value="{{ $pvs[0]->id }}">
					 	</div><br />
					 	<div class="col-sm-12">
					 	<div class="row g-3">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">PV Recipient</label>
								<select name="sendto" id="sendto" class="form-control">
									<option value="{{ $pvs[0]->sendto }}">{{ app\Http\Controllers\Controller::staffname($pvs[0]->sendto) }}</option>
								</select>
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">PV CC</label>
								<select data-placeholder="Begin typing a name to filter..." multiple class=" form-control" name="copies[]">
								    
								    <option value="{{ $pvs[0]->copies }}">@if(!empty($pvs[0]->copies)) |
											@php $copy = explode(",", $pvs[0]->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }} |
											@endfor
											@endif</option>
								    
								  </select>
							</div>
						</div>
					</div>
					 	<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">PV Body</label>
							<textarea class="form-control" id="body" name="body" placeholder="PV Body" required>{{ $pvs[0]->body }}</textarea>
								
					 	</div>

					 	
					 	
					 	<div class="col-sm-12" style="margin-top: 20px;" id="attachbutton">
						<div class="row g-3">
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Add Attachment</label>
								<input type="file" name="attachment" class="form-control" accept=".pdf" placeholder="Select Attachment">
							</div>
						 	<div class="col-sm-6">
								<label for="inputFirstName" class="form-label">Project</label>
								<select name="project" id="project" class="form-control" required>
									<option>{{ $pvs[0]->project }}</option>
									<option>Not Applicable</option>
								</select>
							</div>
						</div>
					</div><br /><br />
					

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
								<div class="col-sm-2 text-right float-right">
									<svg id="sumall" title="Click sum the entire record" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 6H8.83l6 6l-6 6H18v2H6v-2l6-6l-6-6V4h12v2Z"/></svg>

									<svg title="Click to sum the active tow" id="sumrow" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M0 1408v-128h1920v128H0zm0-896h1920v128H0V512z"/></svg>

									<svg title="Click to add a new row" id="addsheet" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg>

									<svg title="Click to remove the last row" id="minussheet" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7 13h10v-2H7"/></svg>

									<svg title="Click to edit row" class="vouchericon" id="editrow" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg>

									<select class="form-control" id="rowid" style="display: none;">
										<option>Select Row ID</option>
										@for($i=1; $i<=50; $i++)
										<option>{{ $i }}</option>
										@endfor
									</select>


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
									<td><p id="sn{{ $x }}">{{ $x }}</p></td>
									<td><input type="text" class="form-control" id="description{{ $x }}" name="description[]" value="{{ $vsheet->description }}" required></td>
									<td><input type="text" class="form-control qty" id="qty{{ $x }}" name="qty[]" value="{{ $vsheet->qty }}" required></td>
									<td><input type="text" class="form-control prc" id="price{{ $x }}" name="price[]" value="{{ $vsheet->unitprice }}" required></td>
									<td><p class="form-control amt" id="amount{{ $x }}">{{ $vsheet->amount }}</p>
						 			<input type="hidden" class="form-control" id="amounts{{ $x }}" name="amounts[]" value="{{ $vsheet->amount }}"></td>
									<td><input type="text" class="form-control" id="vatp{{ $x }}" name="vatp[]" value="{{ $vsheet->vatpercent }}"></td>
									<td><p class="form-control" id="vatamount{{ $x }}">{{ $vsheet->vatamount }}</p>
						 			<input type="hidden" class="form-control" id="vata{{ $x }}" name="vata[]" value="{{ $vsheet->vatamount }}"></td>
									<td><p class="form-control" id="grossamount{{ $x }}">{{ $vsheet->grossamount }}</p>
						 			<input type="hidden" class="form-control" id="gross{{ $x }}" name="gross[]" value="{{ $vsheet->grossamount }}"></td>
									<td><input type="text" class="form-control" id="whtp{{ $x }}" name="whtp[]" value="{{ $vsheet->whtpercent }}"></td>
									<td><p class="form-control" id="whtamount{{ $x }}">{{ $vsheet->whtamount }}</p>
						 			<input type="hidden" class="form-control" id="whta{{ $x }}" name="whta[]" value="{{ $vsheet->whtamount }}"></td>
									<td><p class="form-control" id="netamount{{ $x }}">{{ $vsheet->netamount }}</p>
						 			<input type="hidden" class="form-control" id="net{{ $x }}" name="net[]" value="{{ $vsheet->netamount }}"></td>
								</tr>
								@php $x++ @endphp
								@endforeach
							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b>Total</b></th>
							 		<th class="tdqt"><b></b></th>
							 		<th class="tdpr totalsum" id="totalprice">{{ $pvs[0]->totalprice }}</th>
							 		<input type="hidden" name="totalprices" id="totalprices" value="{{ $pvs[0]->totalprice }}">
							 		<th class="tdam totalsum" id="totalamount">{{ $pvs[0]->totalamount }}</th>
							 		<input type="hidden" name="totalamounts" id="totalamounts" value="{{ $pvs[0]->totalamount }}">
							 		<th class="tdva"><b></b></th>
							 		<th class="tdvt totalsum" id="totalvat"><b>{{ $pvs[0]->totalvat }}</b></th>
							 		<input type="hidden" name="totalvats" id="totalvats" value="{{ $pvs[0]->totalvat }}">
							 		<th class="tdgr totalsum" id="totalgross">{{ $pvs[0]->totalgross }}</th>
							 		<input type="hidden" name="totalgrosses" id="totalgrosses" value="{{ $pvs[0]->totalgross }}">
							 		<th class="tdwh"><b></b></th>
							 		<th class="tdwt totalsum" id="totalwht">{{ $pvs[0]->totalwht }}</th>
							 		<input type="hidden" name="totalwhts" id="totalwhts" value="{{ $pvs[0]->totalwht }}">
							 		<th class="tdnt totalsum" id="totalnet">{{ $pvs[0]->totalnet }}</th>
							 		<input type="hidden" name="totalnets" id="totalnets" value="{{ $pvs[0]->totalnet }}">
							</tfoot>
						</table>
					</div>
					<input type="hidden" name="counter" id="counter" value="{{ $vsheets->count() }}">
					<input type="hidden" name="countrow" id="countrow" value="{{ $vsheets->count() }}">
						</div>
						<div class="col-sm-12">
					 		<label for="inputFirstName" class="form-label">Net Amount in Words</label>
							<input type="text" class="form-control" id="amountinwords" name="amountinwords" value="{{ $pvs[0]->amountinwords }}">
					 	</div><br />
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
								<select name="bankname" id="bankname" class="form-control">
									<option>{{ $pvs[0]->bank }}</option>
								</select>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Number</label>
								<input type="text" name="accountnumber" maxlength="10" class="form-control" value="{{ $pvs[0]->accountno }}">
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Name</label>
								<input type="text" name="accountname" class="form-control" value="{{ $pvs[0]->accountname }}">
							</div>
						</div>
					</div><br /><br />
					</div>
				</div>


		<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Major Changes Made</h4>
						</div>
						<hr/>
					<div class="col-sm-12">
						<div class="row g-3">
						 	<div class="col-sm-10">
						 		<label for="inputFirstName" class="form-label">What changed on this PV</label>
								<input type="text" name="changes" id="changes" class="form-control" placeholder="Changes made">
							</div>
						 	<div class="col-sm-2 text-right float-right" style="padding-top: 25px;">
						 		<label for="inputFirstName" class="form-label"></label>
								<button class="btn btn-info" type="submit" id="button">Submit</button>
								<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
							</div>
						</div>
					</div><br /><br />
					</div>
				</div>

				</form>

</div>
<!--end page wrapper -->
@include("layouts.app-footer")
@include("process.paymentvoucher")
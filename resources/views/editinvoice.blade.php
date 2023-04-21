@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3"><a href="{{ url('allinvoices') }}">Client Invoice</a></div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Edit Client Invoice</li>
							</ol>
						</nav>
					</div>

					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-danger">{{ $pvs[0]->status }}</button>
							
						</div>
					</div>
				</div>
				<!--end breadcrumb-->

		<form class="row g-3" method="post" action="submiteditinvoice" enctype="multipart/form-data" id="submiteditinvoice">
		 		@csrf
		 
		<div class="card" style="padding-bottom: 30px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Invoice Info (#{{ $pvs[0]->invoiceno }})</h4>
						</div>
						<div class="dropdown ms-auto">
							<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
							</a>
							<ul class="dropdown-menu">

								<li><a class="dropdown-item" href="{{ url('invoicedetails?id='.$pvs[0]->id) }}">Cancel Edit</a>
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
				
		 		<input type="hidden" name="id" value="{{ $pvs[0]->id }}">
				  <div class="card-body" style="padding-top: 30px;">
				  	<div class="form-body">
				  		<div class="col-sm-7" style="margin-bottom: 15px;">
					 		<label for="inputFirstName" class="form-label">Project Title <span class="required" >*</span></label>
							<select name="project" id="project" class="form-control" required>
									<option value="{{ $pvs[0]->project }}">{{ app\Http\Controllers\Controller::projectname($pvs[0]->project) }}</option>
									<option>Not Applicable</option>
									@foreach($projects as $project)
									<option value="{{ $project->id }}">{{ $project->title }}</option>
									@endforeach
								</select>
					 	</div>

					 	<div class="col-sm-5" style="margin-bottom: 15px;">
					 		<label for="inputFirstName" class="form-label">Relia Office <span class="required" >*</span></label>
							<select name="office" id="office" class="form-control">
									<option value="{{ $pvs[0]->office }}">{{ app\Http\Controllers\Controller::officename($pvs[0]->office) }}</option>
									@foreach($infos as $info)
									<option value="{{ $info->id }}">{{ $info->address }} {{ $info->city }}, {{ $info->state }}</option>
									@endforeach
								</select>
					 	</div>
					 	
					 	<div class="col-sm-12">
					 	<div class="row g-3">
					 		<div class="col-sm-7" style="margin-bottom: 15px;">
					 		<label class="form-label">Client Details <span class="required" >*</span></label>
							<textarea class="form-control" id="clientdata" name="clientdata" style="height: 100px;" placeholder="Client Details" maxlength="5000" required>{{ $pvs[0]->clientinfo }}</textarea>
								
					 		</div>
						 	<div class="col-sm-5">
								<label for="inputFirstName" class="form-label">Invoice CC</label>
								<select data-placeholder="Begin typing a name to filter..." multiple class=" form-control" name="copies[]">
								    
								    <option></option>
								    @if(!empty($pvs[0]->copies))
										@php $copy = explode(",", $pvs[0]->copies) @endphp
									@endif

								    @foreach($staffs as $staff)
								    @if(Auth::user()->name != $staff->firstname.' '.$staff->surname.' '.$staff->othername)
								    @if($staff->id != 1)
								    @if(in_array($staff->id, $copy))
								    <option value="{{ $staff->id }}" selected>{{ $staff->firstname.' '.$staff->surname.' '.$staff->othername }}</option>
								    @else
								    <option value="{{ $staff->id }}">{{ $staff->firstname.' '.$staff->surname.' '.$staff->othername }}</option>
								    @endif
								    @endif
								    @endif
								    @endforeach
								  </select>
							</div>
						</div>
					</div>
					<div class="col-sm-12">
					 	<div class="row g-3">
					 		<div class="col-sm-5" style="margin-bottom: 15px;">
					 		<label class="form-label">Invoice Sheet <span class="required" >*</span></label>
							<select name="invoicetype" id="invoicetype" class="form-control" >
									<option>{{ $pvs[0]->invoicetype }}</option>
								</select>
								
					 		</div>
						 	<div class="col-sm-3">
								<label class="form-label">Invoice Currency <span class="required" >*</span></label>
								<select name="currency" id="currency" class="form-control" required>
									<option>{{ $pvs[0]->currency }}</option>
									<option>N</option>
									<option>$</option>
									<option>&#163;</option>
									<option>&#x20AC;</option>
								</select>
							</div>
							<div class="col-sm-4">
								<label class="form-label">Ref No. </label>
								<input type="text" name="refno" class="form-control" placeholder="Ref No." value="{{ $pvs[0]->refno }}">
							</div>
						</div>
					</div><br /><br />




						
					 </div>
				  </div>
			  </div>
		   </div>
		</div>


		@if($pvs[0]->invoicetype == "Sheet 1")
		<div class="card" id="invoicesheet1" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-10">
									<h4 class="mb-0">Invoice Sheet</h4>
								</div>
								<div class="col-sm-2 text-right float-right">
									<svg id="sumall1" title="Click sum the entire record" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 6H8.83l6 6l-6 6H18v2H6v-2l6-6l-6-6V4h12v2Z"/></svg>

									<svg title="Click to sum the active tow" id="sumrow1" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M0 1408v-128h1920v128H0zm0-896h1920v128H0V512z"/></svg>

									<svg title="Click to add a new row" id="addsheet1" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg>

									<svg title="Click to remove the last row" id="minussheet1" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7 13h10v-2H7"/></svg>

									<svg title="Click to edit row" class="vouchericon" id="editrow1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg>

									<select class="form-control" id="rowid1" style="display: none;">
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
							 		<th class="tdpr"><b>Price <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
							</thead>
							<tbody id="sheetdata1">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn{{ $x }}">{{ $x }}</p></td>
									<td><input type="text" class="form-control" id="description1{{ $x }}" name="description1[]" value="{{ $vsheet->description }}" required></td>
									<td><input type="text" class="form-control qty" id="qty1{{ $x }}" name="qty1[]" value="{{ $vsheet->qty }}" required></td>
									<td><input type="text" class="form-control prc" id="price1{{ $x }}" name="price1[]" value="{{ $vsheet->unitprice }}" required></td>
									<td><p class="form-control amt" id="amount1{{ $x }}">{{ $vsheet->amount }}</p>
						 			<input type="hidden" class="form-control" id="amounts1{{ $x }}" name="amounts1[]" value="{{ $vsheet->amount }}"></td>
								</tr>
								@php $x++ @endphp
								@endforeach
							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdpr totalsum" class="form-control"><p id="totalprice1">{{ $pvs[0]->totalprice }}</p></th>
							 		<input type="hidden" name="totalprices1" id="totalprices1" value="{{ $pvs[0]->totalprice }}">
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount1">{{ $pvs[0]->totalamount }}</p></th>
							 		<input type="hidden" name="totalamounts1" id="totalamounts1" value="{{ $pvs[0]->totalamount }}">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>VAT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="vatp1" id="vat1" value="{{ $pvs[0]->vatp }}" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="vatamount1">{{ $pvs[0]->totalvat }}</p></th>
							 		<input type="hidden" name="vatamounts1" id="vatamounts1" value="{{ $pvs[0]->totalvat }}">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>WHT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="whtp1" id="wht1" value="{{ $pvs[0]->whtp }}" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="whtamount1">{{ $pvs[0]->totalwht }}</p></th>
							 		<input type="hidden" name="whtamounts1" id="whtamounts1" value="{{ $pvs[0]->totalwht }}">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"></th>
							 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount1">{{ $pvs[0]->sumamounts }}</b></h4></th>
							 		<input type="hidden" name="sumamounts1" id="sumamounts1" value="{{ $pvs[0]->sumamounts }}">
							 	</tr>
							</tfoot>
							<input type="hidden" name="counter1" id="counter1" value="{{ $vsheets->count() }}">
							<input type="hidden" name="countrow1" id="countrow1" value="{{ $vsheets->count() }}">
								@elseif($pvs[0]->invoicetype == "Sheet 2")
								<div class="card" id="invoicesheet2" style="padding-bottom: 30px;">
						<div class="card-body">
							<div class="card-header">
								<div class="row">
									<div class="col-sm-10">
										<h4 class="mb-0">Invoice Sheet</h4>
									</div>
									<div class="col-sm-2 text-right float-right">
										<svg id="sumall2" title="Click sum the entire record" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 6H8.83l6 6l-6 6H18v2H6v-2l6-6l-6-6V4h12v2Z"/></svg>

										<svg title="Click to sum the active tow" id="sumrow2" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M0 1408v-128h1920v128H0zm0-896h1920v128H0V512z"/></svg>

										<svg title="Click to add a new row" id="addsheet2" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg>

										<svg title="Click to remove the last row" id="minussheet2" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7 13h10v-2H7"/></svg>

										<svg title="Click to edit row" class="vouchericon" id="editrow2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg>

										<select class="form-control" id="rowid2" style="display: none;">
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
							 		<th class="tdqt"><b>Period</b></th>
							 		<th class="tdpr"><b>Rate <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdqt"><b>Hours</b></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
								</thead>
								<tbody id="sheetdata2">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn{{ $x }}">{{ $x }}</p></td>
									<td><input type="text" class="form-control" id="description2{{ $x }}" name="description2[]" value="{{ $vsheet->description }}" required></td>
									<td><input type="text" class="form-control" id="period2{{ $x }}" name="period2[]" value="{{ $vsheet->period }}" required></td>
									<td><input type="text" class="form-control prc" id="price2{{ $x }}" name="rate2[]" value="{{ $vsheet->rate }}" required></td>
									<td><input type="text" class="form-control qty" id="qty2{{ $x }}" name="hours2[]" value="{{ $vsheet->hours }}" required></td>
									<td><p class="form-control amt" id="amount{{ $x }}">{{ $vsheet->amount }}</p>
						 			<input type="hidden" class="form-control" id="amounts2{{ $x }}" name="amounts2[]" value="{{ $vsheet->amount }}"></td>
								</tr>
								@php $x++ @endphp
								@endforeach
								</tbody>
								<tfoot>
									<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
								 		<th class="tdpr totalsum" class="form-control"><p id="totalprice2">{{ $pvs[0]->totalprice }}</p></th>
								 		<input type="hidden" name="totalprices2" id="totalprices2" value="{{ $pvs[0]->totalprice }}">
								 		<th class="tdam totalsum" class="form-control"><p id="totalamount2">{{ $pvs[0]->totalamount }}</p></th>
								 		<input type="hidden" name="totalamounts2" id="totalamounts2" value="{{ $pvs[0]->totalamount }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>VAT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="vatp2" id="vat2" value="{{ $pvs[0]->vatp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="vatamount2">{{ $pvs[0]->totalvat }}</p></th>
								 		<input type="hidden" name="vatamounts2" id="vatamounts2" value="{{ $pvs[0]->totalvat }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>WHT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="whtp2" id="wht2" value="{{ $pvs[0]->whtp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="whtamount2">{{ $pvs[0]->totalwht }}</p></th>
								 		<input type="hidden" name="whtamounts2" id="whtamounts2" value="{{ $pvs[0]->totalwht }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdds"></th>
								 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
								 		<th class="tdpr totalsum" class="form-control"></th>
								 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount2">{{ $pvs[0]->sumamounts }}</b></h4></th>
								 		<input type="hidden" name="sumamounts2" id="sumamounts2" value="{{ $pvs[0]->sumamounts }}">
								 	</tr>
								</tfoot>
								<input type="hidden" name="counter2" id="counter2" value="{{ $vsheets->count() }}">
								<input type="hidden" name="countrow2" id="countrow2" value="{{ $vsheets->count() }}">
								@elseif($pvs[0]->invoicetype == "Sheet 3")
								<div class="card" id="invoicesheet3" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-10">
									<h4 class="mb-0">Invoice Sheet</h4>
								</div>
								<div class="col-sm-2 text-right float-right">
									<svg id="sumall3" title="Click sum the entire record" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 6H8.83l6 6l-6 6H18v2H6v-2l6-6l-6-6V4h12v2Z"/></svg>

									<svg title="Click to sum the active tow" id="sumrow3" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M0 1408v-128h1920v128H0zm0-896h1920v128H0V512z"/></svg>

									<svg title="Click to add a new row" id="addsheet3" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg>

									<svg title="Click to remove the last row" id="minussheet3" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7 13h10v-2H7"/></svg>

									<svg title="Click to edit row" class="vouchericon" id="editrow3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg>

									<select class="form-control" id="rowid3" style="display: none;">
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
							 		<th class="tdds"><b>Name</b></th>
							 		<th class="tdqt"><b>Designation</b></th>
							 		<th class="tdqt"><b>Location</b></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
								</thead>
								<tbody id="sheetdata3">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn{{ $x }}">{{ $x }}</p></td>
									<td><input type="text" class="form-control" id="description3{{ $x }}" name="name3[]" value="{{ $vsheet->name }}" required></td>
									<td><input type="text" class="form-control qty" id="qty3{{ $x }}" name="designation3[]" value="{{ $vsheet->designation }}" required></td>
									<td><input type="text" class="form-control prc" id="price3{{ $x }}" name="location3[]" value="{{ $vsheet->location }}" required></td>
									<td><p class="form-control amt" id="amount3{{ $x }}">{{ $vsheet->amount }}</p>
						 			<input type="hidden" class="form-control" id="amounts3{{ $x }}" name="amounts3[]" value="{{ $vsheet->amount }}"></td>
								</tr>
								@php $x++ @endphp
								@endforeach
								</tbody>
								<tfoot>
									<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
								 		<th class="tdpr totalsum" class="form-control"><p id="totalprice3">{{ $pvs[0]->totalprice }}</p></th>
								 		<input type="hidden" name="totalprices3" id="totalprices3" value="{{ $pvs[0]->totalprice }}">
								 		<th class="tdam totalsum" class="form-control"><p id="totalamount3">{{ $pvs[0]->totalamount }}</p></th>
								 		<input type="hidden" name="totalamounts3" id="totalamounts3" value="{{ $pvs[0]->totalamount }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>VAT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="vatp3" id="vat3" value="{{ $pvs[0]->vatp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="vatamount3">{{ $pvs[0]->totalvat }}</p></th>
								 		<input type="hidden" name="vatamounts3" id="vatamounts3" value="{{ $pvs[0]->totalvat }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>WHT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="whtp3" id="wht3" value="{{ $pvs[0]->whtp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="whtamount3">{{ $pvs[0]->totalwht }}</p></th>
								 		<input type="hidden" name="whtamounts3" id="whtamounts3" value="{{ $pvs[0]->totalwht }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"></th>
								 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
								 		<th class="tdpr totalsum" class="form-control"></th>
								 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount3">{{ $pvs[0]->sumamounts }}</b></h4></th>
								 		<input type="hidden" name="sumamounts3" id="sumamounts3" value="{{ $pvs[0]->sumamounts }}">
								 	</tr>
								</tfoot>
								<input type="hidden" name="counter3" id="counter3" value="{{ $vsheets->count() }}">
								<input type="hidden" name="countrow3" id="countrow3" value="{{ $vsheets->count() }}">
								@elseif($pvs[0]->invoicetype == "Sheet 4")
								<div class="card" id="invoicesheet4" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<div class="row">
								<div class="col-sm-10">
									<h4 class="mb-0">Invoice Sheet</h4>
								</div>
								<div class="col-sm-2 text-right float-right">
									<svg id="sumall4" title="Click sum the entire record" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M18 6H8.83l6 6l-6 6H18v2H6v-2l6-6l-6-6V4h12v2Z"/></svg>

									<svg title="Click to sum the active tow" id="sumrow4" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 2048 2048"><path fill="currentColor" d="M0 1408v-128h1920v128H0zm0-896h1920v128H0V512z"/></svg>

									<svg title="Click to add a new row" id="addsheet4" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 17h2v-4h4v-2h-4V7h-2v4H7v2h4v4Zm1 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/></svg>

									<svg title="Click to remove the last row" id="minussheet4" class="vouchericon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 20c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8m0-18A10 10 0 0 0 2 12a10 10 0 0 0 10 10a10 10 0 0 0 10-10A10 10 0 0 0 12 2M7 13h10v-2H7"/></svg>

									<svg title="Click to edit row" class="vouchericon" id="editrow4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m19.3 8.925l-4.25-4.2l1.4-1.4q.575-.575 1.413-.575t1.412.575l1.4 1.4q.575.575.6 1.388t-.55 1.387L19.3 8.925ZM17.85 10.4L7.25 21H3v-4.25l10.6-10.6l4.25 4.25Z"/></svg>

									<select class="form-control" id="rowid4" style="display: none;">
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
							 		<th class="tdqt"><b>Date</b></th>
							 		<th></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
								</thead>
								<tbody id="sheetdata4">
								@php $x=1 @endphp
								@foreach($vsheets as $vsheet)
								<tr>
									<td><p id="sn{{ $x }}">{{ $x }}</p></td>
									<td><input type="text" class="form-control" id="description4{{ $x }}" name="description4[]" value="{{ $vsheet->description }}" required></td>
									<td><input type="text" class="form-control qty" id="qty4{{ $x }}" name="date4[]" value="{{ $vsheet->date }}" required></td>
									<td></td>
									<td><p class="form-control amt" id="amount4{{ $x }}">{{ $vsheet->amount }}</p>
						 			<input type="hidden" class="form-control" id="amounts4{{ $x }}" name="amounts4[]" value="{{ $vsheet->amount }}"></td>
								</tr>
								@php $x++ @endphp
								@endforeach
								</tbody>
								<tfoot>
									<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
								 		<th class="tdpr totalsum" class="form-control"><p id="totalprice4">{{ $pvs[0]->totalprice }}</p></th>
								 		<input type="hidden" name="totalprices4" id="totalprices4" value="{{ $pvs[0]->totalprice }}">
								 		<th class="tdam totalsum" class="form-control"><p id="totalamount4">{{ $pvs[0]->totalamount }}</p></th>
								 		<input type="hidden" name="totalamounts4" id="totalamounts4" value="{{ $pvs[0]->totalamount }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>VAT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="vatp4" id="vat4" value="{{ $pvs[0]->vatp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="vatamount4">{{ $pvs[0]->totalvat }}</p></th>
								 		<input type="hidden" name="vatamounts4" id="vatamounts4" value="{{ $pvs[0]->totalvat }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"><b></b></th>
								 		<th class="tdqt"><b>WHT (%)</b></th>
								 		<th class="tdpr totalsum"><input type="text" name="whtp4" id="wht4" value="{{ $pvs[0]->whtp }}" class="form-control" style="width: 70px"></th>
								 		<th class="tdam totalsum"><p id="whtamount4">{{ $pvs[0]->totalwht }}</p></th>
								 		<input type="hidden" name="whtamounts4" id="whtamounts4" value="{{ $pvs[0]->totalwht }}">
								 	</tr>
								 	<tr>	
								 		<th class="tdsn"><b></b></th>
								 		<th class="tdds"></th>
								 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
								 		<th class="tdpr totalsum" class="form-control"></th>
								 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount4">{{ $pvs[0]->sumamounts }}</b></h4></th>
								 		<input type="hidden" name="sumamounts4" id="sumamounts4" value="{{ $pvs[0]->sumamounts }}">
								 	</tr>
								</tfoot>
								<input type="hidden" name="counter4" id="counter4" value="{{ $vsheets->count() }}">
								<input type="hidden" name="countrow4" id="countrow4" value="{{ $vsheets->count() }}">
								@endif
						</table>
					</div>
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
						<div class="row g-3" style="margin-bottom: 10px;">
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
						<div class="row g-3" style="margin-bottom: 10px;">
						 	<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Bank Branch</label>
								<input type="text" name="branch" class="form-control" placeholder="Bank Branch" value="{{ $pvs[0]->branch }}" >
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Sort Code</label>
								<input type="text" name="sortcode" class="form-control" placeholder="Branch Sort Code" value="{{ $pvs[0]->sortcode }}" >
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">IBAN Number</label>
								<input type="text" name="ibanno" class="form-control" placeholder="IBAN Number" value="{{ $pvs[0]->ibanno }}" >
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
						 		<label for="inputFirstName" class="form-label">What changed on this Invoice</label>
								<input type="text" name="changes" id="changes" class="form-control" placeholder="Changes made" required>
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
@include("process.project")
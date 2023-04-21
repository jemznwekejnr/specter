@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3"><a href="{{ url('allinvoices') }}"> Client Invoice </a></div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0" style="background-color: transparent;">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-copy"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Create New Client Invoice</li>
							</ol>
						</nav>
					</div>
				</div>
		<!--end breadcrumb-->

	 <form method="post" action="submitinvoice" enctype="multipart/form-data" id="submitinvoice">
	 	@csrf
	 	
		<div class="card" style="padding-bottom: 30px;">
		       <div class="col-12 col-lg-12">
		          <div class=" radius-10">
				<div class="card-header">
					<div class="d-flex align-items-center">
						<div>
							<h4 class="mb-0">Invoice Info</h4>
						</div>
					</div>
				</div>
				  <div class="card-body" style="padding-top: 30px;">
				  	<div class="form-body">
					 	<div class="col-sm-7" style="margin-bottom: 15px;">
					 		<label for="inputFirstName" class="form-label">Project Title <span class="required" >*</span></label>
							<select name="project" id="project" class="form-control">
									<option value="">Select Project</option>
									<option>Not Applicable</option>
									@foreach($projects as $project)
									<option value="{{ $project->id }}">{{ $project->title }}</option>
									@endforeach
								</select>
					 	</div>

					 	<div class="col-sm-5" style="margin-bottom: 15px;">
					 		<label for="inputFirstName" class="form-label">Relia Office <span class="required" >*</span></label>
							<select name="office" id="office" class="form-control">
									<option value="" selected disabled>Select Address</option>
									@foreach($infos as $info)
									<option value="{{ $info->id }}">{{ $info->address }} {{ $info->city }}, {{ $info->state }}</option>
									@endforeach
								</select>
					 	</div>
					 	
					 	<div class="col-sm-12">
					 	<div class="row g-3">
					 		<div class="col-sm-7" style="margin-bottom: 15px;">
					 		<label for="inputFirstName" class="form-label">Client Details <span class="required" >*</span></label>
							<textarea class="form-control" id="clientdata" name="clientdata" style="height: 100px;" placeholder="Client Details" maxlength="5000" required></textarea>
								
					 		</div>
						 	<div class="col-sm-5">
								<label for="inputFirstName" class="form-label">Invoice CC</label>
								<select data-placeholder="Begin typing a name to filter..." multiple class=" form-control" name="copies[]">
								    
								    <option></option>
								    @foreach($staffs as $staff)
								    @if(Auth::user()->name != $staff->firstname.' '.$staff->surname.' '.$staff->othername)
								    @if($staff->id != 1)
								    <option value="{{ $staff->id }}">{{ $staff->firstname.' '.$staff->surname.' '.$staff->othername }}</option>
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
							<select name="invoicetype" id="invoicetype" class="form-control" required>
									<option value="">Select Sheet Type</option>
									<option>Sheet 1</option>
									<option>Sheet 2</option>
									<option>Sheet 3</option>
									<option>Sheet 4</option>
								</select>
								
					 		</div>
						 	<div class="col-sm-3">
								<label class="form-label">Invoice Currency <span class="required" >*</span></label>
								<select name="currency" id="currency" class="form-control" required>
									<option>N</option>
									<option>$</option>
									<option>&#163;</option>
									<option>&#x20AC;</option>
								</select>
							</div>
							<div class="col-sm-4">
								<label class="form-label">Ref No. </label>
								<input type="text" name="refno" class="form-control" placeholder="Ref No.">
							</div>
						</div>
					</div><br /><br />
						
					 
					 </div>
				  </div>
			  </div>
		   </div>
		</div>


		<!--- Invoice Sheet 1 --->
		<div class="card" id="invoicesheet1" style="padding-bottom: 30px; display: none;">
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
								<tr>
									<td><p id="sn1">1 <span class="required" >*</span></p></td>
									<td><input type="text" class="form-control" id="description11" name="description1[]" placeholder="Description"></td>
									<td><input type="text" class="form-control qty" id="qty11" name="qty1[]" value="0"></td>
									<td><input type="text" class="form-control prc" id="price11" name="price1[]" value="0.00"></td>
									<td><p class="form-control amt" id="amount11">0.00</p>
						 			<input type="hidden" class="form-control" id="amounts11" name="amounts1[]" value="0.00"></td>
								</tr>

							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdpr totalsum" class="form-control"><p id="totalprice1">0.00</p></th>
							 		<input type="hidden" name="totalprices" id="totalprices1" value="0">
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount1">0.00</p></th>
							 		<input type="hidden" name="totalamounts" id="totalamounts1" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>VAT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="vatp1" id="vat1" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="vatamount1">0.00</p></th>
							 		<input type="hidden" name="vatamounts1" id="vatamounts1" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>WHT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="whtp1" id="wht1" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="whtamount1">0.00</p></th>
							 		<input type="hidden" name="whtamounts1" id="whtamounts1" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"></th>
							 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount1">0.00</b></h4></th>
							 		<input type="hidden" name="sumamounts1" id="sumamounts1" value="0">
							 	</tr>
							</tfoot>
						</table>
					</div>
					<input type="hidden" name="counter1" id="counter1" value="1">
					<input type="hidden" name="countrow1" id="countrow1" value="1">
						</div>
					</div>
				</div>

	</div>

	<!--- Invoice Sheet 1 --->


	<!--- Invoice Sheet 2 --->

	<div class="card" id="invoicesheet2" style="padding-bottom: 30px; display: none;">
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
							 		<th class="tdds"><b>Period</b></th>
							 		<th class="tdpr"><b>Rate/Hour <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdqt"><b>Total Hours</b></th>
							 		<th class="tdam"><b>Total Amount <span class="currency">(&#8358;)</span></b></th>
							</thead>
							<tbody id="sheetdata2">
								<tr>
									<td><p id="sn2">1 <span class="required" >*</span></p></td>
									<td><input type="text" class="form-control" id="description21" name="description2[]" placeholder="Description"></td>
									<td><input type="text" class="form-control" id="period21" name="period2[]" placeholder="Period"></td>
									<td><input type="text" class="form-control prc" id="price21" name="rate2[]" value="0.00"></td>
									<td><input type="text" class="form-control qty" id="qty21" name="hours2[]" value="0"></td>
									<td><p class="form-control amt" id="amount21">0.00</p>
						 			<input type="hidden" class="form-control" id="amounts21" name="amounts2[]" value="0.00"></td>
								</tr>

							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount2">0.00</p></th>
							 		<input type="hidden" name="totalamounts2" id="totalamounts2" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>VAT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="vatp2" id="vat2" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="vatamount2">0.00</p></th>
							 		<input type="hidden" name="vatamounts2" id="vatamounts2" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>WHT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="whtp2" id="wht2" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="whtamount2">0.00</p></th>
							 		<input type="hidden" name="whtamounts2" id="whtamounts2" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount2">0.00</b></h4></th>
							 		<input type="hidden" name="sumamounts2" id="sumamounts2" value="0">
							 	</tr>
							</tfoot>
						</table>
					</div>
					<input type="hidden" name="counter2" id="counter2" value="1">
					<input type="hidden" name="countrow2" id="countrow2" value="1">
						</div>
					</div>
				</div>

	</div>

	<!---- Invoice Sheet 2 ------->


	<!--- Invoice Sheet 3 --->

	<div class="card" id="invoicesheet3" style="padding-bottom: 30px; display: none;">
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
							 		<th class="tdds"><b>Designation</b></th>
							 		<th class="tdds"><b>Location</b></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
							</thead>
							<tbody id="sheetdata3">
								<tr>
									<td><p id="sn1">1 <span class="required" >*</span></p></td>
									<td><input type="text" class="form-control" id="name31" name="name3[]" placeholder="Name"></td>
									<td><input type="text" class="form-control" id="designation31" name="designation3[]" placeholder="Designation"></td>
									<td><input type="text" class="form-control" id="location31" name="location3[]" placeholder="Location"></td>
						 			<td><input type="text" class="form-control" id="amounts31" name="amounts3[]" value="0.00"></td>
								</tr>

							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount3">0.00</p></th>
							 		<input type="hidden" name="totalamounts3" id="totalamounts3" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>MARK-UP (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="whtp3" id="wht3" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="whtamount3">0.00</p></th>
							 		<input type="hidden" name="whtamounts3" id="whtamounts3" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"><b></b></th>
							 		<th class="tdqt"><b>VAT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="vatp3" id="vat3" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="vatamount3">0.00</p></th>
							 		<input type="hidden" name="vatamounts3" id="vatamounts3" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdds"></th>
							 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount3">0.00</b></h4></th>
							 		<input type="hidden" name="sumamounts3" id="sumamounts3" value="0">
							 	</tr>
							</tfoot>
						</table>
					</div>
					<input type="hidden" name="counter3" id="counter3" value="1">
					<input type="hidden" name="countrow3" id="countrow3" value="1">
						</div>
					</div>
				</div>

	</div>

	<!---- Invoice Sheet 3 ------->


	<!--- Invoice Sheet 4 --->

	<div class="card" id="invoicesheet4" style="padding-bottom: 30px; display: none;">
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
							 		<th class="tdds"><b>Date</b></th>
							 		<th class="tdam"><b>Amount <span class="currency">(&#8358;)</span></b></th>
							</thead>
							<tbody id="sheetdata4">
								<tr>
									<td><p id="sn1">1 <span class="required" >*</span></p></td>
									<td><input type="text" class="form-control" id="description41" name="description4[]" placeholder="Description"></td>
									<td><input type="date" class="form-control" id="date41" name="date4[]"></td>
						 			<td><input type="text" class="form-control" id="amounts41" name="amounts4[]" value="0.00"></td>
								</tr>

							</tbody>
							<tfoot>
								<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdqt"><b>Sub Total <span class="currency">(&#8358;)</span></b></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><p id="totalamount4">0.00</p></th>
							 		<input type="hidden" name="totalamounts4" id="totalamounts4" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdqt"><b>VAT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="vatp4" id="vat4" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="vatamount4">0.00</p></th>
							 		<input type="hidden" name="vatamounts4" id="vatamounts4" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdqt"><b>WHT (%)</b></th>
							 		<th class="tdpr totalsum"><input type="text" name="whtp4" id="wht4" value="0.00" class="form-control" style="width: 70px"></th>
							 		<th class="tdam totalsum"><p id="whtamount4">0.00</p></th>
							 		<input type="hidden" name="whtamounts4" id="whtamounts4" value="0">
							 	</tr>
							 	<tr>	
							 		<th class="tdsn"><b></b></th>
							 		<th class="tdqt"><h4><b>Total <span class="currency">(&#8358;)</span></b></h4></th>
							 		<th class="tdpr totalsum" class="form-control"></th>
							 		<th class="tdam totalsum" class="form-control"><h4><b id="sumamount4">0.00</b></h4></th>
							 		<input type="hidden" name="sumamounts4" id="sumamounts4" value="0">
							 	</tr>
							</tfoot>
						</table>
					</div>
					<input type="hidden" name="counter4" id="counter4" value="1">
					<input type="hidden" name="countrow4" id="countrow4" value="1">
						</div>
					</div>
				</div>

	</div>

	<!---- Invoice Sheet 4 ------->


	<div class="card" style="padding-bottom: 30px;">
					<div class="card-body">
						<div class="card-header">
							<h4 class="mb-0">Beneficiary Bank Details</h4>
						</div>
						<hr/>

						<div class="col-sm-12" style="margin-bottom: 10px;">
					 		<label for="inputFirstName" class="form-label">Total Amount in Words</label>
							<input type="text" class="form-control" id="amountinwords" name="amountinwords" placeholder="Type Net Amount in Words">
					 	</div><br />
					<div class="col-sm-12">
						<div class="row g-3" style="margin-bottom: 10px;">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Bank Name <span class="required" >*</span></label>
								<select name="bankname" id="sendto" class="form-control" required>
									<option value="">Select Bank</option>
									@foreach($banks as $bank)
									<option>{{ $bank->banks }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Account Number <span class="required" >*</span></label>
								<input type="text" name="accountnumber" max="10" maxlength="10" class="form-control" placeholder="Account Number" required>
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">Account Name <span class="required" >*</span></label>
								<input type="text" name="accountname" class="form-control" placeholder="Account Name" required>
							</div>
						</div>
						<div class="row g-3" style="margin-bottom: 10px;">
						 	<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Bank Branch</label>
								<input type="text" name="branch" class="form-control" placeholder="Bank Branch" >
							</div>
							<div class="col-sm-3">
						 		<label for="inputFirstName" class="form-label">Sort Code</label>
								<input type="text" name="sortcode" class="form-control" placeholder="Branch Sort Code" >
							</div>
							<div class="col-sm-4">
						 		<label for="inputFirstName" class="form-label">IBAN Number</label>
								<input type="text" name="ibanno" class="form-control" placeholder="IBAN Number" >
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
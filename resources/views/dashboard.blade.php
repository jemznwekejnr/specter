@include("layouts.app-title")
<body>
@include("layouts.app-sidebar")
@include("layouts.app-header")
<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10 border-warning border-start border-0 border-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0">Total Expenses {{ date('F, Y') }}</p>
										<h4 class="my-1 text-warning">{{ number_format(app\Http\Controllers\Controller::expensesthismonth(), 2) }}</h4>
									</div>
									<div class="text-warning ms-auto font-35">&#8358;
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-primary border-start border-0 border-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0">Total Inflow {{ date('F, Y') }}</p>
										<h4 class="my-1 text-primary">0.00</h4>
									</div>
									<div class="text-primary ms-auto font-35">&#8358;
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-danger border-start border-0 border-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0">Total Expenses {{ date('Y') }}</p>
										<h4 class="my-1 text-danger">{{ number_format(app\Http\Controllers\Controller::expensesthisyear(), 2) }}</h4>
									</div>
									<div class="text-danger ms-auto font-35">&#8358;
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10  border-success border-start border-0 border-4">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0">Total Inflow {{ date('Y') }}</p>
										<h4 class="text-success my-1">0.00</h4>
									</div>
									<div class="text-success ms-auto font-35">&#8358;
									</div>
								</div>
							</div>
						</div>
					</div>
				</div><!--end row-->

				<div class="row">
                   <div class="col-12 col-lg-8">
                      <div class="card radius-10">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Inflow vs Expenses Overview {{ date('Y') }}</h6>
								</div>
								<div class="dropdown ms-auto">
									<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
									</a>
									<ul class="dropdown-menu">
										<!--<li><a class="dropdown-item" href="javascript:;">Action</a>
										</li>
										<li><a class="dropdown-item" href="javascript:;">Another action</a>
										</li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li><a class="dropdown-item" href="javascript:;">Something else here</a>
										</li>-->
									</ul>
								</div>
							</div>
						</div>
						  <div class="card-body">
							<div class="chart-container-0">
								<canvas id="chart1"></canvas>
							  </div>
						  </div>
					  </div>
				   </div>
				   <div class="col-12 col-lg-4">
                       <div class="card radius-10">
						<div class="card-header">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Inflow vs Expenses {{ date('Y') }}</h6>
								</div>
								<div class="dropdown ms-auto">
									<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
									</a>
									<ul class="dropdown-menu">
										<!--<li><a class="dropdown-item" href="javascript:;">Action</a>
										</li>
										<li><a class="dropdown-item" href="javascript:;">Another action</a>
										</li>
										<li>
											<hr class="dropdown-divider">
										</li>
										<li><a class="dropdown-item" href="javascript:;">Something else here</a>
										</li>-->
									</ul>
								</div>
							</div>
						</div>
						   <div class="card-body">
							<div class="chart-container-0">
								<canvas id="chart2"></canvas>
							  </div>
						   </div>
					   </div>
				   </div>
				</div><!--end row-->
				

				 <div class="card radius-10">
                         <div class="card-body">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">Recent Expenses</h6>
								</div>
								<div class="dropdown ms-auto">
									<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
									</a>
									<ul class="dropdown-menu">
										<li><a class="dropdown-item" href="{{ url('allpvs') }}">View All</a>
										</li>
										<li>
											<hr class="dropdown-divider">
										</li>
									</ul>
								</div>
							</div>
						 <div class="table-responsive">
						   <table class="table align-middle mb-0">
							<thead class="table-light">
							 <tr>
										<th>Date</th>
										<th>Title</th>
										<th>Net Amount (&#8358;)</th>
										<th>Created By</th>
										<th>Sent To</th>
										<th>CCs</th>
										<th>Status</th>
									</tr>
							 </thead>
							 <tbody>@foreach($pvs as $pv)
									<tr>
										<td>{{ $pv->created_at }}</td>
										<td>{{ $pv->title }}</td>
										<td>{{ $pv->totalnet }}</td>
										<td>{{ app\Http\Controllers\Controller::staffname($pv->sentform) }}</td>
										<td>{{ app\Http\Controllers\Controller::staffname($pv->sendto) }}</td>
										<td>@if(!empty($pv->copies)) |
											@php $copy = explode(",", $pv->copies) @endphp
											@for($j=0; $j < count($copy); $j++)
											{{ app\Http\Controllers\Controller::staffname($copy[$j]) }} |
											@endfor
											@endif</td>
										<td>
											<a href="{{ url('pvdetails?id='.$pv->id) }}">@if($pv->status == "Pending Approval")
											<button type="button" class="btn btn-warning btn-sm">{{ $pv->status }}</button>
											@elseif($pv->status == "Approved")
											<button type="button" class="btn btn-primary btn-sm">{{ $pv->status }}</button>
											@elseif($pv->status == "Paid")
											<button type="button" class="btn btn-success btn-sm">{{ $pv->status }}</button>
											@elseif($pv->status == "Rejected")
											<button type="button" class="btn btn-danger btn-sm">{{ $pv->status }}</button>
											@else
											<button type="button" class="btn btn-info btn-sm">{{ $pv->status }}</button>
											@endif</a>
											</td>
										
									</tr>
									@endforeach
						    </tbody>
						  </table>
						  </div>
						 </div>
					  </div>

					  <!--<div class="card radius-10 w-100">
						<div class="card-header bg-transparent">
							<div class="d-flex align-items-center">
								<div>
									<h6 class="mb-0">World Map</h6>
								</div>
								<div class="dropdown ms-auto">
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
								</div>
							</div>
						   </div>
						<div class="card-body">
							<div id="geographic-map-2"></div>
						 </div>
					   </div>-->

			</div>
		</div>
		<!--end page wrapper -->
@include("layouts.app-footer")
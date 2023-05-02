@include("layouts.app-title")
@include("layouts.app-header")
@include("layouts.app-sidebar")
<!--**********************************
    Content body start
***********************************-->
<style>
	.previous{
		display: none !important;
	}
	.next{
		display: none !important;
	}
	#example_previous{
		display: none;
	}
	#example_next{
		display: none;
	}
</style>
<div class="content-body">
    <!-- row -->	
	<div class="page-titles">
		<ol class="breadcrumb">
			<li><h5 class="bc-title">Dashboard</h5></li>
			<li class="breadcrumb-item"><a href="javascript:void(0)">
				<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M2.125 6.375L8.5 1.41667L14.875 6.375V14.1667C14.875 14.5424 14.7257 14.9027 14.4601 15.1684C14.1944 15.4341 13.8341 15.5833 13.4583 15.5833H3.54167C3.16594 15.5833 2.80561 15.4341 2.53993 15.1684C2.27426 14.9027 2.125 14.5424 2.125 14.1667V6.375Z" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M6.375 15.5833V8.5H10.625V15.5833" stroke="#2C2C2C" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				Home </a>
			</li>
			<li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
		</ol>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-12 wid-100">
				<div class="row">
					<!--Start--
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Search Entity (Person or Organization)</h4>
							</div>
							<div class="card-body">
								<div class="basic-form">
									<form action="submitsearch" method="post" id="submitsearch">
									@csrf
									<div class="row">
										<div class="col-xl-5 col-md-5">
											<div class="mb-3">
												<input type="text" class="form-control input-rounded" name="searchtext" placeholder="Enter Query Text (Name or Organization)">
											</div>
										</div>
										<div class="col-xl-3 col-md-3">
											<div class="mb-3">
												<input type="date" class="form-control input-rounded" name="startdate" placeholder="Start Date(OPTIONAL): e.g. '20131224'">
											</div>
										</div>
										<div class="col-xl-3 col-md-3">
											<div class="mb-3">
												<input type="date" class="form-control input-rounded" name="enddate" placeholder="End Date(OPTIONAL): e.g. '20131230'">
											</div>
										</div>
										<div class="col-xl-1 col-md-1">
											<div class="mb-6">
												<button type="submit" id="button" class="btn btn-primary btn-sm btn-rounded">Search</button>
												<img src="{{ asset('assets/images/processing.gif') }}" width="50px;" id="processing" class="processing" style="display: none;">
											</div>
										</div>
									</div>
								</form>
								</div>
							</div>
						</div>
					</div>
					<!--End-->
					<!--Start of Tab-->
					<div class="col-xl-12 col-lg-12">
						<div class="card">
							<div class="card-body pt-0">
								<!-- Nav tabs -->
								<div class="custom-tab-1">
									<ul class="nav nav-tabs">
										<li class="nav-item">
											<a class="nav-link active" data-bs-toggle="tab" href="#home1"><i class="la la-line-chart me-2"></i> Data Core</a>
										</li>
										
									</ul>
									<!-- Content -->
									<div class="tab-content">
										<div class="tab-pane fade show active" id="home1" role="tabpanel">
											<div class="pt-4">
												<h4>Table Showing All similar Entities of {{ $_GET["searchtext"] }} Retrieved from Data Core</h4>
												<div class="row">
													<!--Table-->
													<div class="col-xl-6 active-p">
														<div class="card">
															<div class="card-body p-0">
																<div class="table-responsive active-projects" style="padding: 20px;">
																<div class="tbl-caption">
																	
																</div>
																<table id="example" class="table example table-striped">
																<thead>
																	<tr>
																		<th>Action</th>
																		<th>Event Date</th>
																		<th>Entity Name</th>
																		<th>Entity Count</th>
																		<th>Event Location</th>
																		<th>Reporting Media</th>
																		<th>Report Source</th>
																	</tr>
																</thead>
																<tbody>
																	@isset($table_data)
																	@foreach($table_data as $data)
																	<tr>
																		<td>
																			@isset($startdate)
																				@isset($enddate)
																					<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id'].'&startdate='.$startdate.'&enddate='.$enddate) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																				@else
																					<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id'].'&startdate='.$startdate) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																				@endisset
																				@else
																				<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id']) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																			@endisset
																		</td>
																		<td class="pe-0">{{ $data["event_day"] }}</td>
																		<td>
																			@isset($startdate)
																				@isset($enddate)
																					<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id'].'&startdate='.$startdate.'&enddate='.$enddate) }}" target="_blank">{{ $data["entity_name"] }}</a>
																				@else
																					<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id'].'&startdate='.$startdate) }}" target="_blank">{{ $data["entity_name"] }}</a>
																				@endisset
																				@else
																				<a href="{{ url('sentities?searchtext='.$data['entity_name'].'&event_id='.$data['event_id']) }}" target="_blank">{{ $data["entity_name"] }}</a>
																			@endisset
																		</td>
																		<td>{{ $data["entity_count"] }}</td>
																		<td class="pe-0">{{ $data["event_location"] }}</td>
																		<td>{{ $data["media_house"] }}</td>
																		<td><a href="{{ $data['source_url'] }}" class="badge badge-danger light border-0" target="_blank">View</a></td>
																	</tr>
																	@endforeach
																	@endisset
																</tbody>
																
															</table>
																</div>
															</div>
														</div>
													</div>
													<!--End of Table-->

													<!--Map-->
													<div class="col-xl-6 col-md-6 flag">
														<div class="card overflow-hidden">
															<div class="card-header border-0">
																<h4 class="heading mb-0">Map Showing Location of Events Similar to Queried String</h4>
															</div>
															<div class="card-body pe-0">
																<div class="row">
																	<div class="col-xl-8 active-map-main">
																		@include("process.map")
																		<div id="map_markers_div" style="width: 100%; height: 400px"></div>  
																	</div>
																	<div class="col-xl-4 active-country dz-scroll">
																		<div class="">

																			@isset($locator)
																			@foreach($locator as $key => $value)
																			<div class="country-list">
																				<img src="{{ asset('assets/images/country/nigeria.png') }}" alt="">
																				<div class="progress-box mt-0">
																					<div class="d-flex justify-content-between">
																						<p class="mb-0 c-name">{{ $key }}</p>
																						<p class="mb-0">{{ number_format($value / $count_locator * 100, 2) }}%</p>
																					</div>
																					<div class="progress">
																						<div class="progress-bar bg-primary" style="width:{{ $value / $count_locator * 100 }}%; height:5px; border-radius:4px;" role="progressbar"></div>
																					</div>
																				</div>
																			</div>
																			@endforeach
																			@endisset
																			
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<!--End of Map-->


												</div>
												
											</div>
										</div>
										<!-- end of tab -->
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--End of Tabs-->
			
				</div>
			</div>
			
		</div>
		<!--End of First section-->
		<div class="row">
			<!--Barchart-->
			<div class="col-xl-6">
				<div class="card overflow-hidden">
					<div class="card-header border-0 pb-0 flex-wrap">
						<h4 class="heading mb-0">Barchart Showing Enitities Frequency  (Events from Results) </h4>
					</div>
					<div class="card-body  p-0">
							@include('process.charts')
							<div id="columnchart_values" style="width: 100%; height: 400px;"></div>
						
					</div>
				</div>
			</div>
			<!--End of Barchart-->
			<!--results Table-->
			<div class="col-xl-6">
				<!--Table-->
				<div class="card">
					<div class="card-body p-0">
						<div class="table-responsive active-projects" style="padding: 20px;">
						<div class="tbl-caption">
							<h4 class="heading mb-0">Table Showing List of Similar Enitities and Frequency of Events for Retrieved Results</h4>
						</div>
							<table id="projects-tbl" class="table example table-striped table-bordered">
								<thead>
									<tr>
										<th>Entity Name</th>
										<th>Entity Type</th>
										<th>Frequency</th>
									</tr>
								</thead>
								<tbody>
									@foreach($table_datas as $datas)
									<tr>
										<td>{{ $datas['entity_name'] }}</td>
										<td>{{ $datas['entity_type'] }}</td>
										<td>{{ $datas['entity_type'] }}</td>
									</tr>
									@endforeach
									
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
				<!--End of Table-->
			</div>
			<!--End of results Table-->
		</div>
        <!--End of second section-->
        <div class="row">
			<!--results Table-->
			<div class="col-xl-6">
				<!--Table-->
				<div class="card">
					<div class="card-body p-0">
						<div class="table-responsive active-projects" style="padding: 20px;">
						<div class="tbl-caption">
							<h4 class="heading mb-0">Table Showing Crime Distribution for Retrieved Events</h4>
						</div>
							<table id="projects-tbl" class="table example table-striped">
								<thead>
									<tr>
										<th>Entity Name</th>
										<th>Event Date</th>
										<th>Crime Prediction</th>
										<th>Frequency</th>
									</tr>
								</thead>
								<tbody>
									@foreach($graph_datas as $graph)
									<tr>
										<td>{{ $graph["entity_name"] }}</td>
										<td>{{ $graph["event_date"] }}</td>
										<td>{{ $graph["crime_prediction"] }}</td>
										<td>{{ $graph["frequency"] }}</td>
									</tr>
									@endforeach
								</tbody>
								
							</table>
						</div>
					</div>
				</div>
				<!--End of Table-->
			</div>
			<!--End of results Table-->
            <!--Piechart-->
			<div class="col-xl-6">
				<div class="card h-auto">
                    <div class="card-header pb-0 border-0">
                        <h4 class="heading mb-0">Piechart of Crime Distribution for Retrieved Events</h4>
                    </div>
                    <div class="card-body">
                    	@include("process.gpiechart")
                    	<div id="piechart" style="width: 100%; height: 600px;"></div>
                        
                    </div>
                </div>
			</div>
			<!--End of Piechart-->
		</div>
        <!--End of Third section-->
        <div class="row">
            <!--Barchart-->
			<div class="col-xl-12">
				<div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Graph Showing Frequency of Retrieved Entities Over a Timeline</h4>
                    </div>
                    <div class="card-body">
                     @include("process.barchart")
					<div id="line_chart" style="width: 100%; height: 400px;"></div>
                    </div>
                </div>
			</div>
			<!--End of Barchart-->
        </div>
	</div>
</div>

<!--**********************************
    Content body end
***********************************-->
@include("layouts.app-footer")
<script>
	$(document).ready(function() {
		$('.example').DataTable();
	  });
</script>
@include("process.dashboard")
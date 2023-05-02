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
			<div class="col-xl-12 col-md-12 col-lg-12">
				<div class="card">
					<div class="card-body pt-0">
						<!-- Nav tabs -->
						<div class="custom-tab-1">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" data-bs-toggle="tab" href="#home1"><i class="la la-line-chart me-2"></i> Data Core</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#web"><i class="la la-globe me-2"></i> Web</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" data-bs-toggle="tab" href="#pep"><i class="la la-dashcube me-2"></i>  External PEP & Sanction Data</a>
								</li>
								
							</ul>
							<!-- Content -->
							<div class="tab-content">
								<div class="tab-pane fade show active" id="home1" role="tabpanel">
									<div class="pt-4">
										<h4>Showing results for [ Query_TEXT ]</h4>
										<div class="row">
											<!--Table-->
											<div class="col-xl-6 col-md-6 active-p">
												<div class="card">
													<div class="card-body p-0">
														<div class="table-responsive active-projects">
														<div class="tbl-caption">
															<h4 class="heading mb-0">Table Showing All Similar Entities Retrieved from Data Core</h4>
														</div>
															<table id="example" class="table example table-striped">
																<thead>
																	<tr>
																		<th>Action</th>
																		<th>Event Date</th>
																		<th>Entity Name</th>
																		<th>Entity Type</th>
																		<th>Event Location</th>
																		<th>Report Source</th>
																		<th>Crime Prediction</th>
																	</tr>
																</thead>
																<tbody>
																	@isset($search_table_data)
																	@foreach($search_table_data as $data)
																	<tr>
																		<td>
																			@isset($startdate)
																				@isset($enddate)
																					<a href="{{ url('gentities?searchtext='.$data['entity_name'].'&startdate='.$startdate.'&enddate='.$enddate) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																				@else
																					<a href="{{ url('gentities?searchtext='.$data['entity_name'].'&startdate='.$startdate) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																				@endisset
																				@else
																				<a href="{{ url('gentities?searchtext='.$data['entity_name']) }}" target="_blank" class="badge badge-primary light border-0">Expand</a>
																			@endisset
																		</td>
																		<td class="pe-0">{{ $data["event_date"] }}</td>
																		<td>
																			@isset($startdate)
																				@isset($enddate)
																					<a href="{{ url('gentities?searchtext='.$data['entity_name'].'&startdate='.$startdate.'&enddate='.$enddate) }}" target="_blank">{{ $data["entity_name"] }}</a>
																				@else
																					<a href="{{ url('gentities?searchtext='.$data['entity_name'].'&startdate='.$startdate) }}" target="_blank">{{ $data["entity_name"] }}</a>
																				@endisset
																				@else
																				<a href="{{ url('gentities?searchtext='.$data['entity_name']) }}" target="_blank">{{ $data["entity_name"] }}</a>
																			@endisset
																		</td>
																		<td>{{ $data["entity_type"] }}</td>
																		<td class="pe-0">{{ $data["event_location"] }}</td>
																		<td>{{ $data["media_house"] }}</td>
																		<td class="pe-0">
																			@php $prediction = $data["crime_prediction"] @endphp
																			@for($i=0; $i < count($prediction); $i++)
																				{{ $prediction[$i] }},
																			@endfor
																		</td>
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
														<h4 class="heading mb-0"> Map Showing Location of Events Similar to Queried String </h4>
													</div>
													<div class="card-body pe-0">
														<div class="row">
															<div class="col-xl-8">
																<!--<div id="world-map" class="active-map"></div>-->
																@include("process.map")
																<div id="map_markers_div" style="width: 600px; height: 400px"></div>
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
								<div class="tab-pane fade" id="web">
									<div class="row">
										<!--Table-->
										<div class="col-xl-12 col-md-12 active-p">
											<div class="card">
												<div class="card-body p-0">
													<div class="table-responsive active-projects">
													<div class="tbl-caption">
														<h4 class="heading mb-0">Table Showing Results From the Web</h4>
													</div>
														<table id="projects-tbl_2" class="table table-striped example">
															<thead>
																<tr>
																	<th>Position</th>
																	<th>Title</th>
																	<th>Description</th>
																	<th>Resource Link</th>
																</tr>
															</thead>
															<tbody>
																@isset($web_results)
																@foreach($web_results as $web_result)
																<tr>
																	<td>{{ $web_result["position"] }}</td>
																	<td>{{ $web_result["title"] }}</td>
																	<td class="pe-0">{{ $web_result["description"] }}</td>
																	<td class="pe-0"><a href="{{ $web_result['link'] }}" class="badge badge-primary light border-0" target="_blank">View</a></td>
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
									</div>
								</div>
								<!-- end of tab -->
								<div class="tab-pane fade" id="pep">
									<div class="row">
										<!--Table-->
										<div class="col-xl-12 col-md-12 active-p">
											<div class="card">
												<div class="card-body p-0">
													<div class="table-responsive active-projects">
													<div class="tbl-caption">
														<h4 class="heading mb-0">Table Showing Results from PEP & External Data Sources</h4>
													</div>
														<table id="projects-tbl_3" class="table table-striped example">
															<thead>
																<tr>
																	<th>Name</th>
																	<th>Schema</th>
																	<th>Date of Birth</th>
																	<th>Countries</th>
																	<th>Data Set</th>
																	<th>Data Type</th>
																	<th>Aliases</th>
																</tr>
															</thead>
															<tbody>
																@isset($pep_results)
																@foreach($pep_results as $pep_result)
																<tr>
																	<td>{{ $pep_result["name"] }}</td>
																	<td>{{ $pep_result["schema"] }}</td>
																	<td class="pe-0">{{ $pep_result["birth_date"] }}</td>
																	<td class="pe-0">{{ strtoupper($pep_result["countries"]) }}</td>
																	<td class="pe-0">{{ $pep_result["dataset"] }}</td>
																	<td>{{ $pep_result["db_type"] }}</td>
																	<td>{{ $pep_result["aliases"] }}</td>
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

										<!--Table-->
										<div class="col-xl-12 col-md-12 active-p">
											<div class="card">
												<div class="card-body p-0">
													<div class="table-responsive active-projects">
													<div class="tbl-caption">
														<h4 class="heading mb-0">Table Showing Court Cases</h4>
													</div>
														<table id="projects-tbl_3" class="table table-striped example">
															<thead>
																<tr>
																	<th>Title</th>
																	<th>Amount</th>
																	<th>Date Arraigned</th>
																	<th>Status</th>
																	<th>Stage</th>
																	<th>Description</th>
																	<th>Charge</th>
																	<th>Type</th>
																	<th>Sector</th>
																	<th>Agency</th>
																	<th>Court</th>
																	<th>Judges</th>
																	<th>Defendants</th>
																	<th>Counsels</th>
																	<th>Prosecutors</th>
																	<th>Date Case Ended</th>
																	<th>ACJA/ACJL Compliance</th>
																	<th>ACJA/ACJL remark</th>
																	<th>Court Decision/Update</th>
																</tr>
															</thead>
															<tbody>
																@isset($court_cases)
																@foreach($court_cases as $court_case)
																<tr>
																	<td>{{ $court_case["title"] }}</td>
																	<td>{{ $court_case["amount"] }}</td>
																	<td class="pe-0">{{ $court_case["date arraigned"] }}</td>
																	<td class="pe-0">{{ $court_case["status"] }}</td>
																	<td class="pe-0">{{ $court_case["stage"] }}</td>
																	<td>{{ $court_case["description"] }}</td>
																	<td>{{ $court_case["charge"] }}</td>
																	<td>{{ $court_case["type"] }}</td>
																	<td>{{ $court_case["sector"] }}</td>
																	<td>{{ $court_case["agency"] }}</td>
																	<td>{{ $court_case["court"] }}</td>
																	<td>{{ $court_case["judges"] }}</td>
																	<td>{{ $court_case["defendants"] }}</td>
																	<td>{{ $court_case["counsels"] }}</td>
																	<td>{{ $court_case["prosecutors"] }}</td>
																	<td>{{ $court_case["date case ended"] }}</td>
																	<td>{{ $court_case["acja/acjl compliance"] }}</td>
																	<td>{{ $court_case["acja/acjl remark"] }}</td>
																	<td>{{ $court_case["court decision/update"] }}</td>
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
	<div class="col-xl-3 col-md-3 t-earn">
		<div class="card">
               <div class="card-header border-0 pb-0">
                   <h4 class="card-title">Graph Showing Frequency of Retrieved Entities Over a Timeline</h4>
               </div>
               <div class="card-body p-0">
                   <div id="DZ_W_TimeLine11" class="widget-timeline dz-scroll style-1 height720 my-4 px-4">
                       <ul class="timeline">
                       	@isset($entities_table)
                       	@foreach($entities_table as $entity)
                           <li>
                               <div class="timeline-badge info">
                               </div>
                               <a class="timeline-panel" href="{{ url($entity['source_url']) }}">
                                   <span>{{ $entity["event_day"] }}</span>
                                   <h6 class="mb-0">{{ $entity["entity_name"] }} <strong class="text-info">Type: {{ $entity["entity_type"] }}</strong> <strong class="text-warning">Total Occurence: {{ $entity["entity_count"] }}</strong> </h6>
								<p class="mb-0">{{ $entity["event_location"] }}</p>
                               </a>
                           </li>
                           @endforeach
                           @endisset
                       </ul>
                   </div>
               </div>
           </div>
		<!--End of Timeline-->
	</div>
</div>
<!--End of First section-->
<div class="row">
	<!--Barchart-->
	<div class="col-xl-5 col-md-5">
		<div class="card overflow-hidden">
			<div class="card-header border-0 pb-0 flex-wrap">
				<h4 class="heading mb-0">Barchart Showing Media House Frequency  (Events From Results)</h4>
				
			</div>
			<div class="card-body  p-0">
					@include('process.charts')
					<div id="chart_div" style="width: 100%; height: 500px;"></div>
			</div>
		</div>
	</div>
	<!--End of Barchart-->
	<!--results Table-->
	<div class="col-xl-7">
		<!--Table-->
		<div class="card">
			<div class="card-body p-0">
				<div class="table-responsive active-projects" style="padding: 20px;">
				<div class="tbl-caption">
					<h4 class="heading mb-0">Table Showing Entities Frequency  (Events From Results)</h4>
				</div>
				<div class="table-responsive">
					<table id="projects-tbl" class="table example table-striped">
						<thead>
							<tr>
								<th>Event Date</th>
								<th>Entity Name</th>
								<th>Entity Type</th>
								<th>Event Location</th>
								<th>Count</th>
								<th>Source</th>
							</tr>
						</thead>
						<tbody>
							@isset($entities_table)
							@foreach($entities_table as $entity)
							<tr>
								<td>{{ $entity["event_day"] }}</td>
								<td>{{ $entity["entity_name"] }}</td>
								<td class="pe-0">{{ $entity["entity_type"] }}</td>
								<td class="pe-0">{{ $entity["event_location"] }}</td>
								<td class="pe-0">{{ $entity["entity_count"] }}</td>
								<td><a href="{{ url($entity['source_url']) }}" target="_blank" class="badge badge-danger light border-0">View</a></td>
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
	</div>
	<!--End of results Table-->
</div>

</div>
</div>




<script>
	$(document).ready(function() {
		$('.example').DataTable();
	  });
</script>
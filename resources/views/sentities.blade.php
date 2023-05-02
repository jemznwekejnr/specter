@include("layouts.app-title")
@include("layouts.app-header")
@include("layouts.app-sidebar")
<!--**********************************
    Content body start
***********************************-->
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
					<div class="col-xl-9 col-lg-12">
						<div class="card">
							<div class="card-header">
								<h4 class="card-title">Search Entity (Person or Organization)</h4>
							</div>
							<div class="card-body">
								<div class="basic-form">
									<form>
										<div class="row">
											<div class="col-xl-6">
												<div class="mb-3">
													<input type="text" class="form-control input-rounded" placeholder="Enter Query Text (Name or Organization)">
												</div>
											</div>
											<div class="col-xl-3">
												<div class="mb-3">
													<input type="date" class="form-control input-rounded" placeholder="Start Date(OPTIONAL): e.g. '20131224'">
												</div>
											</div>
											<div class="col-xl-3">
												<div class="mb-3">
													<input type="date" class="form-control input-rounded" placeholder="End Date(OPTIONAL): e.g. '20131230'">
												</div>
											</div>
											<div class="col-xl-6">
												<div class="mb-6">
													<button type="submit" class="btn btn-primary btn-sm btn-rounded">Search</button>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					--End-->
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
												<h4>Table Showing Event Details (url, date, etc) for {{ $_GET["searchtext"] }}</h4>
												<div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="profile card card-body px-3 pt-3 pb-0">
                                                            <div class="profile-head">
                                                                
                                                                <table id="projects-tbl" class="table table-striped example">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Global Evenet ID</th>
                                                                            <th>Event Location</th>
                                                                            <th>Country</th>
                                                                            <th>Event Date</th>
                                                                            <th>Date Published</th>
                                                                            <th>Goldstein Scale</th>
                                                                            <th>Source</th>
                                                                            <th>Source URL</th>
                                                                            <th>Article Type</th>
                                                                            <th>Location on Map</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @isset($table_data2)
                                                                        @foreach($table_data2 as $data2)
                                                                        <tr>
                                                                            <td>{{ $data2["global_event_id"] }}</td>
                                                                            <td>{{ $data2["event_location"] }}</td>
                                                                            <td>{{ $data2["country"] }}</td>
                                                                            <td>{{ $data2["event_date"] }}</td>
                                                                            <td>{{ $data2["date_published"] }}</td>
                                                                            <td>{{ $data2["goldstein_scale"] }}</td>
                                                                            <td>{{ $data2["media_house"] }}</td>
                                                                            <td><a href="{{ url($data2['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                                                                            <td class="pe-0">{{ $data2["article_type"] }}</td>
                                                                            <td><a href="{{ url('https://www.google.com/search?q='.$data2['latitude'].','.$data2['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @endisset
                                                                    </tbody>
                                                                    
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
													<!--E-->
                                                   

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
            <!--Table-->
            <div class="col-xl-6 active-p">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive active-projects">
                        <div class="tbl-caption">
                            <h4 class="heading mb-0">Table Showing List of all “PERSON” Entities that Appear in Event</h4>
                        </div>
                        <div style="padding: 30px;">
                            <table id="projects-tbl" class="table table-striped example">
                                <thead>
                                    <tr>
                                        <th>Entity Name</th>
                                        <th>Entity Type</th>
                                        <th>Frequency</th>
                                        <th>Source URL</th>
                                        <th>Event Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($table_data1)
                                    @foreach($table_data1 as $data1)
                                    @if($data1["entity_type"] == "PERSON")
                                    <tr>
                                        <td>{{ $data1["entity_name"] }}</td>
                                        <td>{{ $data1["entity_type"] }}</td>
                                        <td class="pe-0">{{ $data1["frequency"] }}</td>
                                        <td class="pe-0"><a href="{{ url($data1['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                                        <td class="pe-0">{{ $data1["event_date"] }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endisset
                                </tbody>
                                
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End of Table-->

            <!--Map-->
            <div class="col-xl-6 col-md-6 flag">
                <div class="card overflow-hidden">
                    <div class="card-header border-0">
                        <h4 class="heading mb-0">Map Showing Location of Event</h4>
                    </div>
                    <div class="card-body pe-0">
                        <div class="row">
                            <div class="col-xl-8 active-map-main">
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
        <!--End of second section-->
        <div class="row">
			<!--results Table-->
			<div class="col-xl-8">
				<!--Table-->
				<div class="card">
					<div class="card-body p-0">
						<div class="table-responsive active-projects">
						<div class="tbl-caption">
							<h4 class="heading mb-0">Table Showing List of All “ORG” Entities that Appear in Event</h4>
						</div>
							<table id="projects-tbl" class="table table-striped example">
                                <thead>
                                    <tr>
                                        <th>Entity Name</th>
                                        <th>Entity Type</th>
                                        <th>Frequency</th>
                                        <th>Source URL</th>
                                        <th>Event Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($table_data1)
                                    @foreach($table_data1 as $data1)
                                    @if($data1["entity_type"] == "ORG")
                                    <tr>
                                        <td>{{ $data1["entity_name"] }}</td>
                                        <td>{{ $data1["entity_type"] }}</td>
                                        <td class="pe-0">{{ $data1["frequency"] }}</td>
                                        <td class="pe-0"><a href="{{ url($data1['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                                        <td class="pe-0">{{ $data1["event_date"] }}</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @endisset
                                </tbody>
                                
                            </table>
						</div>
					</div>
				</div>
				<!--End of Table-->
			</div>
			<!--End of results Table-->
            <!--Piechart-->
			<div class="col-xl-4">
				<div class="card h-auto">
                    <div class="card-header pb-0 border-0">
                        <h4 class="heading mb-0">Piechart Showing Crime Distribution for Retrieved Event</h4>
                    </div>
                    <div class="card-body">
                        @include("process.spiechart")
                        <div id="piechart" style="width: 100%; height: 400px;"></div>
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
                        <h4 class="card-title">Graph Showing Link Analytics</h4>
                        
                    </div>
                    <div class="card-body">
                        
                        <div id="network_chart_div" style="width: 100%; height: 500px;"></div>
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
@include("process.dashboard")
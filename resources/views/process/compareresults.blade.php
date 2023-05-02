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
                                    <div class="row">
                                        <!--results Table-->
                                        <div class="col-xl-12">
                                            <!--Table-->
                                            <div class="card">
                                                <div class="card-body p-0">
                                                    <div class="table-responsive active-projects">
                                                    <div class="tbl-caption">
                                                        <h4 class="heading mb-0">[20] Table Showing List of Entities that Appear in Co-entity Pair</h4>
                                                    </div>
                                                    <div style="padding: 30px">
                                                        <table id="projects-tbl" class="table table-striped example">
                                                            <thead>
                                                                <tr>
                                                                    <th>Event Date</th>
                                                                    <th>First Entity</th>
                                                                    <th>Second Entity</th>
                                                                    <th>Source URL</th>
                                                                    <th>Event Location</th>
                                                                    <th>Location on Map</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @isset($co_events)
                                                                @foreach($co_events as $co_event)
                                                                <tr>
                                                                    <td>{{ $co_event["event_date"] }}</td>
                                                                    <td>{{ $co_event["first_entity"] }}</td>
                                                                    <td class="pe-0">{{ $co_event["second_entity"] }}</td>
                                                                    <td class="pe-0"><a href="{{ url($co_event['source_url']) }}" class="badge badge-primary light"  target="_blank">View</a></td>
                                                                    <td class="pe-0">{{ $co_event["event_location"] }}</td>
                                                                    <td><a href="{{ url('https://www.google.com/search?q='.$co_event['latitude'].','.$co_event['longitude']) }}"  target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
                                        <!--Map-->
                                        <div class="col-xl-6 col-md-6 flag">
                                            <div class="card overflow-hidden">
                                                <div class="card-header border-0">
                                                    <h4 class="heading mb-0">Map Showing Location that Appear in Co-entity Pair</h4>
                                                </div>
                                                <div class="card-body pe-0">
                                                    <div class="row">
                                                        <div class="col-xl-8 active-map-main">
                                                        @include("process.comparemap")
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
                                        <!--Barchart-->
                                        <div class="col-xl-12">
                                            <div class="card overflow-hidden">
                                                <div class="card-header border-0 pb-0 flex-wrap">
                                                    <h4 class="heading mb-0">Graph Showing Timeline & Frequency of Entities that Appear in Co-entity Pair </h4>
                                                </div>
                                                <div class="card-body  p-0">
                                                    @include('process.comparechart')
                                                    <div id="chart_div" style="width: 100%; height: 400px;"></div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!--End of Barchart-->
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
<!--End:::::of First section:::::::-->
<div class="row">
<!--Table-->
<div class="col-xl-12 active-p">
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Table Showing Co-entity Pair vs Other Entities</h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Entity Name</th>
                            <th>Entity Type</th>
                            <th>Frequency</th>
                            <th>Source URL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($co_entity_freq)
                        @foreach($co_entity_freq as $freq)
                        <tr>
                            <td>{{ $freq["event_date"] }}</td>
                            <td>{{ $freq["entity_name"] }}</td>
                            <td class="pe-0">{{ $freq["entity_type"] }}</td>
                            <td class="pe-0">{{ $freq["frequency"] }}</td>
                            <td class="pe-0"><a href="{{ url($freq['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                        </tr>
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
<!--Barchart-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Barchart Showing Frequency of Location that Appear in Co-entity Pair</h4>
            
        </div>
        <div class="card-body">
     @include("process.comparebarchart")
    <div id="columnchart_values" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--End of Barchart-->
<!--Piechart-->
<div class="col-xl-6">
    <div class="card h-auto">
        <div class="card-header pb-0 border-0">
            <h4 class="heading mb-0">Barchart Showing Crime Frequencies that Appear in Co-entity Pair Events</h4>
        </div>
        <div class="card-body">
            @include('process.cgraphbarchart')
            <div id="barchart_material" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--End of Piechart-->
<!--Barchart-->
<div class="col-xl-6">
    <div class="card overflow-hidden">
        <div class="card-header border-0 pb-0 flex-wrap">
            <h4 class="heading mb-0">Line Chart Showing Timeline of Crime Frequencies that Appear in Co-entity Pair Events</h4>
        </div>
        <div class="card-body  p-0">
                @include('process.cgraphlinechart')
                <div id="line_chart" style="width: 100%; height: 600px;"></div>
            
        </div>
    </div>
</div>
<!--End of Barchart-->
<!--results Table-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Table Showing Crimes that Appear in Co-entity Pair Events </h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Crime Prediction</th>
                            <th>Crime Prediction Probability</th>
                            <th>First Entity</th>
                            <th>Second Entity</th>
                            <th>Source URL</th>
                            <th>Event Location</th>
                            <th>Frequency</th>
                            <th>Location on Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($co_crimes)
                        @foreach($co_crimes as $co_crime)
                        <tr>
                            <td>{{ $co_crime["event_date"] }}</td>
                            <td>{{ $co_crime["crime_prediction"] }}</td>
                            <td class="pe-0">{{ $co_crime["crime_pred_prob"] }}</td>
                            <td class="pe-0">{{ $co_crime["first_entity"] }}</td>
                            <td class="pe-0">{{ $co_crime["second_entity"] }}</td>
                            <td class="pe-0"><a href="{{ url($co_crime['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                            <td>{{ $co_crime["event_location"] }}</td>
                            <td>{{ $co_crime["frequency"] }}</td>
                            <td><a href="{{ url('https://www.google.com/search?q='.$co_crime['latitude'].','.$co_crime['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
<div class="col-xl-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Barchart Showing Co-entity Pair vs Other Entities</h4>
            
        </div>
        <div class="card-body">
            @include('process.cbubblechart')
            <div id="series_chart_div" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>

<!--==========Beginning of AB Compare============-->
<!--results Table-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Table Showing Enitiy vs Location Frequncy of A</h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Event Location</th>
                            <th>Entity Name</th>
                            <th>Frequency</th>
                            <th>Location on Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($compare_locations["entity_one"])
                        @foreach($compare_locations["entity_one"] as $first_entity)
                        <tr>
                            <td>{{ $first_entity["event_date"] }}</td>
                            <td>{{ $first_entity["event_location"] }}</td>
                            <td>{{ $first_entity["entity_name"] }}</td>
                            <td>{{ $first_entity["frequency"] }}</td>
                            <td><a href="{{ url('https://www.google.com/search?q='.$first_entity['latitude'].','.$first_entity['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
<!--results Table-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Showing Enitiy vs Location Frequncy of B</h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Event Location</th>
                            <th>Entity Name</th>
                            <th>Frequency</th>
                            <th>Location on Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($compare_locations["entity_two"])
                        @foreach($compare_locations["entity_two"] as $second_entity)
                        <tr>
                            <td>{{ $second_entity["event_date"] }}</td>
                            <td>{{ $second_entity["event_location"] }}</td>
                            <td>{{ $second_entity["entity_name"] }}</td>
                            <td>{{ $second_entity["frequency"] }}</td>
                            <td><a href="{{ url('https://www.google.com/search?q='.$second_entity['latitude'].','.$second_entity['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
<!--Map-->
<div class="col-xl-6 col-md-6 flag">
    <div class="card overflow-hidden">
        <div class="card-header border-0">
            <h4 class="heading mb-0">Map Showing Enitiy A vs Location</h4>
        </div>
        <div class="card-body pe-0">
            <div class="row">
                <div class="col-xl-8 active-map-main">
                    @include("process.cmapentity1")
                    <div id="map_markers_div1" style="width: 100%; height: 400px"></div>  
                </div>
                <div class="col-xl-4 active-country dz-scroll">
                    <div class="">
                        @isset($clocation1)
                        @foreach($clocation1 as $key => $value)
                        <div class="country-list">
                            <img src="{{ asset('assets/images/country/nigeria.png') }}" alt="">
                            <div class="progress-box mt-0">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 c-name">{{ $key }}</p>
                                    <p class="mb-0">{{ number_format($value / $count_location1 * 100, 2) }}%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width:{{ $value / $count_location1 * 100 }}%; height:5px; border-radius:4px;" role="progressbar"></div>
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
<!--Map-->
<div class="col-xl-6 col-md-6 flag">
    <div class="card overflow-hidden">
        <div class="card-header border-0">
            <h4 class="heading mb-0">Map Showing Enitiy B vs Location</h4>
        </div>
        <div class="card-body pe-0">
            <div class="row">
                <div class="col-xl-8 active-map-main">
                    @include("process.cmapentity2")
                    <div id="map_markers_div2" style="width: 100%; height: 400px"></div>  
                </div>
                <div class="col-xl-4 active-country dz-scroll">
                    <div class="">
                        @isset($clocation2)
                        @foreach($clocation2 as $key => $value)
                        <div class="country-list">
                            <img src="{{ asset('assets/images/country/nigeria.png') }}" alt="">
                            <div class="progress-box mt-0">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-0 c-name">{{ $key }}</p>
                                    <p class="mb-0">{{ number_format($value / $count_location2 * 100, 2) }}%</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-primary" style="width:{{ $value / $count_location2 * 100 }}%; height:5px; border-radius:4px;" role="progressbar"></div>
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
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Table Showing Similar Names to A and Their Frequencies of Occurrence</h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Event Location</th>
                            <th>Entity Name</th>
                            <th>Frequency</th>
                            <th>Location on Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($compare_locations["entity_one"])
                        @foreach($compare_locations["entity_one"] as $first_entity)
                        <tr>
                            <td>{{ $first_entity["event_date"] }}</td>
                            <td>{{ $first_entity["event_location"] }}</td>
                            <td class="pe-0">{{ $first_entity["entity_name"] }}</td>
                            <td>{{ $first_entity["frequency"] }}</td>
                            <td><a href="{{ url('https://www.google.com/search?q='.$first_entity['latitude'].','.$first_entity['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
<!--results Table-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
                <h4 class="heading mb-0">Table Showing Similar Names to B and Their Frequencies of Occurrence</h4>
            </div>
            <div style="padding: 30px;">
                <table id="projects-tbl" class="table table-striped example">
                    <thead>
                        <tr>
                            <th>Event Date</th>
                            <th>Event Location</th>
                            <th>Entity Name</th>
                            <th>Frequency</th>
                            <th>Location on Map</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($compare_locations["entity_two"])
                        @foreach($compare_locations["entity_two"] as $second_entity)
                        <tr>
                            <td>{{ $second_entity["event_date"] }}</td>
                            <td>{{ $second_entity["event_location"] }}</td>
                            <td class="pe-0">{{ $second_entity["entity_name"] }}</td>
                            <td>{{ $second_entity["frequency"] }}</td>
                            <td><a href="{{ url('https://www.google.com/search?q='.$second_entity['latitude'].','.$second_entity['longitude']) }}" target="_blank"><img src="{{ asset('assets/images/marker.png') }}" width="20px"></a></td>
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
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Piechart Showing Enitiy A vs Top 15 Similar Names Entities</h4>
        </div>
        <div class="card-body">
            @include("process.cpiechart1")
            <div id="piechart_3d1" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Piechart Showing Enitiy B vs Top 15 Similar Names Entities</h4>
            
        </div>
        <div class="card-body">
            @include("process.cpiechart2")
            <div id="piechart_3d2" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
            <h4 class="card-title">Table Showing Crimes Linked  to A and Their Frequencies of Occurrence</h4>
            
        </div>
        <div style="padding: 30px;">
            <table id="projects-tbl" class="table table-striped example">
                <thead>
                    <tr>
                        <th>Event Date</th>
                        <th>Entity Name</th>
                        <th>Entity Type</th>
                        <th>Frequency</th>
                        <th>Source URL</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($compare_top_entities["entity_one"])
                    @foreach($compare_top_entities["entity_one"] as $entity1)
                    <tr>
                        <td>{{ $entity1["event_date"] }}</td>
                        <td>{{ $entity1["entity_name"] }}</td>
                        <td>{{ $entity1["entity_type"] }}</td>
                        <td>{{ $entity1["frequency"] }}</td>
                        <td class="pe-0"><a href="{{ url($entity1['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
                
            </table>
        </div>
    </div>
</div>
</div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <!--Table-->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive active-projects">
            <div class="tbl-caption">
            <h4 class="card-title">Table Showing Crimes Linked to B and Their Frequencies of Occurrence</h4>
            
        </div>
        <div style="padding: 30px;">
            <table id="projects-tbl" class="table table-striped example">
                <thead>
                    <tr>
                        <th>Event Date</th>
                        <th>Entity Name</th>
                        <th>Entity Type</th>
                        <th>Frequency</th>
                        <th>Source URL</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($compare_top_entities["entity_two"])
                    @foreach($compare_top_entities["entity_two"] as $entity2)
                    <tr>
                        <td>{{ $entity2["event_date"] }}</td>
                        <td>{{ $entity2["entity_name"] }}</td>
                        <td>{{ $entity2["entity_type"] }}</td>
                        <td>{{ $entity2["frequency"] }}</td>
                        <td class="pe-0"><a href="{{ url($entity2['source_url']) }}" class="badge badge-primary light" target="_blank">View</a></td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
                
            </table>
        </div>
    </div>
</div>
</div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Barchart Showing Crimes Linked to A and Their Frequencies of Occurrence</h4>
            
        </div>
        <div class="card-body">
            
            @include("process.cbarchart1")
            <div id="columnchart_material1" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Barchart Showing Crimes Linked to B and Their Frequencies of Occurrence</h4>
            
        </div>
        <div class="card-body">
            @include("process.cbarchart2")
            <div id="columnchart_material2" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Graph Showing Crimes Linked to A and Their Frequencies of Occurrence</h4>
            
        </div>
        <div class="card-body">
            @include("process.comparelinchart1")
            <div id="line_chart1" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
<!--compare Item-->
<div class="col-xl-6">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Graph Showing Crimes Linked to B and Their Frequencies of Occurrence</h4>
            
        </div>
        <div class="card-body">
            @include("process.comparelinchart2")
            <div id="line_chart2" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
</div>
</div>
<!--End of Third section-->

</div>
</div>

<!--**********************************
Content body end
***********************************-->

<script>
$(document).ready(function() {
$('.example').DataTable();
});
</script>
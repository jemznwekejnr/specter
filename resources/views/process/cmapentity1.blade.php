
    
    <script type="text/javascript">
      google.charts.load("current", {
        "packages":["map"],
        // Note: you will need to get a mapsApiKey for your project.
        // See: https://developers.google.com/chart/interactive/docs/basic_load_libs#load-settings
        "mapsApiKey": "AIzaSyB253uMRyP4nohpiUCK8okOwx5AxlV0djQ"
      });
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Latitude', 'Longitude', 'Name'],
          @isset($compare_locations["entity_one"])
          @foreach($compare_locations["entity_one"] as $data1)
          [{{ $data1['latitude'] }}, {{ $data1['longitude'] }}, '{{ $data1["event_location"] }}'],
          @endforeach
          @endisset
        ]);

        var options = {
          icons: {
            default: {
              normal: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Azure-icon.png',
              selected: 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Ball-Right-Azure-icon.png'
            }
          }
        };

        var map = new google.visualization.Map(document.getElementById('map_markers_div1'));
        map.draw(data, options);
      }
      
    </script>
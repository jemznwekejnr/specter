
    
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
          @isset($compare_locations["entity_two"])
          @foreach($compare_locations["entity_two"] as $data2)
          [{{ $data2['latitude'] }}, {{ $data2['longitude'] }}, '{{ $data2["event_location"] }}'],
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

        var map = new google.visualization.Map(document.getElementById('map_markers_div2'));
        map.draw(data, options);
      }
      
    </script>
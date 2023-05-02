
    
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Entity', 'Frequency'],
          @isset($top_entity2)
          @foreach($top_entity2 as $key => $value)
            ['{{ $key }}',  {{ $value }}],
          @endforeach
          @endisset
        ]);

        var options = {
          
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d2'));
        chart.draw(data, options);
      }
    </script>

    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Crimes', 'Frequency'],
          @isset($crimes)
          @foreach($crimes as $key => $value)
          ['{{ $key }}',  {{ $value }}],
          @endforeach
          @endisset
        ]);

        var options = {
          chart: {
            
          },
          bars: 'horizontal' // Required for Material Bar Charts.
        };

        var chart = new google.charts.Bar(document.getElementById('barchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>

    
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Source', 'Occurence'],
          @isset($sources)
          @foreach($sources as $key => $value)
          ['{{ $key }}',  {{ $value }}],
          @endforeach
          @endisset
        ]);

        var options = {
          title: 'Media Sources',
          hAxis: {title: 'Sources',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>


    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Entity Type', 'Frequency'],
          @isset($crime_freq)
          @foreach($crime_freq as $key => $value)
          ['{{ $key }}',  {{ $value }}],
          @endforeach
          @endisset
        ]);

        var options = {
          title: 'Company Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('series_chart_div'));
        chart.draw(data, options);
      }
    </script>
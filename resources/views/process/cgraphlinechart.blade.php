
    
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawBasic);

      function drawBasic() {

      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Crimes');
      data.addColumn('number', 'Frequency');

      data.addRows([
        @isset($crimes)
        @php $x = 0 @endphp
        @foreach($crimes as $key => $value)
        ['{{ $key }}', {{ $value }}],
        @endforeach
        @endisset
      ]);
      

      var options = {
        hAxis: {
          title: 'Crimes'
        },
        vAxis: {
          title: 'Frequency'
        }
      };

      var chart = new google.visualization.LineChart(document.getElementById('line_chart'));

      chart.draw(data, options);
    }
    </script>
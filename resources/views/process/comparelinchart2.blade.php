
    
    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawLineStyles);

      function drawLineStyles() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Crimes');
            data.addColumn('number', 'Frequency');

            data.addRows([
              @isset($compare_crime2)
              @php $x = 0 @endphp
              @foreach($compare_crime2 as $key => $value)
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
              },
              colors: ['#a52714', '#097138'],
              series: {
                0: {
                  lineWidth: 10,
                  lineDashStyle: [5, 1, 5]
                },
                1: {
                  lineWidth: 5,
                  lineDashStyle: [7, 2, 4, 3]
                }
              }
            };

            var chart = new google.visualization.LineChart(document.getElementById('line_chart2'));
            chart.draw(data, options);
          }

    </script>
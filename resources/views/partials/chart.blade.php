<!-- resources/views/partials/chart.blade.php -->
<div class="chart-container" style="margin-bottom: 2rem;">
  <canvas id="{{ $chartId }}" width="400" height="200"></canvas>
</div>

<script>
  (function(){
      var ctx = document.getElementById('{{ $chartId }}').getContext('2d');
      
      // Siapkan data chart
      var chartData = {
          labels: {!! json_encode($labels) !!},
          datasets: [
              @if(isset($datasets) && is_array($datasets) && count($datasets) > 0)
                  @foreach($datasets as $dataset)
                      {
                          label: '{{ $dataset["label"] ?? "Dataset" }}',
                          data: {!! json_encode($dataset["data"] ?? []) !!},
                          backgroundColor: {!! json_encode($dataset["backgroundColor"] ?? 'rgba(75,192,192,0.4)') !!},
                          borderColor: {!! json_encode($dataset["borderColor"] ?? 'rgba(75,192,192,1)') !!},
                          borderWidth: 1,
                          fill: {{ isset($dataset["fill"]) ? $dataset["fill"] : 'false' }},
                          tension: {{ isset($dataset["tension"]) ? $dataset["tension"] : 0.1 }}
                      },
                  @endforeach
              @else
                  {
                      label: '{{ $datasetLabel ?? "Dataset" }}',
                      data: {!! json_encode($data ?? []) !!},
                      backgroundColor: {!! json_encode($backgroundColor ?? 'rgba(75,192,192,0.4)') !!},
                      borderColor: {!! json_encode($borderColor ?? 'rgba(75,192,192,1)') !!},
                      borderWidth: 1
                  }
              @endif
          ]
      };

      new Chart(ctx, {
          type: '{{ $chartType ?? "bar" }}',
          data: chartData,
          options: {
              responsive: true,
              plugins: {
                  legend: {
                      position: '{{ $legendPosition ?? "top" }}'
                  }
              },
              scales: {
                  y: {
                      beginAtZero: true,
                      title: {
                          display: {{ isset($yAxisTitle) && $yAxisTitle ? 'true' : 'false' }},
                          text: '{{ $yAxisTitle ?? "" }}'
                      }
                  },
                  x: {
                      title: {
                          display: {{ isset($xAxisTitle) && $xAxisTitle ? 'true' : 'false' }},
                          text: '{{ $xAxisTitle ?? "" }}'
                      }
                  }
              }
          }
      });
  })();
</script>

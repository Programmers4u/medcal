<br>
<div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-11">
      <b>Rozpoznania - choroby</b>
      <div style="position: relative; height:60vh; width:60vw">
        <canvas id="myChart"></canvas>
      </div>
    </div>
</div>

@push('footer_scripts')
<script type="text/javascript" src="/js/statistics/statistics.min.js"></script>

<script type="text/javascript">
    var csrf = '{{csrf_token()}}';   
    var businessId = '{{ $business->id }}';
    var contactId = '{{ $contacts->id }}';

    var Statistics = Object.create(Statistics);
    Statistics.csrf = '{{csrf_token()}}';
    Statistics.businessId = '{{ $business->id }}';
    Statistics.endPoint = '/statistics';
    Statistics.post.type = 'diagnosis_patient';
    Statistics.post.contactId = contactId;
</script>

<script>
var ctx = document.getElementById('myChart');
Statistics.get(function(data) {
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels : data.statistics[0].labels,
            datasets: [{
                label: 'Rozpoznania',
                data: data.statistics[0].data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'                
                ],
                borderWidth: 1            
            }, {
                label: 'Rozpoznania All',
                data: data.statistics[1].data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'                
                ],
                borderWidth: 1            
            }],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 50,
                            suggestedMax: 100,
                            beginAtZero: true
                        }
                    }]
                }
            }
        }
    });
});
</script>
@endpush
<br>
<div class="row">
    <div class="col-md-1"></div>
        <div class="col-md-11">
      <b>Statystyka - finanse</b>
      <div style="position: relative; height:80vh; width:80vw">
        <canvas id="myChart"></canvas>
      </div>
    </div>
</div>

@push('footer_scripts')
<script type="text/javascript" src="/js/statistics/statistics.min.js"></script> --}}

<script type="text/javascript">

    var Statistics = Object.create(ModelStatistics);
    Statistics.csrf = '{{csrf_token()}}';
    Statistics.endPoint = '/statistics';
    Statistics.post.businessId = '{{ $business->id }}';
    Statistics.post.type = Statistics.businessPriceType;

    var ctx = document.getElementById('myChart');
    
    Statistics.get(function(data) {
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels : data.statistics[0].labels,
            datasets: [{
                label: 'Obrót w danym okresie',
                data: data.statistics[0].data,
                backgroundColor: data.statistics[0].data.map(item=>{
                    return 'rgba(54, 162, 235, 0.2)';
                }),
                borderColor: data.statistics[0].data.map(item=>{
                    return 'rgba(0, 99, 132, 1)';
                }),                
                borderWidth: 1            
            }, {
                label: 'Średni obrót z całego okresu',
                data: data.statistics[1].data,
                backgroundColor: data.statistics[1].data.map(item=>{
                    return 'rgba(255, 255, 255, 0)';
                }),
                borderColor: data.statistics[1].data.map(item=>{
                    return 'rgba(255, 99, 132, 1)';
                }),
                borderWidth: 1            
            }, 
            // {
            //     label: 'Ilość wizyt z okresu',
            //     data: data.statistics[2].data,
            //     backgroundColor: data.statistics[2].data.map(item=>{
            //         return 'rgba(154, 162, 35, 1)';
            //     }),
            //     borderColor: data.statistics[2].data.map(item=>{
            //         return 'rgba(154, 162, 35, 1)';
            //     }),
            //     borderWidth: 1            
            // }
            ],
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100,
                            stepSize: 1,
                            beginAtZero: true,
                        }
                    }],
                }            
            }
        }
    });
});

</script>
@endpush

  <!--testimonial-->
  <section id="testimonial" class="section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2 class="ser-title">Jakie problemy rozwiąże za Ciebie nasz program?</h2>
          <hr class="botm-line">
        </div>
        <div class="col-md-4">
          <div class="testi-details">
            <!-- Paragraph -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js" integrity="sha256-CfcERD4Ov4+lKbWbYqXD6aFM9M51gN4GUEtDhkWABMo=" crossorigin="anonymous"></script>            
<b style="font-size: 20px;">Powiadomienia</b><hr>
<canvas id="myChart" width="300" height="300"></canvas>
<b style="font-size: 40px;">40%</b>
<hr class="botm-line">
rezerwacji nie dochodzi do skutku z powodu przegapienia terminu
<hr class="botm-line">
forma przypominającego sms-a to najprostszy sposób na wyeliminowanie takich zdarzeń

<script>
data = {
    datasets: [{
        data: [40, 60],
        backgroundColor: [
            '#ff6384',
            '#36a2eb',
            '#cc65fe',
            '#ffce56',
        ],        
    }],

    // These labels appear in the legend and in the tooltips when hovering different arcs
    labels: [
        'strata',
        'klienci',
    ],
    
};
var options = {
        title: {
            display: true,
            text: 'Straty z powodu braku powiadomień'
        }
    };
var ctx = document.getElementById("myChart").getContext('2d');
// For a pie chart
var myPieChart = new Chart(ctx,{
    type: 'pie',
    data: data,
    options: options
});
/*
// And for a doughnut chart
var myDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: options
});
*/
</script>            
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ testimonial-->
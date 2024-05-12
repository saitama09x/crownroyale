<?= $this->extend('layouts/dashboard-layout') ?>
<?= $this->section('page_title') ?>
Dashboard
<?= $this->endSection() ?>
<?= $this->section('content') ?>


<div class='row mb-3'>
  <div class='col-md-4'>
    <div class='small-box bg-warning'>  
      <div class="inner">
        <h3><?= $pending ?></h3>
        <p>Pending Tasks</p>
        </div>    
    </div>
  </div>
  <div class='col-md-4'>
    <div class='small-box bg-info'>  
      <div class="inner">
        <h3><?= $progress ?></h3>
        <p>Progress Tasks</p>
        </div>    
    </div>
  </div>
  <div class='col-md-4'>
    <div class='small-box bg-success'>  
      <div class="inner">
        <h3><?= $completed ?></h3>
        <p>Completed Tasks</p>
        </div>    
    </div>
  </div>
</div>

<div class='row'>
  <div class='col-md-12'>
    <div class='card'>
      <div class='card-header'><h4 class='card-title'>Project Tasks Status</h4>
      <div class='card-body'>
        <div id="chart"></div>
      </div>
    </div>
  </div>
</div>

<h5>Payment Status</h5>
<div class='row'>
  <?php if($payments): ?>
    <?php foreach($payments as $i => $p): ?>
      <div class='col-md-6'>
        <div class='card'>
          <div class='card-header'><h4 class='card-title'>Project Title: <?= $p->projname ?></h4>
            <div class='card-body'>
              <div id="donut<?= $i ?>"></div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach ?>
  <?php endif ?>
</div>

<?= $this->endSection() ?>


<?= $this->section('footer') ?>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
var options = {
  series: JSON.parse(`<?= json_encode($series) ?>`),
  chart: {
  type: 'bar',
  height: 350
},
plotOptions: {
  bar: {
    horizontal: false,
    columnWidth: '55%',
    endingShape: 'rounded'
  },
},
dataLabels: {
  enabled: false
},
stroke: {
  show: true,
  width: 2,
  colors: ['transparent']
},
xaxis: {
  categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
},
yaxis: {
  title: {
    text: 'Tasks Completed'
  }
},
fill: {
  opacity: 1
},
tooltip: {
  y: {
    formatter: function (val) {
      return val + "%"
    }
  }
}
};

var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();


      
</script>

<?php if($payments): ?>
    <?php foreach($payments as $i => $p): ?>

      <script>        
          var option = {
            series: [<?= $p->projcost ?>, <?= $p->payment ?>],
            chart: {
                type: 'donut',
                width: 400
            },            
            labels: ['Project Cost', 'Paid Amount'],          
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
          };

          var chart = new ApexCharts(document.querySelector("#donut<?= $i ?>"), option);
          chart.render();

      </script>
    <?php endforeach ?>
<?php endif ?>

<?= $this->endSection() ?>
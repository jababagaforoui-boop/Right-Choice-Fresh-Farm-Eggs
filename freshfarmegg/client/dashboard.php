<?php
include __DIR__ . '/backend/dashboard_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo htmlspecialchars($branch_name); ?> Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
body{display:flex;background:#f0fdf4;min-height:100vh;}

/* Sidebar */
.sidebar{
    width:220px;
    background:#38b000;
    color:#fff;
    height:100vh;
    position:fixed;
    display:flex;
    flex-direction:column;
    padding:20px;
}
.sidebar h2{text-align:center;margin-bottom:40px;}
.sidebar a{
    display:block;
    padding:12px 15px;
    margin-bottom:15px;
    background:#2d6a4f;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}
.sidebar a:hover{
    background:#70d6ff;
    color:#000;
    transform:translateX(5px);
}
.sidebar .logout{
    background:#d00000;
    margin-top:auto;
}
.sidebar .logout:hover{
    background:#9d0208;
    transform:translateX(5px);
}

/* Main content */
.main{
    margin-left:220px;
    padding:25px;
    flex:1;
}

/* KPI Boxes */
.kpi-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
    margin-top:20px;
}
.kpi-box{
    padding:20px;
    border-radius:15px;
    color:#fff;
    display:flex;
    flex-direction:column;
    align-items:flex-start;
    justify-content:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}
.kpi-box i{
    font-size:28px;
    margin-bottom:10px;
}
.green{background:#22c55e;}
.yellow{background:#facc15;color:#000;}
.red{background:#ef4444;}

/* Summary Cards */
.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:20px;
    margin-top:20px;
}
.summary-box{
    background:#fff;
    border-radius:15px;
    padding:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
    font-size:1em;
}

/* Charts */
.chart-container{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    margin-top:30px;
}
.chart{
    background:#fff;
    border-radius:15px;
    padding:20px;
    height:350px;
    box-shadow:0 5px 15px rgba(0,0,0,0.08);
}
.chart canvas{
    width:100% !important;
    height:100% !important;
}

/* Responsive */
@media (max-width:1024px){.kpi-grid{grid-template-columns:repeat(2,1fr);} }
@media (max-width:600px){.kpi-grid{grid-template-columns:1fr;} }
@media(max-width:850px){.sidebar{width:100%;height:auto;position:relative;flex-direction:row;overflow-x:auto;}.main{margin-left:0;}.chart-container{grid-template-columns:1fr;}}
</style>
</head>
<body>

<div class="sidebar">
<h2>Client Panel</h2>
<a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
<a href="add_deliveries.php"><i class="fas fa-truck"></i> Deliveries</a>
<a href="orders.php"><i class="fas fa-list"></i> Orders</a>
<a href="stocks.php"><i class="fas fa-boxes"></i> Stocks</a>
<a href="returns.php"><i class="fas fa-undo"></i> Returns</a>
<a href="profile.php"><i class="fas fa-user"></i> Profile</a>
<a href="../index.html" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main">
<h1><?php echo $branch_name; ?> Dashboard</h1>

<!-- KPI Boxes -->
<div class="kpi-grid">
<div class="kpi-box green"><i class="fas fa-egg"></i>
<h3>Big Trays</h3>
<p><?php echo $big_remaining; ?> Trays</p>
<small><?php echo $big_remaining*$big_tray_eggs; ?> Eggs</small>
</div>

<div class="kpi-box green"><i class="fas fa-egg"></i>
<h3>Small Trays</h3>
<p><?php echo $small_remaining; ?> Trays</p>
<small><?php echo $small_remaining*$small_tray_eggs; ?> Eggs</small>
</div>

<div class="kpi-box green"><i class="fas fa-boxes"></i>
<h3>Total Eggs</h3>
<p><?php echo $total_eggs_remaining; ?></p>
</div>

<div class="kpi-box yellow"><i class="fas fa-coins"></i>
<h3>Sold Eggs Per Trays</h3>
<p><?php echo $eggs_sold; ?></p>
</div>

<div class="kpi-box red"><i class="fas fa-undo"></i>
<h3>Returned Eggs</h3>
<p><?php echo $eggs_returned; ?></p>
</div>

<div class="kpi-box yellow"><i class="fas fa-peso-sign"></i>
<h3>Profit</h3>
<p>₱<?php echo number_format($total_profit,2); ?></p>
</div>
</div>

<!-- Summary Cards -->
<div class="summary-grid">
<div class="summary-box">
<strong>📅 Monthly Sales:</strong> <?php echo array_sum($big_monthly)+array_sum($small_monthly); ?> Eggs
</div>
<div class="summary-box">
<strong>⚠ Stock Alerts:</strong>
<?php echo !empty($stock_alerts) ? implode('<br>',$stock_alerts) : "All stocks sufficient"; ?>
</div>
<div class="summary-box">
<strong>💰 Total Profit:</strong> ₱<?php echo number_format($total_profit,2); ?>
</div>
</div>

<!-- Charts -->
<div class="chart-container">
<div class="chart"><canvas id="barChart"></canvas></div>
<div class="chart"><canvas id="lineChart"></canvas></div>
</div>

<!-- Forecast Charts -->
<div class="chart-container" style="margin-top:30px;">
  <div class="chart"><canvas id="profitChart"></canvas></div>
  <div class="chart"><canvas id="eggForecastChart"></canvas></div>
</div>

<script>
// BAR CHART
new Chart(document.getElementById('barChart'),{
type:'bar',
data:{
labels:['Big Trays','Small Trays','Sold Per Trays','Returned Eggs'],
datasets:[{
label:'Egg Count',
data:[
<?php echo $big_remaining*$big_tray_eggs; ?>,
<?php echo $small_remaining*$small_tray_eggs; ?>,
<?php echo $eggs_sold; ?>,
<?php echo $eggs_returned; ?>
],
backgroundColor:'#38b000',
borderRadius:10
}]
},
options:{plugins:{legend:{display:false}},scales:{y:{beginAtZero:true}}}
});

// LINE CHART
new Chart(document.getElementById('lineChart'),{
type:'line',
data:{
labels:<?php echo json_encode($six_months); ?>,
datasets:[
{label:'Big Eggs',data:<?php echo json_encode($big_monthly); ?>,borderColor:'#16a34a',fill:true},
{label:'Small Eggs',data:<?php echo json_encode($small_monthly); ?>,borderColor:'#2563eb',fill:true}
]
}
});

<?php
$total_eggs_all = array_sum($big_monthly) + array_sum($small_monthly);
$profit_per_egg = $total_eggs_all > 0 ? $total_profit / $total_eggs_all : 0;

$actual_profit_arr = array_map(function($big, $small) use ($profit_per_egg) {
    $eggs = $big + $small;
    return $eggs * $profit_per_egg;
}, $big_monthly, $small_monthly);
?>

// ✅ FIX: NOW THIS EXISTS IN JS
const actualProfit = <?php echo json_encode($actual_profit_arr); ?>;

const forecastProfit = <?php echo json_encode($forecast_profit); ?>;
const profitLabels = <?php echo json_encode(array_merge($six_months,$forecast_months)); ?>;

new Chart(document.getElementById('profitChart'), {
  type: 'line',
  data: {
    labels: profitLabels,
    datasets: [
      {
        label: 'Actual Profit',
        data: actualProfit,
        borderColor: '#16a34a',
        fill: true,
        backgroundColor: 'rgba(22,163,74,0.2)',
        tension: 0.4
      },
      {
        label: 'Forecast Profit',
        data: Array(actualProfit.length).fill(null).concat(forecastProfit),
        borderColor: '#f59e0b',
        borderDash: [5,5],
        fill: false,
        tension: 0.4
      }
    ]
  },
  options: {
    plugins: { legend: { position: 'top' } },
    scales: { y: { beginAtZero: true } }
  }
});

// EGG SALES FORECAST CHART
const actualBig = <?php echo json_encode($big_monthly); ?>;
const actualSmall = <?php echo json_encode($small_monthly); ?>;
const forecastBig = <?php echo json_encode($forecast_big); ?>;
const forecastSmall = <?php echo json_encode($forecast_small); ?>;
const allLabels = <?php echo json_encode(array_merge($six_months,$forecast_months)); ?>;

new Chart(document.getElementById('eggForecastChart'), {
  type: 'line',
  data: {
    labels: allLabels,
    datasets: [
      {
        label: 'Big Eggs Sold',
        data: actualBig.concat(Array(forecastBig.length).fill(null)),
        borderColor: '#16a34a',
        fill: true,
        backgroundColor: 'rgba(22,163,74,0.2)',
        tension:0.4
      },
      {
        label: 'Forecast Big Eggs',
        data: Array(actualBig.length).fill(null).concat(forecastBig),
        borderColor: '#16a34a',
        borderDash:[5,5],
        fill:false,
        tension:0.4
      },
      {
        label: 'Small Eggs Sold',
        data: actualSmall.concat(Array(forecastSmall.length).fill(null)),
        borderColor: '#2563eb',
        fill:true,
        backgroundColor: 'rgba(37,99,235,0.2)',
        tension:0.4
      },
      {
        label: 'Forecast Small Eggs',
        data: Array(actualSmall.length).fill(null).concat(forecastSmall),
        borderColor:'#2563eb',
        borderDash:[5,5],
        fill:false,
        tension:0.4
      }
    ]
  },
  options:{
    plugins:{legend:{position:'top'}},
    scales:{y:{beginAtZero:true}}
  }
});
</script>

</body>
</html>

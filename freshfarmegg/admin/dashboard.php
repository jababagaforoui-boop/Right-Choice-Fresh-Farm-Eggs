```php
<?php
include __DIR__ . '/backend/dashboard_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Fresh Farm Egg | Admin Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* ===== GLOBAL ===== */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;
}

body{
    display:flex;
    background:#e6f4ea;
    color:#2d6a4f;
    transition:0.3s;
    overflow-x:hidden;
}


/* ===== DARK MODE ===== */

body.dark{
    background:#121821;
    color:#e0e0e0;
}

body.dark .sidebar{
    background:#0f172a;
}

body.dark .sidebar h2{
    color:#fff;
}

body.dark .sidebar a{
    color:#e0e0e0;
}

body.dark .sidebar a.active,
body.dark .sidebar a:hover{
    background:#2563eb;
    color:#fff;
}

body.dark .sidebar .logout{
    background:#d90429;
}

body.dark .sidebar .logout:hover{
    background:#9b0a20;
}

body.dark .card,
body.dark .section,
body.dark .channel,
body.dark .goal{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark .dark-toggle{
    background:#334155;
    color:#fff;
}

body.dark .dark-toggle:hover{
    background:#1e293b;
}


/* =========================================================
   SIDEBAR / ADMIN PANEL
========================================================= */

.sidebar{
    width:240px;
    background:#38b000;
    color:#fff;
    padding:25px;
    display:flex;
    flex-direction:column;
    position:fixed;
    top:0;
    left:0;
    height:100vh;
    overflow:hidden;
}

.sidebar h2{
    text-align:center;
    font-size:1.8rem;
    margin-bottom:30px;
    font-weight:700;
    color:#fff;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px 18px;
    margin-bottom:10px;
    background:#2d6a4f;
    color:#fff;
    border-radius:10px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
    text-align:left;
}

.sidebar a i{
    width:20px;
    text-align:center;
}

.sidebar a.active,
.sidebar a:hover{
    background:#70d6ff;
    color:#000;
}

.sidebar .logout{
    background:#d90429;
    margin-top:auto;
}

.sidebar .logout:hover{
    background:#9b0a20;
}


/* ===== MAIN CONTENT ===== */

.main{
    flex:1;
    margin-left:260px;
    padding:30px;
    transition:0.3s;
}


/* ===== HEADER ===== */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h1{
    font-size:2.4rem;
    color:#2d6a4f;
}

.header p{
    color:#52796f;
    font-size:1rem;
}

body.dark .header h1{
    color:#fff;
}

body.dark .header p{
    color:#cbd5e1;
}


/* ===== DARK TOGGLE ===== */

.dark-toggle{
    padding:10px 20px;
    border:none;
    border-radius:6px;
    background:#334155;
    color:#fff;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

.dark-toggle:hover{
    background:#1e293b;
}


/* ===== DASHBOARD CARDS ===== */

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:30px;
}

.card{
    padding:20px;
    border-radius:15px;
    box-shadow:0 8px 20px rgba(0,0,0,0.1);
    text-align:center;
    transition:0.3s;
    color:#fff;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-6px);
}

.card h3{
    font-size:14px;
    margin-bottom:10px;
    font-weight:600;
}

.card p{
    font-size:28px;
    font-weight:bold;
    margin-bottom:5px;
    transition:0.3s;
}

.card .kpi{
    font-size:0.9rem;
    margin-top:5px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:5px;
}

.card-icon{
    font-size:28px;
    margin-bottom:8px;
    display:block;
}


/* ===== GRADIENT CARDS ===== */

.card.sales{
    background:linear-gradient(135deg,#16a34a,#4ade80);
}

.card.orders{
    background:linear-gradient(135deg,#2563eb,#60a5fa);
}

.card.inventory{
    background:linear-gradient(135deg,#f97316,#fb923c);
}

.card.branches{
    background:linear-gradient(135deg,#7c3aed,#a78bfa);
}


/* ===== SECTIONS ===== */

.section{
    background:#f8fafc;
    padding:20px;
    border-radius:15px;
    margin-bottom:30px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.section h2{
    margin-bottom:15px;
    color:#2d6a4f;
    font-size:18px;
    font-weight:600;
}

body.dark .section h2{
    color:#fff;
}


/* ===== COMBINED CHARTS ===== */

.combined-charts{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-bottom:15px;
}

.combined-charts .chart-container{
    background:#fff;
    padding:15px;
    border-radius:12px;
    box-shadow:0 8px 20px rgba(0,0,0,0.05);
    flex:1;
    min-width:300px;
    height:250px;
}

body.dark .combined-charts .chart-container{
    background:#1e293b;
}

.combined-charts canvas.chart{
    height:100% !important;
}


/* ===== GOALS GRID ===== */

.goals{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:15px;
    margin-top:15px;
}

.goal{
    background:#e0f2f1;
    padding:10px;
    border-radius:10px;
    text-align:center;
    transition:0.3s;
    font-size:0.9rem;
    position:relative;
}

.goal span{
    font-size:18px;
    font-weight:bold;
    display:block;
    margin-bottom:3px;
}

.progress-bar{
    width:100%;
    height:12px;
    background:#d1d5db;
    border-radius:10px;
    margin-top:8px;
    overflow:hidden;
}

.progress-bar-fill{
    height:100%;
    background:#16a34a;
    width:0%;
    border-radius:10px;
    transition:width 1s ease-in-out;
}


/* ===== RESPONSIVE ===== */

@media(max-width:768px){

    .sidebar{
        width:100%;
        flex-direction:row;
        overflow-x:auto;
        height:auto;
        padding:15px;
        position:relative;
    }

    .sidebar h2{
        display:none;
    }

    .sidebar a{
        margin-right:8px;
        margin-bottom:0;
        white-space:nowrap;
    }

    .main{
        margin-left:0;
        padding:20px;
    }

    .cards{
        grid-template-columns:1fr;
    }

    .goals{
        grid-template-columns:1fr;
    }

}

</style>
</head>


<body>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="dashboard.php" class="active">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>

    <a href="branches.php">
        <i class="fas fa-store"></i>
        Branches
    </a>

    <a href="deliveries.php">
        <i class="fas fa-truck"></i>
        Deliveries
    </a>

    <a href="purchase_order.php">
        <i class="fas fa-file-invoice"></i>
        Purchase Orders
    </a>

    <a href="sales.php">
        <i class="fas fa-chart-line"></i>
        Sales Report
    </a>

    <a href="reports.php">
        <i class="fas fa-file-alt"></i>
        Reports
    </a>

    <a href="stocks.php">
        <i class="fas fa-boxes"></i>
        Stocks
    </a>

    <a href="users.php">
        <i class="fas fa-users"></i>
        Users
    </a>

    <a href="../index.html" class="logout">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>

</div>


<!-- =========================================================
     MAIN
========================================================= -->

<div class="main">

    <div class="header">

        <div>

            <h1>
                Admin Dashboard
            </h1>

            <p>
                Real-time KPIs and Sales Overview
            </p>

        </div>

        <button
            class="dark-toggle"
            onclick="toggleDark()"
        >
            🌙 Dark Mode
        </button>

    </div>


    <!-- =====================================================
         METRICS CARDS
    ===================================================== -->

    <div class="cards">

        <div class="card sales">

            <i class="fas fa-coins card-icon"></i>

            <h3>
                Total Sales
            </h3>

            <p>
                ₱<?php echo number_format($total_sales,2); ?>
            </p>

        </div>


        <div class="card orders">

            <i class="fas fa-shopping-cart card-icon"></i>

            <h3>
                Total Orders
            </h3>

            <p>
                <?php echo $total_orders; ?>
            </p>

        </div>


        <div class="card inventory">

            <i class="fas fa-egg card-icon"></i>

            <h3>
                Total Eggs
            </h3>

            <p>
                <?php echo $total_eggs_inventory; ?>
            </p>

        </div>


        <div class="card branches">

            <i class="fas fa-store-alt card-icon"></i>

            <h3>
                Active Branches
            </h3>

            <p>
                <?php echo $active_branches; ?>
            </p>

        </div>

    </div>


    <!-- =====================================================
         COMBINED CHARTS
    ===================================================== -->

    <div class="section">

        <h2>
            Monthly Sales (Last 6 Months)
        </h2>

        <div class="combined-charts">

            <div class="chart-container">

                <canvas
                    id="monthlySalesChart"
                    class="chart"
                ></canvas>

            </div>


            <div class="chart-container">

                <canvas
                    id="branchDistributionChart"
                    class="chart"
                ></canvas>

            </div>

        </div>


        <h2>
            Goals & Completion
        </h2>

        <div class="goals">

            <?php foreach($goals as $goal_name => $goal_val): ?>

                <div class="goal">

                    <strong>
                        <?php echo $goal_name; ?>
                    </strong>

                    <span>
                        <?php echo $goal_val; ?>%
                    </span>

                    <div class="progress-bar">

                        <div
                            class="progress-bar-fill"
                            style="width:<?php echo $goal_val; ?>%"
                        ></div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    </div>


    <!-- =====================================================
         FORECASTING SECTION
    ===================================================== -->

    <div class="section">

        <h2>
            Sales Forecast (Next 3 Months)
        </h2>

        <?php

        // Calculate average monthly sales for Big and Small trays
        $avg_big = array_sum($big_monthly)/count($big_monthly);
        $avg_small = array_sum($small_monthly)/count($small_monthly);

        // Forecast for next 3 months
        $forecast_months = [];
        $forecast_big = [];
        $forecast_small = [];
        $forecast_revenue = [];

        for($i=1;$i<=3;$i++){

            $month = date(
                'Y-m',
                strtotime("+$i month")
            );

            $forecast_months[] =
                date(
                    'M Y',
                    strtotime($month.'-01')
                );

            $forecast_big[] =
                round($avg_big);

            $forecast_small[] =
                round($avg_small);


            // Forecast revenue
            $forecast_revenue[] =
                round(
                    ($avg_big * $big_price) +
                    ($avg_small * $small_price)
                );

        }

        ?>


        <div class="combined-charts">

            <div class="chart-container">

                <canvas
                    id="forecastSalesChart"
                    class="chart"
                ></canvas>

            </div>


            <div class="chart-container">

                <canvas
                    id="forecastRevenueChart"
                    class="chart"
                ></canvas>

            </div>

        </div>


        <p style="margin-top:10px;color:#52796f;font-size:0.95rem;">

            Forecast based on average sales of the last 6 months.

        </p>

    </div>


</div>


<script>


// =========================================================
// DARK MODE
// =========================================================

function toggleDark(){

    document.body.classList.toggle("dark");

    localStorage.setItem(
        'darkMode',
        document.body.classList.contains('dark')
        ? 'enabled'
        : 'disabled'
    );

}


if(
    localStorage.getItem('darkMode') === 'enabled'
){

    document.body.classList.add('dark');

}


// =========================================================
// MONTHLY SALES LINE CHART
// =========================================================

new Chart(
    document.getElementById('monthlySalesChart'),
    {
        type:'line',

        data:{

            labels:
                <?php echo json_encode($months); ?>,

            datasets:[

                {
                    label:'Big Eggs',

                    data:
                        <?php echo json_encode($big_monthly); ?>,

                    borderColor:'#16a34a',

                    fill:false,

                    tension:0.3,

                    pointBackgroundColor:'#16a34a'
                },


                {
                    label:'Small Eggs',

                    data:
                        <?php echo json_encode($small_monthly); ?>,

                    borderColor:'#2563eb',

                    fill:false,

                    tension:0.3,

                    pointBackgroundColor:'#2563eb'
                }

            ]

        },

        options:{

            plugins:{
                legend:{
                    position:'top'
                }
            },

            animation:{
                duration:1000
            }

        }

    }
);


// =========================================================
// BRANCH DISTRIBUTION DOUGHNUT CHART
// =========================================================

new Chart(
    document.getElementById('branchDistributionChart'),
    {
        type:'doughnut',

        data:{

            labels:
                <?php echo json_encode($branch_labels); ?>,

            datasets:[

                {
                    data:
                        <?php echo json_encode($branch_data); ?>,

                    backgroundColor:[
                        '#16a34a',
                        '#2563eb',
                        '#f97316',
                        '#7c3aed',
                        '#4ade80',
                        '#fb923c'
                    ]

                }

            ]

        },

        options:{

            plugins:{

                legend:{
                    position:'bottom'
                }

            },

            animation:{
                animateScale:true,
                animateRotate:true
            }

        }

    }
);


// =========================================================
// FORECAST SALES LINE CHART
// =========================================================

new Chart(
    document.getElementById('forecastSalesChart'),
    {
        type:'line',

        data:{

            labels:
                <?php echo json_encode($forecast_months); ?>,

            datasets:[

                {
                    label:'Big Eggs (Forecast)',

                    data:
                        <?php echo json_encode($forecast_big); ?>,

                    borderColor:'#16a34a',

                    fill:false,

                    tension:0.3,

                    pointBackgroundColor:'#16a34a'
                },


                {
                    label:'Small Eggs (Forecast)',

                    data:
                        <?php echo json_encode($forecast_small); ?>,

                    borderColor:'#2563eb',

                    fill:false,

                    tension:0.3,

                    pointBackgroundColor:'#2563eb'
                }

            ]

        },

        options:{

            plugins:{

                legend:{
                    position:'top'
                },

                title:{
                    display:true,
                    text:'Next 3 Months Sales Forecast (Trays)'
                }

            },

            animation:{
                duration:1000
            }

        }

    }
);


// =========================================================
// FORECAST REVENUE LINE CHART
// =========================================================

new Chart(
    document.getElementById('forecastRevenueChart'),
    {
        type:'line',

        data:{

            labels:
                <?php echo json_encode($forecast_months); ?>,

            datasets:[

                {
                    label:'Revenue (Forecast ₱)',

                    data:
                        <?php echo json_encode($forecast_revenue); ?>,

                    borderColor:'#f97316',

                    fill:false,

                    tension:0.3,

                    pointBackgroundColor:'#f97316'
                }

            ]

        },

        options:{

            plugins:{

                legend:{
                    position:'top'
                },

                title:{
                    display:true,
                    text:'Next 3 Months Revenue Forecast'
                }

            },

            animation:{
                duration:1000
            }

        }

    }
);

</script>


</body>
</html>
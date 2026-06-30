<?php
// ===== INCLUDE BACKEND =====
include __DIR__ . '/backend/deliveries_backend.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Deliveries - Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',Tahoma,Verdana;
}

body{
    background:#f0fdf4;
    color:#2d6a4f;
    transition:0.3s;
}

body.dark{
    background:#121821;
    color:#e0e0e0;
}

body.dark .sidebar{
    background:#0f172a;
}

body.dark .sidebar a.active,
body.dark .sidebar a:hover{
    background:#2563eb;
    color:#fff;
}

body.dark .dashboard-card,
body.dark .chart-container,
body.dark table,
body.dark .card{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark table th{
    background:#2563eb;
    color:#fff;
}

body.dark form input,
body.dark form select{
    background:#334155;
    color:#e0e0e0;
    border:1px solid #555;
}

body.dark form button{
    background:#2563eb;
    color:#fff;
}

.wrapper{
    display:flex;
    min-height:100vh;
}

.sidebar{
    width:240px;
    background:#38b000;
    color:#fff;
    padding:25px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    position:fixed;
    top:0;
    left:0;
    height:100vh;
}

.sidebar a{
    padding:12px;
    margin-bottom:12px;
    background:#2d6a4f;
    color:#fff;
    text-decoration:none;
    border-radius:12px;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:10px;
    transition:0.3s;
}

.sidebar a.active{
    background:#70d6ff;
    color:#000;
}

.sidebar a:hover{
    transform:translateX(5px);
}

.sidebar .logout{
    background:#d00000;
    margin-top:20px;
}

.sidebar .logout:hover{
    background:#9d0208;
}

.main-content{
    flex:1;
    margin-left:260px;
    padding:30px;
}

h1{
    margin-bottom:20px;
}

.alert{
    padding:12px;
    border-radius:12px;
    margin-bottom:20px;
    font-weight:600;
}

.alert.success{
    background:#d1fae5;
    color:#16a34a;
}

.alert.error{
    background:#fcd5ce;
    color:#b91c1c;
}

.dashboard-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:20px;
    margin-bottom:25px;
}

.dashboard-card{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    text-align:center;
    transition:0.3s;
}

.dashboard-card:hover{
    box-shadow:0 12px 35px rgba(0,0,0,0.12);
}

.dashboard-card h2{
    font-size:28px;
    margin-bottom:8px;
    color:#2563eb;
}

.dashboard-card p{
    font-weight:600;
}

.chart-container{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    margin-bottom:25px;
    height:400px;
}

.progress-bar-container{
    background:#e5e7eb;
    border-radius:12px;
    overflow:hidden;
    margin-bottom:15px;
}

.progress-bar{
    height:25px;
    border-radius:12px;
    transition:0.3s;
}

.progress-orders{
    background:#2563eb;
    width:<?= $goalDeliveredPercent ?>%;
}

.card{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

form input,
form select{
    width:100%;
    padding:12px;
    border-radius:12px;
    border:1px solid #ccc;
    margin-bottom:12px;
    font-size:16px;
}

form button{
    padding:12px 20px;
    background:#38b000;
    color:#fff;
    border:none;
    border-radius:12px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
    font-size:16px;
}

form button:hover{
    background:#2d6a4f;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
    background:#fff;
    border-radius:12px;
    overflow:hidden;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ddd;
    font-size:14px;
}

th{
    background:#38b000;
    color:#fff;
}

tr:nth-child(even){
    background:#f0fdf4;
}

.delete-btn{
    background:#d00000;
    color:#fff;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
    font-weight:bold;
    transition:0.3s;
}

.delete-btn:hover{
    background:#9d0208;
}

#darkToggle{
    position:fixed;
    top:15px;
    right:15px;
    padding:10px 18px;
    background:#334155;
    color:#fff;
    border:none;
    border-radius:10px;
    cursor:pointer;
    z-index:1000;
}

#darkToggle:hover{
    background:#2563eb;
}

@media(max-width:768px){

    .main-content{
        margin-left:0;
        padding:20px;
    }

    .dashboard-grid{
        grid-template-columns:repeat(auto-fit,minmax(140px,1fr));
    }
}

</style>
</head>

<body>

<button id="darkToggle">🌙 Dark Mode</button>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar">

<div>

<h2>Admin Panel</h2>

<a href="dashboard.php">
<i class="fas fa-tachometer-alt"></i> Dashboard
</a>

<a href="branches.php">
<i class="fas fa-store"></i> Branches
</a>

<a href="deliveries.php" class="active">
<i class="fas fa-truck"></i> Deliveries
</a>

<a href="purchase_order.php">
<i class="fas fa-file-invoice"></i> Purchase Orders
</a>

<a href="sales.php">
<i class="fas fa-file-invoice"></i> Sales Report
</a>

<a href="reports.php">
<i class="fas fa-file-alt"></i> Reports
</a>

<a href="stocks.php">
<i class="fas fa-boxes"></i> Stocks
</a>

<a href="users.php">
<i class="fas fa-users"></i> Users
</a>

</div>

<a href="../index.html" class="logout">
<i class="fas fa-sign-out-alt"></i> Logout
</a>

</div>

<!-- MAIN CONTENT -->
<div class="main-content">

<h1>Delivery Management</h1>

<?php if($success): ?>
<div class="alert success">
    <?= $success ?>
</div>
<?php endif; ?>

<?php if($error): ?>
<div class="alert error">
    <?= $error ?>
</div>
<?php endif; ?>

<!-- KPI CARDS -->
<div class="dashboard-grid">

<div class="dashboard-card">
<h2><?= $total_deliveries ?></h2>
<p>Total Deliveries</p>
</div>

<div class="dashboard-card">
<h2><?= $stock['big_trays'] ?></h2>
<p>Big Trays Remaining</p>
</div>

<div class="dashboard-card">
<h2><?= $stock['small_trays'] ?></h2>
<p>Small Trays Remaining</p>
</div>

<div class="dashboard-card">
<h2><?= $totalEggsMonth ?></h2>
<p>Total Eggs Delivered</p>
</div>

</div>

<!-- DELIVERY FORM -->
<div class="card">

<h2>Record Delivery</h2>

<form method="post">

<label>Branch:</label>

<select name="branch">

<?php foreach($branches_list as $id=>$name): ?>

<option value="<?= $id ?>">
<?= htmlspecialchars($name) ?>
</option>

<?php endforeach; ?>

</select>

<label>Big Tray (1 dozen):</label>

<input
type="number"
id="big_trays"
name="big_trays"
min="0"
max="<?= $stock['big_trays'] ?>"
value="0">

<label>Price Per Big Tray:</label>

<input
type="number"
id="big_price"
name="big_price"
step="0.01"
min="0"
value="106">

<label>Small Tray (Half dozen):</label>

<input
type="number"
id="small_trays"
name="small_trays"
min="0"
max="<?= $stock['small_trays'] ?>"
value="0">

<label>Price Per Small Tray:</label>

<input
type="number"
id="small_price"
name="small_price"
step="0.01"
min="0"
value="56">

<label>Total Amount:</label>

<input
type="text"
id="total_amount"
readonly
value="₱0.00">

<button type="submit" name="record_delivery">
Deliver Eggs
</button>

</form>

</div>

<!-- CHART -->
<h2>Monthly Deliveries Chart</h2>

<div class="chart-container">
<canvas id="branchChart"></canvas>
</div>

<!-- DAILY CHART -->
<h2>Daily Deliveries Chart</h2>

<div class="chart-container">
<canvas id="dailyChart"></canvas>
</div>

<!-- GOALS -->
<h2>Delivery Completion Goals</h2>

<div class="progress-bar-container">
<div class="progress-bar progress-orders"></div>
</div>

<p>
<?= $goalDeliveredPercent ?>%
of target deliveries completed
(Target: <?= $goalOrders ?>)
</p>

<!-- RECENT DELIVERIES -->
<h2>Recent Deliveries</h2>

<table>

<tr>
<th>ID</th>
<th>Branch</th>
<th>Big Trays</th>
<th>Small Trays</th>
<th>Total Eggs</th>
<th>Total Amount</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php if(!empty($deliveries)): ?>

<?php foreach($deliveries as $d):

$total_eggs =
($d['big_trays'] * 12) +
($d['small_trays'] * 6);

?>

<tr>

<td><?= $d['id'] ?></td>

<td><?= htmlspecialchars($d['branch_name']) ?></td>

<td><?= $d['big_trays'] ?></td>

<td><?= $d['small_trays'] ?></td>

<td><?= $total_eggs ?> pcs</td>

<td>
₱<?= number_format($d['total_amount'],2) ?>
</td>

<td>
<?= date("Y-m-d H:i", strtotime($d['created_at'])) ?>
</td>

<td>

<a href="?delete=<?= $d['id'] ?>"
class="delete-btn"
onclick="return confirm('Delete this delivery record?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

<?php else: ?>

<tr>
<td colspan="8">
No deliveries recorded.
</td>
</tr>

<?php endif; ?>

</table>

</div>
</div>

<script>

function calculateTotal(){

    let bigQty =
        parseInt(document.getElementById('big_trays').value) || 0;

    let smallQty =
        parseInt(document.getElementById('small_trays').value) || 0;

    let bigPrice =
        parseFloat(document.getElementById('big_price').value) || 0;

    let smallPrice =
        parseFloat(document.getElementById('small_price').value) || 0;

    let total =
        (bigQty * bigPrice) +
        (smallQty * smallPrice);

    document.getElementById('total_amount').value =
        '₱' + total.toLocaleString(undefined,{
            minimumFractionDigits:2,
            maximumFractionDigits:2
        });
}

document.getElementById('big_trays')
.addEventListener('input', calculateTotal);

document.getElementById('small_trays')
.addEventListener('input', calculateTotal);

document.getElementById('big_price')
.addEventListener('input', calculateTotal);

document.getElementById('small_price')
.addEventListener('input', calculateTotal);

calculateTotal();

const toggleBtn = document.getElementById('darkToggle');

// LOAD SAVED MODE
if(localStorage.getItem('darkMode') === 'enabled'){

    document.body.classList.add('dark');

    toggleBtn.textContent = "☀️ Light Mode";
}

// TOGGLE DARK MODE
toggleBtn.addEventListener('click', () => {

    document.body.classList.toggle('dark');

    const isDark =
    document.body.classList.contains('dark');

    toggleBtn.textContent =
    isDark
    ? "☀️ Light Mode"
    : "🌙 Dark Mode";

    localStorage.setItem(
        'darkMode',
        isDark ? 'enabled' : 'disabled'
    );
});

// MONTHLY CHART
new Chart(
document.getElementById('branchChart').getContext('2d'),
{
    type:'bar',

    data:{
        labels:<?= json_encode($chartLabels) ?>,

        datasets:[

        {
            label:'Big Trays',
            data:<?= json_encode($chartBig) ?>,
            backgroundColor:'#38b000'
        },

        {
            label:'Small Trays',
            data:<?= json_encode($chartSmall) ?>,
            backgroundColor:'#70d6ff'
        },

        {
            label:'Total Eggs',
            data:<?= json_encode($chartTotal) ?>,
            backgroundColor:'#ffba08'
        }

        ]
    },

    options:{
        responsive:true,

        plugins:{
            legend:{position:'top'},

            title:{
                display:true,
                text:'Branch Deliveries This Month'
            }
        },

        scales:{
            y:{beginAtZero:true}
        }
    }
});

// DAILY CHART
new Chart(
document.getElementById('dailyChart').getContext('2d'),
{
    type:'line',

    data:{
        labels:<?= json_encode($dailyLabels) ?>,

        datasets:[

        {
            label:'Big Trays',
            data:<?= json_encode($dailyBig) ?>,
            borderColor:'#38b000',
            fill:false,
            tension:0.2
        },

        {
            label:'Small Trays',
            data:<?= json_encode($dailySmall) ?>,
            borderColor:'#70d6ff',
            fill:false,
            tension:0.2
        },

        {
            label:'Total Eggs',
            data:<?= json_encode($dailyTotal) ?>,
            borderColor:'#ffba08',
            fill:false,
            tension:0.2
        }

        ]
    },

    options:{
        responsive:true,

        plugins:{
            legend:{position:'top'},

            title:{
                display:true,
                text:'Daily Deliveries'
            }
        }
    }
});

</script>

</body>
</html>
<?php include __DIR__ . '/backend/sales_backend.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sales Report - Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ===== YOUR ORIGINAL DESIGN (UNCHANGED) ===== */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma,Verdana;}
body{background:#e6f4ea;color:#2d6a4f;transition:0.3s;}
body.dark{background:#121821;color:#e0e0e0;}
body.dark .sidebar{background:#0f172a;}
body.dark .sidebar a.active,body.dark .sidebar a:hover{background:#2563eb;color:#fff;}
body.dark .card,body.dark .card-summary,body.dark table{background:#1e293b;color:#e0e0e0;}
body.dark th{background:#2563eb;color:#fff;}
body.dark tr:nth-child(even){background:#1e293b;}
body.dark tr:hover{background:#334155;}
body.dark #darkToggle{background:#334155;color:#fff;}

.wrapper{display:flex;min-height:100vh;}

.sidebar{
    width:240px;background:#38b000;color:#fff;
    padding:25px;display:flex;flex-direction:column;
    justify-content:space-between;position:fixed;top:0;left:0;height:100vh;
}

.sidebar h2{text-align:center;font-size:1.8rem;margin-bottom:35px;font-weight:700;}

.sidebar a{
    display:flex;align-items:center;gap:10px;
    padding:12px 18px;margin-bottom:12px;
    background:#2d6a4f;color:#fff;
    border-radius:10px;text-decoration:none;
    font-weight:600;
}

.sidebar a.active,.sidebar a:hover{background:#70d6ff;color:#000;}
.sidebar .logout{background:#d90429;margin-top:auto;}

.main-content{
    flex:1;padding:30px 40px;margin-left:260px;
}

.header{
    display:flex;justify-content:space-between;align-items:center;margin-bottom:35px;
}

#darkToggle{
    padding:8px 16px;border:none;border-radius:6px;
    background:#334155;color:#fff;cursor:pointer;
}

.cards-container{
    display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;margin-bottom:35px;
}

.card-summary{
    background:#fff;padding:25px;border-radius:12px;
}

.card-summary p{
    font-size:1.7rem;font-weight:700;
}

.card{
    background:#fff;padding:25px;border-radius:12px;
    margin-bottom:30px;
}

table{
    width:100%;border-collapse:collapse;border-radius:12px;overflow:hidden;
}

th,td{padding:14px;text-align:center;}

th{background:#38b000;color:#fff;}

tr:nth-child(even){background:#f6fbf7;}

body.dark th{background:#2563eb;}
body.dark tr:nth-child(even){background:#1e293b;}

/* DELETE BUTTON */
.delete-btn{
    background:#d90429;
    color:#fff;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    display:inline-block;
}
</style>
</head>

<body>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="branches.php"><i class="fas fa-store"></i> Branches</a>
    <a href="deliveries.php"><i class="fas fa-truck"></i> Deliveries</a>
    <a href="purchase_order.php"><i class="fas fa-file-invoice"></i> Purchase Orders</a>
    <a href="sales.php" class="active"><i class="fas fa-chart-line"></i> Sales Report</a>
    <a href="reports.php"><i class="fas fa-file-alt"></i> Reports</a>
    <a href="stocks.php"><i class="fas fa-boxes"></i> Stocks</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>
    <a href="../index.html" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- MAIN -->
<div class="main-content">

<div class="header">
    <h1>Sales Report</h1>
    <button id="darkToggle">🌙 Dark Mode</button>
</div>

<div class="cards-container">
    <div class="card-summary">Total Sales<br><p><?= number_format($total_sales_amount,2) ?></p></div>
    <div class="card-summary">Big<br><p><?= $total_big_trays ?></p></div>
    <div class="card-summary">Small<br><p><?= $total_small_trays ?></p></div>
    <div class="card-summary">Eggs<br><p><?= $total_eggs ?></p></div>
</div>

<div class="card">
<h2>Sales Records</h2>

<table>
<tr>
<th>ID</th>
<th>Branch</th>
<th>Big</th>
<th>Small</th>
<th>Eggs</th>
<th>Total</th>
<th>Date</th>
<th>Action</th>
</tr>

<?php foreach($sales as $row): ?>
<tr>
<td><?= $row['id'] ?></td>
<td><?= $row['branch_name'] ?></td>
<td><?= $row['big_trays_sold'] ?></td>
<td><?= $row['small_trays_sold'] ?></td>
<td><?= $row['egg_pieces_sold'] ?></td>
<td>₱<?= number_format($row['total_amount'],2) ?></td>
<td><?= $row['sale_datetime'] ?></td>
<td>
    <a class="delete-btn"
       href="sales.php?delete=<?= $row['id'] ?>"
       onclick="return confirm('Delete this record?')">
       Delete
    </a>
</td>
</tr>
<?php endforeach; ?>

</table>

</div>
</div>

<script>
// DARK MODE (UNCHANGED)
const body = document.body;
const toggle = document.getElementById('darkToggle');

if(localStorage.getItem('darkMode')==='enabled'){
    body.classList.add('dark');
}

toggle.onclick = () => {
    body.classList.toggle('dark');
    localStorage.setItem('darkMode', body.classList.contains('dark') ? 'enabled' : 'disabled');
};
</script>

</body>
</html>
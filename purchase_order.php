<?php include __DIR__ . '/backend/purchase_order_backend.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Purchase Order - Admin Panel</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

/* ===== BASE ===== */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',Tahoma;}
body{background:#f0fdf4;color:#2d6a4f;transition:0.3s;}
body.dark{background:#121821;color:#e0e0e0;}

/* ===== WRAPPER ===== */
.wrapper{display:flex;min-height:100vh;}

/* ===== SIDEBAR (UNCHANGED) ===== */
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
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.sidebar a:hover{background:#70d6ff;color:#000;}
.sidebar a.active{background:#70d6ff;color:#000;}

.sidebar .logout{
    background:#d90429;
    margin-top:auto;
}
.sidebar .logout:hover{background:#9b0a20;}

/* DARK SIDEBAR */
body.dark .sidebar{background:#0f172a;}
body.dark .sidebar a.active,
body.dark .sidebar a:hover{background:#2563eb;color:#fff;}

/* ===== MAIN ===== */
.main-content{
    flex:1;
    margin-left:260px;
    padding:30px;
}

/* ===== TEXT ===== */
h1,h2{color:#2d6a4f;}
body.dark h1,
body.dark h2{color:#fff;}

/* ===== FORM ===== */
form input,form select{
    width:100%;
    padding:12px;
    margin-bottom:10px;
    border-radius:10px;
    border:1px solid #ccc;
}

form button{
    padding:12px 18px;
    background:#38b000;
    border:none;
    color:#fff;
    border-radius:10px;
    cursor:pointer;
}

form button:hover{background:#2d6a4f;}

body.dark form input,
body.dark form select{
    background:#334155;
    color:#fff;
}

/* ===== RECEIPT ===== */
.receipt{
    background:#fff;
    padding:20px;
    margin-top:20px;
    border-radius:12px;
}

/* ===== TABLE (UNCHANGED) ===== */
table{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
    background:#fff;
}

th{
    background:#38b000;
    color:#fff;
    padding:10px;
}

td{
    padding:10px;
    text-align:center;
}

tr:nth-child(even){
    background:#f0fdf4;
}

/* ===== PRINT BUTTON ===== */
.print-btn{
    margin-top:10px;
    padding:10px 15px;
    background:#38b000;
    color:#fff;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

/* ===== DARK TOGGLE ===== */
#darkToggle{
    position:fixed;
    top:15px;
    right:15px;
    padding:10px 15px;
    background:#334155;
    color:#fff;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

/* ===== DELETE BUTTON (ONLY ADDITION) ===== */
.delete-btn{
    color:red;
    font-weight:bold;
    text-decoration:none;
}
</style>
</head>

<body>

<button id="darkToggle">🌙 Dark Mode</button>

<div class="wrapper">

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>

    <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="branches.php"><i class="fas fa-store"></i> Branches</a>
    <a href="deliveries.php"><i class="fas fa-truck"></i> Deliveries</a>
    <a href="purchase_order.php" class="active"><i class="fas fa-file-invoice"></i> Purchase Orders</a>
    <a href="sales.php"><i class="fas fa-chart-line"></i> Sales Report</a>
    <a href="reports.php"><i class="fas fa-file-alt"></i> Reports</a>
    <a href="stocks.php"><i class="fas fa-boxes"></i> Stocks</a>
    <a href="users.php"><i class="fas fa-users"></i> Users</a>

    <a href="../index.html" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<!-- MAIN -->
<div class="main-content">

<h1>Purchase Order Management</h1>

<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>
<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>


<?php if($receipt): ?>
<div class="receipt">
    <h2>Receipt</h2>
    <p>PO-<?= $receipt['id'] ?></p>
    <p>Branch: <?= $receipt['branch'] ?></p>
    <p>Total Eggs: <?= $receipt['total_eggs'] ?></p>

    <button class="print-btn" onclick="window.print()">Print</button>
</div>
<?php endif; ?>

<h2>History</h2>

<table>
<tr>
<th>PO</th>
<th>Branch</th>
<th>Big</th>
<th>Small</th>
<th>Eggs</th>
<th>Date</th>
<th>Print</th>
<th>Action</th>
</tr>

<?php foreach($deliveries_history as $d): ?>
<tr>
<td>PO-<?= $d['id'] ?></td>
<td><?= $d['branch_name'] ?></td>
<td><?= $d['big_trays'] ?></td>
<td><?= $d['small_trays'] ?></td>
<td><?= $d['total_eggs'] ?></td>
<td><?= $d['delivery_datetime'] ?></td>

<td>
<button class="print-btn"
onclick="window.open('print_po.php?id=<?= $d['id'] ?>')">
Print
</button>
</td>

<!-- ONLY ADDITION -->
<td>
<a href="?delete=<?= $d['id'] ?>"
class="delete-btn"
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
const btn=document.getElementById("darkToggle");

if(localStorage.getItem("darkMode")==="enabled"){
    document.body.classList.add("dark");
    btn.textContent="☀️ Light Mode";
}

btn.onclick=()=>{
    document.body.classList.toggle("dark");
    let dark=document.body.classList.contains("dark");
    btn.textContent=dark?"☀️ Light Mode":"🌙 Dark Mode";
    localStorage.setItem("darkMode",dark?"enabled":"disabled");
};
</script>

</body>
</html>
```php
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

/* ===== BASE ===== */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',Tahoma,Verdana;
}

body{
    background:#e6f4ea;
    color:#2d6a4f;
    transition:0.3s;
}

body.dark{
    background:#121821;
    color:#e0e0e0;
}


/* ===== WRAPPER ===== */
.wrapper{
    display:flex;
    min-height:100vh;
    overflow:hidden;
}


/* ===== SIDEBAR ===== */
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


/* ===== DARK SIDEBAR ===== */
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


/* ===== MAIN CONTENT ===== */
.main-content{
    flex:1;
    padding:30px;
    margin-left:260px;
    overflow-y:auto;
    height:100vh;
}


/* ===== HEADER ===== */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.header h1{
    font-size:2.2rem;
    color:#2d6a4f;
}

body.dark .header h1{
    color:#fff;
}


/* ===== DARK TOGGLE ===== */
#darkToggle{
    padding:8px 15px;
    border:none;
    border-radius:6px;
    background:#334155;
    color:#fff;
    cursor:pointer;
    font-weight:600;
    transition:0.3s;
}

#darkToggle:hover{
    background:#1e293b;
}

body.dark #darkToggle{
    background:#334155;
    color:#fff;
}


/* ===== SALES CARDS ===== */
.cards-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:25px;
    margin-bottom:35px;
}

.card-summary{
    background:#fff;
    padding:25px;
    border-radius:12px;
    color:#2d6a4f;
}

.card-summary p{
    font-size:1.7rem;
    font-weight:700;
    margin-top:8px;
    color:#2d6a4f;
}


/* ===== DARK SALES CARDS ===== */
body.dark .card-summary{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark .card-summary p{
    color:#fff;
}


/* ===== CARD ===== */
.card{
    background:#fff;
    padding:25px;
    border-radius:12px;
    margin-bottom:30px;
}

.card h2{
    color:#2d6a4f;
    margin-bottom:15px;
}

body.dark .card{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark .card h2{
    color:#fff;
}


/* ===== TABLE ===== */
table{
    width:100%;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
    background:#fff;
}

th,
td{
    padding:14px;
    text-align:center;
}

th{
    background:#38b000;
    color:#fff;
}

td{
    color:#2d6a4f;
}

tr:nth-child(even){
    background:#f6fbf7;
}

tr:hover{
    background:#e8f5e9;
}


/* ===== DARK TABLE ===== */
body.dark table{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark th{
    background:#2563eb;
    color:#fff;
}

body.dark td{
    color:#e0e0e0;
}

body.dark tr:nth-child(even){
    background:#1e293b;
}

body.dark tr:nth-child(odd){
    background:#152030;
}

body.dark tr:hover{
    background:#334155;
}


/* ===== DELETE BUTTON ===== */
.delete-btn{
    background:#d90429;
    color:#fff;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    display:inline-block;
}

.delete-btn:hover{
    background:#9b0a20;
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

    .main-content{
        margin-left:0;
        padding:20px;
        height:auto;
    }

    .cards-container{
        grid-template-columns:1fr;
    }

}

</style>
</head>


<body>

<div class="wrapper">


<!-- SIDEBAR -->

<div class="sidebar">

    <h2>Admin Panel</h2>

    <a href="dashboard.php">
        <i class="fas fa-tachometer-alt"></i>
        Dashboard
    </a>

    <a href="branches.php">
        <i class="fas fa-store"></i>
        Branches
    </a>

    <!-- DELIVERIES IS HIGHLIGHTED -->
    <a href="deliveries.php" class="active">
        <i class="fas fa-truck"></i>
        Deliveries
    </a>

    <a href="purchase_order.php">
        <i class="fas fa-file-invoice"></i>
        Purchase Orders
    </a>

    <!-- SALES REPORT IS NOT HIGHLIGHTED -->
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


<!-- MAIN -->

<div class="main-content">


<div class="header">

    <h1>Sales Report</h1>

    <button id="darkToggle">
        🌙 Dark Mode
    </button>

</div>


<!-- SALES SUMMARY -->

<div class="cards-container">

    <div class="card-summary">

        Total Sales

        <br>

        <p>
            <?= number_format($total_sales_amount,2) ?>
        </p>

    </div>


    <div class="card-summary">

        Big

        <br>

        <p>
            <?= $total_big_trays ?>
        </p>

    </div>


    <div class="card-summary">

        Small

        <br>

        <p>
            <?= $total_small_trays ?>
        </p>

    </div>


    <div class="card-summary">

        Eggs

        <br>

        <p>
            <?= $total_eggs ?>
        </p>

    </div>

</div>


<!-- SALES RECORDS -->

<div class="card">

    <h2>
        Sales Records
    </h2>


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

            <td>
                <?= $row['id'] ?>
            </td>

            <td>
                <?= $row['branch_name'] ?>
            </td>

            <td>
                <?= $row['big_trays_sold'] ?>
            </td>

            <td>
                <?= $row['small_trays_sold'] ?>
            </td>

            <td>
                <?= $row['egg_pieces_sold'] ?>
            </td>

            <td>
                ₱<?= number_format($row['total_amount'],2) ?>
            </td>

            <td>
                <?= $row['sale_datetime'] ?>
            </td>

            <td>

                <a
                    class="delete-btn"
                    href="sales.php?delete=<?= $row['id'] ?>"
                    onclick="return confirm('Delete this record?')"
                >
                    Delete
                </a>

            </td>

        </tr>

        <?php endforeach; ?>

    </table>

</div>


</div>

</div>


<!-- DARK MODE -->

<script>

const body = document.body;
const toggle = document.getElementById('darkToggle');

if(localStorage.getItem('darkMode') === 'enabled'){

    body.classList.add('dark');

    toggle.textContent = '☀️ Light Mode';

}

toggle.onclick = () => {

    body.classList.toggle('dark');

    const dark =
        body.classList.contains('dark');

    toggle.textContent =
        dark
        ? '☀️ Light Mode'
        : '🌙 Dark Mode';

    localStorage.setItem(
        'darkMode',
        dark ? 'enabled' : 'disabled'
    );

};

</script>

</body>
</html>
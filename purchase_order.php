<?php
session_start();

include __DIR__ . '/includes/db.php';

/* Include Purchase Order Backend */
include __DIR__ . '/backend/purchase_order_backend.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>Purchase Order - Admin Panel</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

/* GENERAL STYLES */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',Verdana,Tahoma;
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


/* WRAPPER */

.wrapper{
    display:flex;
    min-height:100vh;
    overflow:hidden;
}


/* SIDEBAR */

.sidebar{
    width:240px;
    background:#38b000;
    color:#fff;
    padding:25px;
    display:flex;
    flex-direction:column;
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


/* DARK SIDEBAR */

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


/* MAIN CONTENT */

.main-content{
    flex:1;
    padding:30px;
    height:100vh;
    overflow-y:auto;
}


/* HEADER */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header h1{
    font-size:2.2rem;
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


/* DARK MODE BUTTON */

#darkToggle{
    padding:8px 16px;
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


/* FORM */

.form-card{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.form-card h2{
    color:#2d6a4f;
    margin-bottom:15px;
}

body.dark .form-card{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark .form-card h2{
    color:#fff;
}

form input,
form select{
    width:100%;
    padding:12px;
    margin-bottom:10px;
    border-radius:10px;
    border:1px solid #ccc;
    font-size:1rem;
}

form input:focus,
form select:focus{
    outline:none;
    border-color:#38b000;
}

body.dark form input,
body.dark form select{
    background:#2d3748;
    color:#e0e0e0;
    border:1px solid #555;
}


/* FORM BUTTON */

form button{
    padding:10px 16px;
    background:#38b000;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
}

form button:hover{
    background:#2d6a4f;
}

body.dark form button{
    background:#2563eb;
    color:#fff;
}


/* RECEIPT */

.receipt{
    background:#fff;
    padding:20px;
    border-radius:12px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.receipt h2{
    color:#2d6a4f;
    margin-bottom:12px;
}

.receipt p{
    margin-bottom:8px;
    color:#2d6a4f;
}

body.dark .receipt{
    background:#1e293b;
    color:#e0e0e0;
}

body.dark .receipt h2{
    color:#fff;
}

body.dark .receipt p{
    color:#e0e0e0;
}


/* HISTORY CARD */

.table-card{
    background:#fff;
    padding:25px;
    border-radius:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.table-card h2{
    color:#2d6a4f;
    margin-bottom:15px;
}

body.dark .table-card{
    background:#1e293b;
}

body.dark .table-card h2{
    color:#fff;
}


/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
}

th,
td{
    padding:12px;
    text-align:center;
    font-size:1rem;
    border-bottom:1px solid #ddd;
}

th{
    background:#38b000;
    color:#fff;
    font-weight:600;
}

td{
    color:#2d6a4f;
}

tr:nth-child(even){
    background:#f6fbf7;
}

tr:hover{
    background:#e0f4e6;
    transition:0.2s;
}


/* DARK TABLE */

body.dark table{
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
    background:#2d3748;
}


/* PRINT BUTTON */

.print-btn{
    display:inline-block;
    padding:6px 10px;
    background:#38b000;
    color:#fff;
    border:none;
    border-radius:6px;
    cursor:pointer;
    text-decoration:none;
    font-weight:600;
}

.print-btn:hover{
    background:#2d6a4f;
}

body.dark .print-btn{
    background:#2563eb;
    color:#fff;
}


/* DELETE BUTTON */

.delete-btn{
    display:inline-block;
    background:#d90429;
    color:#fff;
    padding:6px 10px;
    border-radius:6px;
    text-decoration:none;
    margin-top:5px;
    font-weight:600;
}

.delete-btn:hover{
    background:#9b0a20;
}


/* MESSAGE */

.success-message{
    background:#d1fae5;
    color:#065f46;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    font-weight:bold;
}

.error-message{
    background:#fcd5ce;
    color:#7f1d1d;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    font-weight:bold;
}


/* RESPONSIVE */

@media(max-width:768px){

    .sidebar{
        width:100%;
        flex-direction:row;
        overflow-x:auto;
        height:auto;
        padding:15px;
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
        padding:20px;
        height:auto;
    }

    table{
        min-width:700px;
    }

    .table-card{
        overflow-x:auto;
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

    <a href="deliveries.php">
        <i class="fas fa-truck"></i>
        Deliveries
    </a>

    <a href="purchase_order.php" class="active">
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


<!-- MAIN CONTENT -->

<div class="main-content">


<!-- HEADER -->

<div class="header">

    <div>

        <h1>Purchase Order Management</h1>

        <p>Manage purchase orders and delivery records</p>

    </div>

    <button id="darkToggle">
        🌙 Dark Mode
    </button>

</div>


<!-- SUCCESS / ERROR -->

<?php if(isset($success) && $success): ?>

<p style="color:green; margin-top:10px;">
    <?= $success ?>
</p>

<?php endif; ?>


<?php if(isset($error) && $error): ?>

<p style="color:red; margin-top:10px;">
    <?= $error ?>
</p>

<?php endif; ?>


<!-- RECEIPT -->

<?php if(isset($receipt) && $receipt): ?>

<div class="receipt">

    <h2>Receipt</h2>

    <p>
        PO-<?= $receipt['id'] ?>
    </p>

    <p>
        Branch: <?= $receipt['branch'] ?>
    </p>

    <p>
        Total Eggs: <?= $receipt['total_eggs'] ?>
    </p>

    <button
        class="print-btn"
        onclick="window.print()"
    >
        Print
    </button>

</div>

<?php endif; ?>


<!-- HISTORY -->

<div class="table-card">

    <h2>
        History
    </h2>


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

            <td>
                PO-<?= $d['id'] ?>
            </td>

            <td>
                <?= $d['branch_name'] ?>
            </td>

            <td>
                <?= $d['big_trays'] ?>
            </td>

            <td>
                <?= $d['small_trays'] ?>
            </td>

            <td>
                <?= $d['total_eggs'] ?>
            </td>

            <td>
                <?= $d['delivery_datetime'] ?>
            </td>


            <td>

                <button
                    class="print-btn"
                    onclick="window.open('print_po.php?id=<?= $d['id'] ?>')"
                >

                    Print

                </button>

            </td>


            <td>

                <a
                    href="?delete=<?= $d['id'] ?>"
                    class="delete-btn"
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

const body =
    document.body;

const toggle =
    document.getElementById(
        "darkToggle"
    );


if(
    localStorage.getItem(
        "darkMode"
    ) === "enabled"
){

    body.classList.add(
        "dark"
    );

    toggle.textContent =
        "☀️ Light Mode";

}


toggle.onclick = () => {

    body.classList.toggle(
        "dark"
    );


    if(
        body.classList.contains(
            "dark"
        )
    ){

        localStorage.setItem(
            "darkMode",
            "enabled"
        );

        toggle.textContent =
            "☀️ Light Mode";

    }else{

        localStorage.setItem(
            "darkMode",
            "disabled"
        );

        toggle.textContent =
            "🌙 Dark Mode";

    }

};

</script>


</body>

</html>

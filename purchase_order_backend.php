<?php
session_start();
include __DIR__ . '/../includes/db.php';

/* ===== AUTO ADMIN LOGIN ===== */
if(!isset($_SESSION['user'])){
    $_SESSION['user'] = [
        "role"=>"admin",
        "name"=>"Administrator"
    ];
}

/* ===== FETCH BRANCHES ===== */
$branches_list = [];

$result_branches = $conn->query("
    SELECT id, branch_name
    FROM branches
    ORDER BY branch_name ASC
");

while($row = $result_branches->fetch_assoc()){
    $branches_list[$row['id']] = $row['branch_name'];
}

$success = "";
$error = "";
$receipt = null;

/* =========================================================
   DELETE DELIVERY (NEW)
========================================================= */
if(isset($_GET['delete'])){

    $delete_id = (int)$_GET['delete'];

    $stmt = $conn->prepare("
        DELETE FROM deliveries
        WHERE id = ?
    ");

    $stmt->bind_param("i", $delete_id);

    if($stmt->execute()){
        $success = "Record deleted successfully!";
    } else {
        $error = "Failed to delete record!";
    }

    $stmt->close();
}


/* ===== HISTORY ===== */
$deliveries_history = [];

$result = $conn->query("
    SELECT
        d.id,
        d.big_trays,
        d.small_trays,
        d.delivery_datetime,
        b.branch_name
    FROM deliveries d
    JOIN branches b ON d.branch_id=b.id
    ORDER BY d.id DESC
");

while($row = $result->fetch_assoc()){
    $row['total_eggs'] = ($row['big_trays']*12)+($row['small_trays']*6);
    $deliveries_history[] = $row;
}
?>
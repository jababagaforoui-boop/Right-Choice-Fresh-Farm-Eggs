<?php
session_start();
include __DIR__ . '/../includes/db.php';

// Protect page - admin only
if(!isset($_SESSION['admin'])){
    $_SESSION['admin'] = 1;
}

/* =========================
   DELETE HANDLER (FIX)
========================= */
if(isset($_GET['delete'])){
    $delete_id = (int) $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM sales WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    $stmt->close();

    header("Location: sales.php");
    exit();
}

/* =========================
     PIECES
========================= */

$big_tray_pieces = 12;
$small_tray_pieces = 6;

/* =========================
   FETCH SALES
========================= */
$sales_query = "
    SELECT
        s.id,
        s.branch_id,
        s.big_trays_sold,
        s.small_trays_sold,
        s.big_price,
        s.small_price,
        s.total_amount,
        s.sale_datetime,
        b.branch_name
    FROM sales s
    LEFT JOIN branches b ON s.branch_id = b.id
    ORDER BY s.sale_datetime ASC
";

$result = $conn->query($sales_query);

$sales = [];

if ($result) {
    while($row = $result->fetch_assoc()) {

        $row['egg_pieces_sold'] =
            ($row['big_trays_sold'] * 12) +
            ($row['small_trays_sold'] * 6);

        // Use the saved total from database
        $row['total_amount'] = (float)$row['total_amount'];

        $sales[] = $row;
    }
}

/* =========================
   TOTALS / CHART DATA
========================= */
$branch_totals = [];
$daily_totals = [];
$branch_trays = [];

$total_big_trays = 0;
$total_small_trays = 0;
$total_eggs = 0;
$total_sales_amount = 0;

foreach($sales as $s){

    $branch = $s['branch_name'] ?? 'Unknown';

    $branch_totals[$branch] =
        ($branch_totals[$branch] ?? 0) + $s['total_amount'];

    $date = date("Y-m-d", strtotime($s['sale_datetime']));
    $daily_totals[$date] =
        ($daily_totals[$date] ?? 0) + $s['total_amount'];

    if(!isset($branch_trays[$branch])){
        $branch_trays[$branch] = ['big'=>0,'small'=>0];
    }

    $branch_trays[$branch]['big'] += $s['big_trays_sold'];
    $branch_trays[$branch]['small'] += $s['small_trays_sold'];

    $total_big_trays += $s['big_trays_sold'];
    $total_small_trays += $s['small_trays_sold'];
    $total_eggs += $s['egg_pieces_sold'];
    $total_sales_amount += $s['total_amount'];
}
?>
<?php
// =====================
// Client Dashboard Backend
// =====================

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Include database
include __DIR__ . '/../includes/db.php';

/* SECURITY: only client users */
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'client'){
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];
$branch_id   = $user['branch_id'];
$branch_name = $user['branch_name'] ?? 'Branch';

/* EGGS PER TRAY */
$big_tray_eggs = 12;
$small_tray_eggs = 6;

/* ================= FETCH INVENTORY ================= */
$stmt = $conn->prepare("SELECT * FROM inventory WHERE branch_id=?");
$stmt->bind_param("i",$branch_id);
$stmt->execute();
$inventory = $stmt->get_result()->fetch_assoc();

$big_remaining   = $inventory['big_trays'] ?? 0;
$small_remaining = $inventory['small_trays'] ?? 0;

/* ================= FETCH SALES ================= */
$stmt_sales = $conn->prepare("
    SELECT 
        SUM(big_trays_sold) AS big_sold,
        SUM(small_trays_sold) AS small_sold
    FROM sales WHERE branch_id=?
");
$stmt_sales->bind_param("i",$branch_id);
$stmt_sales->execute();
$sales = $stmt_sales->get_result()->fetch_assoc();

$total_big_sold   = $sales['big_sold'] ?? 0;
$total_small_sold = $sales['small_sold'] ?? 0;

/* ================= FETCH RETURNS ================= */
$stmt_ret = $conn->prepare("
    SELECT 
        SUM(big_trays) AS big_returned,
        SUM(small_trays) AS small_returned,
        SUM(egg_pieces) AS pieces_returned
    FROM returns WHERE branch_id=?
");
$stmt_ret->bind_param("i",$branch_id);
$stmt_ret->execute();
$ret = $stmt_ret->get_result()->fetch_assoc();

$total_big_returned   = $ret['big_returned'] ?? 0;
$total_small_returned = $ret['small_returned'] ?? 0;
$total_pieces_returned = $ret['pieces_returned'] ?? 0;

/* ================= CALCULATIONS ================= */
$eggs_sold =
    ($total_big_sold * $big_tray_eggs) +
    ($total_small_sold * $small_tray_eggs);

$eggs_returned =
    ($total_big_returned * $big_tray_eggs) +
    ($total_small_returned * $small_tray_eggs) +
    $total_pieces_returned;

$total_eggs_remaining =
    ($big_remaining * $big_tray_eggs) +
    ($small_remaining * $small_tray_eggs);

/* ================= PROFIT (FROM SALES RECORDS) ================= */
$stmt_profit = $conn->prepare("
    SELECT SUM(total_amount) AS total_profit
    FROM sales
    WHERE branch_id = ?
");
$stmt_profit->bind_param("i", $branch_id);
$stmt_profit->execute();
$profit_result = $stmt_profit->get_result()->fetch_assoc();

$total_profit = $profit_result['total_profit'] ?? 0; 

/* MONTHLY DATA */
$six_months = [];
$big_monthly = [];
$small_monthly = [];

for($i=5;$i>=0;$i--){
    $month = date('Y-m', strtotime("-$i month"));
    $six_months[] = date('M Y', strtotime($month.'-01'));

    $stmt_month = $conn->prepare("
        SELECT 
            SUM(big_trays_sold) AS big_sold,
            SUM(small_trays_sold) AS small_sold
        FROM sales
        WHERE branch_id=? 
        AND DATE_FORMAT(sale_datetime,'%Y-%m')=?
    ");

    $stmt_month->bind_param("is",$branch_id,$month);
    $stmt_month->execute();
    $res = $stmt_month->get_result()->fetch_assoc();

    $big_monthly[] = ($res['big_sold'] ?? 0) * $big_tray_eggs;
    $small_monthly[] = ($res['small_sold'] ?? 0) * $small_tray_eggs;
}

/* ================= FORECAST ================= */
$avg_big = count($big_monthly) ? round(array_sum($big_monthly)/count($big_monthly)) : 0;
$avg_small = count($small_monthly) ? round(array_sum($small_monthly)/count($small_monthly)) : 0;

$forecast_big = [];
$forecast_small = [];
$forecast_profit = [];
$forecast_months = [];

/* use current average profit per egg */
$avg_price_per_egg = $total_eggs_sold = ($total_big_sold * $big_tray_eggs) + ($total_small_sold * $small_tray_eggs);

$avg_price_per_egg = $total_eggs_sold > 0 ? ($total_profit / $total_eggs_sold) : 0;

for($i=1;$i<=3;$i++){
    $forecast_months[] = date('M Y', strtotime("+$i month"));

    $forecast_big[] = $avg_big;
    $forecast_small[] = $avg_small;

    // forecast profit based on real system profit ratio
    $forecast_profit[] =
        (($avg_big + $avg_small) * $avg_price_per_egg);
}

/* STOCK ALERTS */
$stock_alerts = [];
$low_threshold = 5;

if($big_remaining <= $low_threshold)
    $stock_alerts[] = "⚠ Low Big Trays Stock: Only $big_remaining left!";

if($small_remaining <= $low_threshold)
    $stock_alerts[] = "⚠ Low Small Trays Stock: Only $small_remaining left!";
?>
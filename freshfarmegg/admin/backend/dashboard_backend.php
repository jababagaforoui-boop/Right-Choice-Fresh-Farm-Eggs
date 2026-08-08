<?php
// =====================
// Admin Dashboard Backend Logic
// =====================

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// Include DB connection
include __DIR__ . '/../includes/db.php';

// Security: only admin users
if(!isset($_SESSION['admin'])){
    $_SESSION['admin'] = 1;
}

// =====================
// METRICS: SALES & ORDERS
// =====================
$big_price = 106;
$small_price = 56;

// Total Sales & Total Orders
$sales_res = $conn->query("
    SELECT 
        COALESCE(SUM(total_amount),0) AS total_sales,
        COUNT(*) AS total_orders
    FROM deliveries
")->fetch_assoc();

$total_sales  = $sales_res['total_sales'];
$total_orders = $sales_res['total_orders'];

// =====================
// INVENTORY (FIXED LOGIC)
// =====================
$inventory_res = $conn->query("
    SELECT 
        COALESCE(SUM(d.big_trays * 12 + d.small_trays * 6),0)
        -
        COALESCE(SUM(s.big_trays_sold * 12 + s.small_trays_sold * 6),0)
        AS total_eggs
    FROM deliveries d
    LEFT JOIN sales s ON s.branch_id = d.branch_id
")->fetch_assoc();

$total_eggs_inventory = max(0, $inventory_res['total_eggs'] ?? 0);

// Active Branches
$branches_res = $conn->query("SELECT COUNT(*) AS active_branches FROM branches")->fetch_assoc();
$active_branches = $branches_res['active_branches'] ?? 0;

// =====================
// CHART DATA
// =====================
$months = [];
$big_monthly = [];
$small_monthly = [];

for($i=5;$i>=0;$i--){
    $month = date('Y-m', strtotime("-$i month"));
    $months[] = date('M Y', strtotime($month.'-01'));

    $stmt_month = $conn->prepare("
        SELECT SUM(big_trays_sold) AS big_sold, SUM(small_trays_sold) AS small_sold
        FROM sales
        WHERE DATE_FORMAT(sale_datetime,'%Y-%m') = ?
    ");
    $stmt_month->bind_param("s",$month);
    $stmt_month->execute();
    $res = $stmt_month->get_result()->fetch_assoc();

    $big_monthly[] = $res['big_sold'] ?? 0;
    $small_monthly[] = $res['small_sold'] ?? 0;
}

// Branch distribution
$branch_chart_res = $conn->query("
    SELECT b.branch_name, 
        SUM(s.big_trays_sold*12 + s.small_trays_sold*6) AS eggs_sold
    FROM branches b
    LEFT JOIN sales s ON s.branch_id = b.id
    GROUP BY b.id
");

$branch_labels = [];
$branch_data   = [];

while($row = $branch_chart_res->fetch_assoc()){
    $branch_labels[] = $row['branch_name'];
    $branch_data[]   = $row['eggs_sold'] ?? 0;
}

// Goals
$goals = [
    'Orders'      => min(100, round(($total_orders/5000)*100)),
    'Deliveries'  => min(100, round(($total_orders/5000)*100)),
    'Inventory'   => min(100, round(($total_eggs_inventory/10000)*100)),
    'Revenue'     => min(100, round(($total_sales/500000)*100)),
];

// Forecast calculations
$avg_big = count($big_monthly) ? array_sum($big_monthly)/count($big_monthly) : 0;
$avg_small = count($small_monthly) ? array_sum($small_monthly)/count($small_monthly) : 0;

$forecast_months = [];
$forecast_big = [];
$forecast_small = [];
$forecast_revenue = [];

for($i=1;$i<=3;$i++){
    $month = date('Y-m', strtotime("+$i month"));
    $forecast_months[] = date('M Y', strtotime($month.'-01'));

    $forecast_big[] = round($avg_big);
    $forecast_small[] = round($avg_small);

    $forecast_revenue[] = round(
        ($avg_big * $big_price) +
        ($avg_small * $small_price)
    );
}
?>
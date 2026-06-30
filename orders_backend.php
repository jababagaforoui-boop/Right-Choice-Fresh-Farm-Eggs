<?php
session_start();

/* ----------------------
   DATABASE CONNECTION
----------------------- */
$servername = "localhost";
$username   = "root";
$password   = ""; 
$dbname     = "freshfarmegg";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

/* ----------------------
   SECURITY CHECK
----------------------- */
if(!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'client'){
    header("Location: login.php"); 
    exit();
}

$user = $_SESSION['user'];
$branch_id   = $user['branch_id'];
$branch_name = $user['branch_name'];

/* ----------------------
   PRICES
----------------------- */
$price_big_tray   = 106;
$price_small_tray = 56;

/* ----------------------
   HANDLE SALES AND UPDATE STOCK
----------------------- */
$success_sale = '';
$stock_alerts = [];

if(isset($_POST['add_sale'])){

    $big_trays_sold   = (int)$_POST['big_trays_sold'];
    $small_trays_sold = (int)$_POST['small_trays_sold'];

    $custom_big_price = (!empty($_POST['big_price']))
    ? (float)$_POST['big_price']
    : $price_big_tray;

$custom_small_price = (!empty($_POST['small_price']))
    ? (float)$_POST['small_price']
    : $price_small_tray;

    /* GET INVENTORY */
    $stmt = $conn->prepare("SELECT big_trays, small_trays FROM inventory WHERE branch_id=? LIMIT 1");
    $stmt->bind_param("i",$branch_id);
    $stmt->execute();
    $inventory = $stmt->get_result()->fetch_assoc();

    $current_big   = $inventory['big_trays'] ?? 0;
    $current_small = $inventory['small_trays'] ?? 0;

    $new_big   = max(0, $current_big - $big_trays_sold);
    $new_small = max(0, $current_small - $small_trays_sold);

    /* UPDATE INVENTORY */
    $stmt_update = $conn->prepare("
        UPDATE inventory 
        SET big_trays=?, small_trays=?, updated_at=NOW() 
        WHERE branch_id=?
    ");
    $stmt_update->bind_param("iii",$new_big,$new_small,$branch_id);
    $stmt_update->execute();

    /* =========================
       FIXED SALES INSERT
    ========================= */

   $total_amount =
    ($big_trays_sold * $custom_big_price) +
    ($small_trays_sold * $custom_small_price);

    $stmt_sale = $conn->prepare("
        INSERT INTO sales(
            branch_id,
            big_trays_sold,
            small_trays_sold,
            big_price,
            small_price,
            total_amount,
            sale_datetime
        ) VALUES(?,?,?,?,?, ?, NOW())
    ");

    $stmt_sale->bind_param(
    "iiiddd",
    $branch_id,
    $big_trays_sold,
    $small_trays_sold,
    $custom_big_price,
    $custom_small_price,
    $total_amount
);

$stmt_sale->execute();

    $success_sale = "✅ Sale recorded successfully!";

    $low_threshold = 5;
    if($new_big <= $low_threshold) $stock_alerts[] = "⚠ Low Big Trays Stock: Only $new_big left!";
    if($new_small <= $low_threshold) $stock_alerts[] = "⚠ Low Small Trays Stock: Only $new_small left!";
}

/* ----------------------
   REQUEST TO ADMIN
----------------------- */
$success_request = '';
$error_request = '';

if(isset($_POST['request_admin'])){
    $request_big   = (int)$_POST['request_big_trays'];
    $request_small = (int)$_POST['request_small_trays'];
    $message       = trim($_POST['message']);

    if($request_big < 0 || $request_small < 0 || empty($message)){
        $error_request = "⚠ Please fill all fields correctly.";
    } else {
        $stmt_req = $conn->prepare("
            INSERT INTO requests(branch_id, big_trays, small_trays, message, status, request_datetime)
            VALUES (?,?,?,?, 'pending', NOW())
        ");
        $stmt_req->bind_param("iiis", $branch_id, $request_big, $request_small, $message);
        $stmt_req->execute();
        $success_request = "📨 Request sent successfully!";
    }
}

/* ----------------------
   FETCH SALES
----------------------- */
$stmt = $conn->prepare("SELECT * FROM sales WHERE branch_id=? ORDER BY sale_datetime DESC");
$stmt->bind_param("i",$branch_id);
$stmt->execute();
$sales = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/* ----------------------
   CALCULATE TOTALS (FIXED)
----------------------- */
$total_big_trays = 0;
$total_small_trays = 0;
$total_income = 0;

if(!empty($sales)){
    foreach($sales as $s){

        $big   = (int)$s['big_trays_sold'];
        $small = (int)$s['small_trays_sold'];

        $bp = $s['big_price'] ?? $price_big_tray;
        $sp = $s['small_price'] ?? $price_small_tray;

        $total_big_trays += $big;
        $total_small_trays += $small;

        $total_income += ($big * $bp) + ($small * $sp);
    }
}

/* EGGS */
$total_eggs = ($total_big_trays * 12) + ($total_small_trays * 6);

/* ----------------------
   ADMIN REPLIES
----------------------- */
$stmt_reply = $conn->prepare("
    SELECT * FROM requests 
    WHERE branch_id=? AND admin_reply IS NOT NULL 
    ORDER BY request_datetime DESC
");
$stmt_reply->bind_param("i", $branch_id);
$stmt_reply->execute();
$admin_replies = $stmt_reply->get_result()->fetch_all(MYSQLI_ASSOC);

if(!isset($_SESSION['shown_replies'])) $_SESSION['shown_replies'] = [];
?>
<?php
session_start();
include __DIR__ . '/../includes/db.php';

// ===== SECURITY CHECK =====
if(!isset($_SESSION['admin'])){
    $_SESSION['admin'] = 1; // or redirect to login
}

// ===== SETTINGS =====
$month = date('Y-m');

// ===== FETCH OR INITIALIZE STOCK =====
$stock_query = $conn->query("SELECT * FROM stocks WHERE month='$month' LIMIT 1");
if($stock_query->num_rows === 0){
    $conn->query("INSERT INTO stocks (month, big_trays, small_trays) VALUES ('$month', 200, 200)");
    $stock_query = $conn->query("SELECT * FROM stocks WHERE month='$month' LIMIT 1");
}
$stock = $stock_query->fetch_assoc();

// ===== HANDLE ADDING BIG / SMALL TRAYS =====
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $add_big = intval($_POST['add_big_trays'] ?? 0);
    $add_small = intval($_POST['add_small_trays'] ?? 0);

    if($add_big > 0 || $add_small > 0){
        $stmt_update = $conn->prepare("UPDATE stocks SET big_trays = big_trays + ?, small_trays = small_trays + ? WHERE month = ?");
        $stmt_update->bind_param("iis", $add_big, $add_small, $month);
        $stmt_update->execute();
    }
    header("Location: stocks.php");
    exit();
}

// ===== CALCULATE TOTAL EGGS =====
$big_trays = intval($stock['big_trays']);
$small_trays = intval($stock['small_trays']);
$total_big_eggs = $big_trays * 12;
$total_small_eggs = $small_trays * 6;
$total_eggs = $total_big_eggs + $total_small_eggs;
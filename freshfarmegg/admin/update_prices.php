<?php
session_start();
include __DIR__ . '/../includes/db.php';

// SECURITY CHECK
if(!isset($_SESSION['admin'])){
    die("Access denied");
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $egg = $_POST['egg_price'];
    $big = $_POST['big_price'];
    $small = $_POST['small_price'];

    $sql = "UPDATE settings SET 
            egg_price = '$egg',
            big_tray_price = '$big',
            small_tray_price = '$small'
            WHERE id = 1";

    if($conn->query($sql)){
        header("Location: sales.php?updated=1");
        exit();
    } else {
        echo "Error updating prices: " . $conn->error;
    }
}
?>
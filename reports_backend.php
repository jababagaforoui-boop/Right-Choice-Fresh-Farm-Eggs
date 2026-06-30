<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include __DIR__ . '/../includes/db.php';

/* =========================
   HANDLE REPLY
========================= */
if(isset($_POST['reply_request'])){
    $request_id = (int)$_POST['request_id'];
    $reply_msg  = trim($_POST['reply_msg']);
    $status     = $_POST['status'];

    if(!empty($reply_msg) && in_array($status, ['confirmed','rejected'])){
        $stmt = $conn->prepare("UPDATE requests SET admin_reply=?, status=? WHERE id=?");
        $stmt->bind_param("ssi", $reply_msg, $status, $request_id);
        $stmt->execute();
        $success_reply = "Reply sent successfully!";
    } else {
        $error_reply = "Please fill all fields.";
    }
}

/* =========================
   DELETE REQUEST
========================= */
if (isset($_GET['delete_request'])) {

    $delete_id = (int)$_GET['delete_request'];

    $stmt = $conn->prepare("DELETE FROM requests WHERE id=?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);

   if($stmt->execute()){
        $success = "Record deleted successfully!";
    } else {
        $error = "Failed to delete record!";
    }

    $stmt->close();

}

/* =========================
   DELETE RETURN
========================= */
if (isset($_GET['delete_return'])) {

    $delete_id = (int)$_GET['delete_return'];

    $stmt = $conn->prepare("DELETE FROM returns WHERE id=?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $delete_id);

    if (!$stmt->execute()) {
        die("Delete failed: " . $stmt->error);
    }

    $stmt->close();

   
}

/* =========================
   FETCH REQUESTS
========================= */
$requests = [];

$sql = "
    SELECT r.*, b.branch_name
    FROM requests r
    JOIN branches b ON r.branch_id = b.id
    ORDER BY r.request_datetime DESC
";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

/* =========================
   COUNTS
========================= */
$pending_count = 0;
$confirmed_count = 0;
$rejected_count = 0;

foreach ($requests as $r) {
    if ($r['status'] === 'pending') $pending_count++;
    if ($r['status'] === 'confirmed') $confirmed_count++;
    if ($r['status'] === 'rejected') $rejected_count++;
}

/* =========================
   FETCH RETURNS
========================= */
$returns = [];

$sql = "
    SELECT ret.*, b.branch_name
    FROM returns ret
    JOIN branches b ON ret.branch_id = b.id
    ORDER BY ret.return_datetime DESC
";

$result = $conn->query($sql);

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $returns[] = $row;
    }
}
?>
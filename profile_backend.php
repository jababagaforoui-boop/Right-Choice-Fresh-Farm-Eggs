<?php
// =====================
// Profile Backend Logic
// =====================

if(session_status() === PHP_SESSION_NONE){
    session_start();
}

include __DIR__ . '/../includes/db.php';

/* SECURITY CHECK */
if(!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'client'){
    header("Location: ../index.php");
    exit();
}

$user = $_SESSION['user'];
$user_id = $user['id'] ?? null;

$success_msg = '';
$error_msg = '';

/* ================= UPDATE PROFILE ================= */
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])){

    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $contact  = trim($_POST['contact'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');

    if(empty($username)){
        $error_msg = "Username cannot be empty.";
    }
    elseif(!empty($password) && $password !== $confirm){
        $error_msg = "Passwords do not match.";
    }
    else {

        $photo_path = $user['photo'] ?? null;

        /* UPLOAD PHOTO */
        if(!empty($_FILES['photo']['name'])){
            $upload_dir = __DIR__ . '/../uploads/';

            if(!is_dir($upload_dir)){
                mkdir($upload_dir, 0755, true);
            }

            $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
            $new_name = 'user_'.$user_id.'_'.time().'.'.$ext;
            $target_file = $upload_dir.$new_name;

            if(move_uploaded_file($_FILES['photo']['tmp_name'], $target_file)){
                $photo_path = 'uploads/'.$new_name;
            } else {
                $error_msg = "Failed to upload photo.";
            }
        }

        /* UPDATE DATABASE */
        if(!$error_msg && $user_id){

            if(!empty($password)){
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("
                    UPDATE user 
                    SET username=?, fullname=?, email=?, contact=?, password=?, photo=? 
                    WHERE id=?
                ");
                $stmt->bind_param("ssssssi",
                    $username, $fullname, $email, $contact, $hash, $photo_path, $user_id
                );

            } else {
                $stmt = $conn->prepare("
                    UPDATE user 
                    SET username=?, fullname=?, email=?, contact=?, photo=? 
                    WHERE id=?
                ");
                $stmt->bind_param("sssssi",
                    $username, $fullname, $email, $contact, $photo_path, $user_id
                );
            }

            if($stmt->execute()){
                $success_msg = "Profile updated successfully!";

                $_SESSION['user']['username'] = $username;
                $_SESSION['user']['fullname']  = $fullname;
                $_SESSION['user']['email']     = $email;
                $_SESSION['user']['contact']   = $contact;
                $_SESSION['user']['photo']     = $photo_path;

                $user = $_SESSION['user'];
            } else {
                $error_msg = "Update failed: " . $conn->error;
            }
        }
    }
}
?>
<?php
session_start();

// Example logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {

        if ($_POST['action'] === 'login') {
            // Example login logic
            $_SESSION['user'] = "sample_user";

            // Redirect to dashboard
            header("Location: client/dashboard.php");
            exit();
        }
    }
}
?>
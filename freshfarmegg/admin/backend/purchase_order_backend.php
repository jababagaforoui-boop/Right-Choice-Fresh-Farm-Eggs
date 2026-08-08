<?php

/* =========================================================
   AUTO ADMIN LOGIN
========================================================= */

if (!isset($_SESSION['user'])) {

    $_SESSION['user'] = [
        "role" => "admin",
        "name" => "Administrator"
    ];

}


/* =========================================================
   FETCH BRANCHES
========================================================= */

$branches_list = [];


$result_branches = $conn->query("
    SELECT id, branch_name
    FROM branches
    ORDER BY branch_name ASC
");


if ($result_branches) {

    while ($row = $result_branches->fetch_assoc()) {

        $branches_list[$row['id']] = $row['branch_name'];

    }

}


/* =========================================================
   VARIABLES
========================================================= */

$success = "";

$error = "";

$receipt = null;


/* =========================================================
   DELETE DELIVERY
========================================================= */

if (isset($_GET['delete'])) {

    $delete_id = (int)$_GET['delete'];


    if ($delete_id > 0) {

        $stmt = $conn->prepare("
            DELETE FROM deliveries
            WHERE id = ?
        ");


        if ($stmt) {

            $stmt->bind_param(
                "i",
                $delete_id
            );


            if ($stmt->execute()) {

                $success = "Record deleted successfully!";

            } else {

                $error = "Failed to delete record!";

            }


            $stmt->close();

        } else {

            $error = "Failed to prepare delete query!";

        }

    } else {

        $error = "Invalid record ID!";

    }

}


/* =========================================================
   HISTORY
========================================================= */

$deliveries_history = [];


$result = $conn->query("
    SELECT
        d.id,
        d.big_trays,
        d.small_trays,
        d.delivery_datetime,
        b.branch_name
    FROM deliveries d
    JOIN branches b
        ON d.branch_id = b.id
    ORDER BY d.id DESC
");


if ($result) {

    while ($row = $result->fetch_assoc()) {

        $row['total_eggs'] =
            ((int)$row['big_trays'] * 12) +
            ((int)$row['small_trays'] * 6);

        $deliveries_history[] = $row;

    }

}

?>
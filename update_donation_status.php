<?php
require_once "configure.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['donationId']) && isset($_POST['status'])) {
        $donationId = $_POST['donationId'];
        $status = $_POST['status'];

        // Update the donation status in the database
        $updateSql = "UPDATE donate_blood SET status = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $updateSql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $status, $donationId);
            if (mysqli_stmt_execute($stmt)) {
                echo "Success"; // Return a success message
            } else {
                // Error updating the donation status
                echo "Error updating donation status: " . mysqli_error($conn);
            }

            mysqli_stmt_close($stmt);
        } else {
            // Error preparing the SQL statement
            echo "Error preparing SQL statement: " . mysqli_error($conn);
        }
    } else {
        // Missing donationId or status in the POST data
        echo "Invalid POST data";
    }
} else {
    // Invalid request method
    echo "Invalid request method";
}

mysqli_close($conn);
?>

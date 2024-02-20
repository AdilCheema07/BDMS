<!-- This Scipt changes the status of donation in the donate_blood table from approved to either fulfilled or cancelled depending upon the function which is called in the Fulfill.js page -->

<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit; // Terminate the script if the user is not logged in
}

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
                // If the status is "approved," update the blood_quantity in the blood table
                if ($status === "fulfilled") {
                    $selectSql = "SELECT blood_group, blood_quantity FROM donate_blood WHERE id = ?";
                    $selectStmt = mysqli_prepare($conn, $selectSql);
                    mysqli_stmt_bind_param($selectStmt, "i", $donationId);
                    if (mysqli_stmt_execute($selectStmt)) {
                        mysqli_stmt_store_result($selectStmt);
                        mysqli_stmt_bind_result($selectStmt, $bloodGroup, $bloodQuantity);
                        mysqli_stmt_fetch($selectStmt);

                        // Update the blood_quantity in the blood table
                        $updateBloodSql = "UPDATE blood SET blood_quantity = blood_quantity + ? WHERE blood_group = ?";
                        $updateBloodStmt = mysqli_prepare($conn, $updateBloodSql);
                        mysqli_stmt_bind_param($updateBloodStmt, "is", $bloodQuantity, $bloodGroup);
                        if (mysqli_stmt_execute($updateBloodStmt)) {
                            echo "Success"; // Return a success message
                        } else {
                            echo "Error updating blood quantity: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($updateBloodStmt);
                    } else {
                        echo "Error fetching blood donation information: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($selectStmt);
                } else {
                    echo "Success"; // Return a success message
                }
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
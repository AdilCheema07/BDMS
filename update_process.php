<!-- This Script handles the update process of Donor or Seeker Information in the donors or seekers table by receiving the new updated information from the update user page  -->

<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit();
}

// Include your configuration file
require_once "configure.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST["id"];
    $source = $_POST["source"]; // Retrieve the source parameter

    // Determine the table name and fields based on the source
    $tableName = '';
    $fieldsToUpdate = '';

    if ($source === 'donors') {
        $tableName = 'donors';
        // Add fields for donors (e.g., "username = ?, email = ?, mobile = ?, age = ?, gender = ?, address = ?, blood_group = ?")
        $fieldsToUpdate = "username = ?, email = ?, mobile = ?, age = ?, gender = ?, address = ?, blood_group = ?";
    } else {
        $tableName = 'seekers';
        // Add fields for seekers (e.g., "username = ?, email = ?, mobile = ?, gender = ?, address = ?")
        $fieldsToUpdate = "username = ?, email = ?, mobile = ?, gender = ?, address = ?";
    }

    // Build your update query based on the table name and fields
    $updateQuery = "UPDATE $tableName SET $fieldsToUpdate WHERE id = ?";

    $stmt = mysqli_prepare($conn, $updateQuery);

    if ($stmt) {
        // Bind parameters based on the source
        if ($source === 'donors') {
            mysqli_stmt_bind_param($stmt, "sssssssi", $_POST['username'], $_POST['email'], $_POST['mobile'], $_POST['age'], $_POST['gender'], $_POST['address'], $_POST['blood_group'], $id);
        } else {
            mysqli_stmt_bind_param($stmt, "sssssi", $_POST['username'], $_POST['email'], $_POST['mobile'], $_POST['gender'], $_POST['address'], $id);
        }

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);

            // Redirect the user to a success page or back to the appropriate management page
            if ($source === 'donors') {
                header("location: Manage_donors.php");
            } else {
                header("location: Manage_seekers.php");
            }
            exit();
        } else {
            echo "Error updating user data: " . mysqli_error($conn);
        }
    } else {
        echo "Error in prepared statement: " . mysqli_error($conn);
    }
} else {
    // Handle the case where the form was not submitted via POST
    echo "Invalid request.";
}
mysqli_close($conn);
?>
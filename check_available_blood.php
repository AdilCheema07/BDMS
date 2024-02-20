<?php
require_once "configure.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bloodGroup = $_POST["bloodGroup"];

    // Fetch the available blood quantity for the requested blood group
    $query = "SELECT blood_quantity FROM blood WHERE blood_group = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $bloodGroup);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_bind_result($stmt, $availableQuantity);

            if (mysqli_stmt_fetch($stmt)) {
                echo $availableQuantity;
            } else {
                echo "Blood group not found";
            }
        } else {
            echo "Error executing the query.";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing the statement.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
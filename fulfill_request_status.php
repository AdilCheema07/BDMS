<!-- This Scipt changes the status of request in the request_blood table from approved to either fulfilled or cancelled depending upon the function which is called in the Fulfill.js page -->

<?php
require_once "configure.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestId = $_POST["requestId"];
    $status = $_POST["status"];

    // Get the requested blood quantity and blood group from the request_blood table
    $selectSql = "SELECT blood_group, blood_quantity FROM request_blood WHERE id = ?";
    $selectStmt = mysqli_prepare($conn, $selectSql);
    mysqli_stmt_bind_param($selectStmt, "i", $requestId);

    if (mysqli_stmt_execute($selectStmt)) {
        mysqli_stmt_store_result($selectStmt);
        mysqli_stmt_bind_result($selectStmt, $bloodGroup, $requestedQuantity);
        mysqli_stmt_fetch($selectStmt);

        // Get the available blood quantity from the blood table for the same blood group
        $selectBloodSql = "SELECT blood_quantity FROM blood WHERE blood_group = ?";
        $selectBloodStmt = mysqli_prepare($conn, $selectBloodSql);
        mysqli_stmt_bind_param($selectBloodStmt, "s", $bloodGroup);

        if (mysqli_stmt_execute($selectBloodStmt)) {
            mysqli_stmt_store_result($selectBloodStmt);
            mysqli_stmt_bind_result($selectBloodStmt, $availableQuantity);
            mysqli_stmt_fetch($selectBloodStmt);


            // Update the status in the request_blood table
            $updateSql = "UPDATE request_blood SET status = ? WHERE id = ?";
            $updateStmt = mysqli_prepare($conn, $updateSql);

            if ($updateStmt) {
                mysqli_stmt_bind_param($updateStmt, "si", $status, $requestId);

                if (mysqli_stmt_execute($updateStmt)) {
                    // If the status is "approved," update the blood_quantity in the blood table
                    if ($status === "fulfilled") {
                        // Update the blood_quantity in the blood table
                        $updateBloodSql = "UPDATE blood SET blood_quantity = blood_quantity - ? WHERE blood_group = ?";
                        $updateBloodStmt = mysqli_prepare($conn, $updateBloodSql);
                        mysqli_stmt_bind_param($updateBloodStmt, "is", $requestedQuantity, $bloodGroup);

                        if (mysqli_stmt_execute($updateBloodStmt)) {
                            echo "Success"; // Return a success message
                        } else {
                            echo "Error updating blood quantity: " . mysqli_error($conn);
                        }
                        mysqli_stmt_close($updateBloodStmt);
                    } else {
                        echo "Success";
                    }
                } else {
                    echo "Error executing the update query.";
                }
                mysqli_stmt_close($updateStmt);
            } else {
                echo "Error preparing the update statement.";
            }

        } else {
            echo "Error fetching available blood quantity: " . mysqli_error($conn);
        }
        mysqli_stmt_close($selectBloodStmt);
    } else {
        echo "Error fetching request information: " . mysqli_error($conn);
    }
    mysqli_stmt_close($selectStmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
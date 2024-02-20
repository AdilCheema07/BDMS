<?php
require_once "configure.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $requestId = $_POST["requestId"];
    $status = $_POST["status"];

    // Update the status in the request_blood table
    $updateSql = "UPDATE request_blood SET status = ? WHERE id = ?";
    $updateStmt = mysqli_prepare($conn, $updateSql);

    if ($updateStmt) {
        mysqli_stmt_bind_param($updateStmt, "si", $status, $requestId);

        if (mysqli_stmt_execute($updateStmt)) {
            echo "Success"; // Return a success message
        } else {
            echo "Error executing the update query.";
        }
        mysqli_stmt_close($updateStmt);
    } else {
        echo "Error preparing the update statement.";
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
<!-- This script handles the deletion of users when the delete button is pressed in the manage donors or manage seekers page  -->

<?php
// delete_user.php

session_start();
require_once "configure.php";

if (isset($_GET['id']) && isset($_GET['source'])) {
    $userId = $_GET['id'];
    $source = $_GET['source'];

    // Determine the table name based on the source
    $tableName = ($source === 'donors') ? 'donors' : 'seekers';

    // Delete the user's record from the appropriate table
    $sql = "DELETE FROM $tableName WHERE id = $userId";
    mysqli_query($conn, $sql);

    // Redirect back to the referring page
    if ($source === 'donors') {
        header("location: Manage_donors.php");
    } elseif ($source === 'seekers') {
        header("location: Manage_seekers.php");
    }
} else {
    header("location: Main_page.php");
}
?>
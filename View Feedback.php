<!-- This page displays the feedback provided by donors and seekers  -->

<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit; // Terminate the script to prevent further execution
}

require_once "configure.php";

$userRole = $_SESSION['userRole'];

// Query to select all rows from the 'feedback' table
$sql = "SELECT id, username, age, gender, feedback FROM feedback";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Requests</title>
    <!-- Css Links -->
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="Dashboard_form.css">

    <!-- jQuery Link  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- JavaScript File Link  -->
    <script src="Approve_decline.js"></script>
</head>

<body>
    <!-- Navbar 1 -->
    <nav class="nav1">
        <div class="nav-right">
            <span>adcheema85@gmail.com</span>
            <span><i class="vertical-line"></i></span>
            <span>+923486717316</span>
            <button id="btn-logout"><a href="logout.php">Logout <svg fill="#ffffff" height="14px" width="25px"
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M352 96l64 0c17.7 0 32 14.3 32 32l0 256c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0c53 0 96-43 96-96l0-256c0-53-43-96-96-96l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32zm-9.4 182.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L242.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z" />
                    </svg></a></button>
        </div>
    </nav>

    <section id="nav-menu">
        <?php
        if ($userRole === "Donor") {
            include('donor_navbar.php');
        } elseif ($userRole === "Seeker") {
            include('seeker_navbar.php');
        } elseif ($userRole === "Admin") {
            include('Admin_navbar.php');
        }
        ?>

        <div class="dashboard-right">
            <?php
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo '<div style="border: 1px solid #ccc; padding: 10px; margin-bottom: 10px;">';
                    echo "ID: " . $row["id"] . "<br>";
                    echo "Name: " . $row["username"] . "<br>";
                    echo "Age: " . $row["age"] . "<br>";
                    echo "Gender: " . $row["gender"] . "<br>";
                    echo "Feedback: " . $row["feedback"] . "<br><br>";
                    echo "</div>";
                }
            } else {
                echo "No feedback records found.";
            }

            mysqli_close($conn);
            ?>
</body>

</html>
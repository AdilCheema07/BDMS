<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

// Include your configuration file
require_once "configure.php";

$userRole = $_SESSION['userRole'];

$sql = "SELECT * FROM seekers";
$result = mysqli_query($conn, $sql);

// Check if there are any seekers in the table
$hasSeekers = mysqli_num_rows($result) > 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Seekers</title>
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
            <?php if ($hasSeekers): ?>
                <table class="table-users" border="1">
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Update</th>
                        <th>Delete</th>
                    </tr>
                    <?php
                    // Loop through the seeker data and display it in the table
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['mobile'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td><a class='update-button' href='Update_user.php?id=" . $row['id'] . "&source=seekers'>Update</a></td>";
                        echo "<td><a class='delete-button' href='Delete_user.php?id=" . $row['id'] . "&source=seekers'>Delete</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </table>
            <?php else: ?>
                <p>No seekers found.</p>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>
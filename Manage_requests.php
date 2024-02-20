<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

// Include your configuration file
require_once "configure.php";

$userRole = $_SESSION['userRole'];

// Fetch data from the donate_blood table
$sql = "SELECT id, username, age, gender, blood_quantity, blood_group, request_type, sent_at, status ,datetime FROM donate_blood WHERE status = 'pending'";


// Prepare the SQL statement
$stmt_donate = mysqli_prepare($conn, $sql);

if ($stmt_donate) {
    // Execute the query
    mysqli_stmt_execute($stmt_donate);

    // Get the result set
    $result_donate = mysqli_stmt_get_result($stmt_donate);

    // Create an array to store the fetched data
    $donations = [];

    // Check if there are rows in the result set
    if (mysqli_num_rows($result_donate) > 0) {
        while ($row = mysqli_fetch_assoc($result_donate)) {
            $donations[] = $row;
        }
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt_donate);
} else {
    // Handle the SQL statement preparation error
    echo "Error preparing SQL statement for donate_blood: " . mysqli_error($conn);
}

// Fetch data from the request_blood table
$sql = "SELECT id, username, age, gender, blood_quantity, blood_group, reason, request_type, sent_at, status ,datetime FROM request_blood WHERE status = 'pending'";

// Prepare the SQL statement
$stmt_request = mysqli_prepare($conn, $sql);

if ($stmt_request) {
    // Execute the query
    mysqli_stmt_execute($stmt_request);

    // Get the result set
    $result_request = mysqli_stmt_get_result($stmt_request);

    // Create an array to store the fetched data
    $requests = [];

    // Check if there are rows in the result set
    if (mysqli_num_rows($result_request) > 0) {
        while ($row = mysqli_fetch_assoc($result_request)) {
            $requests[] = $row;
        }
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt_request);
} else {
    // Handle the SQL statement preparation error
    echo "Error preparing SQL statement for request_blood: " . mysqli_error($conn);
}

// Close the database connection
mysqli_close($conn);
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
            <?php if (!empty($donations) || !empty($requests)) { ?>
                <table class="table" border="1">
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Blood Group</th>
                        <th>Quantity</th>
                        <th>Request Type</th>
                        <th>Date & Time of Arrival</th>
                        <th>Approve</th>
                        <th>Decline</th>

                    </tr>

                    <?php
                    // Loop through the $donations array and display data in table rows
                    foreach ($donations as $donation) {
                        echo "<tr>";
                        echo "<td>" . $donation['username'] . "</td>";
                        echo "<td>" . $donation['gender'] . "</td>";
                        echo "<td>" . $donation['blood_group'] . "</td>";
                        echo "<td>" . $donation['blood_quantity'] . "</td>";
                        echo "<td>" . $donation['request_type'] . "</td>";
                        echo "<td>" . $donation['datetime'] . "</td>";
                        echo '<td><button class="btn_approve" onclick="approveDonation(' . $donation['id'] . ', \'' . $donation['blood_group'] . '\', ' . $donation['blood_quantity'] . ')">Approve</button></td>';
                        echo '<td><button class ="btn_decline" onclick="declineDonation(' . $donation['id'] . ')">Decline</button></td>';
                        echo "</tr>";

                    }
                    ?>

                    <?php
                    // Loop through the $requests array and display data in table rows
                    foreach ($requests as $request) {
                        echo "<tr>";
                        echo "<td>" . $request['username'] . "</td>";
                        echo "<td>" . $request['gender'] . "</td>";
                        echo "<td>" . $request['blood_group'] . "</td>";
                        echo "<td>" . $request['blood_quantity'] . "</td>";
                        echo "<td>" . $request['request_type'] . "</td>";
                        echo "<td>" . $request['datetime'] . "</td>";
                        echo '<td><button class="btn_approve" onclick="approveRequest(' . $request['id'] . ', \'' . $request['blood_group'] . '\', ' . $request['blood_quantity'] . ')">Approve</button></td>';
                        echo '<td><button class ="btn_decline" onclick="declineRequest(' . $request['id'] . ')">Decline</button></td>';
                        echo "</tr>";

                    }
                    ?>
                </table>
            <?php } else { ?>
                <p>No requests found.</p>
            <?php } ?>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
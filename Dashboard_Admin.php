<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

// Include your configuration file
require_once "configure.php";

// Initialize variables for each blood type
$A_plus = $B_plus = $AB_plus = $O_plus = $A_minus = $B_minus = $AB_minus = $O_minus = null;

// SQL query to retrieve blood quantities for each type
$sql = "SELECT blood_group, blood_quantity FROM blood WHERE id BETWEEN 1 AND 8";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    // Loop through the results and assign quantities to the variables
    while ($row = mysqli_fetch_assoc($result)) {
        $blood_group = $row['blood_group'];
        $blood_quantity = $row['blood_quantity'];

        // Assign quantities to the corresponding variables based on blood group
        switch ($blood_group) {
            case 'A+':
                $A_plus = $blood_quantity;
                break;
            case 'B+':
                $B_plus = $blood_quantity;
                break;
            case 'AB+':
                $AB_plus = $blood_quantity;
                break;
            case 'O+':
                $O_plus = $blood_quantity;
                break;
            case 'A-':
                $A_minus = $blood_quantity;
                break;
            case 'B-':
                $B_minus = $blood_quantity;
                break;
            case 'AB-':
                $AB_minus = $blood_quantity;
                break;
            case 'O-':
                $O_minus = $blood_quantity;
                break;
        }
    }

    // Close the result set
    mysqli_free_result($result);
} else {
    // Handle the SQL query error
    echo "Error executing SQL query: " . mysqli_error($conn);
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
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="Dashboard.css">

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
        include('Admin_navbar.php');
        ?>
        <div class="dashboard-right">

            <h1>
                Welcome to Your Dashboard Admin
            </h1>
            <br>
            <div class="blood_quantities">
                <div class="blood-type">
                    <h4>AB+</h4>
                    <p>
                        <?php echo $AB_plus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>AB-</h4>
                    <p>
                        <?php echo $AB_minus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>A+</h4>
                    <p>
                        <?php echo $A_plus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>A-</h4>
                    <p>
                        <?php echo $A_minus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>B+</h4>
                    <p>
                        <?php echo $B_plus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>B-</h4>
                    <p>
                        <?php echo $B_minus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>O+</h4>
                    <p>
                        <?php echo $O_plus; ?>
                    </p>
                </div>
                <div class="blood-type">
                    <h4>O-</h4>
                    <p>
                        <?php echo $O_minus; ?>
                    </p>
                </div>
            </div>

        </div>
    </section>

</body>

</html>
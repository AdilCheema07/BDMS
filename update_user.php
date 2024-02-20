<!-- This Script displays a form when update button is pressed in the manage donors or manage seekers page and the previous information is displayed in that form which can be changed or updated by the Admin  -->

<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

// Include your configuration file
require_once "configure.php";

$userRole = $_SESSION['userRole'];
$error = 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $source = $_GET['source']; // Added source parameter to differentiate between donors and seekers

    // Determine the table name based on the source
    $tableName = ($source === 'donors') ? 'donors' : 'seekers';

    // Query to retrieve user data
    $sql = "SELECT * FROM $tableName WHERE id = $id";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $userData = mysqli_fetch_assoc($result);
    } else {
        // Handle the case where the user with the given ID does not exist
        echo "User not found.";
        $error = 1;
        exit();
    }
} else {
    // Handle the case where 'id' is not set in the URL
    echo "User ID not provided.";
    $error = 1;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Users</title>
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
            <!-- Display a form with fields populated with user data -->
            <form action="update_process.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
                <input type="hidden" name="source" value="<?php echo $source; ?>">
                <!-- Pass the source to the processing page -->

                <label for="username">Username:</label>
                <br>
                <input type="text" name="username" id="username" class="form-box2 input-box"
                    value="<?php echo $userData['username']; ?>"><br>

                <label for="email">Email:</label>
                <br>
                <input type="email" name="email" id="email" class="form-box2 input-box"
                    value="<?php echo $userData['email']; ?>"><br>

                <label for="mobile">Mobile:</label>
                <br>
                <input type="text" name="mobile" id="mobile" class="form-box2 input-box"
                    value="<?php echo $userData['mobile']; ?>"><br>

                <label for="gender">Gender:</label>
                <br>
                <input type="text" name="gender" id="gender" class="form-box2 input-box"
                    value="<?php echo $userData['gender']; ?>"><br>

                <label for="address">Address:</label>
                <br>
                <input type="text" name="address" id="address" class="form-box2 input-box"
                    value="<?php echo $userData['address']; ?>"><br>

                <?php if ($source === 'donors'): ?>
                    <label for="age">Age:</label>
                    <br>
                    <input type="text" name="age" id="age" class="form-box2 input-box"
                        value="<?php echo $userData['age']; ?>"><br>

                    <label for="blood_group">Blood Group:</label>
                    <br>
                    <input type="text" name="blood_group" id="blood_group" class="form-box2 input-box"
                        value="<?php echo $userData['blood_group']; ?>"><br>
                <?php endif; ?>

                <input type="submit" class="update-button" value="Update">
            </form>
        </div>
</body>

</html>
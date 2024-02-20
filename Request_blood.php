<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

require_once "configure.php";

$blood_group = $blood_quantity = $reason = "";
$blood_group_err = $blood_quantity_err = $reason_err = "";
$request_type = "Blood Request";
$userRole = $_SESSION['userRole'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $usertype = $_POST['usertype'];

    // Check if Blood Quantity is empty
    if (empty(trim($_POST["quantity"]))) {
        $blood_quantity_err = "Blood Quantity cannot be blank";
    } else {
        $sql = "SELECT id FROM request_blood WHERE blood_quantity = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_blood_quantity);

            // Set the value of Param Blood Quantity
            $param_blood_quantity = trim($_POST['quantity']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                $blood_quantity = trim($_POST['quantity']);
                mysqli_stmt_close($stmt);
            } else {
                echo "something went wrong";
            }
        }
    }

    // Store Blood Group Value (Do not need to check because the user only has a few options to select from)
    if (isset($_POST['blood_group'])) {
        $blood_group = trim($_POST['blood_group']);
    } else {
        $blood_group_err = "Blood Group is not set";
    }

    if (isset($_POST['reason'])) {
        $reason = trim($_POST['reason']);
    }

    if (isset($_POST['quantity']) && !empty(trim($_POST['quantity']))) {
        $blood_quantity = trim($_POST['quantity']);

        // Check if blood quantity is not negative
        if ($blood_quantity < 0) {
            $blood_quantity_err = "Blood quantity cannot be negative";
            echo "<script>alert('Blood quantity cannot be negative');</script>";
        }
    } else {
        $blood_quantity_err = "Blood quantity number must not be empty";
    }

    // Check Date and Time 
    if (isset($_POST['datetime']) && !empty(trim($_POST['datetime']))) {
        $datetime = trim($_POST['datetime']);
    } else {
        $datetime_err = "Time of arrival for donating blood must be entered";
    }

    // If there are no errors then the name and password are to be inserted/saved in the database    
    if (empty($blood_quantity_err) && empty($datetime_err)) {
        $sql = "INSERT INTO request_blood (username, age, gender, blood_quantity, blood_group, reason, request_type, usertype, status, datetime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $param_username, $param_age, $param_gender, $param_blood_quantity, $param_blood_group, $param_reason, $param_request_type, $param_usertype, $param_datetime);

            // Set these parameters
            $param_username = $username;
            $param_age = $age;
            $param_gender = $gender;
            $param_blood_quantity = $blood_quantity;
            $param_blood_group = $blood_group;
            $param_reason = $reason;
            $param_request_type = $request_type;
            $param_usertype = $usertype;
            $param_datetime = $datetime;

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>alert('Request Submitted');</script>";
            } else {
                echo "Something went wrong, cannot redirect!";
            }
        }
        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Blood</title>
    <link rel="stylesheet" href="Dashboard.css">
    <link rel="stylesheet" href="Dashboard_form.css">

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
        }

        ?>
        <div class="dashboard-right">
            <form action="" method="post">

                <div class="form-box">

                    <!-- Blood Quantity  -->

                    <div class="form-box2">
                        <label for="">Select Quantity<sup class="red">*</sup>:</label>
                        <input name="quantity" type="number" class="input-box" placeholder="Enter Number of units"
                            required="">
                    </div>
                    <br><br>

                    <!-- Blood Group  -->

                    <div class="form-box2">
                        <label for="Blood Group">Select Blood Group<sup class="red">*</sup>: </label>
                        <select name="blood_group" id="blood_group" class="input-box">
                            <option value="A+" selected>A+</option>
                            <option value="A-" selected>A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>


                </div>

                <div class="form-box2">
                    <label for="Date & Time">Enter Your Arrival Time<sup class="red">*</sup>: </label>
                    <input name="datetime" class="input-box" type="datetime-local" required="">

                </div>

                <div class="form-box">

                    <div class="reason">
                        <textarea name="reason" id="" cols="50" rows="8" id="message" class="contact-box " required=""
                            placeholder=" Tell us why you need it and for who... "></textarea>
                    </div>
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <input type="hidden" name="age" value="<?php echo $_SESSION['age']; ?>">
                    <input type="hidden" name="gender" value="<?php echo $_SESSION['gender']; ?>">
                    <input type="hidden" name="usertype" value="<?php echo $_SESSION['usertype']; ?>">

                </div>



                <button type="submit" id="btn-send">Send Request </button>
            </form>
        </div>
    </section>

</body>

</html>
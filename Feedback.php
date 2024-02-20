<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

require_once "configure.php";

$feedback = "";
$reason_err = "";
$userRole = $_SESSION['userRole'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $username = $_POST['username'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];


    // Check if Blood Quantity is empty
    if (empty(trim($_POST["feedback"]))) {
        $blood_quantity_err = "Feedback cannot be blank";
    } else {
        $sql = "SELECT id FROM feedback WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_feedback);

            // Set the value of Param Blood Quantity
            $param_feedback = trim($_POST['feedback']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                $blood_feedback = trim($_POST['feedback']);
                mysqli_stmt_close($stmt);
            } else {
                echo "something went wrong";
            }
        }
    }

    if (isset($_POST['feedback'])) {
        $feedback = trim($_POST['feedback']);
    }


    // If there are no errors then the name and password are to be inserted/saved in the database    
    if (empty($blood_feedback_err)) {
        $sql = "INSERT INTO feedback (username, age, gender, feedback) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_age, $param_gender, $param_feedback);

            // Set these parameters
            $param_username = $username;
            $param_age = $age;
            $param_gender = $gender;
            $param_feedback = $feedback;

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
    <title>Give Feedback</title>
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

                    <div class="feedback">
                        <textarea name="feedback" id="" cols="50" rows="8" id="message" class="contact-box " required=""
                            placeholder=" Give us your valuable feedback "></textarea>
                    </div>
                    <input type="hidden" name="username" value="<?php echo $_SESSION['username']; ?>">
                    <input type="hidden" name="age" value="<?php echo $_SESSION['age']; ?>">
                    <input type="hidden" name="gender" value="<?php echo $_SESSION['gender']; ?>">
                </div>



                <button type="submit" id="btn-send">Submit Feedback </button>
            </form>
        </div>
    </section>

</body>

</html>
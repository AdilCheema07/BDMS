<?php

// This Script will handle Donor Registration
require_once "configure.php";

$username = $email = $mobile = $msg = "";
$username_err = $email_err = $mobile_err = $msg_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Check if Username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM contact_us WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of Param Username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (ctype_digit(trim($_POST['username']))) {
                    $username_err = "Username cannot consist only of digits";
                    echo "<script>alert('Username cannot consist only of digits');</script>";
                } elseif (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo "<script>alert('Username is already taken');</script>";
                } else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);

    // Check Email
    if (empty(trim($_POST['email']))) {
        $email_err = "Email cannot be blank";
        echo "<script>alert('Email cannot be blank');</script>";
    } else {
        $email = trim($_POST['email']);
    }

    // Check Mobile Number 
    if (empty((trim($_POST['mobile'])))) {
        $mobile_err = "Mobile number must not be empty";
        echo "<script>alert('Mobile number must not be empty');</script>";
    } elseif (strlen(trim($_POST['mobile'])) != 11) {
        $mobile_err = "Mobile number must be valid";
        echo "<script>alert('Mobile number must be valid');</script>";
    } else {
        $mobile = trim($_POST['mobile']);
    }

    // Message 
    if (empty(trim($_POST['msg']))) {
        $msg_err = "Message cannot be empty";
        echo "<script>alert('Message must not be empty');</script>";
    } elseif (strlen(trim($_POST['msg'])) < 10) {
        echo "<script>alert('Message is too short to be considered valid');</script>";
    } else {
        $msg = trim($_POST['msg']);
    }

    // If there are no errors then the name and password is to be inserted\saved in database    
    if (empty($username_err) && empty($email_err) && empty($mobile_err)) {
        $sql = "INSERT INTO contact_us (username, email, mobile, msg) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $param_username, $param_email, $param_mobile, $param_msg);

            // Set these parameters
            $param_username = $username;
            $param_email = $email;
            $param_mobile = $mobile;
            $param_msg = $msg;

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: Home_login.html");
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="navbar_footer.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="login_form.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web&display=swap" rel="stylesheet">
</head>

<body>
    <!-- Navbar 1 -->
    <nav class="nav1">
        <div class="nav-right">
            <span>adcheema85@gmail.com</span>
            <span><i class="vertical-line"></i></span>
            <span>+923486717316</span>
        </div>
    </nav>

    <!-- Navbar  2-->
    <nav class="navbar">
        <div class="logo">
            Blood Donation Management System
        </div>
        <div class="nav-items">
            <ul>
                <li><a class="nav-item" href="Home_login.php">Home</a></li>
                <li><a class="nav-item" href="About_us.php">About Us</a></li>
                <li><a class="nav-item" href="Contact_us.php">Contact Us</a></li>
                <li><a class="nav-item" href="Admin_login.php">Admin</a></li>
                <li><a class="nav-item" href="Donor_login.php">Donor</a></li>
                <li><a class="nav-item" href="Seeker_login.php">Seeker</a></li>
            </ul>
        </div>
    </nav>

    <form action="" id="form" method="post">
        <div class="contact-form-left">

        </div>

        <div class="contact-form-right scolor">
            <center>
                <h1>
                    Get In Touch
                </h1>
            </center>
            <br>
            <input name="username" type="text" placeholder="Name" id="name" class="contact-box">
            <br>

            <input name="mobile" type="tel" placeholder="Phone Number" id="phone" class="contact-box">
            <br>

            <input name="email" type="email" placeholder="Email" id="email" class="contact-box">
            <br>

            <textarea name="msg" id="" cols="30" rows="10" placeholder="Enter Your Message" id="message"
                class="contact-box"></textarea>
            <br>

            <button type="submit" class="btn-contact ">Send Message </button>

        </div>

    </form>

    <!-- Footer  -->
    <footer class="footer">
        <div class="footer-content">
            <h1 class=" secondary-headings footer-logo">
                Blood Donation Management System
            </h1><br>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, veritatis?</p><br>
            <h2>Address</h2><br>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero assumenda et dicta sunt, pariatur fuga
                dolorum fugiat ducimus explicabo rerum totam architecto neque, tempore nobis.</p><br>
                <div class="social-icons">
            <i class="fab fa-facebook" id="facebook"></i>
            <i class="fab fa-instagram" id="instagram"></i>
            <i class="fab fa-whatsapp" id="whatsapp"></i>
        </div>
        </div>
        <center>
            <p class="white">
                Copyright &copy; 2023 | Muhammad Adil
            </p>
        </center>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
            crossorigin="anonymous"></script>
</body>

</html>
<?php
// This Script Will Deal With Admin Login 


// Check if user is already logged in
if (isset($_SESSION['username'])) {
    header("location: home_login.php");
    exit;
}

require_once "configure.php";

$username = $password = "";
$username_err = $password_err = "";

// If request method is post

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['username']))) {
        $username_err = "Username should not be empty";
    } elseif (empty(trim($_POST['password']))) {
        $password_err = "Password should not be empty";
    } else {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM admins WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;

        // Try to execute this statement
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) == 1) {
                mysqli_stmt_bind_result($stmt, $id, $username, $hased_password);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hased_password)) {
                        // This means the password is correct. Allow user to login.
                        session_start();
                        $_SESSION["username"] = $username;
                        $_SESSION["id"] = $id;
                        $_SESSION["loggedin"] = true;
                        $_SESSION["userRole"] = "Admin";

                        // Redirect user to Dashboard
                        header("location: Dashboard_Admin.php");
                    }
                }
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="">
    <title>Login/Signup</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- CSS Files -->
    <link rel="stylesheet" href="login_form.css">
    <link rel="stylesheet" href="navbar_footer.css">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-hJArhlqHkWv9g1qIAvRL43LvjkYB23qfDccmIzWThLrN9TFrxcn/dx9QBSI9GY0XdJ3q/RNK6/l7qKDNMCg+mA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    <!-- Login Form  -->
    <section id="container">
        <div class="login-box">
            <center>
                <h3>Admin Login Page</h3>
            </center>
            <hr>

            <form action="" method="post">
                <div class="form-box">
                    <label for="">Name<sup class="red">*</sup>:</label>
                    <input name="username" type="text" class="input-box" placeholder="Enter Your Name" required="">
                    <label for="">Password<sup class="red">*</sup>:</label>
                    <input name="password" type="password" class="input-box" placeholder="Enter Your Password"
                        required="">
                </div>

                <br>
                <button type="submit" class="btn-login ">Login <svg class="icon-btn" fill="#ffffff" height="20px"
                        width="20px" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 512 512"><!--! Font Awesome Pro 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M352 96l64 0c17.7 0 32 14.3 32 32l0 256c0 17.7-14.3 32-32 32l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32l64 0c53 0 96-43 96-96l0-256c0-53-43-96-96-96l-64 0c-17.7 0-32 14.3-32 32s14.3 32 32 32zm-9.4 182.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L242.7 224 32 224c-17.7 0-32 14.3-32 32s14.3 32 32 32l210.7 0-73.4 73.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l128-128z" />
                    </svg>

                </button>
                <br>
        </div>
        </form>
        </div>
    </section>


    <!-- Footer  -->
    <footer class="footer">
        <div class="footer-content">
            <h1 class="scolor secondary-headings footer-logo">
                Blood Donation Management System
            </h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, veritatis?</p>
            <h3>Address</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero assumenda et dicta sunt, pariatur fuga
                dolorum fugiat ducimus explicabo rerum totam architecto neque, tempore nobis.</p>
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
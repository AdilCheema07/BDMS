<?php

// This Script will handle Donor Registration
require_once "configure.php";

$username = $password = "";
$username_err = $password_err =  "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // Check if Username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM admins WHERE username = ?";
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
                }
                elseif (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                    echo "<script>alert('Username is already taken');</script>";
                }
                else {
                    $username = trim($_POST['username']);
                }
            } else {
                echo "something went wrong";
            }
        }
    }
    mysqli_stmt_close($stmt);


    // Check if Password is empty

    if (empty(trim($_POST['password']))) {
        $password_err = "Password cannot be blank";
        echo "<script>alert('Password cannot be blank');</script>";
    } elseif (strlen(trim($_POST['password'])) < 4) {
        $password_err = "Password must be at least 4 characters long";
        echo "<script>alert('Password must be at least 4 characters long');</script>";
    } else {
        $password = trim($_POST['password']);
    }




    // If there are no errors then the name and password is to be inserted\saved in database    
    if (empty($username_err) && empty($password_err)) {
        $sql = "INSERT INTO admins (username, password) VALUES (?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: Admin_login.php");
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
    <link rel="stylesheet" href="">
    <title>Login/Signup</title>
    <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="register_form.css">
        <link rel="stylesheet" href="navbar_footer.css">
        <link rel="stylesheet" href="Home.css">
</head>
<body>
   
    <!-- Navbar  -->
<nav class="navbar">
    <div class="logo">
        Blood Donation Management System
    </div>
    <div class="nav-items">
        <ul >
        <li ><a class="nav-item" href="Home_login.html">Home</a></li>
        <li ><a class="nav-item" href="About_us.php">About Us</a></li>
        <li ><a class="nav-item" href="Contact_us.php">Contact Us</a></li>
        <li ><a class="nav-item" href="Admin_login.php">Admin</a></li>
        <li ><a class="nav-item" href="Donor_login.php">Donor</a></li>
        <li ><a class="nav-item" href="Seeker_login.php">Seeker</a></li>
        </ul>
    </div>
</nav>

    <!-- Login Form  -->
    <section id="container">
        <div class="signup-box">
            <center><h3 >Admin Register Page</h3></center>
            <hr>
            
            <form action="" method="post">
                <div class="form-box">

                    <!-- Name  -->

                <div class="form-box2">
                    <label for="">Name<sup class="red">*</sup>:</label>
                    <input name="username" type="text" class="input-box" placeholder="Enter Your Name" required="">
                </div>

                    <!-- Password  -->    

                <div class="form-box2">
                    <label for="">Password<sup class="red">*</sup>:</label>
                    <input name="password" type="password" class="input-box" placeholder="Enter Your Password" required="">
                </div>
                </div>
                   
    

                <!-- Submit Button -->
                <button type="submit" class="btn-login ">Register</button>
                <br><br>
                <span>Already have an account? </span>
                <span  > <a id="signup"  href="Admin_login.php">Sign in</a></span>
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
        <h3 class="tcolor">Address</h3>
        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero assumenda et dicta sunt, pariatur fuga dolorum fugiat ducimus explicabo rerum totam architecto neque, tempore nobis.</p>
    </div>
        <center>
        <p class="white">
                 Copyright &copy; 2023 | Muhammad Adil
        </p> 
        </center>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>
</html>
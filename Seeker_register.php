<!-- This Script will handle Seeker Registration -->

<?php

require_once "configure.php";

$username = $password = $confirm_password = $email = $cnic = $address = $mobile = $gender = "";
$username_err = $password_err = $confirm_password_err = $email_err = $cnic_err = $address_err = $mobile_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $usertype = $_POST['usertype'];

    // Check if Username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM seekers WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of Param Username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (preg_match('/\d/', $_POST['username'])) {
                    $username_err = "Username cannot contain any digits";
                    echo "<script>alert('Username cannot contain any digits');</script>";
                } else {
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

    // Confirm Password if there is a field for confirming password in your form.
    if (trim($_POST['password']) != trim($_POST['confirm_password'])) {
        $confirm_password_err = "Passwords should match";
        echo "<script>alert('Passwords should match');</script>";
    }

    // Check Email
    if (empty(trim($_POST['email']))) {
        $email_err = "Email cannot be blank";
        echo "<script>alert('Email cannot be blank');</script>";
    } else {
        $email = trim($_POST['email']);
    }

    // Check CNIC 
    if (empty(trim($_POST['cnic']))) {
        $cnic_err = "cnic cannot be blank";
        echo "<script>alert('CNIC cannot be blank');</script>";
    } elseif (strlen(trim($_POST['cnic'])) != 13) {
        $cnic_err = "CNIC must be 13 characters long";
        echo "<script>alert('CNIC must be 13 characters long');</script>";
    } else {
        $cnic = trim($_POST['cnic']);
    }

    // Check address
    if (empty(trim($_POST['address']))) {
        $address_err = "Address cannot be empty";
        echo "<script>alert('Address cannot be empty');</script>";
    } elseif (ctype_digit(trim($_POST['address']))) {
        $address_err = "Address cannot be only digits";
        echo "<script>alert('Address cannot be only digits');</script>";
    } else {
        $address = trim($_POST['address']);
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

    // Store Gender Value (Do not need to check because user only have two options to select from)
    $gender = trim($_POST['gender']);




    // If there are no errors then the name and password is to be inserted\saved in database    
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($cnic_err) && empty($address_err) && empty($mobile_err)) {
        $sql = "INSERT INTO seekers (username, password, email, cnic, address, mobile, gender, usertype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssss", $param_username, $param_password, $param_email, $param_cnic, $param_address, $param_mobile, $param_gender, $param_usertype);

            // Set these parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_cnic = $cnic;
            $param_address = $address;
            $param_mobile = $mobile;
            $param_gender = $gender;
            $param_usertype = $usertype;

            // Try to execute the query
            if (mysqli_stmt_execute($stmt)) {
                header("location: Seeker_login.php");
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
    <title>Seeker Registration</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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
        <div class="signup-box">
            <center>
                <h3>Seeker Register Page</h3>
            </center>
            <hr>

            <form action="" method="post">
                <div class="form-box">

                    <!-- Name  -->

                    <div class="form-box2">
                        <label for="">Name<sup class="red">*</sup>:</label>
                        <input name="username" type="text" class="input-box" placeholder="Enter Your Name" required="">
                    </div>

                    <!-- Email  -->

                    <div class="form-box2">
                        <label for="">Email<sup class="red">*</sup>:</label>
                        <input name="email" type="email" class="input-box" placeholder="Enter Your Email ID"
                            required="">
                    </div>

                </div>



                <div class="form-box">

                    <!-- Password  -->

                    <div class="form-box2">
                        <label for="">Password<sup class="red">*</sup>:</label>
                        <input name="password" type="password" class="input-box" placeholder="Enter Your Password"
                            required="">
                    </div>

                    <!--Confirm Password  -->

                    <div class="form-box2">
                        <label for="">Confirm Password<sup class="red">*</sup>:</label>
                        <input name="confirm_password" type="password" class="input-box"
                            placeholder="Confirm Your Password" required="">
                    </div>



                </div>


                <div class="form-box">

                    <!-- CNIC Number  -->

                    <div class="form-box2">
                        <label for="">CNIC<sup class="red">*</sup>:</label>
                        <input name="cnic" type="text" class="input-box" placeholder="Enter Your CNIC Number"
                            required="">
                    </div>

                    <!-- Address  -->

                    <div class="form-box2">
                        <label for="address">Address<sup class="red">*</sup>:</label>
                        <input name="address" list="cities" name="city" class="input-box" placeholder="Enter Your City">
                        <datalist id="cities">
                            <option value="Islamabad">Islamabad</option>
                            <option value="Ahmed Nager Chatha">Ahmed Nager Chatha</option>
                            <option value="Ahmadpur East">Ahmadpur East</option>
                            <option value="Ali Khan Abad">Ali Khan Abad</option>
                            <option value="Alipur">Alipur</option>
                            <option value="Arifwala">Arifwala</option>
                            <option value="Attock">Attock</option>
                            <option value="Bhera">Bhera</option>
                            <option value="Bhalwal">Bhalwal</option>
                            <option value="Bahawalnagar">Bahawalnagar</option>
                            <option value="Bahawalpur">Bahawalpur</option>
                            <option value="Bhakkar">Bhakkar</option>
                            <option value="Burewala">Burewala</option>
                            <option value="Chillianwala">Chillianwala</option>
                            <option value="Chakwal">Chakwal</option>
                            <option value="Chichawatni">Chichawatni</option>
                            <option value="Chiniot">Chiniot</option>
                            <option value="Chishtian">Chishtian</option>
                            <option value="Daska">Daska</option>
                            <option value="Darya Khan">Darya Khan</option>
                            <option value="Dera Ghazi Khan">Dera Ghazi Khan</option>
                            <option value="Dhaular">Dhaular</option>
                            <option value="Dina">Dina</option>
                            <option value="Dinga">Dinga</option>
                            <option value="Dipalpur">Dipalpur</option>
                            <option value="Faisalabad">Faisalabad</option>
                            <option value="Ferozewala">Ferozewala</option>
                            <option value="Fateh Jhang">Fateh Jang</option>
                            <option value="Ghakhar Mandi">Ghakhar Mandi</option>
                            <option value="Gojra">Gojra</option>
                            <option value="Gujranwala">Gujranwala</option>
                            <option value="Gujrat">Gujrat</option>
                            <option value="Gujar Khan">Gujar Khan</option>
                            <option value="Hafizabad">Hafizabad</option>
                            <option value="Haroonabad">Haroonabad</option>
                            <option value="Hasilpur">Hasilpur</option>
                            <option value="Haveli Lakha">Haveli Lakha</option>
                            <option value="Jatoi">Jatoi</option>
                            <option value="Jalalpur">Jalalpur</option>
                            <option value="Jattan">Jattan</option>
                            <option value="Jampur">Jampur</option>
                            <option value="Jaranwala">Jaranwala</option>
                            <option value="Jhang">Jhang</option>
                            <option value="Jhelum">Jhelum</option>
                            <option value="Kalabagh">Kalabagh</option>
                            <option value="Karor Lal Esan">Karor Lal Esan</option>
                            <option value="Kasur">Kasur</option>
                            <option value="Kamalia">Kamalia</option>
                            <option value="Kamoke">Kamoke</option>
                            <option value="Khanewal">Khanewal</option>
                            <option value="Khanpur">Khanpur</option>
                            <option value="Kharian">Kharian</option>
                            <option value="Khushab">Khushab</option>
                            <option value="Kot Addu">Kot Addu</option>
                            <option value="Jauharabad">Jauharabad</option>
                            <option value="Lahore">Lahore</option>
                            <option value="Lalamusa">Lalamusa</option>
                            <option value="Layyah">Layyah</option>
                            <option value="Liaquat Pur">Liaquat Pur</option>
                            <option value="Lodhran">Lodhran</option>
                            <option value="Malakwal">Malakwal</option>
                            <option value="Mamoori">Mamoori</option>
                            <option value="Mailsi">Mailsi</option>
                            <option value="Mandi Bahauddin">Mandi Bahauddin</option>
                            <option value="Mian Channu">Mian Channu</option>
                            <option value="Mianwali">Mianwali</option>
                            <option value="Multan">Multan</option>
                            <option value="Murree">Murree</option>
                            <option value="Muridke">Muridke</option>
                            <option value="Mianwali Bangla">Mianwali Bangla</option>
                            <option value="Muzaffargarh">Muzaffargarh</option>
                            <option value="Narowal">Narowal</option>
                            <option value="Nankana Sahib">Nankana Sahib</option>
                            <option value="Okara">Okara</option>
                            <option value="Renala Khurd">Renala Khurd</option>
                            <option value="Pakpattan">Pakpattan</option>
                            <option value="Pattoki">Pattoki</option>
                            <option value="Pir Mahal">Pir Mahal</option>
                            <option value="Qaimpur">Qaimpur</option>
                            <option value="Qila Didar Singh">Qila Didar Singh</option>
                            <option value="Rabwah">Rabwah</option>
                            <option value="Raiwind">Raiwind</option>
                            <option value="Rajanpur">Rajanpur</option>
                            <option value="Rahim Yar Khan">Rahim Yar Khan</option>
                            <option value="Rawalpindi">Rawalpindi</option>
                            <option value="Sadiqabad">Sadiqabad</option>
                            <option value="Safdarabad">Safdarabad</option>
                            <option value="Sahiwal">Sahiwal</option>
                            <option value="Sangla Hill">Sangla Hill</option>
                            <option value="Sarai Alamgir">Sarai Alamgir</option>
                            <option value="Sargodha">Sargodha</option>
                            <option value="Shakargarh">Shakargarh</option>
                            <option value="Sheikhupura">Sheikhupura</option>
                            <option value="Sialkot">Sialkot</option>
                            <option value="Sohawa">Sohawa</option>
                            <option value="Soianwala">Soianwala</option>
                            <option value="Siranwali">Siranwali</option>
                            <option value="Talagang">Talagang</option>
                            <option value="Taxila">Taxila</option>
                            <option value="Toba Tek Singh">Toba Tek Singh</option>
                            <option value="Vehari">Vehari</option>
                            <option value="Wah Cantonment">Wah Cantonment</option>
                            <option value="Wazirabad">Wazirabad</option>
                            <option value="" disabled>Sindh Cities</option>
                            <option value="Badin">Badin</option>
                            <option value="Bhirkan">Bhirkan</option>
                            <option value="Rajo Khanani">Rajo Khanani</option>
                            <option value="Chak">Chak</option>
                            <option value="Dadu">Dadu</option>
                            <option value="Digri">Digri</option>
                            <option value="Diplo">Diplo</option>
                            <option value="Dokri">Dokri</option>
                            <option value="Ghotki">Ghotki</option>
                            <option value="Haala">Haala</option>
                            <option value="Hyderabad">Hyderabad</option>
                            <option value="Islamkot">Islamkot</option>
                            <option value="Jacobabad">Jacobabad</option>
                            <option value="Jamshoro">Jamshoro</option>
                            <option value="Jungshahi">Jungshahi</option>
                            <option value="Kandhkot">Kandhkot</option>
                            <option value="Kandiaro">Kandiaro</option>
                            <option value="Karachi">Karachi</option>
                            <option value="Kashmore">Kashmore</option>
                            <option value="Keti Bandar">Keti Bandar</option>
                            <option value="Khairpur">Khairpur</option>
                            <option value="Kotri">Kotri</option>
                            <option value="Larkana">Larkana</option>
                            <option value="Matiari">Matiari</option>
                            <option value="Mehar">Mehar</option>
                            <option value="Mirpur Khas">Mirpur Khas</option>
                            <option value="Mithani">Mithani</option>
                            <option value="Mithi">Mithi</option>
                            <option value="Mehrabpur">Mehrabpur</option>
                            <option value="Moro">Moro</option>
                            <option value="Nagarparkar">Nagarparkar</option>
                            <option value="Naudero">Naudero</option>
                            <option value="Naushahro Feroze">Naushahro Feroze</option>
                            <option value="Naushara">Naushara</option>
                            <option value="Nawabshah">Nawabshah</option>
                            <option value="Nazimabad">Nazimabad</option>
                            <option value="Qambar">Qambar</option>
                            <option value="Qasimabad">Qasimabad</option>
                            <option value="Ranipur">Ranipur</option>
                            <option value="Ratodero">Ratodero</option>
                            <option value="Rohri">Rohri</option>
                            <option value="Sakrand">Sakrand</option>
                            <option value="Sanghar">Sanghar</option>
                            <option value="Shahbandar">Shahbandar</option>
                            <option value="Shahdadkot">Shahdadkot</option>
                            <option value="Shahdadpur">Shahdadpur</option>
                            <option value="Shahpur Chakar">Shahpur Chakar</option>
                            <option value="Shikarpaur">Shikarpaur</option>
                            <option value="Sukkur">Sukkur</option>
                            <option value="Tangwani">Tangwani</option>
                            <option value="Tando Adam Khan">Tando Adam Khan</option>
                            <option value="Tando Allahyar">Tando Allahyar</option>
                            <option value="Tando Muhammad Khan">Tando Muhammad Khan</option>
                            <option value="Thatta">Thatta</option>
                            <option value="Umerkot">Umerkot</option>
                            <option value="Warah">Warah</option>
                            <option value="" disabled>Khyber Cities</option>
                            <option value="Abbottabad">Abbottabad</option>
                            <option value="Adezai">Adezai</option>
                            <option value="Alpuri">Alpuri</option>
                            <option value="Akora Khattak">Akora Khattak</option>
                            <option value="Ayubia">Ayubia</option>
                            <option value="Banda Daud Shah">Banda Daud Shah</option>
                            <option value="Bannu">Bannu</option>
                            <option value="Batkhela">Batkhela</option>
                            <option value="Battagram">Battagram</option>
                            <option value="Birote">Birote</option>
                            <option value="Chakdara">Chakdara</option>
                            <option value="Charsadda">Charsadda</option>
                            <option value="Chitral">Chitral</option>
                            <option value="Daggar">Daggar</option>
                            <option value="Dargai">Dargai</option>
                            <option value="Darya Khan">Darya Khan</option>
                            <option value="Dera Ismail Khan">Dera Ismail Khan</option>
                            <option value="Doaba">Doaba</option>
                            <option value="Dir">Dir</option>
                            <option value="Drosh">Drosh</option>
                            <option value="Hangu">Hangu</option>
                            <option value="Haripur">Haripur</option>
                            <option value="Karak">Karak</option>
                            <option value="Kohat">Kohat</option>
                            <option value="Kulachi">Kulachi</option>
                            <option value="Lakki Marwat">Lakki Marwat</option>
                            <option value="Latamber">Latamber</option>
                            <option value="Madyan">Madyan</option>
                            <option value="Mansehra">Mansehra</option>
                            <option value="Mardan">Mardan</option>
                            <option value="Mastuj">Mastuj</option>
                            <option value="Mingora">Mingora</option>
                            <option value="Nowshera">Nowshera</option>
                            <option value="Paharpur">Paharpur</option>
                            <option value="Pabbi">Pabbi</option>
                            <option value="Peshawar">Peshawar</option>
                            <option value="Saidu Sharif">Saidu Sharif</option>
                            <option value="Shorkot">Shorkot</option>
                            <option value="Shewa Adda">Shewa Adda</option>
                            <option value="Swabi">Swabi</option>
                            <option value="Swat">Swat</option>
                            <option value="Tangi">Tangi</option>
                            <option value="Tank">Tank</option>
                            <option value="Thall">Thall</option>
                            <option value="Timergara">Timergara</option>
                            <option value="Tordher">Tordher</option>
                            <option value="" disabled>Balochistan Cities</option>
                            <option value="Awaran">Awaran</option>
                            <option value="Barkhan">Barkhan</option>
                            <option value="Chagai">Chagai</option>
                            <option value="Dera Bugti">Dera Bugti</option>
                            <option value="Gwadar">Gwadar</option>
                            <option value="Harnai">Harnai</option>
                            <option value="Jafarabad">Jafarabad</option>
                            <option value="Jhal Magsi">Jhal Magsi</option>
                            <option value="Kacchi">Kacchi</option>
                            <option value="Kalat">Kalat</option>
                            <option value="Kech">Kech</option>
                            <option value="Kharan">Kharan</option>
                            <option value="Khuzdar">Khuzdar</option>
                            <option value="Killa Abdullah">Killa Abdullah</option>
                            <option value="Killa Saifullah">Killa Saifullah</option>
                            <option value="Kohlu">Kohlu</option>
                            <option value="Lasbela">Lasbela</option>
                            <option value="Lehri">Lehri</option>
                            <option value="Loralai">Loralai</option>
                            <option value="Mastung">Mastung</option>
                            <option value="Musakhel">Musakhel</option>
                            <option value="Nasirabad">Nasirabad</option>
                            <option value="Nushki">Nushki</option>
                            <option value="Panjgur">Panjgur</option>
                            <option value="Pishin Valley">Pishin Valley</option>
                            <option value="Quetta">Quetta</option>
                            <option value="Sherani">Sherani</option>
                            <option value="Sibi">Sibi</option>
                            <option value="Sohbatpur">Sohbatpur</option>
                            <option value="Washuk">Washuk</option>
                            <option value="Zhob">Zhob</option>
                            <option value="Ziarat">Ziarat</option>

                        </datalist>
                    </div>

                </div>


                <div class="form-box">

                    <!-- Mobile Number  -->

                    <div class="form-box2">
                        <label for="">Mobile<sup class="red">*</sup>:</label>
                        <input name="mobile" type="tel" class="input-box" placeholder="Enter Your Mobile Number"
                            required="">
                    </div>


                    <!-- Gender  -->

                    <div class="form-box2">
                        <label for="gender">Gender</label>
                        <select name="gender" id="Gender">
                            <option value="Male" selected>Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <br><br>



                </div>
                <input type="hidden" name="usertype" value="seeker">

                <div class="form-box-submit">
                    <!-- Submit Button -->
                    <button type="submit" class="btn-login ">Register</button>
                    <br><br>
                    <span>Already have an account? </span>
                    <span> <a id="signup" href="Seeker_login.php">Sign in</a></span>
                </div>
            </form>
        </div>
    </section>


    <!-- Footer  -->
    <footer class="footer">
        <div class="footer-content">
            <h1 class=" secondary-headings footer-logo">
                Blood Donation Management System
            </h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe, veritatis?</p>
            <h3>Address</h3>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Vero assumenda et dicta sunt, pariatur fuga
                dolorum fugiat ducimus explicabo rerum totam architecto neque, tempore nobis.</p>
        </div>
        <div class="social-icons">
            <i class="fab fa-facebook" id="facebook"></i>
            <i class="fab fa-instagram" id="instagram"></i>
            <i class="fab fa-whatsapp" id="whatsapp"></i>
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
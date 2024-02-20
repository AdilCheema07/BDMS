<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
}

$currentUsername = $_SESSION['username'];

// Include your configuration file
require_once "configure.php";

$userRole = $_SESSION['userRole'];

// Initialize variables to hold search results
$result = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the search form 
    $address = isset($_POST['address']) ? $_POST['address'] : "";
    $blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : "";

    // Create the SQL query based on the user's input
    $sql = "SELECT * FROM donors WHERE 1";

    if (!empty($address)) {
        $sql .= " AND address LIKE '%$address%'";
    }

    if (!empty($blood_group)) {
        $sql .= " AND blood_group = '$blood_group'";
    }

    // Execute the query
    $result = mysqli_query($conn, $sql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Donor</title>
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
        } elseif ($userRole === "Admin") {
            include('Admin_navbar.php');
        }

        ?>
        <div class="dashboard-right">




            <form action="" method="post">
                <div class="form-box">
                    <!-- Blood Quantity  -->

                    <div class="form-box2">
                        <label for="address">Select Address: </label>
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

                    <!-- Blood Group  -->

                    <div class="form-box2">
                        <label for="Blood Group">Select Blood Group: </label>
                        <select name="blood_group" id="blood_group" class="input-box">
                            <option value="" selected disabled>Select an option</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                        </select>
                    </div>


                </div>





                <button type="submit" id="btn-send">Search </button>
            </form>

            <div class="form-box">
                <?php
                // Check if the query was successful
                if ($result) {
                    // Check if there are matching donors
                    if (mysqli_num_rows($result) > 0) {
                        // Display the search results in a table
                        echo "<table>";
                        echo "<tr><th>Name</th><th>Address</th><th>Blood Group</th><th>Age</th><th>Mobile Number</th><th>Email</th></tr>";

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['address'] . "</td>";
                            echo "<td>" . $row['blood_group'] . "</td>";
                            echo "<td>" . $row['age'] . "</td>";
                            echo "<td>" . $row['mobile'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "No matching donors found.";
                    }
                }
                // else {
//     echo "Query execution failed: " . mysqli_error($conn);
// }
                
                // Close the database connection
                mysqli_close($conn);
                ?>
            </div>
        </div>

    </section>

</body>

</html>
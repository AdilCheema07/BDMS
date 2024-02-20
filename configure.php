<?php

// This file contains database configuration 
 
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'BDMS');

// Try connecting to the database 
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn == false) {
    dir('Error: Cannot Connect');
}
?>
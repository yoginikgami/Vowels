<?php
$DBName = "dashboard";
$host = 'localhost';
$username = 'root';
$password = '';
//$port = 3307;

$con = new mysqli($host, $username, $password, $DBName);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
} else {
    // echo "Connected successfully to the database.";
}

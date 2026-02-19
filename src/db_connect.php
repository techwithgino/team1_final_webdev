<?php
$host = "db";  
$port = 3306;                     
$user = "root";
$pass = "password";
$dbname = "Users";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed");
}




<?php
// turning on error display ,needed it when i was building the thing
ini_set('display_errors', 1);
error_reporting(E_ALL);


require 'auth_check.php';
require 'db_connect.php';

// only admins get to create new accounts
if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

// handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // grabbing the form fields and cleaning them up a bit
    $company_id = trim($_POST['company_id']);
    $username   = trim($_POST['username']);
    $password   = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashing the password like a responsible adult
    $role       = $_POST['role'];

    // quick sanity check ,making sure nothing important is empty
    if ($company_id !== '' && $username !== '' && $_POST['password'] !== '') {

        // insert the new user into the database
        $stmt = $conn->prepare("INSERT INTO users (company_id, username, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $company_id, $username, $password, $role);
        $stmt->execute();

        // when ur done just send them back to the dashboard
        header("Location: admin_portal.php");
        exit;
    }
}





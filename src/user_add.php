<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'auth_check.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_id = trim($_POST['company_id']);
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    if ($company_id !== '' && $username !== '' && $_POST['password'] !== '') {
        $stmt = $conn->prepare("INSERT INTO users (company_id, username, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $company_id, $username, $password, $role);
        $stmt->execute();
        header("Location: admin_portal.php");
        exit;
    }
}





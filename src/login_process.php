<?php
session_start();
require 'db_connect.php';

$company_id = trim($_POST['company_id']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);

$stmt = $conn->prepare("SELECT id, company_id, username, password_hash, role FROM users WHERE company_id = ? AND username = ?");
$stmt->bind_param("ss", $company_id, $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['company_id'] = $user['company_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: admin_portal.php");
        exit;
    }
}

header("Location: login.php?error=1");
exit;








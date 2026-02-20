<?php
session_start();

require 'db_connect.php';

// grab the form inputs and clean them up a bit
$company_id = trim($_POST['company_id']);
$username = trim($_POST['username']);
$password = trim($_POST['password']);

// prepare a query to find a user with this company_id + username combo
// (basically checking if the account exists)
$stmt = $conn->prepare("SELECT id, company_id, username, password_hash, role FROM users WHERE company_id = ? AND username = ?");
$stmt->bind_param("ss", $company_id, $username);
$stmt->execute();
$result = $stmt->get_result();

// if we found exactly one matching user, we can continue
if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // now we check if the password they typed matches the hashed one in the DB
    if (password_verify($password, $user['password_hash'])) {

        // password is correct → log them in by storing info in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['company_id'] = $user['company_id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // send them to the dashboard
        header("Location: admin_portal.php");
        exit;
    }
}

// if we reach this point, something failed (wrong username or password)
// so we send them back to login with an error flag
header("Location: login.php?error=1");
exit;








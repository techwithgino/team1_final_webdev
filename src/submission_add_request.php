<?php
require 'auth_check.php';
require 'db_connect.php';

if (!isset($_POST['title'], $_POST['description'])) {
    header("Location: admin_portal.php");
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO submissions (user_id, type, title, description) VALUES (?, 'request', ?, ?)");
$stmt->bind_param("iss", $user_id, $title, $description);
$stmt->execute();

header("Location: admin_portal.php?success=submitted_request");
exit;
?>

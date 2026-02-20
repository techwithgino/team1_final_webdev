<?php
require 'auth_check.php';
require 'db_connect.php';

//admins only

if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

$id = $_GET['id'] ?? null;
// if we got an id, go ahead and delete the user

if ($id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}
// after deleting just sending tghem back to dashboard
header("Location: admin_portal.php");
exit;

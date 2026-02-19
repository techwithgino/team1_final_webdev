<?php
require 'auth_check.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: admin_portal.php");
exit;

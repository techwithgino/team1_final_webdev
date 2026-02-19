<?php
include 'db_connect.php';

if (isset($_POST['submit'])) {

    $companyid = $_POST['companyid'];
    $fname     = $_POST['fname'];
    $lname     = $_POST['lname'];
    $coemail   = $_POST['coemail'];
    $username  = $_POST['username'];
    $password  = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO signupinfo (companyId, fname, lname, coemail, username, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL ERROR: " . $conn->error);
    }

    $stmt->bind_param("isssss", $companyid, $fname, $lname, $coemail, $username, $hashed_password);

    if ($stmt->execute()) {
        header("Location: thankyou.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>





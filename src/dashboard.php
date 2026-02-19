<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'header.php';
?>

<div class="container">
    <div class="dashboard-box">
        <h2>Welcome to the CNSS Tech Case Management Portal</h2>
        <p>Manage, track, and monitor your service cases here.</p>
        <p>Logged in as: <?php echo $_SESSION['username']; ?></p>
    </div>
</div>

<?php include 'footer.php'; ?>






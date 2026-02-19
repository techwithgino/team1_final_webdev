<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$page_css = "css/style_login.css";
include 'header.php';
?>

<div style="min-height: calc(105vh - 140px); display: flex; flex-direction: column;">
    
    <div style="flex: 1;">
        <div class="container">
            <div class="dashboard-box">
                <h2>Welcome to the CNSS Tech Case Management Portal</h2>
                <p>Manage, track, and monitor your service cases here.</p>
                <p>Logged in as: <?php echo $_SESSION['username']; ?></p>
            </div>
        </div>
    </div>

    <div style="margin-top: auto;">
        <?php include 'footer.php'; ?>
    </div>

</div>






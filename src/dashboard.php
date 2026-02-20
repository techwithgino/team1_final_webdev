<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// making sure the CSS file is the second one, not the index one
$page_css = "css/style_login.css";

// load the header (navigation, styles, etc.)
include 'header.php';
?>

<!-- main layout wrapper -->
<div style="min-height: calc(105vh - 140px); display: flex; flex-direction: column;">
    
    <!-- this part grows to fill the screen -->
    <div style="flex: 1;">
        <div class="container">
            <div class="dashboard-box">

                <!-- friendly welcome message -->
                <h2>Welcome to the CNSS Tech Case Management Portal</h2>
                <p>Manage, track, and monitor your service cases here.</p>

                <!-- show who is logged in -->
                <p>Logged in as: <?php echo $_SESSION['username']; ?></p>

            </div>
        </div>
    </div>

    <!-- footer sticks to the bottom -->
    <div style="margin-top: auto;">
        <?php include 'footer.php'; ?>
    </div>

</div>







<!-- I modified this to let this page use only style_login.css file - Gino-->

<?php
$page_css = "css/style_login.css";
include 'header.php';
?>
<!-- 0000000000000000000000000000000000000000000-->

<div class="container login-page">

    <div class="login-container">
        <h2>CNSS Tech Login Portal</h2>
        <p>Enter your login credentials</p>

        <form id="loginForm" action="login_process.php" method="POST">
            <label>Company ID</label>
            <input type="text" name="company_id" id="company_id" required>

            <label>Username</label>
            <input type="text" name="username" id="username" required>

            <label>Password</label>
            <input type="password" name="password" id="password" required>

            <div style="margin-top: 0.3rem; display:flex; align-items:center; gap:6px;">
                <input type="checkbox" id="showPassword" onclick="togglePassword()">
                <label for="showPassword" style="margin:0; font-weight:normal;">Show password</label>
            </div>

            <button type="submit">Log In</button>
        </form>

        <div style="text-align:center; margin-top: 0.7rem; font-size: 0.9rem;">
            <p style="margin: 0.2rem 0;">
                Having trouble signing in?
                <a href="contactus.php" style="color:#00887A; font-weight:bold; text-decoration:none;">Contact us</a>
            </p>
            <p style="margin: 0.2rem 0;">
                Don’t have an account yet?
                <a href="register.php" style="color:#00887A; font-weight:bold; text-decoration:none;">Create an account</a>
            </p>
        </div>
    </div>

    <div class="login-info-card">
        <p>Our experts are available to assist you with support and maintenance issues on weekdays:</p>
        <p><strong style="color:#00887A;">08:00 AM – 16:00 PM</strong></p>
        <p>As our contract customer, you may send your support request conveniently by email to:</p>
        <p><strong><a href="mailto:cnsstech@support.fi">cnsstech@support.fi</a></strong></p>
        <p>For urgent matters requiring immediate attention, please contact us directly by phone:</p>
        <p><strong><a href="tel:0417408331">041 740 8331</a></strong></p>
    </div>

</div>

<?php include 'footer.php'; ?>

<script>
function togglePassword() {
    const passwordField = document.getElementById("password");
    passwordField.type = passwordField.type === "password" ? "text" : "password";
}
</script>

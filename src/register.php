<!-- I modified this to let this page use only style_index.css file - Gino-->
<?php
$page_css = "css/style_index.css";
include 'header.php';
?>
<!-- 0000000000000000000000000000000000000000000-->

    <main class="login-page">
    <div class="login-card" style="max-width: 560px;">
        <h2 class="login-title">Create an Account</h2>

        <p class="login-subtitle" style="text-align:left; margin-top:0.75rem;">
        As a valued CNSS Tech customer, you may create an account to manage your company's Case Management Portal and related services.
        </p>

        <p class="login-subtitle" style="text-align:left;">
        The portal allows you to submit new cases, monitor ongoing cases, update information, and communicate directly with our technical support team.
        </p>

        <h2 style="margin: 1.25rem 0 0.75rem 0; font-size: 1.1rem; color:#111827;">Enter Details:</h2>

        <form class="login-form" action="register_process.php" method="post">
        <div class="login-field">
            <label for="companyid">Company ID</label>
            <input type="text" id="companyid" name="companyid" required>
        </div>

        <div class="login-field">
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" required>
        </div>

        <div class="login-field">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" name="lname" required>
        </div>

        <div class="login-field">
            <label for="coemail">Company Email Address</label>
            <input type="email" id="coemail" name="coemail" required>
        </div>

        <div class="login-field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>
        </div>

        <div class="login-field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div class="checkbox-row">
            <label class="checkbox-line">
            <input type="checkbox" id="terms" name="terms" required>
            <span>
                By submitting this form, you confirm that you agree to the storing and processing of your personal data by CNSS Tech as described in the
                <a href="privacy-policy.php">Privacy Policy</a>.
            </span>
            </label>
        </div>

        <div class="checkbox-row">
            <label class="checkbox-line">
            <input type="checkbox" id="showPassword" onclick="togglePassword()">
            <span>Show password</span>
            </label>
        </div>

        <button class="login-btn" type="submit" name="submit">Create Account</button>
        </form>
    </div>
    </main>

    <script>
    function togglePassword() {
        const pwd = document.getElementById("password");
        pwd.type = (pwd.type === "password") ? "text" : "password";
    }
</script>

<?php include 'footer.php'; ?>

<?php include 'header.php'; ?>

<h2>Create an Account</h2>

<p>
As a valued CNSS Tech customer, you may create an account to manage your company's Case Management Portal and related services.
</p>

<p>
The portal allows you to submit new cases, monitor ongoing cases, update information, and communicate directly with our technical support team.
</p>



<h2>Enter Details:</h2>

<form class="signup-form" action="register_process.php" method="post">
      <div class="form-group">
        <label for="companyId">Company ID</label>
        <input type="text" id="companyid" name="companyid" required>
      </div>

      <div class="form-group">
        <label for="fname">First Name</label>
        <input type="text" id="fname" name="fname" required>
      </div>

      <div class="form-group">
        <label for="lname">Last Name</label>
        <input type="text" id="lname" name="lname" required>
      </div>

      <div class="form-group">
        <label for="coemail">Company Email Address</label>
        <input type="email" id="email" name="coemail" required>
      </div>

      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="checkbox-row">
        <label class="checkbox-line">
          <input type="checkbox" id="terms" name="terms" required>
          <span>
            By submitting this form, you confirm that you agree to the storing and processing of your personal data by CNSS Tech as described in the 
            <a href="privacy_policy.php">Privacy Policy</a>.
          </span>
        </label>
      </div>

      <div class="checkbox-row">
        <label class="checkbox-line">
        <input type="checkbox" id="showPassword" onclick="togglePassword()">
        <span>Show password</span>
        </label>
      </div>



      <button type="submit" name="submit">Create Account</button>
    </form>


<script>
function togglePassword() {
  const pwd = document.getElementById("password");
  if (pwd.type === "password") {
    pwd.type = "text";
  } else {
    pwd.type = "password";
  }
}
</script>

<?php include 'footer.php';?>


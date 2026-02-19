<?php
include 'register_db.php';

// Get the ID from the URL
$id = $_GET['id'];

// Fetch the existing record
$result = mysqli_query($conn, "SELECT * FROM signupinfo WHERE id='$id'");
$row = mysqli_fetch_array($result);
?>

<h2>Update your information below:</h2>

<form method="post" action="">
    <div>
        <label>Company ID:</label>
        <input type="text" name="coid" required value="<?php echo $row['companyId']; ?>">
    </div>

    <div>
        <label>First Name:</label>
        <input type="text" name="fname" required value="<?php echo $row['fname']; ?>">
    </div>

    <div>
        <label>Last Name:</label>
        <input type="text" name="lname" required value="<?php echo $row['lname']; ?>">
    </div>

    <div>
        <label>Company Email Address:</label>
        <input type="text" name="coemail" required value="<?php echo $row['coemail']; ?>">
    </div>

    <div>
        <label>Username:</label>
        <input type="text" name="username" required value="<?php echo $row['username']; ?>">
    </div>

    <div>
        <label>Password:</label>
        <input type="text" name="password" required value="<?php echo $row['password']; ?>">
    </div>

    <br>
    <button type="submit" name="submit">Update Information</button>
    <button type="submit" name="delete">Delete Record</button>
</form>

<?php
// UPDATE logic
if (isset($_POST['submit'])) {
    $companyid = $_POST['companyId'];  
    $fname = $_POST['fname'];     
    $lname = $_POST['lname'];     
    $coemail = $_POST['coemail'];       
    $username = $_POST['username']; 
    $password = $_POST['password'];

    $query = mysqli_query($conn,
        "UPDATE signupinfo
         SET companyId='$companyid', fname='$fname', lname='$lname', coemail='$coemail', username='$username', password='$password'
         WHERE id='$id'"
    );

    if ($query) {
        echo "<h3>Record updated successfully.</h3>";
        echo "<a href='register_read.php'>Back to records</a>";
    } else {
        echo "Update failed.";
    }
}

// DELETE logic
if (isset($_POST['delete'])) {
    $query = mysqli_query($conn, "DELETE FROM signupinfo WHERE id='$id'");

    if ($query) {
        echo "<h3>Record deleted successfully.</h3>";
        echo "<a href='register_read.php'>Back to records</a>";
    } else {
        echo "Delete failed.";
    }
}

$conn->close();
?>
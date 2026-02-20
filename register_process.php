<?php
// Check if the 'submit' button in the form was clicked
if (isset($_POST['submit'])) {
    // Retrieve data from the form and store it in variables
    $companyid = $_POST['companyId'];   //Company ID
    $fname = $_POST['fname'];     // First name
    $lname = $_POST['lname'];     // Last name
    $coemail = $_POST['coemail'];       // Company email address
    $username = $_POST['username']; // Username
    $password = $_POST['password'];     //Password

    // Include the database connection file
    include 'register_db.php';

    // Define an SQL query to insert data into the 'signupinfo' table
    $sql = "INSERT INTO signupinfo (companyId, fname, lname, coemail, username, password)
            VALUES ('$companyid', '$fname', '$lname', '$coemail', '$username', '$password')";

    // Execute the SQL query using the database connection
    if ($conn->query($sql) === TRUE) {
        // If the query was successful, display a success message
        header("Location: thankyou.php");
        exit();

    } else {
        // If there was an error in the query, display an error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>

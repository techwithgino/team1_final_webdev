<?php
include 'db_connect.php';

// SQL query to retrieve all records
$sql = "SELECT * FROM signupinfo";
$result = $conn->query($sql);

echo "<h2>All Records</h2>";

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8'>
            <tr>
                <th>ID</ID>
                <th>Company ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Company Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td><a href='register_update_single.php?id={$row['id']}'>{$row['id']}</a></td>
                <td>{$row['companyId']}</td>
                <td>{$row['fname']}</td>
                <td>{$row['lname']}</td>
                <td>{$row['coemail']}</td>
                <td>{$row['username']}</td>
                <td>{$row['password']}</td>
                <td><a href='register_update_single.php?id={$row['id']}'>Update/Delete</a></td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "No results found.";
}

$conn->close();
?>
<br>
<a href='register.php'>Create New User</a>
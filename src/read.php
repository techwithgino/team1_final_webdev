<?php
include 'db_connect.php';

// Fetch all records from userquery table
$sql = "SELECT * FROM userquery ORDER BY sn DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Database error: " . $conn->error);
}

if ($result->num_rows > 0) {

    echo "<table class='table table-bordered'>
            <thead>
                <tr>
                    <th>SN</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Phone</th>
                    <th>Query</th>
                    <th>Attachment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $result->fetch_assoc()) {

        // Escape all output to prevent XSS
        $sn           = htmlspecialchars($row['sn']);
        $first_name   = htmlspecialchars($row['first_name']);
        $last_name    = htmlspecialchars($row['last_name']);
        $email_add    = htmlspecialchars($row['email_add']);
        $company_name = htmlspecialchars($row['company_name']);
        $phone_num    = htmlspecialchars($row['phone_num']);
        $query        = htmlspecialchars($row['query']);

        // Handle attachment safely
        if (!empty($row['attachment']) && file_exists($row['attachment'])) {
            $attachmentPath = htmlspecialchars($row['attachment']);
            $fileLink = "<a href='{$attachmentPath}' target='_blank'>View</a>";
        } else {
            $fileLink = "No file";
        }

        echo "<tr>
                <td>{$sn}</td>
                <td>{$first_name}</td>
                <td>{$last_name}</td>
                <td>{$email_add}</td>
                <td>{$company_name}</td>
                <td>{$phone_num}</td>
                <td>{$query}</td>
                <td>{$fileLink}</td>
                <td>
                    <a href='updatesingle.php?sn={$sn}' 
                        class='btn btn-sm btn-warning'>
                        Edit/Delete
                        </a>
                    </td>
                </tr>";
    }

    echo "</tbody></table>";

} else {
    echo "<div class='alert alert-info'>No submissions found.</div>";
}

$conn->close();
?>
<?php
include 'db.php';

if (!isset($_GET['sn'])) {
    die("Invalid request.");
}

$sn = intval($_GET['sn']);
$result = mysqli_query($conn, "SELECT * FROM userquery WHERE sn='$sn'");
$row = mysqli_fetch_assoc($result);

if (!$row) die("Record not found.");

// Handle Update
if (isset($_POST['submit'])) {
    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $email_add    = trim($_POST['email_add']);
    $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : NULL;
    $phone_num    = !empty($_POST['phone_num']) ? trim($_POST['phone_num']) : NULL;
    $query        = trim($_POST['query']);

    // File upload
    $attachment = $row['attachment']; // keep old file if not updated
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $allowed = ['pdf','doc','docx','png','jpg'];
        $fileName = $_FILES['attachment']['name'];
        $fileTmp  = $_FILES['attachment']['tmp_name'];
        $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExt, $allowed)) {
            die("Invalid file type.");
        }

        if ($_FILES['attachment']['size'] > 2*1024*1024) {
            die("File too large. Max 2MB.");
        }

        if (!is_dir("uploads")) mkdir("uploads", 0777, true);
        $newName = uniqid() . "_" . basename($fileName);
        $destination = "uploads/" . $newName;

        if (move_uploaded_file($fileTmp, $destination)) {
            if ($attachment && file_exists($attachment)) unlink($attachment); // delete old file
            $attachment = $destination;
        } else {
            die("Failed to upload file.");
        }
    }

    $stmt = $conn->prepare("UPDATE userquery SET first_name=?, last_name=?, email_add=?, company_name=?, phone_num=?, query=?, attachment=? WHERE sn=?");
    $stmt->bind_param("sssssssi", $first_name, $last_name, $email_add, $company_name, $phone_num, $query, $attachment, $sn);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Record updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: ".$stmt->error."</div>";
    }
}

// Handle Delete
if (isset($_POST['delete'])) {
    if ($row['attachment'] && file_exists($row['attachment'])) unlink($row['attachment']);
    mysqli_query($conn, "DELETE FROM userquery WHERE sn='$sn'");
    echo "<div class='alert alert-success'>Record deleted.</div>";
    echo "<a href='read.php' class='btn btn-primary'>Back to list</a>";
    exit;
}
?>

<form method="post" enctype="multipart/form-data">
    <input type="text" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required><br>
    <input type="text" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required><br>
    <input type="email" name="email_add" value="<?php echo htmlspecialchars($row['email_add']); ?>" required><br>
    <input type="text" name="company_name" value="<?php echo htmlspecialchars($row['company_name']); ?>"><br>
    <input type="text" name="phone_num" value="<?php echo htmlspecialchars($row['phone_num']); ?>"><br>
    <textarea name="query" required><?php echo htmlspecialchars($row['query']); ?></textarea><br>
    <input type="file" name="attachment"><br>
    <?php if($row['attachment']): ?>
        Current file: <a href="<?php echo $row['attachment']; ?>" target="_blank">View</a><br>
    <?php endif; ?>
    <button type="submit" name="submit" class="btn btn-success">Update</button>
    <button type="submit" name="delete" class="btn btn-danger" onclick="return confirm('Are you sure?');">Delete</button>
</form>
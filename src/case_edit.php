<?php
require 'auth_check.php';

// Connect to the database so we can grab and update the case
require 'db_connect.php';

// grab the case ID from the URL if it aint there we cant edit anything
$id = $_GET['id'] ?? null;

// Look up the case in the database so we know what we're editing
$stmt = $conn->prepare("SELECT * FROM cases WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$case = $stmt->get_result()->fetch_assoc();

// if the case doesn't exist, just put them back to the list
if (!$case) {
    header("Location: cases_list.php");
    exit;
}

// this is checking if its an admin or not
$isAdmin = ($_SESSION['role'] === 'admin');

// If they aint an admin, they can only edit cases they created
// This stops users from messing with each other's stuff
if (!$isAdmin && $case['created_by'] != $_SESSION['user_id']) {
    header("Location: cases_list.php");
    exit;
}

// If the form was submitted, handle the update.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Clean up the inputs a bit.
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // Admins can change the status. Regular users can't.
    if ($isAdmin) {
        $status = $_POST['status'];
    } else {
        // Non-admins keep whatever the status already was.
        $status = $case['status'];
    }

    // Make sure the fields aren't empty.
    if ($title !== '' && $description !== '') {

        // Update the case in the database.
        $update = $conn->prepare("UPDATE cases SET title=?, description=?, status=? WHERE id=?");
        $update->bind_param("sssi", $title, $description, $status, $id);
        $update->execute();

        // After saving, send them back to the case list
        header("Location: cases_list.php");
        exit;
    }
}
?>

<?php include 'admin_header.php'; ?>

<!-- Main page layout -->
<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">Edit Case</h2>

        <!-- The form is pre-filled with the existing case info -->
        <form action="case_edit.php?id=<?php echo $case['id']; ?>" method="POST"
              style="margin-top:1.5rem; display:flex; flex-direction:column; gap:1rem;">

            <!-- Title -->
            <div>
                <label style="font-weight:600; color:#003135;">Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($case['title']); ?>"
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                       required>
            </div>

            <!-- Description -->
            <div>
                <label style="font-weight:600; color:#003135;">Description</label>
                <textarea name="description" rows="5"
                          style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                          required><?php echo htmlspecialchars($case['description']); ?></textarea>
            </div>

            <!-- Status dropdown (admins only) -->
            <?php if ($isAdmin): ?>
                <div>
                    <label style="font-weight:600; color:#003135;">Status</label>
                    <select name="status"
                            style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
                        <option value="Open" <?php if ($case['status'] === 'Open') echo 'selected'; ?>>Open</option>
                        <option value="In Progress" <?php if ($case['status'] === 'In Progress') echo 'selected'; ?>>In Progress</option>
                        <option value="Closed" <?php if ($case['status'] === 'Closed') echo 'selected'; ?>>Closed</option>
                    </select>
                </div>
            <?php endif; ?>

            <!-- Save button -->
            <button type="submit"
                    style="background:#00887A; color:white; padding:1rem; border:none; border-radius:10px; font-weight:700; cursor:pointer;">
                Save Changes
            </button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>





<?php

require 'auth_check.php';

// Connect to the database so we can look up and delete the case.
require 'db_connect.php';

// Only admins are allowed to delete cases.
// If a regular user somehow tries to access this page we send them away.
if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

// Get the case ID from the URL.
// If there's no ID, we can't delete anything, so we redirect back.
$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: cases_list.php");
    exit;
}

// Fetch the case title so we can show a confirmation message.
// This also lets us verify that the case actually exists.
$stmt = $conn->prepare("SELECT title FROM cases WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$case = $result->fetch_assoc();

// If the case doesn't exist, there's nothing to delete.
if (!$case) {
    header("Location: cases_list.php");
    exit;
}

// If the form was submitted, we check whether the user confirmed deletion.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Only delete if the user clicked the yes button.
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {

        // Deletes the casef rom the database
        $delete = $conn->prepare("DELETE FROM cases WHERE id = ?");
        $delete->bind_param("i", $id);
        $delete->execute();
    }

    // Whether they confirmed or cancelled, we send them back to the case list.
    header("Location: cases_list.php");
    exit;
}
?>

<?php include 'admin_header.php'; ?>

<!-- Main container for the delete confirmation UI -->
<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem; text-align:center;">

        <!-- Big red warning title -->
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#C62828;">
            Delete Case
        </h2>

        <!-- Ask the user if they're sure -->
        <p style="margin-top:1rem; font-size:1.2rem; color:#003135;">
            Are you sure you want to delete this case?
        </p>

        <!-- Show the case title so the admin knows exactly what they're deleting -->
        <p style="margin-top:0.5rem; font-size:1.1rem; font-weight:600; color:#00887A;">
            "<?php echo htmlspecialchars($case['title']); ?>"
        </p>

        <!-- Confirmation form -->
        <form action="case_delete.php?id=<?php echo $id; ?>" method="POST"
              style="margin-top:2rem; display:flex; justify-content:center; gap:1rem;">

            <!-- The yes, delete button -->
            <button type="submit" name="confirm" value="yes"
                    style="background:#C62828; color:white; padding:1rem 2rem; border:none;
                           border-radius:10px; font-weight:700; cursor:pointer;">
                Delete Case
            </button>

            <!-- The cancel button just links back to the case list -->
            <a href="cases_list.php"
               style="background:#00887A; color:white; padding:1rem 2rem; border-radius:10px;
                      font-weight:700; text-decoration:none;">
                Cancel
            </a>

        </form>

    </div>

</div>

<?php include 'admin_footer.php'; ?>




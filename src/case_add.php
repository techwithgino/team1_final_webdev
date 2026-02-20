<?php

require 'auth_check.php';

// Connect to the database so we can insert the new case.
require 'db_connect.php';

// This block runs only when the form is submitted (POST request).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Grab the title and description from the form and clean them up a bit.
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    // Admins are allowed to choose the case status manually.
    // Regular users cannot — their cases always start as "Open".
    if ($_SESSION['role'] === 'admin') {
        $status = $_POST['status'];
    } else {
        $status = "Open"; 
    }

    // The ID of the user who created the case.
    $created_by = $_SESSION['user_id'];

    // Basic validation: make sure the fields aren't empty.
    if ($title !== '' && $description !== '') {

        // Prepare the SQL insert. Using prepared statements keeps things secure.
        $stmt = $conn->prepare("INSERT INTO cases (title, description, status, created_by) VALUES (?, ?, ?, ?)");

        // Bind the values into the query.
        $stmt->bind_param("sssi", $title, $description, $status, $created_by);

        // Run the query.
        $stmt->execute();

        // After saving the case, send the user back to the case list.
        header("Location: cases_list.php");
        exit;
    }
}
?>

<?php include 'admin_header.php'; ?>

<!-- Main container for the page layout -->
<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">Add New Case</h2>

        <!-- The form where users/admins create a new case -->
        <form id="caseForm" action="case_add.php" method="POST"
              style="margin-top:1.5rem; display:flex; flex-direction:column; gap:1rem;">

            <!-- Case title -->
            <div>
                <label style="font-weight:600; color:#003135;">Title</label>
                <input type="text" name="title" id="title"
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                       required>
            </div>

            <!-- Case description -->
            <div>
                <label style="font-weight:600; color:#003135;">Description</label>
                <textarea name="description" id="description" rows="5"
                          style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                          required></textarea>
            </div>

            <!-- Admins can choose the status; users cannot -->
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <div>
                    <label style="font-weight:600; color:#003135;">Status</label>
                    <select name="status" id="status"
                            style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
                        <option value="Open">Open</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Closed">Closed</option>
                    </select>
                </div>
            <?php else: ?>
                <!-- Regular users don't get to choose; their cases always start as Open -->
                <input type="hidden" name="status" value="Open">
            <?php endif; ?>

            <!-- Submit button -->
            <button type="submit"
                    style="background:#00887A; color:white; padding:1rem; border:none; border-radius:10px; font-weight:700; cursor:pointer;">
                Save Case
            </button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>

<!-- Simple JavaScript validation before the form submits -->
<script>
document.getElementById('caseForm').addEventListener('submit', function(e) {

    // Grab the values from the form fields.
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();

    // Make sure the title is at least 3 characters.
    if (title.length < 3) {
        alert('Title must be at least 3 characters.');
        e.preventDefault(); // Stop the form from submitting.
    }

    // Make sure the description is at least 10 characters.
    if (description.length < 10) {
        alert('Description must be at least 10 characters.');
        e.preventDefault();
    }
});
</script>





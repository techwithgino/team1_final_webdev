<?php
require 'auth_check.php';
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

    
    if ($_SESSION['role'] === 'admin') {
        $status = $_POST['status'];
    } else {
        $status = "Open"; 
    }

   
    $created_by = $_SESSION['user_id'];

    if ($title !== '' && $description !== '') {
        $stmt = $conn->prepare("INSERT INTO cases (title, description, status, created_by) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $title, $description, $status, $created_by);
        $stmt->execute();

        header("Location: cases_list.php");
        exit;
    }
}
?>

<?php include 'admin_header.php'; ?>

<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">Add New Case</h2>

        <form id="caseForm" action="case_add.php" method="POST" style="margin-top:1.5rem; display:flex; flex-direction:column; gap:1rem;">

            <div>
                <label style="font-weight:600; color:#003135;">Title</label>
                <input type="text" name="title" id="title"
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                       required>
            </div>

            <div>
                <label style="font-weight:600; color:#003135;">Description</label>
                <textarea name="description" id="description" rows="5"
                          style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                          required></textarea>
            </div>

            
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
                
                <input type="hidden" name="status" value="Open">
            <?php endif; ?>

            <button type="submit"
                    style="background:#00887A; color:white; padding:1rem; border:none; border-radius:10px; font-weight:700; cursor:pointer;">
                Save Case
            </button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>

<script>
document.getElementById('caseForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const description = document.getElementById('description').value.trim();

    if (title.length < 3) {
        alert('Title must be at least 3 characters.');
        e.preventDefault();
    }

    if (description.length < 10) {
        alert('Description must be at least 10 characters.');
        e.preventDefault();
    }
});
</script>




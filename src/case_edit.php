<?php
require 'auth_check.php';
require 'db_connect.php';

$id = $_GET['id'] ?? null;


$stmt = $conn->prepare("SELECT * FROM cases WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$case = $stmt->get_result()->fetch_assoc();

if (!$case) {
    header("Location: cases_list.php");
    exit;
}

$isAdmin = ($_SESSION['role'] === 'admin');


if (!$isAdmin && $case['created_by'] != $_SESSION['user_id']) {
    header("Location: cases_list.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);

   
    if ($isAdmin) {
        $status = $_POST['status'];
    } else {
        $status = $case['status']; 
    }

    if ($title !== '' && $description !== '') {
        $update = $conn->prepare("UPDATE cases SET title=?, description=?, status=? WHERE id=?");
        $update->bind_param("sssi", $title, $description, $status, $id);
        $update->execute();

        header("Location: cases_list.php");
        exit;
    }
}
?>

<?php include 'admin_header.php'; ?>

<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">Edit Case</h2>

        <form action="case_edit.php?id=<?php echo $case['id']; ?>" method="POST"
              style="margin-top:1.5rem; display:flex; flex-direction:column; gap:1rem;">

            <div>
                <label style="font-weight:600; color:#003135;">Title</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($case['title']); ?>"
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                       required>
            </div>

            <div>
                <label style="font-weight:600; color:#003135;">Description</label>
                <textarea name="description" rows="5"
                          style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;"
                          required><?php echo htmlspecialchars($case['description']); ?></textarea>
            </div>

            
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

            <button type="submit"
                    style="background:#00887A; color:white; padding:1rem; border:none; border-radius:10px; font-weight:700; cursor:pointer;">
                Save Changes
            </button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>




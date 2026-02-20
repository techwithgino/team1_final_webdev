<?php

require 'auth_check.php';
require 'db_connect.php';

// only admins should be editing users, so we kick out anyone else
if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

// grab the user id from the URL
$id = $_GET['id'] ?? null;

// load the user we're editing
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// if the user doesn't exist, out
if (!$user) {
    header("Location: admin_portal.php");
    exit;
}

// handle the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // basic fields
    $company_id = trim($_POST['company_id']);
    $username   = trim($_POST['username']);
    $role       = $_POST['role'];

    // if password field is filled, update it too
    if ($_POST['password'] !== '') {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // update everything including password
        $update = $conn->prepare("UPDATE users SET company_id=?, username=?, password_hash=?, role=? WHERE id=?");
        $update->bind_param("ssssi", $company_id, $username, $password, $role, $id);

    } else {
        // otherwise keep the old password
        $update = $conn->prepare("UPDATE users SET company_id=?, username=?, role=? WHERE id=?");
        $update->bind_param("sssi", $company_id, $username, $role, $id);
    }

    // run the update and go back to adminportal
    $update->execute();
    header("Location: admin_portal.php");
    exit;
}
?>

<?php include 'admin_header.php'; ?>

<!-- main wrapper -->
<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">Edit User</h2>

        <!-- edit form -->
        <form action="user_edit.php?id=<?php echo $user['id']; ?>" method="POST"
              style="margin-top:1.5rem; display:flex; flex-direction:column; gap:1.2rem;">

            <div>
                <label style="font-weight:600; color:#003135;">Company ID</label>
                <input type="text" name="company_id"
                       value="<?php echo htmlspecialchars($user['company_id']); ?>"
                       required
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
            </div>

            <div>
                <label style="font-weight:600; color:#003135;">Username</label>
                <input type="text" name="username"
                       value="<?php echo htmlspecialchars($user['username']); ?>"
                       required
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
            </div>

            <div>
                <label style="font-weight:600; color:#003135;">New Password (leave blank to keep current)</label>
                <input type="password" name="password"
                       style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
            </div>

            <div>
                <label style="font-weight:600; color:#003135;">Role</label>
                <select name="role"
                        style="width:100%; padding:1rem; border-radius:10px; border:1px solid #cfd8dc; box-sizing:border-box;">
                    <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
                    <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
                    <option value="manager" <?php if ($user['role'] === 'manager') echo 'selected'; ?>>Manager</option>
                </select>
            </div>

            <button type="submit"
                    style="background:#00887A; color:white; padding:1rem; border:none; border-radius:10px;
                           font-weight:700; cursor:pointer; margin-top:0.5rem;">
                Save Changes
            </button>

        </form>
    </div>

</div>

<?php include 'admin_footer.php'; ?>






<?php
require 'auth_check.php';
require 'db_connect.php';


if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: cases_list.php");
    exit;
}


$stmt = $conn->prepare("SELECT title FROM cases WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$case = $result->fetch_assoc();

if (!$case) {
    header("Location: cases_list.php");
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
        $delete = $conn->prepare("DELETE FROM cases WHERE id = ?");
        $delete->bind_param("i", $id);
        $delete->execute();
    }

    header("Location: cases_list.php");
    exit;
}
?>

<?php include 'admin_header.php'; ?>

<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem; text-align:center;">

        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#C62828;">
            Delete Case
        </h2>

        <p style="margin-top:1rem; font-size:1.2rem; color:#003135;">
            Are you sure you want to delete this case?
        </p>

        <p style="margin-top:0.5rem; font-size:1.1rem; font-weight:600; color:#00887A;">
            "<?php echo htmlspecialchars($case['title']); ?>"
        </p>

        <form action="case_delete.php?id=<?php echo $id; ?>" method="POST"
              style="margin-top:2rem; display:flex; justify-content:center; gap:1rem;">

            <button type="submit" name="confirm" value="yes"
                    style="background:#C62828; color:white; padding:1rem 2rem; border:none;
                           border-radius:10px; font-weight:700; cursor:pointer;">
                Delete Case
            </button>

            <a href="cases_list.php"
               style="background:#00887A; color:white; padding:1rem 2rem; border-radius:10px;
                      font-weight:700; text-decoration:none;">
                Cancel
            </a>

        </form>

    </div>

</div>

<?php include 'admin_footer.php'; ?>



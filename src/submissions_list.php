<?php
require 'auth_check.php';
require 'db_connect.php';

if ($_SESSION['role'] !== 'admin') {
    header("Location: cases_list.php");
    exit;
}

$submissions = $conn->query("
    SELECT submissions.id AS submission_id,
           submissions.user_id,
           submissions.type,
           submissions.title,
           submissions.description,
           submissions.created_at,
           users.username
    FROM submissions
    JOIN users ON submissions.user_id = users.id
    ORDER BY submissions.created_at DESC
");
?>

<?php include 'admin_header.php'; ?>

<div style="width:100%; max-width:1350px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-header" style="margin-top:2rem;">
        <h2>Submissions</h2>
        <div class="welcome-text">
            All user submissions
        </div>
    </div>

    <div class="user-management" style="max-width:1350px; margin:2rem auto;">
        <h3>Submissions</h3>

        <table>
            <thead>
                <tr>
                    <th>Submission ID</th>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($s = $submissions->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $s['submission_id']; ?></td>
                        <td><?php echo $s['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($s['username']); ?></td>
                        <td>
                            <span class="type-badge type-<?php echo $s['type']; ?>">
                                <?php echo ucfirst($s['type']); ?>
                            </span>
                        </td>
                        <td><?php echo htmlspecialchars($s['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($s['description'])); ?></td>
                        <td><?php echo $s['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'admin_footer.php'; ?>
















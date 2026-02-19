<?php
require 'auth_check.php';
require 'db_connect.php';

$isAdmin = ($_SESSION['role'] === 'admin');


if ($isAdmin) {
    $total = $conn->query("SELECT COUNT(*) AS c FROM cases")->fetch_assoc()['c'];
    $open = $conn->query("SELECT COUNT(*) AS c FROM cases WHERE status='Open'")->fetch_assoc()['c'];
    $progress = $conn->query("SELECT COUNT(*) AS c FROM cases WHERE status='In Progress'")->fetch_assoc()['c'];
    $closed = $conn->query("SELECT COUNT(*) AS c FROM cases WHERE status='Closed'")->fetch_assoc()['c'];

    $query = "SELECT * FROM cases ORDER BY created_at DESC";
    $result = $conn->query($query);


} else {
    $query = "SELECT * FROM cases WHERE created_by = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<?php include 'admin_header.php'; ?>

<div style="width:100%; max-width:1400px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <div class="dashboard-box" style="margin-top:2rem;">

        
        <h2 style="margin:0; font-size:2rem; font-weight:700; color:#003135;">
            <?php echo $isAdmin ? "Case Management" : "My Cases"; ?>
        </h2>

        <p style="margin-top:0.3rem; color:#003135;">
            Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>
        </p>

        
        <a href="case_add.php" 
           style="background:#00887A; color:white; padding:0.8rem 1.4rem; border-radius:10px; 
                  display:inline-block; margin-top:1rem; font-weight:600; text-decoration:none;">
            + Add New Case
        </a>

        
        <?php if ($isAdmin): ?>
        <div style="display:flex; gap:1.5rem; margin-top:1.5rem;">

            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:12px; text-align:center;">
                <h3 style="margin:0; font-size:2rem; color:#00887A;"><?php echo $total; ?></h3>
                <p style="margin:0; color:#003135;">Total Cases</p>
            </div>

            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:12px; text-align:center;">
                <h3 style="margin:0; font-size:2rem; color:#00887A;"><?php echo $open; ?></h3>
                <p style="margin:0; color:#003135;">Open</p>
            </div>

            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:12px; text-align:center;">
                <h3 style="margin:0; font-size:2rem; color:#00887A;"><?php echo $progress; ?></h3>
                <p style="margin:0; color:#003135;">In Progress</p>
            </div>

            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:12px; text-align:center;">
                <h3 style="margin:0; font-size:2rem; color:#00887A;"><?php echo $closed; ?></h3>
                <p style="margin:0; color:#003135;">Closed</p>
            </div>

        </div>

       
        <div class="dashboard-box" style="margin-top:1.5rem; text-align:center;">
            <h3 style="margin-top:0; color:#003135;">Case Status Overview</h3>
            <canvas 
                id="caseChart"
                data-open="<?php echo $open; ?>"
                data-progress="<?php echo $progress; ?>"
                data-closed="<?php echo $closed; ?>"
                style="max-width: 400px; margin:auto;">
            </canvas>
        </div>
        <?php endif; ?>

        
        <input type="text" id="searchInput" placeholder="Search cases..." 
               style="width:100%; padding:1rem; margin-top:1.5rem; border:1px solid #cfd8dc; 
                      border-radius:10px; box-sizing:border-box;">
    </div>

    
    <div class="dashboard-box" style="margin-top:2rem;">
        <h3 style="margin-top:0; color:#003135;">
            <?php echo $isAdmin ? "All Cases" : "Your Cases"; ?>
        </h3>

        <table style="width:100%; border-collapse:collapse; margin-top:1rem; font-size:1rem;">
            <thead>
                <tr>
                    <th style="padding:0.8rem; border-bottom:1px solid #cfd8dc;">ID</th>
                    <th style="padding:0.8rem; border-bottom:1px solid #cfd8dc;">Title</th>
                    <th style="padding:0.8rem; border-bottom:1px solid #cfd8dc;">Status</th>
                    <th style="padding:0.8rem; border-bottom:1px solid #cfd8dc;">Created</th>
                    <th style="padding:0.8rem; border-bottom:1px solid #cfd8dc;">Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($case = $result->fetch_assoc()): ?>

                        <?php
                        $status = $case['status'];
                        $class = '';

                        if ($status === 'Open') $class = 'status-open';
                        if ($status === 'In Progress') $class = 'status-progress';
                        if ($status === 'Closed') $class = 'status-closed';
                        ?>

                        <tr>
                            <td style="padding:0.8rem;"><?php echo $case['id']; ?></td>
                            <td style="padding:0.8rem;"><?php echo htmlspecialchars($case['title']); ?></td>
                            <td style="padding:0.8rem;">
                                <span class="status-badge <?php echo $class; ?>" 
                                      style="padding:0.3rem 0.6rem; border-radius:8px; font-weight:600;">
                                    <?php echo htmlspecialchars($status); ?>
                                </span>
                            </td>
                            <td style="padding:0.8rem;"><?php echo $case['created_at']; ?></td>

                            <td style="padding:0.8rem;">
                                <div class="action-buttons">

                                    
                                    <?php if ($isAdmin || $case['created_by'] == $_SESSION['user_id']): ?>
                                        <button class="edit-btn"
                                                onclick="location.href='case_edit.php?id=<?php echo $case['id']; ?>'">
                                            Edit
                                        </button>
                                    <?php endif; ?>

                                   
                                    <?php if ($isAdmin): ?>
                                        <button class="delete-btn"
                                                onclick="location.href='case_delete.php?id=<?php echo $case['id']; ?>'">
                                            Delete
                                        </button>
                                    <?php endif; ?>

                                </div>
                            </td>
                        </tr>

                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding:0.8rem;">No cases found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include 'admin_footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/cases.js?v=3"></script>






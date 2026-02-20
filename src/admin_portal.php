<?php
// first thing: make sure the user is logged in.
// this page should never be visible to someone who isn't authenticated.
require 'auth_check.php';

// Connect to the database so we can fetch users, cases, etc
require 'db_connect.php';

// f the logged-in user is an admin, we load all the admin-only data, regular users cant see it

if ($_SESSION['role'] === 'admin') {

    // Get a list of all users so the admin can manage them
    $users = $conn->query("SELECT id, company_id, username, role FROM users ORDER BY id ASC");

    // count how many users exist in total
    $count_users = $conn->query("SELECT COUNT(*) AS c FROM users")->fetch_assoc()['c'];

    // count how many cases exist in total
    $count_cases = $conn->query("SELECT COUNT(*) AS c FROM cases")->fetch_assoc()['c'];

    // Count only the open cases
    $count_open_cases = $conn->query("SELECT COUNT(*) AS c FROM cases WHERE status='open'")->fetch_assoc()['c'];
}

// Load the admin header (navigation bar, styles, etc.)
include 'admin_header.php';
?>

<!-- Main container for the dashboard layout -->
<div style="width:100%; max-width:1600px; margin:0 auto; padding:0 40px; box-sizing:border-box;">

    <!-- Big top banner with gradient background -->
    <div class="dashboard-box" 
         style="padding:2rem; border-radius:12px; margin-top:2rem;
                background: linear-gradient(135deg, #00887A, #4CC7B4); color:white;">

        <div style="display:flex; justify-content:space-between; align-items:flex-end; width:100%;">

            <div>
                <!-- Title changes depending on the user's role -->
                <h2 style="margin:0; font-size:2rem; font-weight:700;">
                    <?php echo ($_SESSION['role'] === 'admin') ? 'Admin Portal' : 'User Portal'; ?>
                </h2>

                <!-- Friendly welcome message -->
                <div style="margin-top:0.3rem; font-size:1.1rem;">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                    (<?php echo ucfirst(htmlspecialchars($_SESSION['role'])); ?>)
                </div>
            </div>

            <!-- Admin sees admin tools; users see a simpler button -->
            <?php if ($_SESSION['role'] === 'admin'): ?>
            <div style="display:flex; gap:1rem; margin-bottom:-0.5rem;">

                <!-- Link to case management -->
                <a href="cases_list.php" 
                   style="background:white; color:#00887A; padding:0.85rem 1.5rem;
                          border-radius:12px; font-weight:600; text-decoration:none;
                          box-shadow:0 3px 8px rgba(0,0,0,0.15);">
                    Case Management
                </a>

                <!-- Link to submissions overview -->
                <a href="submissions_list.php" 
                   style="background:white; color:#00887A; padding:0.85rem 1.5rem;
                          border-radius:12px; font-weight:600; text-decoration:none;
                          box-shadow:0 3px 8px rgba(0,0,0,0.15);">
                    View Submissions
                </a>

            </div>

            <?php else: ?>
            <!-- Regular users only get the case management button -->
            <div style="display:flex; gap:1rem; margin-bottom:-0.5rem;">

                <a href="cases_list.php" 
                   style="background:white; color:#00887A; padding:0.85rem 1.5rem;
                          border-radius:12px; font-weight:600; text-decoration:none;
                          box-shadow:0 3px 8px rgba(0,0,0,0.15);">
                    Go to Case Management
                </a>

            </div>
            <?php endif; ?>

        </div>

    </div>

    <!-- ========================= ADMIN SECTION ========================= -->
    <?php if ($_SESSION['role'] === 'admin'): ?>

    <!-- Admin can create new users here -->
    <div class="dashboard-box" style="width:100%; margin-top:2rem; padding:2rem; border-radius:12px;">

        <h3 style="margin-top:0; color:#00887A; font-weight:700;">Add New User</h3>

        <form action="user_add.php" method="POST" class="add-user-form">

            <div>
                <label>Company ID</label>
                <input type="text" name="company_id" required>
            </div>

            <div>
                <label>Username</label>
                <input type="text" name="username" required>
            </div>

            <div>
                <label>Password</label>
                <input type="password" name="password" required>
            </div>

            <div>
                <label>Role</label>
                <select name="role">
                    <option value="user">User</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div style="grid-column:span 2; text-align:right;">
                <button type="submit" 
                        style="background:#00887A; color:white; padding:1rem 2rem; border:none; border-radius:10px; font-weight:700;">
                    Create User
                </button>
            </div>

        </form>
    </div>

    <!-- Admin dashboard stats (users, cases, open cases) -->
    <div class="dashboard-box" style="width:100%; margin-top:2rem; padding:2rem; border-radius:12px;">

        <h3 style="margin-top:0; color:#00887A; font-weight:700;">Admin Tools</h3>

        <div style="display:flex; gap:2rem; margin-top:2rem;">

            <!-- Total users -->
            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:10px; text-align:center;">
                <h4>Total Users</h4>
                <p style="font-size:2rem; font-weight:700; color:#00887A;"><?php echo $count_users; ?></p>
            </div>

            <!-- Total cases -->
            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:10px; text-align:center;">
                <h4>Total Cases</h4>
                <p style="font-size:2rem; font-weight:700; color:#00887A;"><?php echo $count_cases; ?></p>
            </div>

            <!-- Open cases -->
            <div style="flex:1; background:#f4f7f7; padding:1.5rem; border-radius:10px; text-align:center;">
                <h4>Open Cases</h4>
                <p style="font-size:2rem; font-weight:700; color:#00887A;"><?php echo $count_open_cases; ?></p>
            </div>
        </div>

        <!-- Quick admin shortcuts -->
        <div style="display:flex; gap:1rem; margin-top:2rem;">
            <a href="cases_list.php" class="top-action-btn" style="flex:1; text-align:center;">Manage Cases</a>
            <a href="submissions_list.php" class="top-action-btn" style="flex:1; text-align:center;">View Submissions</a>
            <a href="admin_portal.php" class="top-action-btn" style="flex:1; text-align:center;">Refresh Dashboard</a>
        </div>

    </div>

    <?php endif; ?>

    <!-- ========================= USER SECTION ========================= -->
    <?php if ($_SESSION['role'] !== 'admin'): ?>

    <!-- Regular users get three submission forms -->
    <div class="dashboard-box" style="width:100%; margin-top:2rem; padding:2rem; border-radius:12px;">
        <div class="three-card-row">

            <!-- Case submission -->
            <div class="portal-card">
                <h3>Report a Case</h3>
                <p>Submit a new case for follow-up and handling.</p>
                <form action="submission_add_case.php" method="POST">
                    <input type="text" name="title" placeholder="Case Title" required>
                    <textarea name="description" placeholder="Describe your case" required></textarea>
                    <button type="submit" class="btn-green">Submit</button>
                </form>
            </div>

            <!-- Request submission -->
            <div class="portal-card">
                <h3>Submit a Request</h3>
                <p>Ask for changes, services, or specific actions.</p>
                <form action="submission_add_request.php" method="POST">
                    <input type="text" name="title" placeholder="Request Title" required>
                    <textarea name="description" placeholder="Describe your request" required></textarea>
                    <button type="submit" class="btn-green">Submit</button>
                </form>
            </div>

            <!-- Inquiry submission -->
            <div class="portal-card">
                <h3>Send an Inquiry</h3>
                <p>For more information, you can send questions below: .</p>
                <form action="submission_add_inquiry.php" method="POST">
                    <input type="text" name="title" placeholder="Subject" required>
                    <textarea name="description" placeholder="Your question" required></textarea>
                    <button type="submit" class="btn-green">Submit</button>
                </form>
            </div>

        </div>
    </div>

    <?php endif; ?>

    <!-- ========================= ADMIN USER LIST ========================= -->
    <?php if ($_SESSION['role'] === 'admin'): ?>

    <div class="user-management" style="width:100%; margin-top:2rem; margin-bottom:2rem;">
        <h3>Current Users</h3>

        <!-- Search bar for filtering users -->
        <input type="text" id="userSearch" placeholder="Search users..." class="admin-search-input" style="margin-bottom:1rem;">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Company ID</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <?php while ($u = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo htmlspecialchars($u['company_id']); ?></td>
                        <td><?php echo htmlspecialchars($u['username']); ?></td>
                        <td><?php echo htmlspecialchars($u['role']); ?></td>

                        <!-- Edit/Delete buttons -->
                        <td class="action-buttons">
                            <button class="edit-btn" onclick="location.href='user_edit.php?id=<?php echo $u['id']; ?>'">Edit</button>
                            <button class="delete-btn" onclick="if(confirm('Delete this user?')) location.href='user_delete.php?id=<?php echo $u['id']; ?>'">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php endif; ?>

</div>

<!-- Simple JS search filter for the user table -->
<script>
document.getElementById('userSearch')?.addEventListener('input', function() {
    const filter = this.value.toLowerCase();
    const rows = document.querySelectorAll('#userTable tr');
    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>

<?php include 'admin_footer.php'; ?>



































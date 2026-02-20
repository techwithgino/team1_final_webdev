<?php
if (isset($_POST['submit'])) {
    include 'db_connect.php';

        if (!isset($_POST['terms'])) {
            header("Location: contactus.php");
            exit;
        }

    $first_name   = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $email_add    = trim($_POST['email_add']);
    $company_name = !empty($_POST['company_name']) ? trim($_POST['company_name']) : NULL;
    $phone_num    = !empty($_POST['phone_num']) ? trim($_POST['phone_num']) : NULL;
    $message      = trim($_POST['query']);

    $sql = "INSERT INTO `userquery`
    (`first_name`, `last_name`, `email_add`, `company_name`, `phone_num`, `message`)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssss",
        $first_name,
        $last_name,
        $email_add,
        $company_name,
        $phone_num,
        $message
    );

    if ($stmt->execute()) {

        include 'header.php';
        ?>

        <div style="min-height: calc(90vh - 120px); display: flex; flex-direction: column;">
            
            <main style="flex: 1; display: flex; justify-content: center; padding: 4rem 1rem 2rem;">
                <div style="max-width: 800px; width: 100%;">
                    <a href="index.php" class="btn-back">Back to Main</a>
                    
                    <h1>We’ve Received Your Message!</h1>
                    <p>Thank you for contacting CNSS Tech.</p>
                    <p>Our team has received your message and will respond as soon as possible.</p>
                    <p>We appreciate your interest in our services.</p>
                </div>
            </main>

        </div>

        <?php
        include 'footer.php';
        exit;

    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
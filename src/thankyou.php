<!-- I modified this to let this page use only style_index.css file - Gino-->
<?php
$page_css = "css/style_index.css";
include 'header.php';
?>
<!-- 0000000000000000000000000000000000000000000-->

<section class="contact-page">
    <div class="container contact-wrap" style="text-align:center;">

        <div style="
            max-width:700px;
            margin:3rem auto;
            background:#f8fafc;
            padding:3rem 2rem;
            border-radius:16px;
            box-shadow:0 10px 30px rgba(0,0,0,0.08);
        ">

        <div style="min-height: calc(60vh - 120px); display: flex; flex-direction: column;">
            
            <main style="flex: 1; display: flex; justify-content: center; padding: 4rem 1rem 2rem;">
                <div style="max-width: 800px; width: 100%;">
                    
            <h2 style="color:#00887A; margin-bottom:1.5rem;">
                Account Registration Submitted
            </h2>

            <p style="font-size:1.05rem; color:#4b5563; line-height:1.8;">
                Thank you for creating an account with <strong>CNSS Tech</strong>.
                Your registration is currently under review by our team.
            </p>

            <p style="font-size:1.05rem; color:#4b5563; line-height:1.8;">
                You will be notified once your account has been verified and approved.
            </p>

            <div style="margin-top:2.5rem;">
                <a href="index.php" class="btn">Return to Home</a>
            </div>

        </div>

    </div>
    </section>

<?php include 'footer.php'; ?>
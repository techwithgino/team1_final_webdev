<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>CNSS Tech | IT Network and System Services</title>
    <meta name="description" content="CNSS Tech provides professional IT Network & System Services and IT Consultancy in Finland."/>


<!-- I added this part here - Gino -->

<?php if (isset($page_css) && $page_css !== ""): ?>
    <link rel="stylesheet" href="<?php echo $page_css; ?>">
<?php endif; ?>

<!-- Ends here-->


    <link rel="icon" type="image/png" href="images/10_img_logo.PNG">
</head>

<body>
<div class="page-container">

<header>
    <div class="container">
        <div class="brand">
            <a href="index.php">
                <img src="images/10_img_logo.PNG" alt="CNSS Tech Logo" class="logo-blend">
            </a>

            <div class="brand-text">
                <span class="brand-name">CNSS Tech</span>
                <span class="brand-tagline">Driving Business Forward with Technology</span>
            </div>
        </div>

        <div class="navigation">
            <a href="index.php">CNSS Tech</a>
            <a href="index.php#services">Services</a>
            <a href="index.php#solutions">Solutions</a>
            <a href="index.php#about">About</a>
            <a href="contactus.php">Contact</a>
        </div>

        <div class="header-right">
            <div class="signin-wrapper">
                <a href="login.php" class="signin-link">
                    <svg class="signin-icon" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4"></circle>
                        <path d="M4 20c0-4 4-6 8-6s8 2 8 6"></path>
                    </svg>
                    <span class="signin-text">Sign in</span>
                </a>
            </div>

            <div class="language">
                <a href="index.php"><button class="active">EN</button></a>
                <a href="index.php"><button>FI</button></a>
            </div>
        </div>
    </div>
</header>
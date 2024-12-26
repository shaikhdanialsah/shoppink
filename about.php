<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppink | HomePage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/main.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/about.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/commonStyle.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="/shoppink/assets/js/script.js" defer></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

    <!-- Navigation Bar-->
    <?php include "header.php" ?>
    <!-- End of Navigation Bar-->
    <br><br><br><br>

    <div class="animation">  
    <!-- About Us Hero Section -->
    <section class="gridSection">
        <div class="sectionDesc aboutusDesc">
            <h1 class="headline">The Shoppink Oddesey</h1>
            <p class="sub-headline">
            Shoppink PC Essentials specializes in high-quality PC components and accessories. We offer a wide range of products including processors, graphic cards, peripherals, and storage solutions. Our focus is on quality, affordability, and customer satisfaction, providing tech enthusiasts and professionals with top-tier products to enhance their computing experience.
            </p>
        </div>
        <div class="sectionPic bouncepic aboutusPic" id="sectionPic">
            <img src="/shoppink/assets/images/about-hero.png" alt="">
        </div>
    </section>

    <!-- About Us Status -->
    <div class="services">
        <div class="offers">
            <div class="eachOffer">
                <img src="/shoppink/assets/images/fast-forward-icon-white.svg" alt="">
                <div class="offerDesc">
                    <h1>Fast Management</h1>
                    <p>Streamlined operations for swift service and seamless customer experiences.</p>
                </div>
            </div>

            <div class="eachOffer">
                <img src="/shoppink/assets/images/support-agent-icon-white.svg" alt="">
                <div class="offerDesc">
                    <h1>Best Support</h1>
                    <p>Dedicated assistance to ensure your satisfaction and success.</p>
                </div>
            </div>

            <div class="eachOffer">
                <img src="/shoppink/assets/images/progress-warning-icon-white.svg" alt="">
                <div class="offerDesc">
                    <h1>Premium Quality</h1>
                    <p>Elevate your standards with superior craftsmanship and reliability.</p>
                </div>
            </div>
        </div>
    </div>

</div>
    
    <!-- Footer -->
    <?php include "footer.php" ?>
    <!-- End of Footer -->

    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/main.js"></script>
    <script src="/shoppink/assets/js/about.js"></script>
</body>
</html>

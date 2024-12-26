<link rel="stylesheet" href="/shoppink/assets/css/footer.css">
<!-- Footer -->
<footer>
<?php
    if (!isset($_SESSION['username'])) {
?>
    <div class="joinSection">
        <div class="joinDesc">
            <h1 class="sectionHeader">Join with us</h1>
            <p class="sectionPara">
                Once you have created your account, you can purchase products from the website.
            </p>
        </div>
        <button class="btns primaryBtn" onclick="window.location.href='/shoppink/login.php'">JOIN NOW</button>
    </div>
<?php
    }
?>

    
        <div class="footerlinksContainer">
            <div class="footerAboutus">
                <img src="/shoppink/assets/images/logo.png" alt=""style="padding-left: 20px">
            </div>

            <div class="footerlink">
                <h1 class="linkTitle"><a href="/shoppink/index.php">Home</a></h1>
            </div>

            <div class="footerlink">
                <h1 class="linkTitle"><a href="/shoppink/shop.php">Products</a></h1>
            </div>

            <div class="footerlink">
                <h1 class="linkTitle"><a href="/shoppink/about.php">About</a></h1>
            </div>
        </div>

        <div class="footerCopyright">
            <p>&copy; 2024 - Shoppink Sdn Bhd. <br><a class="developedBy">All Rights Reserved</a>.</p>
        </div>
    </footer>
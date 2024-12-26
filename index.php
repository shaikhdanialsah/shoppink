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
    <link rel="stylesheet" href="/shoppink/assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/shoppink/assets/fonts/icomoon/style.css">
    <link rel="stylesheet" href="/shoppink/assets/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="/shoppink/assets/js/script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
  </head>
  <body>
    <!-- Navigation Bar-->
    <?php include "header.php" ?>
    <!-- End of Navigation Bar-->

    <div class="animation">
    <section class="image-generator">
    <div class="content">
      <h1>Welcome to Shoppink</h1>
      <p>Enhance your gaming experience with our latest products</p>
    </div>
  </section>

    <!--Featured Products-->
    <div class="site-section block-3 site-blocks-2 bg-light">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h3 style="color:white">Featured Products</h3>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="nonloop-block-3 owl-carousel">
              <?php
                $q = "SELECT * FROM product ORDER BY productQuantity DESC LIMIT 5;";
                $res = mysqli_query($conn, $q);
                while ($r = mysqli_fetch_assoc($res)) {

              ?>
              <a href="shop-single.php?productID=<?php echo $r['productID']; ?>" style="color:black">
              <div class="item">
                <div class="block-4 text-center" style="height: 350px; display: flex; flex-direction: column; background-color: white;border-radius: 15px;">
                  <figure class="block-4-image" style="display: flex; justify-content: center">
                     <img src="<?php echo $r['productImage']; ?>" class="img-fluid" style="height: 200px; width: auto; object-fit: cover;">
                  </figure>
                  <div class="block-4-text p-4">
                    <h3><?php echo $r['productName'] ?></h3>
                    <p class="text-black">Category: <?php echo $r['productCategory'] ?></p>
                    <p class="text-black">RM <?php echo number_format($r['productPrice'],2)?></p>
                  </div>
                </div>
              </div>
              </a>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--End of Featured Products-->

     <!--Membership Details-->
     <div class="site-section block-3 site-blocks-2 bg-light">
        <div class="row justify-content-center">
          <div class="col-md-7 site-section-heading text-center pt-4">
            <h3 style="color:white">Membership Package</h3><br>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 d-flex justify-content-center">
            <div class="containers">
              <h2 class="title">Bronze Package
              <h3 class="price">RM5<span>/month</span></h3>
              <p class="description">1.5X Reward Points</p><br>
              <!--<b class="offer">Act fast! Offer ends on September 20, 2023.</b> -->
              <!--<a class="subscribe-button" href="#">Subscribe</a>-->
              <div class="ribbon-wrap">
                <div class="ribbon">Bronze Package</div>
              </div>
            </div>
            <div class="containers">
              <h2 class="title">Gold Package
              <h3 class="price">RM20<span>/month</span></h3>
              <p class="description">3X Reward Points+ 500 Initial Reward Points</p>
              <!--<b class="offer">Act fast! Offer ends on September 20, 2023.</b> -->
              <!--<a class="subscribe-button" href="#">Subscribe</a>-->
              <div class="ribbon-wrap">
                <div class="ribbon">Gold Package</div>
              </div>
            </div>
            <div class="containers">
              <h2 class="title">Silver Package
              <h3 class="price">RM10<span>/month</span></h3>
              <p class="description">2X Reward Points</p><br>
              <!--<b class="offer">Act fast! Offer ends on September 20, 2023.</b> -->
              <!--<a class="subscribe-button" href="#">Subscribe</a>-->
              <div class="ribbon-wrap">
                <div class="ribbon">Silver Package</div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </div>
    <!--End of Membership Details-->

    <!-- Footer -->
    <br><br>
    <?php include "footer.php" ?>
    <!-- End of Footer -->
  <script src="/shoppink/assets/js/jquery-3.3.1.min.js"></script>
  <script src="/shoppink/assets/js/owl.carousel.min.js"></script>
  <script src="/shoppink/assets/js/aos.js"></script>
  <script src="/shoppink/assets/js/main.js"></script>
  <script src="/shoppink/assets/js/logout.js"></script>
  <script src="/shoppink/assets/js/alert.js"></script>
  
  </body>
</html>

<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Shoppink | Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
  <link rel="stylesheet" href="/shoppink/assets/css/subscription.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <script src="/shoppink/assets/js/script.js" defer></script>
  <script src="/shoppink/assets/js/subscription.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

  <!-- Navigation Bar-->
  <?php include "../../header.php" ?>
  <!--End of Navigation Bar-->
    <br><br>
  <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / <a class="link" href="/shoppink/view/user/membership.php"><u>My Membership</u></a> / Subscription</p>
  
  <div class="animation">
    <div class="site-wrap">
      <div class="site-section">
        <div class="container">
            <h1>Purchase Subscription</h1>
            <hr>
            <div class="card">
                <!-- Form -->
                <form action="/shoppink/controller/user/profile.php" method="POST" enctype="multipart/form-data">
                    <?php
                    $username = $_SESSION['username'];
                    $sql="SELECT * FROM user WHERE userID = '$username'";
                    $res = mysqli_query($conn, $sql);
                    $r = mysqli_fetch_assoc($res);
                    ?>
                    <h2 style="color:white;text-align:center;">Current membership plan : </h2><br> 
                    <h2 style="color:white;text-align:center;">Step 1: Choose your subscription plan</h2><br> 
                    <div class="membership-plans">
                    <div class="plan-card" id="plan-bronze">
                        <h4 class="plan-title">Bronze</h4>
                        <h4 class="plan-price">RM 5<span>/month</span></h4><br>
                        <ul class="plan-features">
                            <li><b>1.5x Reward Points</b></li>
                        </ul><br><br>
                        <p style="font-size:14px">Valid for 30 days</p>
                        <input class="form-check-input" type="radio" name="plan" value="Bronze II" required>
                    </div>
                    <div class="plan-card" id="plan-silver">
                        <h4 class="plan-title">Silver</h4>
                        <h4 class="plan-price">RM 10<span>/month</span></h4><br>
                        <ul class="plan-features">
                            <li><b>2x Reward Points</b></li>
                        </ul><br><br>
                        <p style="font-size:14px">Valid for 30 days</p>
                        <input class="form-check-input" type="radio" name="plan" value="Silver II" required>
                    </div>
                    <div class="plan-card" id="plan-gold">
                        <h4 class="plan-title">Gold</h4>
                        <h4 class="plan-price">RM 20<span>/month</span></h4><br>
                        <ul class="plan-features">
                            <li><b>3x Reward Points + 500 reward points</b></li>
                        </ul><br>
                        <p style="font-size:14px">Valid for 30 days</p>
                        <input class="form-check-input" type="radio" name="plan" value="Gold II" required>
                    </div>
                </div>

                    <hr><br>
                    <h2 style="color:white;text-align:center;">Step 2: Upload your payment</h2><br>
                    <p>Complete your payment to SHOPPINK SDN BHD at BANK ISLAM <b>088880</b><br>
                    <input type="file" name="paymentproof" id="paymentproof" accept="image/*,application/pdf" style="color:#43c2ed;font-size:15px" required/> 
                    <br><br><hr><br>
                    <div class="infos">
                        <div>
                            <button class="button_save" type="submit" name="changeSubscription">Subscribe</button>
                        </div>
                    </div>
                </form>
                <!-- End of Form -->
            </div>
        </div>
      </div>
    </div> 
  </div>
  <br><br>
<script src="/shoppink/assets/js/logout.js"></script>
<!-- Footer -->
<?php include "../../footer.php" ?>
<!-- End of Footer -->  
</body>
</html>

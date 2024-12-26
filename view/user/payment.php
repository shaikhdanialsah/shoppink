<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppink | Profile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device=width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/profile.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <script src="/shoppink/assets/js/script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

    <!-- Navigation Bar -->
    <?php include "../../header.php" ?>
    <!-- End of Navigation Bar -->

    <br><br>
    <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / <a class="link" href="/shoppink/view/user/checkout.php"><u>Checkout</u></a> / Payment</p>
    <div class="animation">
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <h1 style="display: inline-block;">Payment </h1>
                    <hr>
                    <?php

                    if(isset($_POST['submit']))
                    {
                        $total= $_POST['total'];
                        $userID=$_SESSION['username'];
                    }
                    ?>
                    <!-- Form -->
                    <form action="/shoppink/controller/user/checkoutadd.php" method="POST" enctype="multipart/form-data" id="profile-form">
                        <div class="card">
                            <div class="infos">
                                <div class="name">
                                <p>Complete your payment</p><br>

                                    <p>Total Price : RM <b><?php echo number_format($total,2) ?></b> </p><br>
                                    <p>Please upload your proof of payment to SHOPPINK SDN BHD at Bank Islam <b>0888800</b></p><br>
                                    <label for="receipt">Upload Receipt:</label>
                                    <input type="file" name="paymentproof" id="paymentproof" accept="image/*,application/pdf" style="color:#43c2ed;font-size:16px" required>
                                    <br>
                                    <button class="place-order" name="submit" type="submit">Proceed to payment</button>
                                    <input type="hidden" name="shipname" value="<?php echo $_POST['shipname'] ?>" >
                                    <input type="hidden" name="shipaddress" value="<?php echo $_POST['shipaddress'] ?>" >
                                    <input type="hidden" name="shipnumber" value="<?php echo $_POST['shipnumber'] ?>" >
                                    <input type="hidden" name="totalprice" value="<?php echo $_POST['totalprice'] ?>" >
                                    <input type="hidden" name="total" value="<?php echo $total ?>" >
                                    <input type="hidden" name="usedpoints" value="<?php echo $_POST['usedpoints'] ?>" >
                                    <input type="hidden" name="statusorder" value="<?php echo $_POST['statusorder'] ?>">
                                    <input type="hidden" name="receivepoints" value="<?php echo $_POST['receivepoints'] ?>" >
                                    <input type="hidden" name="userID" value="<?php echo $userID ?>">

                                    
                                </div>
                                <br>
                            </div>
                        </div>
                    </form>
                    <!-- End of Form -->
                </div>
            </div>
        </div>
    </div>
    <br>
    <script src="/shoppink/assets/js/profile.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <!-- Footer -->
    <?php include "../../footer.php" ?>
    <!-- End of Footer -->
</body>
</html>


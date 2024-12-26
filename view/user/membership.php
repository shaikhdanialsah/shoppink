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
    <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / My Membership</p>
    <div class="animation">
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <!-- Informative Icon and Popup -->
                    <h1 style="display: inline-block;">My Subscription <a href="#" class="info-icon" onclick="showInfoPopup()">
                        <i class="fas fa-info-circle"></i> <!-- Adjust the icon class as per your choice -->
                    </a></h1>
                    <hr>
                    <hr>
                    <?php
                    $username = $_SESSION['username'];
                    $sql = "SELECT * FROM user WHERE userID = '$username'";
                    $res = mysqli_query($conn, $sql);
                    $r = mysqli_fetch_assoc($res);
                    ?>
                    <div class="card">
                        <div class="infos">
                            <p class="text"><br>
                                <b>Membership Plan: </b> 
                                <?php 
                                $userID = (int)$_SESSION['username'];
                                $sql = "SELECT * FROM user WHERE userID='$userID'";
                                $result = mysqli_query($conn, $sql);
                                $r = mysqli_fetch_assoc($result);

                                $status = '';
                                $date = '';
                                if ($r['membership'] == 'Bronze' || $r['membership'] == 'Silver' || $r['membership'] == 'Gold') {
                                    $status = 'Active';
                                    $date = $r['finishdate'];
                                } else if ($r['membership'] == 'Bronze II' || $r['membership'] == 'Silver II' || $r['membership'] == 'Gold II') {
                                    $status = 'Waiting for admin approval';
                                    $date = 'Not Available';
                                } else {
                                    $status = 'Inactive';
                                    $date = 'Not Available';
                                }
                                ?>
                                <span class="highlight-advanced"><?php echo $r['membership'] ?></span><br><br><br>
                                <b>Status: </b><?php echo $status ?></p><br><br>
                                <p><b>Valid until: </b><?php echo $date ?></p><br><br>

                                <?php
                                    if($r['paymentproof'])
                                    {
                                ?>
                                    <p><b>Payment proof:  </b><a href="#" onclick="viewPaymentProof('<?php echo $r['filetype']; ?>', '<?php echo base64_encode($r['paymentproof']); ?>')"><u>View Payment Proof</u></a></p>
                                <?php
                                    }
                                    else
                                {
                                ?>
                                    <p><b>Payment proof:  </b> Not Available</p>
                                <?php
                                }
                                ?>
                                
                                <br><br>
                                <?php
                                if ($status == 'Active') {
                                    echo '<button class="button_save" onclick="showAlert()">Change Subscription</button>';
                                } else if($status=='Inactive') {
                                    echo '<button class="button_save" onclick="window.location.href=\'/shoppink/view/user/subscription.php\'" >Buy Subscription</button>';
                                }
                                else
                                {
                                    echo '<button class="button_save disabled-button" onclick="window.location.href=\'/shoppink/view/user/subscription.php\'" disabled>Buy Subscription</button>';
                                }
                                ?>
                            </p>
                            <br>
                            <br>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
    </div>
    <br>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/membership.js"></script>
    
    <!-- Footer -->
    <?php include "../../footer.php" ?>
    <!-- End of Footer -->
</body>
</html>

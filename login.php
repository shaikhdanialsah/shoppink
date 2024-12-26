<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppink | Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/main.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/login.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="/shoppink/assets/js/script.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

    <!-- Navigation Bar-->
    <?php include "header.php" ?>
    <!-- End of Navigation Bar-->
    
    <div class="animation">
        <section>
            <div class="container">
                <div class="user login">
                    <div class="img-box">
                        <img src="/shoppink/assets/images/login.svg" alt="" />
                    </div>
                    <div class="form-box">
                        <form action="/shoppink/controller/loginSignup.php" method="POST" onsubmit="return checkValue()">
                            <div class="form-control">
                                <h2><b>Hello Again!</b></h2>
                                <p>Welcome back you have been missed.</p>
                                <input type="email" name="email" id="email" placeholder="Enter Email Address">
                                <p style="color:red; text-align:left;" id="emailError">&nbsp;</p>
                                <div>
                                    <input type="password" placeholder="Password" id="password" name="password" onkeypress="return event.charCode !== 32"/>
                                    <div class="icon form-icon">
                                        <img src="/shoppink/assets/images/eye.svg" alt=""/>
                                    </div>
                                </div>
                                <p style="color:red; text-align:left;" id="passwordError">&nbsp;</p>
                                <input style="text-align: center;" type="submit" value="Login" name="Login" />
                            </div>
                            <div class="top">
                                <p>Not a member? <span data-id="#ff0066">Register now</span></p>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Register -->
                <div class="user signup">
                    <div class="form-box">
                    <form action="/shoppink/controller/loginSignup.php" method="POST" enctype="multipart/form-data" onsubmit="return validation()">
                            <div class="form-control">
                                <h2><b>Welcome Newbie</b></h2>
                                <p>It's good to have you.</p>
                                <h3>Step 1: Register personal details</h3><br>
                                <input class="form-control form-control-sm" type="text" placeholder="Enter Name" name="name" required id="nameInput">
                                <input class="form-control form-control-sm" type="text" placeholder="Enter Phone" name="phone"  title="Please enter exactly 10 digits" pattern="\d{10}" maxlength="10" required id="phoneInput">
                                <input class="form-control form-control-sm" type="text" placeholder="Enter Address" name="address" required>
                                <input type="email" name="emailRegister" placeholder="Enter Email" required />
                                <div>
                                <input type="password" placeholder="Password" name="passwordRegister" required onkeypress="return event.charCode !== 32" />

                                    <div class="icon form-icon">
                                        <img src="/shoppink/assets/images/eye.svg" alt="" />
                                    </div>
                                </div>
                                
                                <input type="submit" value="Register" name="Register" />
                            </div>
                            <div class="bottom">
                                <p>Already a member? <span data-id="#1a1aff">Login now</span></p>
                            </div>
                        
                    </div>
                    <div class="img-box">
                    <br>
                    <h3 style="text-align:center">Step 2 : Select subscription plan</h3><br>
                    <div class="membership-plans">
                        <div class="plan-card" id="plan-bronze">
                            <h4 class="plan-title">Bronze</h4>
                            <h4 class="plan-price">RM 5<span>/mo</span></h4>
                            <ul class="plan-features">
                                <li><b>1.5X Reward Points</b></li>
                            </ul><br>
                            <p style="font-size:14px">Valid for 30 days</p>
                            <input class="form-check-input" type="radio" name="plan" value="Bronze II" required>
                        </div>
                        <div class="plan-card" id="plan-silver">
                            <h4 class="plan-title">Silver</h4>
                            <h4 class="plan-price">RM 10<span>/mo</span></h4>
                            <ul class="plan-features">
                                <li><b>2x Reward Points</b></li>
                            </ul><br>
                            <p style="font-size:14px">Valid for 30 days</p>
                            <input class="form-check-input" type="radio" name="plan" value="Silver II" required>
                        </div>
                        <div class="plan-card" id="plan-gold">
                            <h4 class="plan-title">Gold</h4>
                            <h4 class="plan-price">RM 20<span>/mo</span></h4>
                            <ul class="plan-features">
                                <li><b>3x Reward Points + 500 reward points</b></li>
                            </ul>
                            <p style="font-size:14px">Valid for 30 days</p>
                            <input class="form-check-input" type="radio" name="plan" value="Gold II" required>
                        </div>
                    </div>
                    <div class="membership-header">
                        <h3>Step 3 : Complete Payment</h3><br>
                        <p>Please upload your payment to SHOPPINK SDN BHD at Bank Islam <b>088000</b></p><br>
                        <span> Payment Receipt:</span><br><input type="file" name="paymentproof" id="paymentproof" accept="image/*,application/pdf" style="font-size:15px;text-align-last: center;" required>
                    </div>
                </div>

                    </form>
                </div>
            </div>
            
        <br><br>
        </section>
    </div>
    <?php include "controller/loginValidate.php" ?>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/alert.js"></script>
    <script src="/shoppink/assets/js/loginSignup.js"></script>

</body>

</html>

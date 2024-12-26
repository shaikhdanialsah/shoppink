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
    <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / Profile</p>
    <div class="animation">
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <h1 style="display: inline-block;">My Profile </h1>
                    <hr>
                    <?php
                        $username = $_SESSION['username'];
                        $sql = "SELECT * FROM user WHERE userID = '$username'";
                        $res = mysqli_query($conn, $sql);
                        $r = mysqli_fetch_assoc($res);
                    ?>
                    <!-- Form -->
                    <form action="/shoppink/controller/user/profile.php" method="POST" enctype="multipart/form-data" id="profile-form">
                        <div class="card">
                            <div class="imgs">
                                <img src="<?php echo $imagePath ?>" id="profile-pic" >
                                <div class="description">
                                    <input type="file" id="file-input" name="profile_pic" accept="image/*"><br>                                
                                </div>
                                <br>
                                <div class="description">
                                    <p>Reward points:</p><br>
                                    <span class="highlight-advanced-points"><?php echo (double) $r['points'] ?></span>
                                </div>
                            </div>
                            <div class="infos">
                                <div class="name">
                                    <p>
                                        <b>Email / Username <a href="#" class="info-icon" onclick="showInfoPopup()">
                                        <i class="fas fa-info-circle"></i></a>:</b>
                                        <br> 
                                        <input type="email" value="<?php echo $r['email'] ?>" name="email" readonly class="inputs" style="background-color:grey">
                                        <br>
                                    <p><b>Name:</b><br> <input type="text" value="<?php echo strtoupper($r['name']) ?>" name="name" required class="inputs" id="nameInput"></p> 
                                    <b>Phone Number:</b><br> <input type="text" value="<?php echo $r['phone'] ?>" name="phone" title="Please enter exactly 10 digits" pattern="\d{10}" maxlength="10" required class="inputs" id="phoneInput"></p>
                                </div>
                                <p class="text">
                                    <b>Address:</b><br>
                                    <textarea rows="2" cols="50" name="address" required class="inputs"><?php echo htmlspecialchars($r['address']); ?></textarea>
                                </p>
                                <br>
                                <a href="/shoppink/view/user/password.php"><span><u>Change password</u></span></a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="/shoppink/view/user/membership.php"><span><u>View subscription</u></span></a>
                                <br><br>
                                <div>
                                    <button class="button_save disabled-button" type="submit" name="submit" id="save-button" disabled>Save</button>
                                </div>
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


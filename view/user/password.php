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
  <link rel="stylesheet" href="/shoppink/assets/css/password.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <script src="/shoppink/assets/js/script.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

  <!-- Navigation Bar-->
  <?php include "../../header.php" ?>
  <!--End of Navigation Bar-->
    <br><br>
  <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / <a class="link" href="/shoppink/view/user/profile.php"><u>Profile</u></a> / Password</p>
  
  <div class="animation">
    <div class="site-wrap">
      <div class="site-section">
        <div class="container">
            <h1>Change password</h1>
            <hr>
            <div class="card">
                <!-- Form -->
                <form action="/shoppink/controller/user/profile.php" method="POST" onsubmit="return checkOldPassword()" id="password-form">
                <?php
                $username = $_SESSION['username'];
                $sql = "SELECT * FROM user WHERE userID = '$username'";
                $res = mysqli_query($conn, $sql);
                $r = mysqli_fetch_assoc($res);
                ?>    
    <div class="infos">
        <div class="name">
            <br>
            <div>
                <p><b>Old password:</b></p>
                <div class="input-container">
                    <input type="password" name="old_password" id="old_pass" required class="inputs" onkeypress="return event.charCode !== 32">
                    <div class="eye-icon">
                        <img src="/shoppink/assets/images/eye.svg" alt="eye icon">
                    </div>
                </div>
            </div> 
            <span id="oldpassword" style="display:none"><?php echo htmlspecialchars($r['password']); ?></span>
            <span style="color:red" id="error"></span><br>
            <div>
                <p><b>New password:</b></p>
                <div class="input-container">
                    <input type="password" name="new_password" id="new_password" required class="inputs" onkeypress="return event.charCode !== 32">
                    <div class="eye-icon">
                        <img src="/shoppink/assets/images/eye.svg" alt="eye icon">
                    </div>
                </div>
                <span style="color:red" id="errorNew"></span><br>
            </div> 
        </div>
        <br>
        <div>
            <button class="button_save" type="submit" name="submitPassword" id="save-button">Change password</button>
        </div>
    </div>
</form>

<!-- End of Form -->
</div>
</div>
</div>
</div> 
</div>
<script src="/shoppink/assets/js/logout.js"></script>
<script src="/shoppink/assets/js/password.js"></script>
<script src="/shoppink/assets/js/main.js"></script>
<!-- Footer -->
<?php include "../../footer.php" ?>
<!-- End of Footer -->  
</body>
</html>

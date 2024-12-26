<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
if (!$_SESSION['username']) {
    header("Location: /shoppink/login.php");
    exit();
}

if (isset($_POST["customerProfile"])) {
    $userID = $_POST["userID"];
    $sql = "SELECT * FROM user WHERE userID='$userID'";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
} else if(isset($_GET['userID'])) {
    $userID = $_GET["userID"];
    $sql = "SELECT * FROM user WHERE userID='$userID'";
    $result = mysqli_query($conn, $sql);
    $r = mysqli_fetch_assoc($result);
}
else
{
    header("Location: /shoppink/view/admin/manage_customer.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shoppink</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="/shoppink/assets/css/admin.css">
    <link rel="stylesheet" href="/shoppink/assets/css/manageCustomer.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
    
</head>

<body class="custom-body">
    <!-- =============== Navigation ================ -->
    <div class="custom-container">
        <!--Navigation menu -->
        <?php include "navigation_menu.php" ?>

        <!-- ========================= Main ==================== -->
        <div class="custom-main">
            <div class="custom-topbar">
                <div class="custom-toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="custom-customer">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Customer Profile</h2>
                    </div>

                    
                    <form method="post" action="/shoppink/controller/admin/adminMembership.php" enctype="multipart/form-data" id="membershipForm" onsubmit='confirmation(event)'>
                        <div class="card-footer border-0 py-5">
                                <div class="row mb-5 gx-5">
                                    <div class="col-xxl-8 mb-5 mb-xxl-0">
                                        <div class="bg-secondary-soft px-4 py-5 rounded">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Name</label>
                                                    <input type="text" name="name" class="form-control" value="<?php echo strtoupper($r['name']) ?>" style="font-size: 16px; border: 1px solid black; background-color: #e7eaf0; cursor: not-allowed;" readonly>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Phone Number</label>
                                                    <input type="text" name="phone" class="form-control" value="<?php echo $r['phone'] ?>" style="font-size: 16px; border: 1px solid black;background-color: #e7eaf0; cursor: not-allowed;" readonly>
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="form-label" style="font-size: 20px;">Address</label>
                                                    <textarea name="address" class="form-control" style="font-size: 16px; border: 1px solid black; cursor: not-allowed;" readonly><?php echo $r['address'] ?></textarea>
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?php echo $r['email'] ?>" style="font-size: 16px; border: 1px solid black; background-color: #e7eaf0; cursor: not-allowed;" readonly>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Password</label>
                                                    <div class="input-group">
                                                        <input type="password" name="password" class="form-control" value="<?php echo $r['password'] ?>" style="font-size: 16px; border: 1px solid black; cursor: not-allowed;" id="passwordInput" readonly>
                                                        <span class="input-group-text" id="togglePassword" style="border: 1px solid black;">
                                                            <i class="bi bi-eye" style="cursor: pointer;" onclick="togglePasswordVisibility()"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <br><hr>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Membership</label>
                                                    <select name="membership" class="form-select" style="font-size: 16px; border: 1px solid black;" required>
                                                    <option value=""><?php echo $r['membership'] ?></option>
                                                    <?php
                                                        if ($r['membership'] == 'Gold' || $r['membership'] == 'Silver' || $r['membership'] == 'Bronze') {
                                                    ?>
                                                        <option value="Inactive">Inactive</option>
                                                    <?php
                                                        }
                                                    ?>
                                                        
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label" style="font-size: 20px;">Valid until</label>
                                                    <input name="finishdate" class="form-control" value="<?php echo $r['finishdate'] ?>" style="font-size: 16px; border: 1px solid black; background-color: #e7eaf0; cursor: not-allowed;" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xxl-4">
                                        <div class="bg-secondary-soft px-4 py-5 rounded">
                                            <div class="row g-3">
                                                <h4 class="mb-4 mt-0" style="text-align: center; font-size: 25px;">Profile Photo</h4>
                                                <div class="text-center">

                                                    <!-- Rounded profile picture -->
                                                     <!--<div class="rounded-circle overflow-hidden mx-auto mb-3" style="width: 270px; height: 270px;">
                                                        <img id="profileImage" src="data:image/jpeg;base64," alt="Profile Image" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                                    </div>-->

                                                    <?php
                                                        $imageData = $r['profile_pic'];
                                                        $imagePath = '';
                                                        if ($imageData != '') {
                                                            $imagePath = $r['profile_pic'];
                                                        } else {
                                                            $imagePath = "/shoppink/assets/images/profile.jpg";
                                                        }
                                                    ?>

                                                    <div class="overflow-hidden mx-auto mb-3" style="width: 250px; height: 240px; border: 2px solid black; border-radius: 15px;">
                                                        <img id="profileImage" src="<?php echo $imagePath ?>" alt="Profile Image" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="gap-5 d-md-flex justify-content-md-left text-center mx-auto" style="padding-left: 20px">
                                    <a href="javascript:window.history.back();">
                                        <button type="button" class="btn btn-primary btn-lg">Back</button>
                                    </a>
                                    <input type="hidden" name="userID" value="<?php echo $r['userID'] ?>">

                                    <?php
                                        if ($r['membership'] == 'Gold' || $r['membership'] == 'Silver' || $r['membership'] == 'Bronze') {
                                    ?>
                                        <input type="hidden" name='updateMembership'>
                                        <button type='submit' class='btn btn-lg' style='background-color: #5cb85c; color: #ffffff;' >Update Membership</button>
                                    <?php
                                            
                                        }
                                    ?>
                                    
                                    <!--<button type="button" data-toggle="modal" data-target="#confirmationModal" class="btn btn-danger btn-lg" data-email="">Delete profile</button>-->
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- =========== Scripts =========  -->
    <script src="/shoppink/assets/js/admin.js"></script>
    <script src="/shoppink/assets/js/alertAdmin.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/customer_profile.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

<div class="custom-navigation">
            <ul>
                <li>
                    <a href="admin.php">
                        <span class="custom-icon-image">
                        <img src="/shoppink/assets/images/logo_2.png">
                        </span>
                        <span class="custom-title">Shoppink</span>
                    </a>
                </li>

                <li >
                    <a href="admin.php" class="active_navigation">
                        <span class="custom-icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="custom-title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="manage_customer.php">
                        <span class="custom-icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="custom-title">Customers</span>
                    </a>
                </li>

                <li>
                    <a href="manage_product.php">
                        <span class="custom-icon">
                            <ion-icon name="cart-outline"></ion-icon>
                        </span>
                        <span class="custom-title">Product</span>
                    </a>
                </li>

                <li>
                    <a href="admin_order.php">
                        <span class="custom-icon">
                            <ion-icon name="receipt-outline"></ion-icon>
                        </span>
                        <span class="custom-title">Order</span>
                    </a>
                </li>

                <li>
                    <a href="admin_membership.php">
                        <span class="custom-icon">
                            <ion-icon name="time-outline"></ion-icon>
                        </span>
                        <span class="custom-title">Pending Membership</span>
                    </a>
                </li>

                <!--<li>
                    <a href="#">
                        <span class="custom-icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="custom-title">??</span>
                    </a>
                </li> -->

                <li>
                    <a href="#" id="logoutLink">
                        <span class="custom-icon" style="color: red;">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="custom-title" style="color: red;">Sign Out</span>
                    </a>
                </li>
                
            </ul>
        </div>

    <!-- Toast Message -->
<?php
    $icon = "fas fa-solid fa-check";
    if (isset($_GET['alert'])) {
    

    if ($_GET['alert'] == 'success') {
      $alertMessage = 'success';
    } else if ($_GET['alert'] == 'productEdit') {
        $alertMessage = 'productEdit';
    } 
    else if ($_GET['alert'] == 'verify') {
        $alertMessage = 'verify';
    } 
    else if ($_GET['alert'] == 'memberUpdate') {
        $alertMessage = 'memberUpdate';
    } 
    else if ($_GET['alert'] == 'delete') {
        $alertMessage = 'delete';
    } 
    else if ($_GET['alert'] == 'productAdd') {
        $alertMessage = 'productAdd';
    } 
    else if ($_GET['alert'] == 'error') {
        $alertMessage = 'error';
        $icon = "fas fa-solid fa-times";
    }
    echo "<div id='alert' style='display:none;'>$alertMessage</div>";
?>
    <div class="toast style='display:none'">
        <div class="toast-content">
            <i class="<?php echo $icon; ?> check" id="errorIcon"></i>
            <div class="message">
                <span class="text text-1" id="toastTitle">Success</span>
                <span class="text text-2" id="toastMessage"></span>
            </div>
        </div>
        <i class="fa-solid fa-xmark close"></i>
        <div class="progress"></div>
    </div>
<?php
}
?>
<!--End of Toast Message -->
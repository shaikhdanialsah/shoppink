<?php
   require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
   session_start();
    $inactive = 1800;

    // Check if the session variable for the last activity is set
    if (isset($_SESSION['last_activity'])) {
        // Calculate the session's lifetime
        $session_lifetime = time() - $_SESSION['last_activity'];
        
        // If the session has been inactive for too long, destroy it
        if ($session_lifetime > $inactive) {
            session_unset();    // Unset session variables
            session_destroy();  // Destroy the session
        }
    }

    // Update the last activity time stamp
    $_SESSION['last_activity'] = time();

    function getCurrentPage() {
        // Retrieve the current script name
        return basename($_SERVER['PHP_SELF']);
    }
    
    $current_page = getCurrentPage();

    if(isset($_SESSION['username']))
    {
        $cartID = (int)$_SESSION['cartID'];
        $query = "SELECT * FROM cartdetails JOIN product ON cartdetails.productID =product.productID WHERE cartdetails.cartID='$cartID' AND product.productQuantity>0 ";
        $res = mysqli_query($conn, $query);

        // Check if there are any rows returned
        $rowCount = mysqli_num_rows($res);
    }
    
?>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/shoppink/assets/js/search.js"></script>
    <script src="/shoppink/assets/js/alert.js"></script>
</head>

<nav class="nav">

    <?php

        $name="";

        if(getCurrentPage()=='index.php')
        {
            $name="Homepage";
        }

        else if(getCurrentPage()=='shop.php' || getCurrentPage()=='shop-single.php')
        {
            $name="Products";
        }
        else if(getCurrentPage()=='about.php')
        {
            $name="About Us";
        }

        else if(getCurrentPage()=='cart.php')
        {
            if(!$_SESSION['username'])
            {
                header("Location: /shoppink/login.php");
                exit();
            }
            $name="My Cart";
        }

        else if(getCurrentPage()=='profile.php'||getCurrentPage()=='password.php'||getCurrentPage()=='subscription.php'||getCurrentPage()=='membership.php')
        {
            $name ="My Profile";
            if(!$_SESSION['username'])
            {
                header("Location: /shoppink/login.php");
                exit();
            }
        }

        else if(getCurrentPage()=='purchases.php'||getCurrentPage()=='order.php')
        {
            if(!$_SESSION['username'])
            {
                header("Location: /shoppink/login.php");
                exit();
            }
            $name="My Purchases";
        }

        else if(getCurrentPage()=='login.php')
        {
            $name ="Login";
        }

        else if(getCurrentPage()=='checkout.php')
        {
            if(!$_SESSION['username'])
            {
                header("Location: /shoppink/login.php");
                exit();
            } else
            {
                $userID = $_SESSION['username'];
                $sql="SELECT * FROM user WHERE userID ='$userID'";
                $result =mysqli_query($conn,$sql);
                $r=mysqli_fetch_assoc($result);

                $membership = ['Gold', 'Silver', 'Bronze'];
                if (!in_array($r['membership'], $membership)) {
                    header("Location: /shoppink/view/user/cart.php");
                    exit();
                }
            }
            $name ="Checkout";
        }
    ?>
    <a href="/shoppink/index.php" class="logo" id="title">Shoppink | <?php echo $name ?></a>

    <div class="search-box">
        <input id="query" name="query" type="text" placeholder="Search here..." autocomplete="off" />
        <div id="results-container" class="results-container"></div>
    </div>
    
    

    <ul class="nav-links">
        <i class="uil uil-times navCloseBtn"></i>
        <li class="dropdown <?php echo $current_page == 'index.php' ? 'active' : ''; ?>">
            <a class="<?php echo $current_page == 'index.php' ? 'actives' : ''; ?>" href="/shoppink/index.php"><?php echo $current_page == 'index.php' ? '<b>Home</b>' : 'Home'; ?></a>
        </li>
        
        <?php if(getCurrentPage()=='shop.php'||getCurrentPage()=='shop-single.php')
        {
            echo "<li class='dropdown active'><a class='actives' href='/shoppink/shop.php'><b>Products</b></a></li>";
        
        }
        else
        {
            echo "<li class='dropdown'><a href='/shoppink/shop.php'>Products</a></li>";
        }
        ?>
        <li class="dropdown <?php echo $current_page == 'about.php' ? 'active' : ''; ?>">
            <a class="<?php echo $current_page == 'about.php' ? 'actives' : ''; ?>" href="/shoppink/about.php"><?php echo $current_page == 'about.php' ? '<b>About Us</b>' : 'About Us'; ?></a>
        </li>

        <?php if (isset($_SESSION['username'])): ?>
        <li class="dropdown <?php echo $current_page == 'cart.php' ? 'active' : ''; ?>">
            <a href="/shoppink/view/user/cart.php" class="cart-icon <?php echo $current_page == 'cart.php' ? 'actives' : ''; ?>">
                <i class="uil uil-shopping-cart "></i>
                <span class="cart-count"><?php echo $rowCount; ?></span>
            </a>
        </li>
        <li class="dropdown <?php echo in_array($current_page, ['profile.php', 'purchases.php','password.php','order.php','subscription.php','membership.php']) ? 'active' : ''; ?>">
            <a href="/shoppink/view/user/profile.php" class="dropdown-toggleclass">
            <?php
                    $userid=$_SESSION['username'];
                    $sql="SELECT * FROM user WHERE userID ='$userid'";
                    $resu = mysqli_query($conn, $sql);
                    $r = mysqli_fetch_assoc($resu);

                    $imageData = $r['profile_pic'];
                    $imagePath='';
                    if($imageData!='')
                    {
                        $imagePath = $r['profile_pic'];
                    }
                    else
                    {
                        $imagePath="/shoppink/assets/images/profile.jpg";
                    }
                    
                ?>
                <img src="<?php echo $imagePath ?>" alt="Profile Picture" class="profile-pic">
                <span style="color: #f3eeee;">
                    <?php echo in_array($current_page, ['profile.php', 'purchases.php','password.php','order.php','subscription.php','membership.php']) ? '<span style="color:#00BBFF"><b>'.$_SESSION['name'].'</b></span>' : '<b>'.$_SESSION['name'].'</b>'; ?>
                </span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="/shoppink/view/user/profile.php"><?php echo in_array($current_page, ['profile.php','password.php']) ? '<span style="color:#00BBFF"><b>My Profile</b></span>' : 'My Profile'; ?></a></li>
                <li><a href="/shoppink/view/user/membership.php"><?php echo in_array($current_page, ['membership.php','subscription.php']) ? '<span style="color:#00BBFF"><b>My Subscription</b></span>' : 'My Subscription'; ?></a></li>
                <li><a href="/shoppink/view/user/purchases.php"><?php echo in_array($current_page, ['purchases.php','order.php']) ? '<span style="color:#00BBFF"><b>My Purchases</b></span>' : 'My Purchases'; ?></a></li>
                <li><a href="#" id="logoutLink">Log Out</a></li>
            </ul>
        </li>
        <?php else: ?>
            <li class="dropdown <?php echo $current_page == 'login.php' ? 'active' : ''; ?>">
                    <a class="<?php echo $current_page == 'login.php' ? 'actives' : ''; ?>" href="/shoppink/login.php"><?php echo $current_page == 'login.php' ? '<b>Login</b>' : 'Login'; ?></a>
                </li>
        <?php endif; ?>
        
    </ul>
</nav>
<br><br>
<!-- Toast Message -->
    <?php
        $icon = "fas fa-solid fa-check";
        if (isset($_GET['alert'])) {
            $name = "";
        if(getCurrentPage()!="login.php")
        {
            $name = $_SESSION['name'];
        }

        if ($_GET['alert'] == 'success') {
            $alertMessage = 'success';
        }else if ($_GET['alert'] == 'register') {
            $alertMessage = 'register';
        } 
        else if ($_GET['alert'] == 'add') {
            $alertMessage = 'add';
        } else if ($_GET['alert'] == 'delete') {
            $alertMessage = 'delete';
        }
        else if ($_GET['alert'] == 'successlogout') {
            $alertMessage = 'successlogout';
        }
        else if ($_GET['alert'] == 'save') {
         $alertMessage = 'save';
        }
        else if ($_GET['alert'] == 'ordersuccess') {
            $alertMessage = 'ordersuccess';
        }
        else if ($_GET['alert'] == 'subscription') {
            $alertMessage = 'subscription';
        }

        else if ($_GET['alert'] == 'error') {
            $alertMessage = 'error';
            $icon = "fas fa-solid fa-times";
        }

        echo "<div id='alert' style='display:none;'>$alertMessage</div>";
        echo "<div id='name' style='display:none;'>$name</div>";
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


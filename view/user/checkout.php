<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit();
}

$userID = $_SESSION['username'];
$cartID = (int)$_SESSION['cartID']; // Ensure $cartID is cast to an integer for security

// Fetch user details
$q = "SELECT * FROM user WHERE userID = '$userID'";
$res = mysqli_query($conn, $q);
$user = mysqli_fetch_assoc($res);

// Fetch cart details
$query = "SELECT cartdetails.*, product.* 
          FROM cartdetails 
          JOIN product ON cartdetails.productID = product.productID 
          WHERE cartdetails.cartID = $cartID
          AND product.productQuantity>0";
$cartItems = mysqli_query($conn, $query);

$totalPrice = 0.0;
while ($item = mysqli_fetch_assoc($cartItems)) {
    $totalPrice += (double)$item['productPrice'] * (int)$item['itemcount'];
}

$points = (double)$user['points'];
$pointsRM = $points / 100;
$usePoints = ($pointsRM > $totalPrice) ? $totalPrice * 100 : $points;

$membershipMultiplier = 1;
switch ($user['membership']) {
    case 'Bronze':
        $membershipMultiplier = 1.5;
        break;
    case 'Silver':
        $membershipMultiplier = 2;
        break;
    case 'Gold':
        $membershipMultiplier = 3;
        break;
}
$pointsReceived = $totalPrice * $membershipMultiplier;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shoppink | View Cart</title>
    <link rel="stylesheet" href="/shoppink/assets/css/checkout.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
    <style>
        .inputs.editable {
            background-color: #e8ecee;
            color:black;
            border: 1px solid grey;
        }
    </style>
</head>

<body>
    <!-- Navigation Bar-->
    <?php include "../../header.php" ?>
    <!-- End of Navigation Bar-->
    <span style="color:white"><a href="/shoppink/view/user/cart.php">&nbsp;&nbsp;<u>Return</u></a></span>
    <div class="animation">
        <div class="site-wrap">
            <form action="/shoppink/view/user/payment.php" method="POST" enctype="multipart/form-data" id="checkout-form">
                <div class="checkout-container">
                    <div class="left">
                        <h2>Checkout</h2><br>
                        <p>Billing information</p>
                        <div class="billing-info">
                            <input type="text" placeholder="First name" class="inputs" value="<?php echo strtoupper($user['name']) ?>" name="shipname" readonly>
                            <input type="text" placeholder="Billing address" class="inputs" value="<?php echo $user['address'] ?>" name="shipaddress" readonly>
                            <input type="text" placeholder="Phone Number" style="width: 50%;" class="inputs" value="<?php echo $user['phone'] ?>" name="shipnumber" readonly>
                            <button type="button" id="edit-button" onclick="toggleEdit()" class="save">Edit</button><br>
                            <h2>Reward Points</h2><br>
                            Current Subscription: <b><?php echo $user['membership']?></b><br>
                            Current Reward Points: <b><?php echo $points ?></b><br>
                            <span style="color:#43c2ed">Reward points received for this purchase (<?php echo $membershipMultiplier ?>x) : +<?php echo $pointsReceived ?></span><br><br>

                            <?php if ($points > 0): ?>
                                <?php if (($points / 100) > $totalPrice): ?>
                                    Use reward points (<span id="usepoints"><?php echo ($totalPrice * 100); ?></span>)
                                <?php else: ?>
                                    Use reward points (<span id="usepoints"><?php echo $points; ?></span>)
                                <?php endif; ?>
                                <label class="switch">
                                    <input type="checkbox" id="checkbox" onchange="toggleSwitch()">
                                    <span class="slider round"></span>
                                </label>
                            <?php endif; ?>

                        </div>
                    </div> 
                    <div class="right">
                        <div class="order-summary">
                            <h2>Order summary</h2>
                            <br>
                            <div class="order-items-container">
                                <?php
                                mysqli_data_seek($cartItems, 0);
                                while ($item = mysqli_fetch_assoc($cartItems)):
                                ?>
                                <div class="order-item">
                                    <img src="<?php echo $item['productImage']; ?>" alt="Product Image">
                                    <div class="product-details">
                                        <h3><?php echo $item['productName'] ?></h3>
                                        <p class="price-details-s">
                                            RM <?php echo number_format($item['productPrice'], 2) ?> x <?php echo $item['itemcount'] ?>
                                            <span class="total-price-s">Total: RM <?php echo number_format($item['productPrice'] * $item['itemcount'], 2) ?></span>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <?php endwhile; ?>
                            </div>
                            <br>
                            <div class="price-details">
                                <p data-label="Total Price" data-value="RM <?php echo number_format($totalPrice, 2) ?>"></p>
                                <p class="discount" data-label="Discount Price" data-value="- RM 0.00"></p>
                                <p data-label="Shipping Fee" data-value="RM 4.90"></p>
                                <hr>
                                <p class="total" data-label="Total Sum" data-value="RM <?php echo number_format($totalPrice+4.9, 2) ?>"></p>
                            </div>
                        </div>
                        <button class="place-order" name="submit" type="submit">Proceed to payment</button>
                    </div>
                </div>
                <!-- Input values -->
                <span id="totalpriceRM" style="display:none"><?php echo $totalPrice ?></span>
                <input type="hidden" name="totalprice" id="totalprice" value="<?php echo $totalPrice ?>" >
                <input type="hidden" name="usedpoints" id="usedpoints" value="0">
                <input type="hidden" name="total" id="total" value="<?php echo $totalPrice+4.9?>">
                <input type="hidden" name="receivepoints" value="<?php echo $pointsReceived ?>">
                <input type="hidden" name="statusorder" value="Waiting for seller to approve">
                <input type="hidden" name="userID" value="<?php echo $userID ?>">
                <!--End of Input values -->
            </form>
        </div>
    </div>
    <!-- Footer -->
    <?php include "../../footer.php" ?>
    <!-- End of Footer -->   
    <script src="/shoppink/assets/js/checkout.js" defer></script>
    <script src="/shoppink/assets/js/main.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/script.js" defer></script>
</body>
</html>

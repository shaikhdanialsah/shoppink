<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shoppink | View Cart</title>
    <link rel="stylesheet" href="/shoppink/assets/css/cart.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="/shoppink/assets/js/script.js" defer></script>
    <script src="/shoppink/assets/js/alert.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

    <!-- Navigation Bar-->
    <?php 
        include "../../header.php";
        //SQL operation from cart table
        $cartID = (int)$_SESSION['cartID'];
        $query = "SELECT cartdetails.*, product.* 
                FROM cartdetails 
                JOIN product ON cartdetails.productID = product.productID 
                WHERE cartdetails.cartID = $cartID
                AND product.productQUantity>0";
        $res = mysqli_query($conn, $query);

        //SQL operation from user table
        $userID = (int)$_SESSION['username'];
        $sql = "SELECT * FROM user WHERE userID ='$userID'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
    ?>
    <!-- End of Navigation Bar-->
    <br><br>
    <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / My Cart</p>

    <div class="animation">
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <div class="row mb-5">
                        &nbsp;&nbsp;<h1>Cart List</h1>
                        <div class="site-blocks-table">
                            <br><br>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="product-thumbnail">Image</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-total">Total</th>
                                        <th class="product-remove">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php
                                    if (mysqli_num_rows($res) > 0) {
                                        while ($r = mysqli_fetch_assoc($res)) { 
                                    ?>
                                            <tr>
                                                <td class="product-thumbnail">
                                                    <img src="<?php echo $r['productImage']; ?>" class="img-fluid">
                                                </td>
                                                <td class="product-name" data-product-id="<?php echo $r['productID']; ?>">
                                                    <h2><a class="product-link-black" href="/shoppink/shop-single.php?productID=<?php echo $r['productID']; ?>"><u><?php echo $r['productName'] ?></u></a></h2>
                                                </td>
                                                <td>RM <span id="product-price"><?php echo $r['productPrice'] ?></span></td>
                                                <td>
                                                    <div style="display: inline-block;">
                                                        <div class="input-group mb-3" style="max-width: 120px;">
                                                            <div class="input-group-prepend">
                                                                <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                                            </div>
                                                            <input type="text" class="form-control text-center" value="<?php echo $r['itemcount'] ?>" style="height: 35px;" readonly>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                                            </div>
                                                        </div>
                                                        <span class="item-left"><b><?php echo $r['productQuantity'] ?> items left</b></span>
                                                    </div>
                                                </td>
                                                <td>RM <span id="total-product-price"></span></td>
                                                <form action="/shoppink/controller/user/cart/cart_delete.php" method="post">
                                                    <td><button type="submit" class="btn btn-primary btn-sm" name="delete">X</button></td>
                                                    <input type="hidden" value="<?php echo $r['productID'] ?>" name="productID">
                                                </form>
                                            </tr>
                                    <?php
                                        }
                                    } else {
                                    ?>
                                        <tr>
                                            <td colspan="6">Ooops...seems like your shopping cart is empty</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <button class="btn btn-primary" onclick="window.location='/shoppink/shop.php'">Continue Shopping</button>
                            </div>
                        </div>
                        <div class="row">
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <span class="text-black">Subtotal <span id="total-item"></span> : <b>RM <span id="total-price"></span></b>
                                    </div>
                                    <br><br>

                                    <?php
if (mysqli_num_rows($res) > 0) {
    if (trim($row['membership']) == 'Bronze' || trim($row['membership']) == 'Silver' || trim($row['membership']) == 'Gold') {
?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='/shoppink/view/user/checkout.php'">Proceed To Checkout</button>
            </div>
        </div>
<?php
    } elseif (trim($row['membership']) == 'Inactive') {
?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg py-3 btn-block" onclick="checkoutalert1()">Proceed To Checkout</button>
            </div>
        </div>
<?php
    } else {
?>
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-primary btn-lg py-3 btn-block" onclick="checkoutalert2()">Proceed To Checkout</button>
            </div>
        </div>
<?php
    }
 } else {
                                    ?>
                                        <p class="text-black">There are no items in your cart to proceed for checkout.</p><br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary btn-lg py-3 btn-block" onclick="window.location='/shoppink/view/user/checkout.php'" disabled>Proceed To Checkout</button>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Closing the container div -->
                </div> <!-- Closing the site-section div -->
            </div> <!-- Closing the site-wrap div -->
        </div>
    </div>
    <!-- Footer -->
    <br><br>
    <?php include "../../footer.php" ?>
    <!-- End of Footer -->
    <script src="/shoppink/assets/js/cart.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
</body>
</html>

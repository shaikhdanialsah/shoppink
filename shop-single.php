<?php
if(!isset($_GET['productID']))
{
    header("Location: /shoppink/shop.php");
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Shoppink | Product Details</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>View Cart</title>
    <link rel="stylesheet" href="/shoppink/assets/css/shop-single.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="/shoppink/assets/js/script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
    
  </head>
  <body>

    <!-- Navigation Bar-->
    <?php include "header.php" ?>
    <br><br>
    <!--End of Navigation Bar-->

    &nbsp; <span style="font-size: 17px;"> <a href="javascript:window.history.back();" class="link"><u>Return</u></a>
    </span>
    <div class="animation">  
        <br>
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">

                <?php
                    $productID=$_GET['productID']; 
                    $q = "SELECT * FROM product WHERE productID='$productID'";
                    $res = mysqli_query($conn, $q);
                    $r = mysqli_fetch_assoc($res);
                    $direct="controller/user/cart/cart_add.php";

                    if(!isset($_SESSION['username']))
                    {
                        $direct= "/shoppink/login.php";  
                    }
                ?>
                <form action="<?php echo $direct;?>" method="post">
                    <div class="row">
                        <div class="col-md-60" >
                        <img src="<?php echo $r['productImage']; ?>" class="img-fluid uniform-image">
                        </div>
                        <div class="col-md-61">
                            <h2 class="text-black"><?php echo $r['productName'] ?></h2>
                            <input type="hidden" name="productID" value="<?php echo $r['productID'] ?>">
                            <p class="mb-4-text"><?php echo $r['productDescription'] ?></p><br>
                            <p class="mb-4-text"><span id="productQuantity"><?php echo $r['productQuantity'] ?></span> items left</p>
                            
                <?php 
                if(isset($_SESSION['username']))
                {
                    $cartID = $_SESSION['cartID'];
                    $query = "SELECT * FROM cartdetails WHERE productID='$productID' AND cartID = '$cartID'";
                    $result = mysqli_query($conn, $query);
                    $ro = mysqli_fetch_assoc($result);
    
                    if(mysqli_num_rows($result) > 0) {
                
                ?>
                    <br>
                    <p class="mb-4-text">You already have <b><span id="itemcart_total"><?php echo $ro['itemcount'] ?></span> item of this product</b> in your cart</p><br>

                <?php
                } 
                else echo "<span id='itemcart_total' style='display:none'>0</span>";
                
                ?>
                    
                <?php
                }
                else
                    echo "<span id='itemcart_total' style='display:none'>0</span>";
                ?>

                <br>
                <h2>RM <?php echo number_format($r['productPrice'], 2) ?></h2>
                <br>
                
                <?php

                if(isset($_SESSION['username']))
                {
                    if(isset($ro['itemcount'])) {
                        if($ro['itemcount'] >= $r['productQuantity']) {
                            echo "<button type='submit' class='buy-now btn btn-sm btn-primary' name='submit' id='add-to-cart' style='display:none'>Add to cart</button>";
                        } 
                        else {
                            echo '<div class="mb-5">';
                             echo '    <div class="input-group mb-3">';
                             echo '        <div class="input-group-prepend">';
                             echo '            <button class="btn btn-outline-primary js-btn-minus" type="button" id="btn-minus">&minus;</button>';
                             echo '        </div>'; 
                             echo '        <input type="text" class="form-control text-center" value="1" placeholder="" aria-describedby="button-addon1" size="3" name="itemcount" id="itemcount" readonly>';
                             echo '        <div class="input-group-append">'; 
                             echo '            <button class="btn btn-outline-primary js-btn-plus" type="button" id="btn-plus">&plus;</button>'; 
                             echo '        </div>'; 
                             echo '    </div>'; 
                             echo '    <p style="color : red;font-size: 14px;" id="warning">&nbsp;</p>'; 
                             echo '</div>'; 
                             echo '<br>'; 
                            echo "<button type='submit' class='buy-now btn btn-sm btn-primary' name='submit' id='add-to-cart'>Add to cart</button>";
                        }
                    }
                    else {
                        echo '<div class="mb-5">';
                         echo '    <div class="input-group mb-3">';
                         echo '        <div class="input-group-prepend">';
                         echo '            <button class="btn btn-outline-primary js-btn-minus" type="button" id="btn-minus">&minus;</button>';
                         echo '        </div>'; 
                         echo '        <input type="text" class="form-control text-center" value="1" placeholder="" aria-describedby="button-addon1" size="3" name="itemcount" id="itemcount" readonly>';
                         echo '        <div class="input-group-append">'; 
                         echo '            <button class="btn btn-outline-primary js-btn-plus" type="button" id="btn-plus">&plus;</button>'; 
                         echo '        </div>'; 
                         echo '    </div>'; 
                         echo '    <p style="color : red;font-size: 14px;" id="warning">&nbsp;</p>'; 
                         echo '</div>'; 
                         echo '<br>'; 

                        echo "<button type='submit' class='buy-now btn btn-sm btn-primary' name='submit' id='add-to-cart'>Add to cart</button>";
                    }
                }
                else
                {
                    echo "<b>*Please login into your account in order to purchase our products</b>";
                }
                   

                ?>
                

                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Footer -->
    <?php include "footer.php" ?>
    <!-- End of Footer -->
  </body>
    <script src="/shoppink/assets/js/shop-single.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
</html>
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Shoppink | Products</title>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="assets/css/shop.css" />
    <link rel="stylesheet" href="assets/css/header.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <script src="assets/js/script.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

    <!-- Navigation Bar-->
    <?php include "header.php" ?>
    <!-- End of Navigation Bar-->
    <br><br>
    <div class="animation">
        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <div class="row mb-5">
                        <div class="col-md-9 order-2">
                            <div class="row mb-5">
                                <h1 style="color:white">All Products</h1>
                            </div>
                            <br><br>
                            <?php 
                            $total_products_query = "SELECT COUNT(*) as total FROM product WHERE productQuantity>0";
                            $total_products_result = mysqli_query($conn, $total_products_query);
                            $total_products_row = mysqli_fetch_assoc($total_products_result);
                            $total_products = $total_products_row['total'];

                            // Define how many products per page
                            $products_per_page = 6;
                            $total_pages = ceil($total_products / $products_per_page);

                            // Get the current page from URL parameter (default to 1 if not set)
                            $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            if ($current_page < 1) $current_page = 1;
                            if ($current_page > $total_pages) $current_page = $total_pages;

                            // Calculate the offset for the SQL LIMIT clause
                            $offset = ($current_page - 1) * $products_per_page;

                            // Fetch the products for the current page
                            $q = "SELECT * FROM product WHERE productQuantity>0 LIMIT $offset, $products_per_page";
                            $res = mysqli_query($conn, $q);

                            echo '<div class="product-row">';
                            while ($r = mysqli_fetch_assoc($res)) {
                            ?>
                            <div class="col-sm-6 col-lg-4 product-card" data-aos="fade-up">
                                <div class="block-4 text-center border">
                                    <figure class="block-4-image" style="flex: 1;">
                                        <a href="shop-single.php?productID=<?php echo $r['productID']; ?>">
                                            <img src="<?php echo $r['productImage']; ?>" loading="lazy" class="img-fluid">
                                        </a>
                                        <div class="hover-buttons">
                                            <button class="btn-view" onclick="window.location.href='shop-single.php?productID=<?php echo $r['productID']; ?>'">View</button>

                                            <?php
                                                $direct="controller/user/cart/cart_add.php";

                                                if(!isset($_SESSION['username']))
                                                {
                                                    $direct= "/shoppink/login.php";  
                                                }
                                                else
                                                {
                                            ?>
                                            <form action="<?php echo $direct;?>" method="post">
                                                <input type="hidden" name="productID" value="<?php echo $r['productID']; ?>">
                                                <input type="hidden" name="itemcount" value="1">
                                                <?php
                                                $cartID = $_SESSION['cartID'];
                                                $productID = $r['productID'];
                                                $sql2 = "SELECT * FROM cartdetails JOIN cart ON cartdetails.cartID=cart.cartID WHERE cartdetails.productID = '$productID' AND cartdetails.cartID ='$cartID'";
                                                $result = mysqli_query($conn,$sql2);
                                                $r2 = mysqli_fetch_assoc($result);

                                               
                                                    $itemcount = $r2['itemcount'] ?? 0;

                                                    if (isset($_SESSION['username']) && $itemcount < $r['productQuantity']) {
                                                        echo "<button class='btn-add' type='submit' name='submit'>Add to Cart</button>";
                                                    }


                                                ?>
                                            </form>
                                            <?php
                                                }
                                            ?>
                                            
                                        </div>
                                    </figure>
                                    <div class="block-4-text p-4">
                                        <h3><?php echo $r['productName']; ?></h3>
                                        <p class="text-black"><b><?php echo $r['productQuantity']; ?> items left</b></p>
                                        <p class="text-black">RM <?php echo number_format($r['productPrice'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            echo '</div>';
                            ?>

                            <br><br>
                            <!-- Pagination controls -->
                            <div class="row" data-aos="fade-up">
                                <div class="col-md-12 text-center">
                                    <div class="site-block-27">
                                        <ul>
                                            <!-- Previous page link -->
                                            <?php if ($current_page > 1): ?>
                                                <li><a href="?page=<?php echo $current_page - 1; ?>">&lt;</a></li>
                                            <?php else: ?>
                                                <li class="disabled"><span>&lt;</span></li>
                                            <?php endif; ?>

                                            <!-- Page number links -->
                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <?php if ($i == $current_page): ?>
                                                    <li class="active"><span><?php echo $i; ?></span></li>
                                                <?php else: ?>
                                                    <li><a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                                <?php endif; ?>
                                            <?php endfor; ?>

                                            <!-- Next page link -->
                                            <?php if ($current_page < $total_pages): ?>
                                                <li><a href="?page=<?php echo $current_page + 1; ?>">&gt;</a></li>
                                            <?php else: ?>
                                                <li class="disabled"><span>&gt;</span></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <!-- Footer -->
    <?php include "footer.php" ?>
    <!-- End of Footer -->
    <script src="assets/js/logout.js"></script>
    
</body>
</html>

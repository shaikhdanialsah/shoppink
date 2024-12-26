<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Shoppink | My Order</title>
    <link rel="stylesheet" href="/shoppink/assets/css/order.css" />
    <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="/shoppink/assets/js/script.js" defer></script>
    <script src="/shoppink/assets/js/order.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0/css/all.min.css"/>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>
    <!-- Navigation Bar-->
    <?php include "../../header.php"; 
    if(isset($_GET['orderID'])) {
        $orderID = (int)$_GET['orderID'];

        $ordersql = "SELECT * FROM ordertable WHERE orderID='$orderID'";
        $orderres = mysqli_query($conn, $ordersql);
        $row = mysqli_fetch_assoc($orderres);

        $sql = "SELECT * FROM orderdetails JOIN product ON orderdetails.productID=product.productID WHERE orderID='$orderID'";
        $res = mysqli_query($conn, $sql);
    }
    ?>
    <!-- End of Navigation Bar-->
    <br><br>
    <span style="color:white;margin-left:50px"><a href="/shoppink/view/user/purchases.php" class="link"><u>Return</u></a></span>
    <div class="animation">
        <div class="site-wrap">
            <br>
            <div class="site-section">
                <div class="container">
                    <div id="printOrder"><!-- Start of printOrder -->
                        <div class="row mb-5">
                            <div class="col-md-12">
                                &nbsp;&nbsp;<h1>Order ID : <?php echo $row['orderID'] ?></h1><br>

                                <div class="row mb-5">
                                    <div class="row justify-content-end">
                                        <div class="col-md-7">
                                            <div class="row">
                                                <div class="col-md-12 text-right border-bottom mb-5">
                                                    <h3 class="text-black h4 text-uppercase">Delivery Status</h3>
                                                </div>
                                            </div>
                                            <div class="outer-container">
                                                <?php
                                                    if($row['statusorder']!='Canceled')
                                                    {
                                                ?>
                                                <div class="containers">
                                                    <div class="steps">
                                                        <div class="step">
                                                            <span class="circle active"><i class="fa-solid fa-clipboard"></i></span>
                                                            <span class="step-text" style="text-align:center">Waiting for seller <br> to approve</span>
                                                        </div>
                                                        <div class="step">
                                                            <span class="circle <?php echo ($row['statusorder'] == "Delivering" || $row['statusorder'] == "Delivered") ? 'active' : ''; ?>"><i class="fa-solid fa-truck-fast"></i></span>
                                                            <span class="step-text">Parcel is on delivery</span>
                                                        </div>
                                                        
                                                        <!-- <div class="step">
                                                            <span class="circle <?php echo ($row['statusorder'] == "Delivered") ? 'active' : ''; ?>"><i class="fa-solid fa-check"></i></span>
                                                            <span class="step-text">Item delivered</span>
                                                        </div> -->
                                                        
                                                        <div class="progress-bar">
                                                            <span class="indicator"></span>
                                                        </div>
                                                        <div style="display:none" id="status"><?php echo $row['statusorder'] ?></div>
                                                    </div>
                                                </div>
                                                <?php
                                                    }
                                                    else
                                                    {
                                                        echo "<b>Your order was canceled!</b>";
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="site-blocks-table">
                                    <br><br>
                                    <div class="col-md-12 text-right border-bottom mb-5">
                                        <h3 class="text-black h4 text-uppercase">Order Details</h3>
                                    </div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="product-thumbnail">Image</th>
                                                <th class="product-name">Product</th>
                                                <th class="product-price">Price</th>
                                                <th class="product-quantity">Quantity</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(mysqli_num_rows($res) > 0) {
                                                while ($r = mysqli_fetch_assoc($res)) {
                                            ?>
                                                    <tr>
                                                        <td class="product-thumbnail">
                                                            <img src="<?php echo $r['productImage']; ?>" alt="Image" class="img-fluid">
                                                        </td>
                                                        <td class="product-name">
                                                            <h2 class="h5 text-black"><?php echo $r['productName']; ?></h2>
                                                        </td>
                                                        <td>RM <?php echo number_format($r['productPrice'], 2); ?></td>
                                                        <td><?php echo $r['itemcount']; ?></td>
                                                        <td>RM <?php echo number_format(((int)$r['itemcount'] * (int)$r['productPrice']), 2); ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="row justify-content-end">
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12 text-right border-bottom mb-5">
                                            <h3 class="text-black h4 text-uppercase">Order Totals</h3>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <span class="text-black">Subtotal (<?php echo mysqli_num_rows($res) ?> items) : <b>RM <?php echo number_format($row['totalprice'], 2) ?></b><br><br>
                                            <span class="text-black">Discount: <b>- RM <?php echo number_format(($row['usedpoints']/100), 2) ?></b><br><br>
                                            <span class="text-black">Shipping Fee: <b>RM 4.90</b><br><br>
                                            <span class="text-black">Total Price : <b>RM <?php echo number_format($row['total'], 2) ?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of printOrder div -->
                    <?php 
                    if($row['statusorder']!='Canceled') 
                    {
                    ?>
                    <button class="btn btn-primary btn-lg py-3 btn-block" style="border-radius:30px" onclick="window.location='/shoppink/view/user/invoice.php?orderID=<?php echo $orderID ?>'">Print Invoice</button>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <br><br>
    <?php include "../../footer.php" ?>
    <!-- End of Footer -->

    <script src="/shoppink/assets/js/main.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
</body>
</html>

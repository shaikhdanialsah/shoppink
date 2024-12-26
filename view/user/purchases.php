<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Shoppink | Purchases</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link rel="stylesheet" href="/shoppink/assets/css/header.css" />
  <link rel="stylesheet" href="/shoppink/assets/css/purchases.css" />
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
  <script src="/shoppink/assets/js/script.js" defer></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
  <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>

  <!-- Navigation Bar-->
  <?php include "../../header.php" ?>
  <!--End of Navigation Bar-->
  <br><br>
  <p style="color:white">&nbsp;&nbsp;<a class="link" href="/shoppink/index.php"><u>Homepage</u></a> / My Purchases</p>
  <div class="animation">
    <!-- Past Purchases -->

    <?php
// Include your database connection file here
// Get the current page number from the URL, if not set default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3; // Number of orders per page
$offset = ($page - 1) * $limit;
$userID = (int)$_SESSION['username'];
// Fetch the total number of orders
$total_orders_query = "SELECT COUNT(*) as total FROM ordertable WHERE userID='$userID'";
$total_orders_result = mysqli_query($conn, $total_orders_query);
$total_orders_row = mysqli_fetch_assoc($total_orders_result);
$total_orders = $total_orders_row['total'];


// Calculate the total number of pages
$total_pages = ceil($total_orders / $limit);

// Fetch the orders for the current page
$orders_query = "SELECT * FROM ordertable WHERE userID='$userID' ORDER BY  orderID DESC LIMIT $limit OFFSET $offset";
$orders_result = mysqli_query($conn, $orders_query);

if (mysqli_num_rows($orders_result) > 0) {
    while ($r = mysqli_fetch_assoc($orders_result)) {
        ?>

        <div class="site-wrap">
            <div class="site-section">
                <div class="container">
                    <div class="order-header">
                        <h2 style="color:white">Order ID : <?php echo $r['orderID'] ?></h2>
                        <span class="additional-info">
                        <span style="color: white; background-color: green; border-radius: 13px; line-height: 15px; padding: 5px 10px;">
                                Status: <?php echo $r['statusorder'] ?>
                            </span>
                        </span>

                    </div>
                    <br>
                    <hr><br>
                    <div class="card">
                        <div class="imgs">
                            <?php
                            $orderID = (int)$r['orderID'];
                            $sql="SELECT product.productImage FROM product JOIN orderdetails ON product.productID = orderdetails.productID WHERE orderdetails.orderID = '$orderID' LIMIT 1";
                            $result = mysqli_query($conn,$sql);
                            $rows = mysqli_fetch_assoc($result);
                            ?>
                            <img src="<?php echo $rows['productImage'];?>" >
                        </div>
                        <div class="infos">
                            <div class="name">
                                <?php
                                $q2 = "SELECT COUNT(*) as count FROM orderdetails WHERE orderID='$orderID'";
                                $res2 = mysqli_query($conn, $q2);
                                if ($res2) {
                                    $row2 = mysqli_fetch_assoc($res2);
                                    $count = $row2['count'];
                                } else {
                                    $count = 0; // Default value in case the query fails
                                }
                                $q3 = "SELECT * FROM ordertable WHERE orderID='$orderID'";
                                $res3 = mysqli_query($conn, $q3);
                                $row3 = mysqli_fetch_assoc($res3);
                                ?>
                                <p><b>Total items:</b> <?php echo $count ?></p>
                                <p><b>Total price:</b> RM <?php echo number_format($row3['total'], 2) ?></p>
                            </div>
                        </div>
                        <div>
                        <?php
                            if($row3['statusorder']!='Canceled')
                            {
                        ?>
                            <button class="button_save_prints" onclick="window.location='/shoppink/view/user/invoice.php?orderID=<?php echo $orderID ?>'"><b>Print Receipt</b></button><br><br>
                        <?php
                            }
                        ?>
                            <button class="button_save" onclick="window.location='/shoppink/view/user/order.php?orderID=<?php echo $orderID ?>'"><b>View Details</b></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }
} else {
    ?>

    <div class="site-wrap">
        <div class="site-section">
            <div class="container">
                <div class="order-header">
                    <h2 style="color:white">Oopss..looks like you do not have have any purchases yet!</h2>
                </div>
                <hr><br>
                <div class="card">
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br>
    <?php
}
?>

<br><br>
<div class="row" data-aos="fade-up">
    <div class="col-md-12 text-center">
        <div class="site-block-27">
            <br><br>
            <ul>
                <?php if ($page > 1): ?>
                    <li><a href="?page=<?php echo $page - 1; ?>">&lt;</a></li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php if ($page == $i) echo 'active'; ?>">
                        <a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li><a href="?page=<?php echo $page + 1; ?>">&gt;</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
                </div>

  <br><br>
  <script src="/shoppink/assets/js/logout.js"></script>
  <!-- Footer -->
<?php include "../../footer.php" ?>
    <!-- End of Footer -->   
</body>
</html>

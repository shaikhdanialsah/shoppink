<?php
    require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
    session_start();
    if(!$_SESSION['username'])
    {
        header("Location: /shoppink/login.php");
        exit();
    }

    function capitalizeFirstWord($string) {
        $lowercasedString = strtolower($string);
    // Capitalize the first letter of each word
        return ucwords($lowercasedString);
    }

    if(isset($_GET['orderID'])) {
        $orderID = (int)$_GET['orderID'];

        $ordersql = "SELECT * FROM ordertable WHERE orderID='$orderID'";
        $orderres = mysqli_query($conn, $ordersql);
        $row = mysqli_fetch_assoc($orderres);

        $sql = "SELECT * FROM orderdetails JOIN product ON orderdetails.productID=product.productID WHERE orderID='$orderID'";
        $res = mysqli_query($conn, $sql);

        $userID =$_SESSION['username'];
        $q = "SELECT * FROM user WHERE userID='$userID'";
        $result=mysqli_query($conn,$q);
        $rr=mysqli_fetch_assoc($result);
    }
    else
    {
        header("Location: /shoppink/view/user/purchases.php");
        exit();
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Invoice</title>
    <link rel="stylesheet" href="/shoppink/assets/css/invoice.css" />
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>ORDER INVOICE</h2>
            <p><b>Shopinkk SDN BHD</b></p>
        </div>
        
        <div class="details">
    <div class="left">
        <span><strong>Recipient Name:</strong> <?php echo capitalizeFirstWord($row['shipname']) ?></span><br>
        <span><strong>Recipient Address:</strong> <?php echo capitalizeFirstWord($row['shipaddress']) ?></span>
    </div>
    <div class="right">
        <span><strong>Order ID:</strong> <?php echo $row['orderID'] ?></span><br>
        <span><strong>Order Paid Date:</strong> <?php echo $row['date'] ?></span>
    </div>
</div>


        <div class="order-details">
            <h3>Order Details</h3>
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Product</th>
                        <th>Category</th>
                        <th>Net Product Price (RM)</th>
                        <th>Qty</th>
                        <th>Subtotal (RM)</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $i=1;
                    $sumtotal=0;
                    if(mysqli_num_rows($res) > 0) {
                        while ($r = mysqli_fetch_assoc($res)) {
                        
                ?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td> <?php echo capitalizeFirstWord($r['productName']) ?></td>
                        <td> <?php echo capitalizeFirstWord($r['productCategory']) ?></td>
                        <td class="text-right"><?php echo number_format($r['productPrice'],2) ?></td>
                        <td class="text-right"><?php echo $r['itemcount'] ?></td>
                        <td class="text-right"><?php echo number_format(($r['productPrice']*$r['itemcount']),2) ?></td>
                    </tr>
                <?php

                    $sumtotal =$sumtotal + ($r['productPrice']*$r['itemcount']);
                    }
                }
                ?>
                </tbody>
            </table>
        </div><br><br>

        <div class="totals">
            <div class="left" style="display:block">
                <span><strong>Subtotal:</strong> RM <?php echo number_format($sumtotal,2) ?></span>
                <span><strong>Total Quantity (Active):</strong> <?php echo $i-1 ?> item (s)</span>
                <span><strong>Membership:</strong> <?php echo $rr['membership'] ?></span>
                <span><strong>Reward points to be received:</strong> +<?php echo $row['receivepoints'] ?></span>
            </div>

            <div class="right">
                <span><strong>Merchandise Subtotal:</strong> RM <?php echo number_format($sumtotal,2) ?></span>
                <span><strong>Discount (Reward Points):</strong> -RM <?php echo number_format(($row['usedpoints']/100),2) ?></span>
                <span><strong>Shipping Fee:</strong> RM 4.90</span>
                <hr style="color:black">
                <span style="font-size:20px"><strong>Total Paid:</strong> RM <?php echo number_format( $row['total'],2) ?></span>
            </div>
        </div>

        <div class="footer">
            <p>End of receipt</p>
        </div>

        <button class="print-button" onclick="printInvoice()">Print</button>
    </div>

    <script>
        function printInvoice() {
    var printContents = document.querySelector('.container').innerHTML;
    var originalContents = document.body.innerHTML;

    var printWindow = window.open('', '', '');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write('<link rel="stylesheet" href="/shoppink/assets/css/invoice.css">');
    printWindow.document.write('</head><body>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');

    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();

    document.body.innerHTML = originalContents;
}


    </script>
</body>
</html>

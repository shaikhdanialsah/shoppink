<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
if(!$_SESSION['username'])
{
    header("Location: /shoppink/login.php");
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
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

            <!-- ======================= Cards ================== -->
            <div class="custom-cardBox">
                <div class="custom-card">
                    <div>
                        <?php 
                            $sql1="SELECT COUNT(*) AS count FROM user WHERE roleID='2'";
                            $result1=mysqli_query($conn,$sql1);
                            $numberCustomer=mysqli_fetch_assoc($result1);

                        ?>
                        <div class="custom-numbers"><?php echo $numberCustomer['count'] ?></div>
                        <div class="custom-cardName">Number of customers</div>
                    </div>

                    <div class="custom-iconBx">
                        <ion-icon name="person-outline"></ion-icon>
                    </div>
                </div>

                <div class="custom-card">
                    <div>
                    <?php 
                            $sql2 = "SELECT SUM(total) AS sum FROM ordertable WHERE statusorder NOT IN ('Waiting for seller to approve', 'Canceled')";
                            $result2 = mysqli_query($conn, $sql2);
                            $totalsales=mysqli_fetch_assoc($result2);

                        ?>
                        <div class="custom-numbers">RM<?php  echo number_format($totalsales['sum'],2) ?></div>
                        <div class="custom-cardName">Total sales earned</div>
                    </div>

                    <div class="custom-iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>

                <div class="custom-card">
                    <div>
                    <?php 
                            $sql3="SELECT COUNT(*) AS count FROM user WHERE roleID='2' AND membership IN ('Gold II', 'Silver II', 'Bronze II')";
                            $result3=mysqli_query($conn,$sql3);
                            $pendingMembership=mysqli_fetch_assoc($result3);

                        ?>
                        <div class="custom-numbers"><?php echo $pendingMembership['count'] ?></div>
                        <div class="custom-cardName">Pending Membership</div>
                    </div>

                    <div class="custom-iconBx">
                        <ion-icon name="time-outline"></ion-icon>
                    </div>
                </div>

                <div class="custom-card">
                    <div>
                    <?php 
                            $sql4="SELECT COUNT(*) AS count FROM ordertable WHERE statusorder='Waiting for seller to approve' ";
                            $result4=mysqli_query($conn,$sql4);
                            $pendingOrder=mysqli_fetch_assoc($result4);

                        ?>
                        <div class="custom-numbers"><?php echo $pendingOrder['count'] ?></div>
                        <div class="custom-cardName">Pending Order</div>
                    </div>

                    <div class="custom-iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Add Charts JS ================= -->
            <!--<div class="custom-chartsBx">
                <div class="custom-chart"> <canvas id="chart-1"></canvas> </div>
                <div class="custom-chart"> <canvas id="chart-2"></canvas> </div>
            </div> -->

            <!-- ================ Order Details List ================= -->
            <div class="custom-details">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Recent Orders</h2>
                        <a href="admin_order.php" class="custom-btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Total Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <?php
                            $sql5="SELECT * FROM ordertable ORDER BY orderID DESC LIMIT 5";
                            $result5=mysqli_query($conn,$sql5);
                        ?>
                        <tbody>
                            <?php
                                while($r=mysqli_fetch_assoc($result5))
                                {
                            ?>
                                <tr>
                                <td><?php echo $r['orderID'] ?></td>
                                <td>RM<?php echo number_format($r['total'],2)?></td>
                                <td><a href="#" onclick="viewPaymentProof('<?php echo $r['filetype']; ?>', '<?php echo base64_encode($r['paymentproof']); ?>')"><u>View Payment Proof</u></a></td>
                                <?php
                                    if($r['statusorder']=='Delivering')
                                    {
                                        echo "<td><span class='custom-status custom-delivered'>" . $r['statusorder'] . "</span></td>";
                                    }
                                    else if($r['statusorder']=='Canceled')
                                    {
                                        echo "<td><span class='custom-status custom-cancel'>" . $r['statusorder'] . "</span></td>";
                                    }
                                    else
                                    {
                                        echo "<td><span class='custom-status custom-pending'>" . $r['statusorder'] . "</span></td>";
                                    }                                    
                                ?>
                                
                            </tr>
                            <?php
                                }
                            ?>
                            

                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="custom-recentCustomers">
                    <div class="custom-cardHeader">
                        <h2>Recent Customers</h2>
                    </div>

                    <table>
                        <?php
                            $sql6="SELECT * FROM user WHERE roleID='2' ORDER BY userID DESC LIMIT 5";
                            $result6=mysqli_query($conn,$sql6);

                            while($row=mysqli_fetch_assoc($result6))
                            {
                        ?>
                            <tr>
                            <td>
                                <h4><?php echo strtoupper($row['name']) ?><br> <span><?php echo $row['email'] ?></span></h4>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="/shoppink/assets/js/admin.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/shoppink/assets/js/paymentProof.js"></script>
    <script src="/shoppink/assets/js/alertAdmin.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    
</body>

</html>

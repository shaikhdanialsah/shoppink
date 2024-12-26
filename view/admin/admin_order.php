<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
if(!$_SESSION['username'])
{
    header("Location: /shoppink/login.php");
    exit();
}

// Handle the search query
$searchQuery = isset($_POST['query']) ? $_POST['query'] : "";

$searchQuery2 = isset($_POST['query_2']) ? $_POST['query_2'] : "";

// Pagination logic for pending orders
$pending_per_page = 4;
$pending_page = isset($_GET['pending_page']) ? (int)$_GET['pending_page'] : 1;
$pending_page = max(1, $pending_page); // Ensure page number is not less than 1

if(isset($_POST['query'])&&$pending_page!=1)
{
    $pending_page=1;
}

$pending_offset = ($pending_page - 1) * $pending_per_page;

$pending_total_query = "SELECT COUNT(*) AS total 
                        FROM ordertable 
                        WHERE statusorder = 'Waiting for seller to approve' 
                        AND orderID LIKE '%$searchQuery%'";
$pending_total_result = mysqli_query($conn, $pending_total_query);
$pending_total_row = mysqli_fetch_assoc($pending_total_result);
$pending_total = $pending_total_row['total'];
$pending_total_pages = ceil($pending_total / $pending_per_page);

$pending_query = "SELECT o.orderID AS orderID, 
                         o.total AS total, 
                         o.date AS date, 
                         o.filetype AS filetype, 
                         o.paymentproof AS paymentproof, 
                         u.name AS name, 
                         u.userID AS userID 
                  FROM ordertable o 
                  JOIN user u ON o.userID = u.userID 
                  WHERE o.statusorder = 'Waiting for seller to approve' 
                  AND o.orderID LIKE '%$searchQuery%' 
                  ORDER BY o.orderID DESC 
                  LIMIT $pending_offset, $pending_per_page";
$pending_res = mysqli_query($conn, $pending_query);

// Pagination logic for approved/canceled orders
$approved_per_page = 4;
$approved_page = isset($_GET['approved_page']) ? (int)$_GET['approved_page'] : 1;
$approved_page = max(1, $approved_page); // Ensure page number is not less than 1

if(isset($_POST['query_2'])&&$approved_page!=1)
{
    $approved_page=1;
}

$approved_offset = ($approved_page - 1) * $approved_per_page;

$approved_total_query = "SELECT COUNT(*) AS total 
                         FROM ordertable 
                         WHERE statusorder != 'Waiting for seller to approve'
                         AND orderID LIKE '%$searchQuery2%'";
$approved_total_result = mysqli_query($conn, $approved_total_query);
$approved_total_row = mysqli_fetch_assoc($approved_total_result);
$approved_total = $approved_total_row['total'];
$approved_total_pages = ceil($approved_total / $approved_per_page);

$approved_query = "SELECT o.orderID AS orderID, 
                          o.total AS total, 
                          o.date AS date, 
                          o.filetype AS filetype, 
                          o.paymentproof AS paymentproof,
                          o.statusorder AS statusorder, 
                          u.name AS name,
                          u.userID AS userID
                   FROM ordertable o 
                   JOIN user u ON o.userID = u.userID 
                   WHERE o.statusorder != 'Waiting for seller to approve'
                   AND orderID LIKE '%$searchQuery2%'
                   ORDER BY o.orderID DESC 
                   LIMIT $approved_offset, $approved_per_page";
$approved_res = mysqli_query($conn, $approved_query);

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
    <link rel="stylesheet" href="/shoppink/assets/css/manageOrder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
            <div class="custom-order">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Pending Order</h2>
                        <form method="POST">
                            <div class="custom-search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="number" class="form-control" id="searchInput" name="query" placeholder="Search order ID">
                                <button type="submit" name="searchCustomer" class="btn-View"></button>
                            </div>
                        </form>
                    </div>

                    <table>
                    <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Total Price</td>
                                <td>Date</td>
                                <td>Payment Proof</td>
                                <td>Customer Name</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($pending_total>0)
                            {
                                while ($r = mysqli_fetch_assoc($pending_res)) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($r['orderID']); ?></td>
                                        <td>RM <?php echo number_format($r['total'],2); ?></td>
                                        <td><?php echo $r['date']; ?></td>
                                        <td><a href="#" onclick="viewPaymentProof('<?php echo $r['filetype']; ?>', '<?php echo base64_encode($r['paymentproof']); ?>')"><u>View Payment Proof</u></a></td>
                                        <td><?php echo strtoupper(substr($r['name'],0,13)); ?></td>
                                        <td>
                                        <form action="/shoppink/controller/admin/orderVerify.php" method="post" style="display: inline; background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
                                                <label for="orderStatus" style="margin-right: 10px; font-weight: bold;">Select Status:</label>
                                                <select name="orderStatus" id="orderStatus" style="background: whitesmoke; color: black; border: none; padding: 5px; border-radius: 3px;" required>
                                                    <option value="" >Pending</option>
                                                    <option value="Approve" >Approve</option>
                                                    <option value="Cancel" >Cancel</option>
                                                </select>
                                                <input type="hidden" name="orderID" value="<?php  echo $r['orderID'] ?>">
                                                <input type="hidden" name="userID" value="<?php  echo $r['userID'] ?>">
                                                <button type="submit" name="approveOrder" style="background: #5cb85c; color: whitesmoke; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Update</button>
                                        </form>
                                        </td>
                                    </tr>
                                <?php endwhile; 
                                }
                                else
                                {
                                    echo "<tr><td colspan=6>No results found</td></tr>";
                                }
                                ?>
                            
                        </tbody>
                    </table>

                    <!-- Pagination for Pending Orders -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">

                            <?php if ($pending_page > 1) : ?>
                                <li class="page-item"><a class="page-link" href="?pending_page=<?php echo ($pending_page - 1); ?>">Previous</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $pending_total_pages; $page++) : ?>
                                <li class="page-item <?php echo ($page === $pending_page) ? 'active' : ''; ?>"><a class="page-link" href="?pending_page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($pending_page < $pending_total_pages) : ?>
                                <li class="page-item"><a class="page-link" href="?pending_page=<?php echo ($pending_page + 1); ?>">Next</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="custom-order">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Approved/Canceled Order</h2>
                        <form method="POST">
                            <div class="custom-search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="number" class="form-control" id="searchInput" name="query_2" placeholder="Search order ID">
                                <button type="submit" name="searchCustomer" class="btn-View"></button>
                            </div>
                        </form>
                    </div>

                    <table>
                    <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Total Price</td>
                                <td>Date</td>
                                <td>Payment Proof</td>
                                <td>Customer Name</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>

                            <?php 
                            if($approved_total>0)
                            {
                            while ($r = mysqli_fetch_assoc($approved_res)) : ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($r['orderID']); ?></td>
                                    <td>RM <?php echo number_format($r['total'],2); ?></td>
                                    <td><?php echo $r['date']; ?></td>
                                    <td><a href="#" onclick="viewPaymentProof('<?php echo $r['filetype']; ?>', '<?php echo base64_encode($r['paymentproof']); ?>')"><u>View Payment Proof</u></a></td>
                                    <td><?php echo strtoupper(substr($r['name'],0,13));?></td>
                                    <td>
                                        <?php if($r['statusorder']=="Delivering")
                                        {
                                        ?>
                                        <span class="highlight_green"><?php echo $r['statusorder']; ?></span> 
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                        <span class="highlight_red"><?php echo $r['statusorder']; ?></span> 
                                        <?php 
                                        }
                                        ?>
                                        
                                    </td>
                                </tr>
                            <?php endwhile; 
                            }
                            else
                            {
                                echo "<tr><td colspan=6>No results found</td></tr>";
                            }?>
                        </tbody>
                    </table>

                    <!-- Pagination for Approved/Canceled Orders -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">

                            <?php if ($approved_page > 1) : ?>
                                <li class="page-item"><a class="page-link" href="?approved_page=<?php echo ($approved_page - 1); ?>">Previous</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $approved_total_pages; $page++) : ?>
                                <li class="page-item <?php echo ($page === $approved_page) ? 'active' : ''; ?>"><a class="page-link" href="?approved_page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($approved_page < $approved_total_pages) : ?>
                                <li class="page-item"><a class="page-link" href="?approved_page=<?php echo ($approved_page + 1); ?>">Next</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="/shoppink/assets/js/admin.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="/shoppink/assets/js/alertAdmin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/shoppink/assets/js/paymentProof.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body> 

</html>

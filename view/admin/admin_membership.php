<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
if(!$_SESSION['username'])
{
    header("Location: /shoppink/login.php");
    exit();
}

// Pagination logic
$users_per_page = 4;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$current_page = max(1, $current_page); // Ensure page number is not less than 1

if(isset($_POST['searchCustomer'])) {
    // Sanitize the user input (consider using prepared statements for security)
    $query = isset($_POST['query']) ? "AND name LIKE '%" . $_POST['query'] . "%'" : "";
} else {
    $query = ""; 
}
// Fetch total number of users with roleID = 2
$total_users_query = "SELECT COUNT(*) AS total 
                     FROM user 
                     WHERE roleID = '2' 
                     AND membership IN ('Gold II', 'Silver II', 'Bronze II') $query";
$total_users_result = mysqli_query($conn, $total_users_query);
$total_users_row = mysqli_fetch_assoc($total_users_result);
$total_users = $total_users_row['total'];

// Calculate total pages
$total_pages = ceil($total_users / $users_per_page);

// Calculate offset for SQL LIMIT clause
$offset = ($current_page - 1) * $users_per_page;


// Fetch users for the current page
$q = "SELECT * FROM user WHERE roleID='2' AND membership IN ('Gold II', 'Silver II', 'Bronze II') $query LIMIT $offset, $users_per_page";
$res = mysqli_query($conn, $q);

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
    <link rel="stylesheet" href="/shoppink/assets/css/manageCustomer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
    <style>
        /* Add any additional custom styles */
    </style>
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
            <div class="custom-customer">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Pending Membership</h2>
                        <form method="POST">
                            <div class="custom-search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search name" name="query">
                                <button type="submit" name="searchCustomer" class="btn-View"></button>
                            </div>
                        </form>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Membership</th>
                                <th>Email</th>
                                <th>Payment Proof</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if($total_users>0)
                            {
                                while ($r = mysqli_fetch_assoc($res)) : ?>
                                    <tr>
                                        <td><?php echo strtoupper(htmlspecialchars($r['name'])); ?></td>
                                        <td><?php echo htmlspecialchars($r['membership']); ?></td>
                                        <td><?php echo htmlspecialchars($r['email']); ?></td>
                                        <td><a href="#" onclick="viewPaymentProof('<?php echo $r['filetype']; ?>', '<?php echo base64_encode($r['paymentproof']); ?>')"><u>View Payment Proof</u></a></td>
                                        <td>
                                        <form action="/shoppink/controller/admin/adminMembership.php" method="post" style="display: inline; background-color: #f0f0f0; padding: 10px; border-radius: 5px;">
                                                <label for="orderStatus" style="margin-right: 10px; font-weight: bold;">Select Status:</label>
                                                <select name="membershipStatus" id="membershipStatus" style="background: whitesmoke; color: black; border: none; padding: 5px; border-radius: 3px;">
                                                    <option value="Pending" >Pending</option>
                                                    <option value="Approve" >Approve</option>
                                                    <option value="Reject" >Reject</option>
                                                </select>
                                                <input type="hidden" name="membership" value="<?php  echo $r['membership'] ?>">
                                                <input type="hidden" name="userID" value="<?php  echo $r['userID'] ?>">
                                                <button type="submit" name="approveMembership" style="background: #5cb85c; color: whitesmoke; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer;">Update</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; 
                            }
                            else
                            {
                                echo '<tr><td colspan=6 style="text-align:center">No results found</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php if ($current_page > 1) : ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo ($current_page - 1); ?>">Previous</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            <?php endif; ?>

                            <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
                                <li class="page-item <?php echo ($page === $current_page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($current_page < $total_pages) : ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo ($current_page + 1); ?>">Next</a></li>
                            <?php else : ?>
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
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

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
    <link rel="stylesheet" href="/shoppink/assets/css/manageCustomer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
            <div class="custom-customer">
                <div class="custom-recentOrders">
                        
                    <div class="custom-cardHeader">
                        <h2>View Profile</h2>
                        <form method='POST'>
                            <div class="custom-search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search name" name="query">
                            </div>
                            <button type="submit" name="searchCustomer" class="btn-View"></button>
                        </form>
                    </div>
                    <table>
                    <?php

                if(isset($_POST['searchCustomer'])) {
                    // Sanitize the user input (consider using prepared statements for security)
                    $query = isset($_POST['query']) ? "AND name LIKE '%" . $_POST['query'] . "%'" : "";
                } else {
                    $query = ""; 
                }

                // Fetch the total number of users with roleID = 2
                $total_users_query = "SELECT COUNT(*) as total FROM user WHERE roleID='2' $query";

    $total_users_result = mysqli_query($conn, $total_users_query);
    $total_users_row = mysqli_fetch_assoc($total_users_result);
    $total_users = $total_users_row['total'];

    // Define how many users per page
    $users_per_page = 4;
    $total_pages = ceil($total_users / $users_per_page);

    // Get the current page from URL parameter (default to 1 if not set)
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($current_page < 1) $current_page = 1;
    if ($current_page > $total_pages) $current_page = $total_pages;

    // Calculate the offset for the SQL LIMIT clause
    $offset = ($current_page - 1) * $users_per_page;

    echo '<table>';
    echo '<thead>
            <tr>
                <th>Name</th>
                <th>Membership</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
          </thead>';
    echo '<tbody>';

    if($total_users>0)
    {
        // Fetch the users for the current page
    $q = "SELECT * FROM user WHERE roleID='2' $query LIMIT $offset, $users_per_page";
    $res = mysqli_query($conn, $q);
    $counter = 0; // Initialize counter variable

    while ($r = mysqli_fetch_assoc($res)) {
        // Start a new row if the counter is a multiple of 4
        if ($counter % 4 === 0 && $counter !== 0) {
            echo '</tbody><tbody>';
        }
?>
        <tr>
            <td><?php echo strtoupper($r['name']) ?></td>
            <td>
                <?php
                    if($r['membership']=="Gold"||$r['membership']=="Silver"||$r['membership']=="Bronze")
                    {
                ?>
                        <span class="highlight_green"><?php echo $r['membership']; ?></span>
                <?php
                    }
                    else if($r['membership']=="Inactive")
                    {
                ?>
                        <span class="highlight_red"><?php echo $r['membership']; ?></span>
                <?php
                    }
                    else
                    {
                ?>
                        <span class="highlight_blue"><?php echo $r['membership']; ?></span>
                <?php
                    }
                ?>
                
            </td>
            <td><?php echo $r['email']; ?></td>
            <td><?php echo $r['phone']; ?></td>
            <td><?php echo substr($r['address'],0,30); ?>..</td>
            <td>
                <form action="customer_profile.php" method="post" style="display: inline;">
                    <input type="hidden" name="userID" value="<?php echo $r['userID']; ?>">
                    <button type="submit" class="custom-btnView" name="customerProfile" value="Submit" style="height: 35px;"><span class="custom-btnText">View</span></button>
                </form>
            </td>
        </tr>
<?php
        // Increment counter
        $counter++;
    }
        echo '</tbody>';
        echo '</table>';

        // Pagination controls
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';
    }
    else
    {
        echo '<tr><td colspan=6 style="text-align:center">No results found</td></tr>';
        echo '</tbody>';
        echo '</table>';

        // Pagination controls
        echo '<nav aria-label="Page navigation">';
        echo '<ul class="pagination justify-content-center">';
    }

    

    // Previous page link (always shown)
    if ($current_page > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';
    }

    // Page number links
    for ($page = 1; $page <= $total_pages; $page++) {
        $active = $page == $current_page ? 'active' : '';
        echo '<li class="page-item ' . $active . '"><a class="page-link" href="?page=' . $page . '">' . $page . '</a></li>';
    }

    // Next page link (always shown)
    if ($current_page < $total_pages) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
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

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

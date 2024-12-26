<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');
session_start();
if (!$_SESSION['username']) {
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
    <link rel="stylesheet" href="/shoppink/assets/css/manageProduct.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"/>
    <link rel="icon" href="/shoppink/assets/images/logo_2.png" />
</head>

<body class="custom-body">
    <div class="custom-container">
        <?php include "navigation_menu.php" ?>

        <div class="custom-main">
            <div class="custom-topbar">
                <div class="custom-toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="custom-product">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>View Product</h2>
                        <form method='POST'>
                            <div class="custom-search-box">
                                <i class="material-icons">&#xE8B6;</i>
                                <input type="text" class="form-control" id="searchInput" placeholder="Search product name" name="query">
                                <button type="submit" class="btn-View"></button>
                            </div>
                            <button type="submit" class="btn btn-warning" name="outOfStock">Out of Stock</button>&nbsp;&nbsp;&nbsp;
                        </form>
                    </div>

                    <table id="productTable">
                        <thead>
                            <tr>
                                <td>Product Image</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Quantity</td>
                                <td>Description</td>
                                <td>Category</td>
                                <th class="text-end">
                                    <a href="/shoppink/view/admin/add_product.php">
                                        <button type="button" class="btn btn-sm" style="background-color: #5cb85c; color: #ffffff;">Add New Product</button>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <?php
                        // Default query condition
                        $queryCondition = "";

                        // Check if the search query is set
                        if (isset($_POST['query'])) {
                            $queryCondition = "WHERE productName LIKE '%" . $_POST['query'] . "%'";
                        }

                        // Check if the out of stock button is pressed
                        if (isset($_POST['outOfStock'])) {
                            $queryCondition = "WHERE productQuantity = 0";
                        }

                        // Fetch the total number of products
                        $total_products_query = "SELECT COUNT(*) as total FROM product $queryCondition";
                        $total_products_result = mysqli_query($conn, $total_products_query);
                        $total_products_row = mysqli_fetch_assoc($total_products_result);
                        $total_products = $total_products_row['total'];

                        // Define how many products per page
                        $products_per_page = 4;
                        $total_pages = ceil($total_products / $products_per_page);

                        // Get the current page from URL parameter (default to 1 if not set)
                        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        if ($current_page < 1) $current_page = 1;
                        if ($current_page > $total_pages) $current_page = $total_pages;

                        // Calculate the offset for the SQL LIMIT clause
                        $offset = ($current_page - 1) * $products_per_page;

                        // Fetch the products for the current page
                        if ($total_products > 0) {
                            $q = "SELECT * FROM product $queryCondition LIMIT $offset, $products_per_page";
                            $res = mysqli_query($conn, $q);
                            $counter = 0; // Initialize counter variable

                            echo '<table>';
                            while ($r = mysqli_fetch_assoc($res)) {
                                // Start a new row if the counter is a multiple of 4
                                if ($counter % 4 === 0) {
                                    echo '<tbody>';
                                }
                        ?>
                                <tr>
                                    <td style="font-size: 15px; color: black">
                                        <img src="<?php echo $r['productImage']; ?>" class="avatar avatar-lg me-6" alt="No Image" loading="lazy" style="width: 100px; height: auto; object-fit: cover; object-position: center;border:2px solid black">
                                    </td>
                                    <td><?php echo substr($r['productName'], 0, 12) ?>..</td>
                                    <td>RM <?php echo number_format($r['productPrice'], 2) ?></td>
                                    <td><?php echo $r['productQuantity'] ?></td>
                                    <td><?php echo substr($r['productDescription'], 0, 35) ?>..</td>
                                    <td><?php echo (strlen($r['productCategory']) > 6) ? substr($r['productCategory'], 0, 6) . '..' : $r['productCategory']; ?></td>
                                    <td class="text-end">
                                        <form action="product_detail.php" method="post" style="display: inline;">
                                            <input type="hidden" name="productID" value="<?php echo $r['productID'] ?>">
                                            <button type="submit" class="btn btn-sm btn-neutral" style="background: #0275d8; color:whitesmoke;" name="submit">View</button>
                                        </form>
                                        <form action="/shoppink/controller/admin/editProduct.php" method="post" style="display: inline;" onsubmit="deleteConfirmation(event)">
                                            <input type="hidden" name="productID" value="<?php echo $r['productID'] ?>">
                                            <input type="hidden" name="deleteProduct">
                                            <button type="submit" class="btn btn-sm btn-square btn-neutral" style="background: #d11a2a; color: whitesmoke;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                        <?php
                                // Increment counter
                                $counter++;

                                // Close the row if the counter is a multiple of 4 or if it's the last product on the current page
                                if ($counter % 4 === 0 || $counter == mysqli_num_rows($res)) {
                                    echo '</tbody>'; // Close the row
                                }
                            }
                            echo '</table>';

                            // Pagination controls
                            echo '<nav aria-label="Page navigation">';
                            echo '<ul class="pagination justify-content-center">';
                        } else {
                            echo "<table>";
                            echo "<tr><td colspan=5>No results found</td></tr>";
                            echo "</table>";
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

                        <!-- =========== Scripts =========  -->
    <script src="/shoppink/assets/js/admin.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/shoppink/assets/js/alertAdmin.js"></script>
    <script src="/shoppink/assets/js/deleteConfirmation.js"></script>


    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

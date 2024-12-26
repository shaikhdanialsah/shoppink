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
    <link rel="stylesheet" href="/shoppink/assets/css/manageProduct.css">
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
            <div class="custom-product">
                <div class="custom-recentOrders">
                    <div class="custom-cardHeader">
                        <h2>Add New Product</h2>
                    </div><br><br>

                    
                    
                    <form method="post" action="/shoppink/controller/admin/productAdd.php" enctype="multipart/form-data">
                            <div class="card-footer border-0 py-5">
                                    <div class="row mb-5 gx-5">
                                        <div class="col-xxl-8 mb-5 mb-xxl-0">
                                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label" style="font-size: 20px;">Product Name</label>
                                                        <input type="text" name="productName" class="form-control" style="font-size: 16px; border: 1px solid black;" required>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class="form-label" style="font-size: 20px;">Product Price (RM)</label>
                                                        <input type="number" name="productPrice" class="form-control" style="font-size: 16px; border: 1px solid black;" required>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label" style="font-size: 20px;">Product Quantity</label>
                                                        <input type="number" name="productQuantity" class="form-control" style="font-size: 16px; border: 1px solid black;" min="1" required>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <?php
                                                            $sql ="SELECT DISTINCT productCategory FROM product";
                                                            $result = mysqli_query($conn, $sql);
                                                        ?>
                                                        <label class="form-label" style="font-size: 20px;">Product Category</label>
                                                        <select name="productCategory" required class="form-select" style="font-size: 16px; border: 1px solid black;" required>
                                                        <option value="">Select</option> 
                                                        <?php
                                                            while ($r = mysqli_fetch_assoc($result))
                                                            {
                                                                echo "<option value=\"{$r['productCategory']}\">{$r['productCategory']}</option>";
                                                            }
                                                            
                                                        ?>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <label class="form-label" style="font-size: 20px;">Product Description</label>
                                                        <textarea name="productDescription" class="form-control" style="font-size: 16px; border: 1px solid black;" required></textarea>
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="row g-3">
                                                    <div class="col-md-2">
                                                        <?php
                                                            $productID='';
                                                            $maxID =0;
                                                            $sql2="SELECT productID FROM product";
                                                            $result2=mysqli_query($conn,$sql2);
                                                            while ($r2 = mysqli_fetch_assoc($result2))
                                                            {
                                                                $productID=(int) substr($r2['productID'],1);
                                                                if($productID>$maxID)
                                                                {
                                                                    $maxID =$productID;
                                                                }

                                                            }

                                                            $maxID =$maxID+1;

                                                            if($maxID>=10)
                                                            {
                                                                $productID = 'P'.$maxID;
                                                            }
                                                            else
                                                            {
                                                                $productID = 'P'.$maxID;
                                                            }
                                                            

                                                        ?>
                                                        <label class="form-label" style="font-size: 20px;">Product ID</label>
                                                        <input type="text" name="productID" class="form-control" style="font-size: 16px; border: 1px solid black;" value='<?php echo $productID ?>' readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4">
                                            <div class="bg-secondary-soft px-4 py-5 rounded">
                                                <div class="row g-3">
                                                    <h4 class="mb-4 mt-0" style="text-align: center; font-size: 25px;">Product Image</h4>
                                                    <div class="text-center">

                                                        <!-- Rounded profile picture -->
                                                        <div class="overflow-hidden mx-auto mb-3" style="width: 250px; height: 240px;border:2px solid black;border-radius:15px">
                                                            <img id="productImage" src="/shoppink/assets/images/not_available.jpg"  class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                                        </div>

                                                        <input type="file" id="customFile" name="productImage" onchange="checkImageSize(this)" hidden accept="image/*">
                                                        <label class="btn btn-success-soft btn-block" for="customFile">Upload</label>
                                                        <!--<label class="btn btn-danger-soft btn-block" onclick="removeProfileImage()">Remove</label>-->

                                                        <!-- <p class="text-muted mt-3 mb-0"><span class="me-1">Note:</span>Minimum size 300px x 300px</p> -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="gap-5 d-md-flex justify-content-md-left text-center mx-auto" style="padding-left: 20px">
                                        <a href="javascript:window.history.back();">
                                            <button type="button" class="btn btn-primary btn-lg">Back</button>
                                        </a>
                                        <button type="submit" name="addProduct" class="btn btn-lg" style="background-color: #5cb85c; color: #ffffff; margin-left: 0%">Add product</button>
                                        <!--<button type="button" class="btn btn-danger btn-lg">Delete profile</button>-->
                                    </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>




    

    <!-- =========== Scripts =========  -->
    <script src="/shoppink/assets/js/admin.js"></script>
    <script src="/shoppink/assets/js/logout.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="/shoppink/assets/js/product_detail.js"></script>

    <!-- ======= Charts JS ====== -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    <!-- <script src="/shoppink/assets/js/chartsJS.js"></script> -->

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>

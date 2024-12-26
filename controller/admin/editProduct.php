<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit; 
}

if (isset($_POST['updateProduct'])) {
    $productID = $_POST['productID'];
    $productName = mysqli_real_escape_string($conn, $_POST['productName']);
    $productPrice = mysqli_real_escape_string($conn, $_POST['productPrice']);
    $productQuantity = mysqli_real_escape_string($conn, $_POST['productQuantity']);
    $productCategory = mysqli_real_escape_string($conn, $_POST['productCategory']);
    $productDescription = mysqli_real_escape_string($conn, $_POST['productDescription']);
    $productImagePath = '';

    // Directory to store uploaded images
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/shoppink/assets/productImage/';

    // Check if the directory exists, if not, create it
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $targetFile = $targetDir . basename($_FILES['productImage']['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if the file is an actual image
        $check = getimagesize($_FILES['productImage']['tmp_name']);
        if ($check !== false) {
            if (move_uploaded_file($_FILES['productImage']['tmp_name'], $targetFile)) {
                $productImagePath = '/shoppink/assets/productImage/' . basename($_FILES['productImage']['name']);
                // Update query for the product image
                $productImageQuery = ", productImage = '$productImagePath'";
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    } else {
        $productImageQuery = '';
    }

    // Update query for the product details
    $updateQuery = "UPDATE product SET 
        productName = '$productName', 
        productPrice = '$productPrice', 
        productQuantity = '$productQuantity', 
        productCategory = '$productCategory', 
        productDescription = '$productDescription' 
        $productImageQuery 
        WHERE productID = '$productID'";

    if (mysqli_query($conn, $updateQuery)) {
        echo "Product updated successfully.";
        header("Location: /shoppink/view/admin/manage_product.php?alert=productEdit");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else if (isset($_POST['deleteProduct'])) {

    $productID = $_POST['productID'];

    $sql = "DELETE FROM product WHERE productID = '$productID'";

    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully.";
        header("Location: /shoppink/view/admin/manage_product.php?alert=delete");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

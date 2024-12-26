<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit;
}

if (isset($_POST['addProduct'])) {
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
            } else {
                echo "Sorry, there was an error uploading your file.";
                exit;
            }
        } else {
            echo "File is not an image.";
            exit;
        }
    } else {
        // Set a default image path if no image is provided
        $productImagePath = '/shoppink/assets/images/not_available.jpg';
    }

    // Insert query for the product details
    $sql = "INSERT INTO product (
            productID,
            productName, 
            productPrice, 
            productQuantity, 
            productCategory, 
            productDescription, 
            productImage
        ) VALUES (
            '$productID', 
            '$productName', 
            '$productPrice', 
            '$productQuantity', 
            '$productCategory', 
            '$productDescription', 
            '$productImagePath'
        )";

    if (mysqli_query($conn, $sql)) {
        echo "Product added successfully.";
        header("Location: /shoppink/view/admin/manage_product.php?alert=productAdd");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

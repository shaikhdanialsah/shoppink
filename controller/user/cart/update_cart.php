<?php
require_once '../../../includes/dbconn.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);
    $itemcount = mysqli_real_escape_string($conn, $_POST['itemcount']);
    $cartID = (int)$_SESSION['cartID']; // Ensure $cartID is cast to an integer for security

    // Construct the query using double quotes for string interpolation
    $q = "UPDATE cartdetails SET itemcount = '$itemcount' WHERE productID = '$productID' AND cartID = '$cartID'";
    if (mysqli_query($conn, $q)) {
        header("Location: ../../../view/user/cart.php");
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }

}
?>

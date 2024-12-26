<?php
require_once '../../../includes/dbconn.php';
session_start();

if (isset($_POST['delete'])) {
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);
    $cartID = (int)$_SESSION['cartID'];

    $q = "DELETE FROM cartdetails WHERE productID='$productID' AND cartID='$cartID'";
    if (mysqli_query($conn, $q)) {
        header("Location: ../../../view/user/cart.php?alert=delete");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

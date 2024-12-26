<?php
require_once '../../../includes/dbconn.php';
session_start();

if (isset($_POST['submit'])) {
    $productID = mysqli_real_escape_string($conn, $_POST['productID']);
    $itemcount = mysqli_real_escape_string($conn, $_POST['itemcount']);
    $cartID = mysqli_real_escape_string($conn, $_SESSION['cartID']);
    $cartID = (int)$_SESSION['cartID'];

    // Fetch the current itemcount for the given productID
    $query = "SELECT itemcount FROM cartdetails WHERE productID='$productID' AND cartID = '$cartID'";
    $res = mysqli_query($conn, $query);

    if (mysqli_num_rows($res) > 0) {
        // Fetch the current itemcount
        $row = mysqli_fetch_assoc($res);
        $existingItemCount = (int)$row['itemcount'];

        // Calculate the new total itemcount
        $total = $existingItemCount + (int)$itemcount;

        // Update the itemcount in the cart
        $q = "UPDATE cartdetails SET itemcount = '$total' WHERE productID = '$productID' AND cartID = '$cartID'";
        if (mysqli_query($conn, $q)) {
            header("Location: ../../../view/user/cart.php?alert=add");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        // Insert a new record into the cart
        $q = "INSERT INTO cartdetails (productID, itemcount, cartID) VALUES ('$productID', '$itemcount', '$cartID')";
        if (mysqli_query($conn, $q)) {
            header("Location: ../../../view/user/cart.php?alert=add");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

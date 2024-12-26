<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit; 
}

$userID = (int)$_SESSION['username'];
if(isset($_POST['submit'])) 
{
    $totalprice=(double)$_POST['totalprice'];
    $statusorder=$_POST['statusorder'];
    $userID=(int)$_POST['userID'];
    $cartID = (int)$_SESSION['cartID'];
    $usedpoints=(double)$_POST['usedpoints'];
    $receivepoints=(double)$_POST['receivepoints'];
    $shipname=$_POST['shipname'];
    $shipaddress=$_POST['shipaddress'];
    $shipnumber=$_POST['shipnumber'];
    $total=(double)$_POST['total'];

    if (isset($_FILES['paymentproof']) && $_FILES['paymentproof']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['paymentproof']['tmp_name'];
        $fileName = $_FILES['paymentproof']['name'];
        $fileSize = $_FILES['paymentproof']['size'];
        $fileType = $_FILES['paymentproof']['type'];
        
        // Read the file content
        $fileContent = file_get_contents($fileTmpPath);

        // Escape the binary data before storing in the database
        $fileContentEscaped = mysqli_real_escape_string($conn, $fileContent);
    } else {
        echo 'No file uploaded or there was an upload error.';
        exit();
    }

    $q1 = "INSERT INTO ordertable (totalprice, statusorder, userID, paymentproof, filetype, receivepoints, usedpoints, shipname, shipaddress, shipnumber, total) VALUES ('$totalprice', '$statusorder','$userID', '$fileContentEscaped', '$fileType', '$receivepoints', '$usedpoints', '$shipname', '$shipaddress', '$shipnumber','$total' )";
    if(mysqli_query($conn, $q1))
    {
        $orderID=mysqli_insert_id($conn);
        $q2= "SELECT * FROM cartdetails JOIN product ON cartdetails.productID = product.productID WHERE cartID ='$cartID' AND product.productQuantity>0";
        $res2= mysqli_query($conn, $q2);

        while ($r = mysqli_fetch_assoc($res2))
        {
            $productID =$r['productID'];
            $itemcount= (int)$r['itemcount'];
            $q3 = "INSERT INTO orderdetails (productID, itemcount,orderID) VALUES ('$productID', '$itemcount', '$orderID')";
            $res3 = mysqli_query($conn, $q3);

            $sql = "SELECT * FROM product WHERE productID='$productID'";
            $result = mysqli_query($conn, $sql);
            $r2 = mysqli_fetch_assoc($result);

            $productQuantity = $r2['productQuantity'] - $itemcount;

            $q7 = "UPDATE product SET productQuantity='$productQuantity' WHERE productID='$productID'";
            $res7 = mysqli_query($conn, $q7);
        }

        $q4 = "DELETE FROM cartdetails WHERE cartID='$cartID'";
        $res4 = mysqli_query($conn, $q4);

        $q5 ="SELECT * FROM user WHERE userID ='$userID'";
        $res5 = mysqli_query($conn, $q5);
        $r=mysqli_fetch_assoc($res5);

        $points = (double)$r['points'] - $usedpoints;

        $q6="UPDATE user SET points='$points' WHERE userid='$userID'";
        $res6 = mysqli_query($conn, $q6);


        

        header("Location: /shoppink/view/user/purchases.php?alert=ordersuccess");
    }

    

}
<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit; 
}


if (isset($_POST['approveOrder'])) {
    $userID = (int)$_POST['userID'];
    $orderID = (int)$_POST['orderID'];
    $orderStatus=$_POST['orderStatus'];

    $sql1 = "SELECT * FROM user WHERE userID='$userID'";
    $resu1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($resu1);
    $currentpoints=(double)$row1['points'];

    $sql2 = "SELECT * FROM ordertable WHERE orderID='$orderID'";
    $resu2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($resu2);
    $receivepoints=(double)$row2['receivepoints'];
    $usedpoints=(double)$row2['usedpoints'];

    if($orderStatus == "Approve")
    {
        $updateQuery = "UPDATE ordertable SET 
        statusorder = 'Delivering'
        WHERE orderID = '$orderID'";

        $points=$currentpoints+$receivepoints;
        $updateQuery2 = "UPDATE user SET 
        points = '$points'
        WHERE userID = '$userID'";

    }
    else
    {
        $updateQuery = "UPDATE ordertable SET 
        statusorder = 'Canceled'
        WHERE orderID = '$orderID'";

        $points=$currentpoints+$usedpoints;
        $updateQuery2 = "UPDATE user SET 
        points = '$points'
        WHERE userID = '$userID'";

    }
    
    if (mysqli_query($conn, $updateQuery)) {
        if (mysqli_query($conn, $updateQuery2))
        {
            header("Location: /shoppink/view/admin/admin_order.php?alert=verify");
            exit;
        }   
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

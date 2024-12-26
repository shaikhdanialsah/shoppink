<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /shoppink/login.php");
    exit; 
}

$currentDate = date("d-m-Y");

// Calculate the date 30 days from now in the format YYYY-MM-DD
$expired = date("d-m-Y", strtotime("+30 days"));

echo $_POST['userID'];
if (isset($_POST['approveMembership'])) {
    $userID = (int)$_POST['userID'];
    $membershipStatus = $_POST['membershipStatus'];
    $membership = $_POST['membership'];

    $sql1 = "SELECT * FROM user WHERE userID='$userID'";
    $resu1 = mysqli_query($conn, $sql1);
    $row1 = mysqli_fetch_assoc($resu1);

    if ($membershipStatus == "Approve") {
        if ($membership == "Bronze II") {
            $membership = "Bronze";
            $points = (double)$row1['points'];
        } elseif ($membership == "Silver II") {
            $membership = "Silver";
            $points = (double)$row1['points'];
        } elseif ($membership == "Gold II") {
            $membership = "Gold";
            $points = (double)$row1['points'] + 500;
        }
    } elseif ($membershipStatus == "Reject") {
        $membership = "Inactive";
        $points = (double)$row1['points'];
    } else {
        $membership = $membership;
        $points = (double)$row1['points'];
    }

    if($membershipStatus == "Approve")
    {
        $updateQuery = "UPDATE user SET 
        membership = '$membership', 
        points = '$points',
        startdate='$currentDate',
        finishdate='$expired'
        WHERE userID = '$userID'";

    }
    else
    {
        $updateQuery = "UPDATE user SET 
        membership = '$membership', 
        points = '$points',
        startdate=NULL,
        finishdate=NULL,
        paymentproof=NULL,
        filetype=NULL
        WHERE userID = '$userID'";

    }
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "Membership updated successfully.";
        header("Location: /shoppink/view/admin/admin_membership.php?alert=verify");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
else if(isset($_POST['updateMembership']))
{
    $userID = (int)$_POST['userID'];
    $membership = $_POST['membership'];

    if($membership=='Inactive')
    {
        $updateQuery = "UPDATE user SET 
        membership = '$membership', 
        startdate=NULL,
        finishdate=NULL,
        paymentproof=NULL,
        filetype=NULL
        WHERE userID = '$userID'";
    }

    if (mysqli_query($conn, $updateQuery)) {
        echo "Membership updated successfully.";
        header("Location: /shoppink/view/admin/customer_profile.php?userID=" . urlencode($userID) . "&alert=memberUpdate");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }

}
else
{
    echo "Kosong bbutton input";
}
?>

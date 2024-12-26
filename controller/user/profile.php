<?php
// Include the database connection file
require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

// Start the session to access session variables
session_start();

// Check if the user is logged in (you should have session authentication logic here)
if (!isset($_SESSION['username'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: /shoppink/login.php");
    exit; // Stop further execution
}

// Retrieve username from session (assuming it's safe to use directly)
$username = (int)$_SESSION['username'];

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Sanitize and validate input data (for security purposes)
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $updateProfilePic = '';
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        // Define the folder path
        $folderPath = $_SERVER['DOCUMENT_ROOT'] . '/shoppink/assets/profileImage/';
        
        // Check if the folder exists, if not, create it
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // Get the file name and path
        $fileName = basename($_FILES['profile_pic']['name']);
        $filePath = $folderPath . $fileName;

        // Move the uploaded file to the profileImage folder
        if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $filePath)) {
            // Store the relative path in the database
            $relativePath = '/shoppink/assets/profileImage/' . $fileName;
            $updateProfilePic = ", profile_pic = '$relativePath'";
        } else {
            echo 'Error uploading the profile picture.';
            exit;
        }
    }

    // Update user data query
    $q = "UPDATE user SET name = '$name', phone = '$phone', email = '$email', address = '$address' $updateProfilePic WHERE userID = '$username'";

    // Execute the query
    if (mysqli_query($conn, $q)) {
        if (strlen($name) > 12) {
            $_SESSION['name'] = substr(strtoupper($name), 0, 13);
        } else {
            $_SESSION['name'] = strtoupper($name);
        }

        header("Location: ../../view/user/profile.php?alert=save");
        exit; // Stop further execution
    } else {
        // Handle query execution error
        echo 'Error: ' . mysqli_error($conn);
    }
} else if (isset($_POST['submitPassword'])) {
    $password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $q = "UPDATE user SET password = '$password' WHERE userID = '$username'";

    if (mysqli_query($conn, $q)) {
        header("Location: ../../view/user/profile.php?alert=save");
        exit;
    } else {
        // Handle query execution error
        echo 'Error: ' . mysqli_error($conn);
    }
} else if (isset($_POST['changeSubscription'])) {
    $membershipID = $_POST['plan'];

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

    $q = "UPDATE user 
      SET membership = '$membershipID',
          paymentproof = '$fileContentEscaped', 
          filetype = '$fileType',
          startdate = '', 
          finishdate = '' 
      WHERE userID = '$username'";

    if (mysqli_query($conn, $q)) {
        header("Location: ../../view/user/membership.php?alert=subscription");
        exit;
    } else {
        // Handle query execution error
        echo 'Error: ' . mysqli_error($conn);
    }
}
?>

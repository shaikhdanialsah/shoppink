<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/shoppink/includes/dbconn.php');

session_start();
$inactive = 1800;

// Check if the session variable for the last activity is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session's lifetime
    $session_lifetime = time() - $_SESSION['last_activity'];
    
    // If the session has been inactive for too long, destroy it
    if ($session_lifetime > $inactive) {
        session_unset();    // Unset session variables
        session_destroy();  // Destroy the session
    }
}

// Update the last activity time stamp
$_SESSION['last_activity'] = time();



if(isset($_POST['Login']))
{
    $username=$_POST['email'];
    echo $username;
    $password=$_POST['password'];
    echo $password;
    $sql = "SELECT * FROM user u WHERE u.email='$username'";
				
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);

				if (mysqli_num_rows($result) == 1&&$row['roleID']=='2'&&$password==$row['password'])
				{
					$userID = $row['userID'];
					$name = $row['name'];

					// Prepare and execute the SQL query to retrieve cartID
					$q = "SELECT cartID FROM cart WHERE userID = ?";
					$stmt = mysqli_prepare($conn, $q);
					mysqli_stmt_bind_param($stmt, "s", $userID);
					mysqli_stmt_execute($stmt);
					$result = mysqli_stmt_get_result($stmt);

					// Fetch the cartID from the result
					if ($r = mysqli_fetch_assoc($result)) {
						// Assign values to session variables
						$_SESSION['username'] = $userID;
						if(strlen($name)>12)
						{
							$_SESSION['name'] = substr(strtoupper($name), 0, 13);
						}
						else
						{
							$_SESSION['name'] = strtoupper($name);
						}
						
						$_SESSION['cartID'] = $r['cartID'];
					}

					//redirect to page based on role
						header("Location: ../index.php?alert=success");
						exit();	
					
				}
                else if(mysqli_num_rows($result) == 1&&$row['roleID']=='1'&&$password==$row['password'])
                {
                    $userID = $row['userID'];
                    $_SESSION['username'] = $userID;
                    header("Location: ../view/admin/admin.php?alert=success");
					exit();
                }
                else
                {
                    header("Location: ../login.php?alert=error");
					exit();
                }
}

if (isset($_POST['Register'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['emailRegister'];
    $password = $_POST['passwordRegister'];
    $roleID = '2';
    $membershipID = $_POST['plan'];
    $points = 0;

    // Handle file upload
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

    // Insert user information into the database
    $q = "INSERT INTO user (name, email, phone, address, roleID, password, membership, points, paymentproof, filetype) 
          VALUES ('$name', '$email', '$phone', '$address', '$roleID', '$password', '$membershipID', '$points', '$fileContentEscaped', '$fileType')";

    if (mysqli_query($conn, $q)) {
        // Get the last inserted userID
        $userID = mysqli_insert_id($conn);

        // Insert the userID into the cart table
        $q2 = "INSERT INTO cart(userID) VALUES ('$userID')";
        if (mysqli_query($conn, $q2)) {
            header("Location: /shoppink/login.php?alert=register");
            exit();
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>


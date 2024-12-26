<?php
        $emailArray = array(); // Initialize an empty array to store emails

        $sql = "SELECT email FROM user";
        $result = mysqli_query($conn, $sql);
                                
        if (mysqli_num_rows($result) > 0) 
        {
            while ($row = mysqli_fetch_assoc($result)) {
            $emailArray[] = $row['email']; // Append each email to the $emailArray
            }
        } else 
        {
         echo "No emails found";
        }
?>
<script>
        var javascriptArray = <?php echo json_encode($emailArray); ?>;

function validation() {
    var email = document.getElementsByName('emailRegister')[0].value;
    var password = document.getElementsByName('passwordRegister')[0].value;

    // Check if email exists
    var emailExists = false;
    for (var i = 0; i < javascriptArray.length; i++) {
        if (javascriptArray[i] === email) {
            emailExists = true;
            break;
        }
    }

    if (emailExists) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Email has already been taken!',
        });
        return false;
    }

    // Password validation
    var messages = [];
    if (password.length >= 8) {
        messages.push('<span style="color: green;">&#x2714; Password is at least 8 characters long.</span>');
    } else {
        messages.push('<span style="color: red;">&#x2716; Password must be at least 8 characters long.</span>');
    }
    if (/[A-Z]/.test(password)) {
        messages.push('<span style="color: green;">&#x2714; Password contains at least one capital letter.</span>');
    } else {
        messages.push('<span style="color: red;">&#x2716; Password must contain at least one capital letter.</span>');
    }
    if (/[!@#$%^&*]/.test(password)) {
        messages.push('<span style="color: green;">&#x2714; Password contains at least one symbol.</span>');
    } else {
        messages.push('<span style="color: red;">&#x2716; Password must contain at least one symbol.</span>');
    }

    if (messages.some(message => message.includes('red'))) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Password',
            html: messages.join('<br>')
        });
        return false;
    }

    return true;
}

    </script>
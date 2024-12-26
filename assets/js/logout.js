document.getElementById('logoutLink').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the default action

    Swal.fire({
        title: 'Are you sure you want to logout?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        //imageUrl: 'https://sweetalert2.github.io/images/nyan-cat.gif',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, log out!',
        background: 'rgb(250, 248, 248)', // Optional, if you want a background color
        backdrop: `
            rgba(0,0,0,0.4)
            left top
        ` // Optional, you can use a GIF or image in the background
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/shoppink/login.php?alert=successlogout'; // Redirect to the logout page
        }
    });
});

function togglePasswordVisibility() {
    const passwordInput = document.getElementById('passwordInput');
    const togglePassword = document.getElementById('togglePassword');

    // Toggle the password field's type attribute between 'password' and 'text'
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        togglePassword.innerHTML = '<i class="bi bi-eye-slash" style="cursor: pointer;" onclick="togglePasswordVisibility()"></i>';
    } else {
        passwordInput.type = 'password';
        togglePassword.innerHTML = '<i class="bi bi-eye" style="cursor: pointer;" onclick="togglePasswordVisibility()"></i>';
    }
}

function confirmation(event) {
event.preventDefault(); // Prevent the form from submitting immediately

Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to edit this customer's membership status?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, update it!'
}).then((result) => {
    if (result.isConfirmed) {
        // If confirmed, submit the form
        document.getElementById('membershipForm').submit();
    }
});
}

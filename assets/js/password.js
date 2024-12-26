const inputs = document.querySelectorAll('.inputs');
const icons = document.querySelectorAll('.eye-icon');

function checkOldPassword() {
    var old_pass = document.getElementById('old_pass').value;
    var oldpassword = document.getElementById('oldpassword').textContent.trim();
    var newpassword = document.getElementById('new_password').value;

    if (old_pass !== oldpassword) {
        document.getElementById('error').textContent = 'This is not your old password';
        document.getElementById('errorNew').textContent = '';
        return false;
    } else {
        if (newpassword === old_pass) {
            document.getElementById('errorNew').textContent = 'New password cannot be the same as old password';
            document.getElementById('error').textContent = '';
            return false;
        }
        document.getElementById('errorNew').textContent = '';
        document.getElementById('error').textContent = '';
    }

    // Password validation
    var messages = [];
    if (newpassword.length >= 8) {
        messages.push('<span style="color: green;">&#x2714; Password is at least 8 characters long.</span>');
    } else {
        messages.push('<span style="color: red;">&#x2716; Password must be at least 8 characters long.</span>');
    }
    if (/[A-Z]/.test(newpassword)) {
        messages.push('<span style="color: green;">&#x2714; Password contains at least one capital letter.</span>');
    } else {
        messages.push('<span style="color: red;">&#x2716; Password must contain at least one capital letter.</span>');
    }
    if (/[!@#$%^&*]/.test(newpassword)) {
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

Array.from(inputs).forEach((input, index) => {
    const icon = icons[index]; // Get the corresponding icon for each input
    icon.innerHTML = `<img src="/shoppink/assets/images/eye.svg" alt="" />`;

    icon.addEventListener("click", () => {
        const type = input.getAttribute("type");
        if (type === "password") {
            input.setAttribute("type", "text");
            icon.innerHTML = `<img src="/shoppink/assets/images/hide.svg" alt="" />`;
        } else if (type === "text") {
            input.setAttribute("type", "password");
            icon.innerHTML = `<img src="/shoppink/assets/images/eye.svg" alt="" />`;
        }
    });
});
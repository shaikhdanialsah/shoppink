        const fileInput = document.getElementById('file-input');
        const profilePic = document.getElementById('profile-pic');

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profilePic.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const phoneInput = document.getElementById('phoneInput');
            
            phoneInput.addEventListener('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });
          });
          
          document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('nameInput');
            
            nameInput.addEventListener('input', function() {
                this.value = this.value.replace(/[0-9]/g, '');
            });
          });

          function showInfoPopup() {
            // Example of using SweetAlert2
            Swal.fire({
                title: 'Information',
                html: '<p style="color:black">The email address is for <b>view</b> only</p>',
                icon: 'info',
                confirmButtonText: 'Close'
            });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('profile-form');
            const saveButton = document.getElementById('save-button');
        
            // Function to enable the Save button if any input field changes
            const enableSaveButton = () => {
                saveButton.disabled = false;
                saveButton.classList.remove('disabled-button');
            };
        
            // Get all input fields
            const inputs = form.querySelectorAll('input[type="text"], input[type="file"], textarea');
        
            // Add event listeners to all input fields
            inputs.forEach(input => {
                input.addEventListener('input', enableSaveButton);
            });
            });
        
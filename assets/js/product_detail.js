const fileInput = document.getElementById('customFile');
const productImage = document.getElementById('productImage');

fileInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            productImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('formID').addEventListener('submit', function(event) {
var quantityInput = document.getElementById('productQuantity');
if (quantityInput.value <= 0) {
    event.preventDefault(); // Prevent form submission
    alert('Product quantity cannot be 0.'); // Alert user
}
});
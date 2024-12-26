document.addEventListener("DOMContentLoaded", function() {
    function updateButtons(row) {
        const input = row.querySelector('.form-control');
        const btnMinus = row.querySelector('.js-btn-minus');
        const btnPlus = row.querySelector('.js-btn-plus');
        const itemsLeft = parseInt(row.querySelector('.item-left').innerText.match(/\d+/)[0], 10);
        const value = parseInt(input.value, 10);
        btnMinus.disabled = value <= 1;
        btnPlus.disabled = value >= itemsLeft;
    }

    function updateTotalPrice(row) {
        const priceElement = row.querySelector('td:nth-child(3) span');
        const totalPriceElement = row.querySelector('td:nth-child(5) span');
        const price = parseFloat(priceElement.innerText);
        const quantity = parseInt(row.querySelector('.form-control').value, 10);
        const totalPrice = (price * quantity).toFixed(2);
        totalPriceElement.innerText = totalPrice;
    }

    function getRowCount() {
        const rowCount = document.querySelectorAll('tbody tr').length;
        document.getElementById('total-item').innerText = "(" +rowCount+ " items)";
        return rowCount;
    }

    function calculateTotalPrice() {
        let totalPrice = 0;
        document.querySelectorAll('tbody tr').forEach(row => {
            const totalProductPriceElement = row.querySelector('td:nth-child(5) span');
            const totalProductPrice = parseFloat(totalProductPriceElement.innerText);
            totalPrice += totalProductPrice;
        });
        document.getElementById('total-price').innerText = totalPrice.toFixed(2);
    }

    function updateItemCount(productID, itemCount, itemCountInput) {
        $.ajax({
            url: '/shoppink/controller/user/cart/update_cart.php',
            method: 'POST',
            data: { productID: productID, itemcount: itemCount },
            success: function(response) {
                itemCountInput.val(itemCount);
                updateButtons(itemCountInput.closest('tr'));
                updateTotalPrice(itemCountInput.closest('tr'));
                calculateTotalPrice();
            },
            error: function() {
                alert('Error updating cart');
            }
        });
    }

    document.querySelectorAll('.js-btn-minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const input = row.querySelector('.form-control');
            let value = parseInt(input.value, 10);
            if (value > 1) {
                input.value = --value;
                updateButtons(row);
                updateTotalPrice(row);
                calculateTotalPrice();
                const productID = row.querySelector('.product-name').dataset.productId;
                updateItemCount(productID, value, input);
            }
        });
    });

    document.querySelectorAll('.js-btn-plus').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const input = row.querySelector('.form-control');
            let value = parseInt(input.value, 10);
            const itemsLeft = parseInt(row.querySelector('.item-left').innerText.match(/\d+/)[0], 10);
            if (value < itemsLeft) {
                input.value = ++value;
                updateButtons(row);
                updateTotalPrice(row);
                calculateTotalPrice();
                const productID = row.querySelector('.product-name').dataset.productId;
                updateItemCount(productID, value, input);
            }
        });
    });

    document.querySelectorAll('tbody tr').forEach(row => {
        updateButtons(row);
        updateTotalPrice(row); // Initialize the total price on page load
    });

    calculateTotalPrice(); // Calculate the initial total price on page load
    getRowCount(); // Calculate the initial row count on page load
});

function checkoutalert1() {
    // Example of using SweetAlert2
    Swal.fire({
        title: 'Error',
        html: '<p style="color:black">Only approved member can proceed to checkout<br><br>Your status: <b>Inactive</b></p>',
        icon: 'error',
        confirmButtonText: 'Close'
    });
}

function checkoutalert2() {
    // Example of using SweetAlert2
    Swal.fire({
        title: 'Error',
        html: '<p style="color:black">Only approved member can proceed to checkout<br><br>Your status: <b>Waiting for admin approval</b></p>',
        icon: 'error',
        confirmButtonText: 'Close'
    });
}

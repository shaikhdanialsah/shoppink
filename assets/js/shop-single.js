document.addEventListener('DOMContentLoaded', function() {
    var productQuantity = parseInt(document.getElementById('productQuantity').innerText);
    const itemCountInput = document.getElementById('itemcount');
    const btnMinus = document.getElementById('btn-minus');
    const btnPlus = document.getElementById('btn-plus');
    const addToCartButton = document.getElementById('add-to-cart');
    var itemcart_total = parseInt(document.getElementById('itemcart_total').innerText);

    // Update the input value based on button clicks
    btnMinus.addEventListener('click', function() {
        let currentCount = parseInt(itemCountInput.value);
        if (currentCount > 1) {
            itemCountInput.value = currentCount - 1;
            document.getElementById('warning').innerHTML="&nbsp;";
        }
        updateButtonState();
    });

    btnPlus.addEventListener('click', function() {
        var product = productQuantity - itemcart_total;
        let currentCount = parseInt(itemCountInput.value);
        if (currentCount < product) {
            itemCountInput.value = currentCount + 1;
            document.getElementById('warning').innerHTML="&nbsp;";
        }
        else if(currentCount==product)
        {
            document.getElementById('warning').innerHTML="You have reach the maximum purchase limit";
        }
        updateButtonState();
    });

    // Update the Add to Cart button state based on the input value
    itemCountInput.addEventListener('input', function() {
        var product = productQuantity - itemcart_total;
        let currentCount = parseInt(itemCountInput.value);
        if (isNaN(currentCount) || currentCount < 1) {
            itemCountInput.value = 1;
        } else if (currentCount > product) {
            itemCountInput.value = product;
        }
        updateButtonState();
    });

    function updateButtonState() {
        let currentCount = parseInt(itemCountInput.value);
    }

    // Initialize the button state
    updateButtonState();
});
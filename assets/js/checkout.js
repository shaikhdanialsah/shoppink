// checkoutUtils.js

function formatNumberWithCommas(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function toggleSwitch() {
    var usepoints = parseFloat(document.getElementById("usepoints").innerHTML);
    var checkbox = document.getElementById("checkbox");
    var usepointsRM = usepoints / 100;
    var totalprice = parseFloat(document.getElementById("totalpriceRM").innerHTML);
    var priceafter = totalprice - usepointsRM;

    if (checkbox.checked) {
        document.getElementById('usedpoints').value = usepoints;
        var totalElement = document.querySelector('.total');
        var discount = document.querySelector('.discount');
        totalElement.setAttribute('data-value', 'RM ' + formatNumberWithCommas((priceafter+4.9).toFixed(2)));
        discount.setAttribute('data-value', '- RM ' + formatNumberWithCommas(usepointsRM.toFixed(2)));
        document.getElementById('total').value = (priceafter+4.9).toFixed(2);
    } else {
        document.getElementById('usedpoints').value = 0;
        var totalElement = document.querySelector('.total');
        var discount = document.querySelector('.discount');
        totalElement.setAttribute('data-value', 'RM ' + formatNumberWithCommas((totalprice+4.9).toFixed(2)));
        discount.setAttribute('data-value', '- RM 0.00');
        document.getElementById('total').value = (totalprice+4.9).toFixed(2);
    }
}

function toggleEdit() {
    var inputs = document.querySelectorAll('.billing-info .inputs');
    var button = document.getElementById('edit-button');
    inputs.forEach(function(input) {
        if (input.readOnly) {
            input.readOnly = false;
            input.classList.add('editable');
            button.innerText = 'Save';
        } else {
            input.readOnly = true;
            input.classList.remove('editable');
            button.innerText = 'Edit';
        }
    });
}

document.getElementById('checkout-form').addEventListener('submit', function(event) {
    var isEditable = document.querySelector('.billing-info .inputs.editable');
    if (isEditable) {
        event.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Unsaved Changes',
            text: 'Please save your billing information first before proceeding.',
            confirmButtonText: 'OK'
        });
    }
});

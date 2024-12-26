function viewPaymentProof(filetype, paymentproof) {
    // Create a new window to display the payment proof
    var newWindow = window.open('', '_blank');
    
    // HTML content to display the image or PDF
    var content = '';
    if (filetype.indexOf('image') === 0) {
        content = '<img src="data:' + filetype + ';base64,' + paymentproof + '" style="max-width: 50%; max-height: 80%; display: block; margin: auto;" />';
    } else {
        content = '<embed src="data:application/pdf;base64,' + paymentproof + '" type="application/pdf" style="width: 100%; height: 100%;" />';
    }

    // Constructing the full HTML page with centered content
    var html = '<html><head><title>Payment Proof</title>';
    html += '<style>html, body { height: 100%; margin: 0; } body { display: flex; justify-content: center; align-items: center; }</style>';
    html += '</head><body>';
    html += content;
    html += '</body></html>';

    // Write the HTML content to the new window
    newWindow.document.write(html);

    // Prevent the default action of the anchor tag
    return false;
}

function showInfoPopup() {
    // Example of using SweetAlert2
    Swal.fire({
        title: 'Subscription Information',
        html: '<p style="color:black">For any Gold, Silver and Bronze subscription that ends with <b>"II"</b> indicates that their membership is pending for admin approval </p>',
        icon: 'info',
        confirmButtonText: 'Close'
    });
}

function showAlert() {
    Swal.fire({
        title: 'Are you sure?',
        html: '<p style="color:black"><b>Information:</b> You currently have an active subscription. Please note that by changing your subscription, your current plan will be replaced with your new plan, and your action cannot be undone.</p>',
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to the subscription page if user clicks 'Proceed'
            window.location.href = '/shoppink/view/user/subscription.php';
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Handle the cancel action if needed
            console.log('Action canceled');
        }
    });
}
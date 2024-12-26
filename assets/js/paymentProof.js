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
function deleteConfirmation(event) {
    event.preventDefault(); // Prevent the form from submitting immediately
    Swal.fire({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: "Yes, delete it!"
            }).then((result) => {
        if (result.isConfirmed) {
            event.target.submit(); // Submit the form if the user confirms
        }
    });
}
$(document).ready(function () {
    // Attach the delete functionality to all delete buttons
    $('.delete-btn').on('click', function (e) {
        e.preventDefault();

        const showId = $(this).data('id'); // Get the show ID from the data attribute

        // Call the function to handle the deletion
        handleDelete(showId);
    });
});


// Function to handle the delete operation with SweetAlert2 and AJAX
function handleDelete(showId) {
    const deleteUrl = "/Admin/delete_show/" + showId; // URL to delete the show

    // Ask for confirmation using SweetAlert2
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Send AJAX request to delete the show
            $.ajax({
                url: deleteUrl,
                method: 'POST', // POST is more secure for deleting
                success: function (response) {
                    // Handle the server response (success or failure)
                    if (response.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload(); // Reload the page to reflect the changes
                        });
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function () {
                    Swal.fire(
                        'Error!',
                        'There was a problem with the request.',
                        'error'
                    );
                }
            });
        }
    });
}


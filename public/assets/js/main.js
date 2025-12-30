$(function () {
    $(".open_modal").on("click", open_modal);
    $(".delete-employee").on("click", confirm_delete);
        showFlashData();

});

function showFlashData() {
    var flashData = $('#flash-data');
    if (!flashData.length) return; // geen flashdata aanwezig

    var successMessage = flashData.data('success');
    var errorMessage   = flashData.data('error');

    if (successMessage) {
        toastr.success(successMessage);
    }

    if (errorMessage) {
        toastr.error(errorMessage);
    }
}

function open_modal() {
    var name = $(this).data("name");
    var controller = $(this).data("controller");

    $.ajax({
        url: controller,
        type: "GET",
        dataType: "html",
        success: function(response) {
            $(name+" .modal-content").html(response);
            $(name).modal("show");
        },
        error: function() {
            console.log("Error loading controller function");
        }
    });
}

// Nieuwe functie voor SweetAlert2 confirm
function confirm_delete(e) {
    e.preventDefault(); // voorkom directe redirect
    var url = $(this).data("url");

    Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to delete this employee?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

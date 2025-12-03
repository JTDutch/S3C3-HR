var id = $(".id").val();
$(function () {
    $(".add-link").on("click", add_link);
    $(".remove-link").on("click", remove_link);
    $("#btn_new_to_in_progress, #btn_in_progress_to_done, #btn_in_progress_to_new, #btn_done_to_in_progress").on("click", handleStatusChange);
    $(".btn_delete").on("click", delete_mail);

});

function add_link() {
    let controller = $(this).data("controller");

    Swal.fire({
        title: 'Voeg link toe',
        input: 'url',
        inputLabel: 'Voer een geldige URL in',
        inputPlaceholder: 'https://voorbeeld.nl',
        showCancelButton: true,
        confirmButtonText: 'Opslaan',
        cancelButtonText: 'Annuleren',
        inputValidator: (value) => {
            if (!value) {
                return 'Je moet een link invoeren!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Contact/add_link",
                method: 'POST',
                data: { 
                link: result.value,
                id: id
            },
                success: function () {
                    Swal.fire('Succes', 'De link is toegevoegd.', 'success');
                    location.reload();
                },
                error: function () {
                    Swal.fire('Fout', 'Er is iets misgegaan.', 'error');
                }
            });
        }
    });
}

function remove_link() {
    let controller = $(this).data("controller");

    Swal.fire({
        title: 'Verwijder link',
        text: 'Weet je zeker dat je deze link wilt verwijderen?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Verwijderen',
        cancelButtonText: 'Annuleren'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Contact/remove_link",
                method: 'POST',
                data: { 
                    id: id
                },
                success: function () {
                    Swal.fire('Succes', 'De link is verwijderd.', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire('Fout', 'Er is iets misgegaan.', 'error');
                }
            });
        }
    });
}

$(function () {
    // Attach event listener to all buttons with status change
    $("#btn_new_to_in_progress, #btn_in_progress_to_done, #btn_in_progress_to_new, #btn_done_to_in_progress").on("click", handleStatusChange);
});

function handleStatusChange() {
    var message = $(this).data("message");  // Get the new status from the data attribute
    var newStatus = $(this).data("new-status");  // Get the new status from the data attribute
    Swal.fire({
        title: `Status veranderen naar ${message}?`,  // Show dynamic message based on new status
        text: `Weet je zeker dat je de status wilt veranderen naar ${message}?`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ja, verander het!',
        cancelButtonText: 'Nee'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Contact/change_ticket_status",  // A generic endpoint for handling status changes
                method: 'POST',
                data: { 
                    id: id,
                    status: newStatus  // Pass the new status
                },
                success: function () {
                    Swal.fire('Succes', 'De status is veranderd!', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                }
            });
        }
    });
}

function delete_mail() {
    var id = $(this).data("id");

    Swal.fire({
        title: 'Weet je het zeker?',
        text: "Deze mail wordt permanent verwijderd.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ja, verwijder',
        cancelButtonText: 'Annuleren'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "/Contact/delete_mail",
                method: "POST",
                data: { id: id },
                success: function () {
                    Swal.fire('Verwijderd!', 'De mail is verwijderd.', 'success').then(() => {
                        location.reload();
                    });
                },
                error: function () {
                    Swal.fire('Fout', 'Er is iets misgegaan bij het verwijderen.', 'error');
                }
            });
        }
    });
}
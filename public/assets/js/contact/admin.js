var contact_datatable;
$(function () {
    create_contact_datatable();
    $(".contact_datatable").on("change", ".datatable-filter", filter_contact_datatable);
    $(".contact_datatable").on("click", ".btn_delete", delete_mail);
});

function create_contact_datatable(){
    contact_datatable = $('.contact_datatable').DataTable({
        "info": false,        
        "lengthChange": false,
        "language":{
            "paginate": {
                "next": "Volgende",
                "previous": "Vorige"
            }
        },
        "serverSide": true,
        "autoWidth": false,
        "ajaxSource": "/Contact/json",
        "columns": [
            {
                "sWidth": "70px",
            },
            {
                "sWidth": "100px",
            },
            {
                "sWidth": "70px",
            },
            {
                "sWidth": "70px",
            },
            {
                "sWidth": "70px",
            },
            {
                "sWidth": "20px",
            },
        ],
        
        "stateSave": true,
        "rowCallback": function( row, data) {
        },
        "stateLoaded": function(settings, data) {

            $.each(data.columns, function(columnNo, column) {
                $(".datatable-filter[data-column='" + columnNo + "']").val(column.search.search);


            });
        }



    });
}

function filter_contact_datatable(e){
    e.preventDefault();
    contact_datatable.column($(this).data("column")).search($(this).val()).draw();
}

function clear_filters(datatable){
    $("." + datatable + "-filter").val('');
    selected_datatable = $("." + datatable).DataTable();
    selected_datatable.search('').columns().search('').draw();
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
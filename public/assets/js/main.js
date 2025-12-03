
$(function () {
    $(".open_modal").on("click", open_modal);

});


function open_modal(){

    name = $(this).data("name");
    controller = $(this).data("controller");
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


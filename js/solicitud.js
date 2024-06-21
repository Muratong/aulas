$("#modulo").change(function () {
    var modulo = $(this).val();
    $.ajax({
        type: 'POST',
        url: './ajax.php?action=piso', 
        data: {modulo:modulo},
        success: function(response) {
            $("#pisos").html(response);
          
        }
    });
});
// script de opcion de select multiple
 $('.select2').select2({
    placeholder:" Selecciona componentes aqui",
    width:'80%'
  });

$("#tipo").change(function () {
    var seleccionOpcion = $(this).val();
    // Oculta todos los campos y realiza el reseteo adecuado
    $("#fechaCampos, #diaCampos, #semanaCampos, #periodoCampos").hide();
    // Muestra los campos según la opción seleccionada
    $("#" + seleccionOpcion + "Campos").show();
});

function resetCampos(selector) {
    $(selector).find("input[type='text']").val('');
}


$("#solicitudForm").submit(function (e) {
    // Este código se ejecuta cuando se envía el formulario con el ID "solicitudForm".
    e.preventDefault(); 
    // Serialize el formulario(el formulario con el ID "solicitudForm") y almacena los datos en la variable dataForm.
    var dataForm = $(this).closest("form").serialize();
    $.ajax({
        type: 'POST', // Método HTTP de la solicitud (en este caso, POST).
        url: './ajax.php?action=solicitud',
        data: dataForm, // Los datos serializados del formulario.
        success: function(response) {
            // Esta función se ejecuta cuando se completa con éxito la solicitud AJAX.
            // Coloca la respuesta del servidor en el elemento HTML con el ID "lista".
            $("#lista").html(response);
        }
    });
});


$(document).on("click", ".Elegir", function () {
    var formData = $(this).closest("form").serialize();
    $.ajax({
        type: "POST",
        url: "./ajax.php?action=guardar",  
        data: formData,
        success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Reserva exitosa",
                    showConfirmButton: false,
                    timer: 1500 
                });

                if (response == 1) {
                    location.reload();
                }
        },
        error: function (xhr, status, error) {
            // Manejar errores de la solicitud AJAX
            console.error("Error en la solicitud AJAX: " + error);
        }
    });
});




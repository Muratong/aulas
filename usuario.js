$(document).ready(function() {
var id_usuario, opcion;

$.extend( $.fn.dataTable.defaults, {
        autoWidth: false,
        pageLength: 10,
        columnDefs: [{
            orderable: false,
            width: '100px'
        }],
        // dom: '<"datatable-header"fpl><"datatable-scroll"t><"datatable-footer"ip>',
        language: {
            search: '<span>Buscar:</span> _INPUT_',
            lengthMenu: '<span>Ver:</span> _MENU_',
            emptyTable: "No existen registros",
            sZeroRecords:    "No se encontraron resultados",
            sInfoEmpty:      "No existen registros",
            sInfoFiltered:   "(filtrado de un total de _MAX_ registros)",
            sInfo:           "Mostrando de _START_ al _END_ de un total de _TOTAL_ datos",
            paginate: { 'first': 'First', 'last': 'Last', 'next': '&rarr;', 'previous': '&larr;' }

        },
        drawCallback: function () {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').addClass('dropup');
        },
        preDrawCallback: function() {
            $(this).find('tbody tr').slice(-3).find('.dropdown, .btn-group').removeClass('dropup');
        }
    });
    
tablaUsuarios = $('#tablaUsuarios').DataTable({
    "bProcessing": true, 
    "bDeferRender": true,   
    "bServerSide": true,                
    "sAjaxSource": "serverside/serversideUsuarios.php", 
    "columnDefs": [ 
        {"targets": 0, "id_usuario" : "id_usuario"},
        {
            "targets": -1,        
            "defaultContent": "<div class='wrapper text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar' data-toggle='tooltip' title='Editar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar' data-toggle='tooltip' title='Eliminar'><span class='material-icons'>delete</span></button></div></div>"
        }
    ],
});
  

var fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#formUsuarios').submit(function(e){                         
    e.preventDefault();
    nombre = $.trim($('#nombre').val());    
    documento = $.trim($('#documento').val());
    rol = $.trim($('#rol').val());    
    username = $.trim($('#username').val());    
    password = $.trim($('#password').val());
    status = $.trim($('#status').val());                            
        $.ajax({
          url: "bd/usuario.php",
          type: "POST",
          datatype:"json",    
          data:  {id_usuario:id_usuario, nombre:nombre, documento:documento,
          rol:rol, username:username, password:password, status:status, opcion:opcion},    
          success: function(data) {
             Swal.fire({
                position: 'top-center',
                icon: 'success',
                title: 'Los datos fueron guardados exitosamente.',
                showConfirmButton: false,
                timer: 2000
            });
            tablaUsuarios.ajax.reload(null, false);
           }
        });                 
    $('#modalPersonal').modal('hide');                                                          
});
        
//para limpiar los campos antes de dar de Alta una Persona
$("#btnNuevoUsuario").click(function(){
    opcion = 1; //alta           
    id_usuario=null;
    $("#formUsuarios").trigger("reset"); //metodo para disparar el evento rset
    $(".modal-header").css( "background-color", "#274d8a");
    $(".modal-header").css( "color", "white" );
    $(".modal-title").text("Alta de Usuario");
    $('#modalPersonal').modal('show');      
});

//Editar        
$(document).on("click", ".btnEditar", function(){               
    opcion = 2;//editar
    fila = $(this).closest("tr");           
    id_usuario = parseInt(fila.find('td:eq(0)').text()); //capturo y convierto el ID de la tabla en Int           
    nombre = fila.find('td:eq(1)').text();
    documento = fila.find('td:eq(2)').text();
    usuario = fila.find('td:eq(3)').text();
    type = fila.find('td:eq(4)').text();
    rol = fila.find('td:eq(5)').text();
     password = fila.find('td:eq(6)').text();

    $("#id_usuario").val(id_usuario);
    $("#nombre").val(nombre);
    $("#documento").val(documento);
    $("#username").val(usuario);
    $("#status").val(type);
     $("select[id=rol]").val(rol);
     $("#password").val(password);
     $('input[id=btnGuardar]').val('Actualizar');
    $(".modal-header").css("background-color", "#274d8a");
    $(".modal-header").css("color", "white" );
    $(".modal-title").text("Actualizar datos ");        
    $('#modalPersonal').modal('show');         
});

//Borrar
$(document).on("click", ".btnBorrar", function(){
    fila = $(this);           
    id_usuario = parseInt($(this).closest('tr').find('td:eq(0)').text()) ;      
    opcion = 3; //eliminar        
    var respuesta = confirm("¿Está seguro de borrar el registro "+id_usuario+"?");                
    if (respuesta) {            
        $.ajax({
          url: "bd/usuario.php",
          type: "POST",
          datatype:"json",    
          data:  {opcion:opcion, id_usuario:id_usuario},    
          success: function() {
              tablaUsuarios.row(fila.parents('tr')).remove().draw();                  
           }
        }); 
    }
 });
     
});    
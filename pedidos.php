<?php 
session_start();
 include('modelo/conexion.php');
$objeto = new Conexion();
$conn = $objeto->Conectar();
if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}

 ?>
<?php include "header.php"; ?>
<style>
    label{
        color: white;
    }
    .fecha{
        color: blue;
    }
    .dia{
        color: red;
    }
    @media (max-width:420px){
        table tr{
            display: flex;
            flex-direction: column;
            border: 1px solid grey;
            padding: 1em;
            margin-bottom: 1em;
        }
        table thead{
            display: none;
        }
        table td[data-titulo]{
            display: flex;
        }
        table td[data-titulo]::before{
            content: attr(data-titulo);
            width: 90px;
            color: silver;
            font-weight: bold;
        }
    }
   /* table tr th:nth-child(1),
    table tr td:nth-child(1),
     table tr th:nth-child(3),
    table tr td:nth-child(3),
    table tr td:nth-child(7),
    table tr th:nth-child(7),
     table tr td:nth-child(6),
    table tr th:nth-child(6) {
        display: none;
}*/
table tr td{
    text-align: justify-all;
}

</style>
<body>

    <section class="cardy">

    <div class="container caja">
        <div class="row">
            <div class="col-lg-12">
            <div class="table-responsive">        
                <table class="table table-striped table-bordered table-condensed" style="width:100%" >
                    <thead class="text-center">
                        <tr>
                            <th>Fijo</th>
                            <th>Docente</th>
                            <th>Modulo</th>
                            <th>Piso</th>  
                             <th>Aula</th>                     
                            <th>Fecha/Dia</th>
                            <th>inicio</th>
                             <th>Final</th>  
                             <th>Tipo Solicitud</th>                             
                        </tr>
                    </thead>
                    <tbody> 
                   <?php 
                   $consulta = $conn->query("SELECT * FROM asignar_class ac INNER JOIN usuarios u ON ac.id_usuario=u.id_usuario INNER JOIN modulos m ON ac.modulo=m.id INNER JOIN pisos p ON ac.id_piso=p.id INNER JOIN classes c ON ac.class=c.id");
                   while($row = $consulta->fetch_assoc()){
                    $diasStr = $row['dias'];
                    $diasArray = explode(',', $diasStr);
                $nombresDiasSemana = array(
                    1 => 'Lunes',
                    2 => 'Martes',
                    3 => 'Miércoles',
                    4 => 'Jueves',
                    5 => 'Viernes',
                    6 => 'Sábado',
                    7 => 'Domingo'
                );
                    $nombresDias = array();
                    // Recorrer el arreglo de días y obtener los nombres correspondientes
                    foreach ($diasArray as $numeroDiaSemana) {
                        if (array_key_exists($numeroDiaSemana, $nombresDiasSemana)) {
                            $nombresDias[] = $nombresDiasSemana[$numeroDiaSemana];
                        }
                    }
                    $nombreDia = implode(', ', $nombresDias); 
                    ?>
                    <tr>
                        <?php if ($row['fijo']==0): ?>
                            <td><input type="checkbox"></td>
                        <?php else: ?>
                            <td><input type="checkbox" checked></td>
                        <?php endif ?>
                        
                        <td><?php echo $row['name'] ?></td>
                        <td><?php echo $row['nombre'] ?></td>
                        <td><?php echo $row['nombre_piso'] ?></td>
                        <td><?php echo $row['nombre_aula'] ?></td>
                        <?php if ($row['fecha']!= '0000-00-00'): ?>

                        <td class="fecha"><?php $fechaFormateada = date('d-m-Y', strtotime($row['fecha']));
                            echo $fechaFormateada;
                             ?>                                
                         </td>
                        <?php else: ?>
                            <td class="dia"><?php echo $nombreDia ?></td>
                        <?php endif ?>
                        
                        <td><?php echo $row['inicio'] ?></td>
                        <td><?php echo $row['final'] ?></td>
                        <td>Por <?php echo $row['tipo'] ?></td>
                    </tr>
                <?php } ?>
                    </tbody>        
                </table>               
            </div>
            </div>
        </div>  
    </div>   

<!--Modal para CRUD-->
<div class="modal fade" id="modalPersonal" tabindex="-1" role="dialog" aria-labelledby="perdonalModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="personalModal"></h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            </div>
        <form id="formUsuarios">      
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                    <div class="form-group">
                        <input type="hidden" name="id_usuario" id="id_usuario">
                    <label for="" class="col-form-label">Nombre completo</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                    </div> 
                    </div>

                </div>
                <div class="row"> 
                    
                    <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Documento</label>
                    <input type="text" class="form-control" name="documento" id="documento" placeholder="Dni sin punto." required>
                    </div>
                    </div>
                    <div class="col-lg-6">    
                        <div class="form-group">
                        <label for="" class="col-form-label">Rol</label>
                        <select class="form-control" name="rol" id="rol" required>
                            <option value="">Seleccione el rol</option>
                            <option value="1">Administrador</option>
                            <option value="2">Docente</option>
                        </select>
                        </div>            
                    </div> 
                </div>
                <div class="row"> 
                <div class="col-lg-6">
                    <div class="form-group">
                    <label for="" class="col-form-label">Usuario:</label>
                    <input type="text" class="form-control" name="username" id="username" required>
                    </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                        <label for="" class="col-form-label">Password</label>
                        <input type="Password" class="form-control" name="password" id="password">
                        </div>
                    </div>
                </div>
                    <div class="col-lg-6">    
                        <div class="form-group">
                        <label for="" class="col-form-label">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="">Seleccione el status</option>
                            <option value="Habilitado">Habilitado</option>
                            <option value="Deshabilitado">Deshabilitado</option>
                        </select>
                        </div>            
                    </div>    
                </div>                
        
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                <input type="submit" id="btnGuardar" class="btn btn-dark" value="Guardar">
            </div>
        </form>    
        </div>
    </div>
</div>  
      
     
    </section>

  
    <!-- jQuery, Popper.js, Bootstrap JS -->
    <script src="assets/jquery/jquery-3.3.1.min.js"></script>
    <script src="assets/popper/popper.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      
    <!-- datatables JS -->
    <script type="text/javascript" src="assets/datatables/datatables.min.js"></script>         
    </script>
    <script src="usuario.js"></script>

    <script>
        function recargarPagina() {
            var url = "usuario_panel.php"; // Coloca aquí la URL de la página que deseas cargar.
            var panel = $("#panel_usuario");

            $.ajax({
                url: url,
                dataType: "html",
                beforeSend: function() {
                    panel.html("<p>Cargando...</p>");
                },
                success: function(data) {
                    panel.html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    panel.html("<p>Ha ocurrido un error al cargar la página.</p>");
                }
            });
        }

        $(function () {
            // Carga la página la primera vez que se carga la página.
            recargarPagina();

            // Recarga la página cada 5 segundos.
            setInterval(recargarPagina, 100000);
        });

    </script>
  <?php include "footer.php" ?>
</body>

</html>
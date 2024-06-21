<?php 
session_start();

if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}

 ?>
<!DOCTYPE html>
<html>
<?php include "header.php"; ?>
<body>
   <?php include('modelo/conexion.php');
$objeto = new Conexion();
$conn = $objeto->Conectar();

$component= $conn->query("SELECT * FROM componentes ");
  $comp_ente = array();
  while ($row=$component->fetch_assoc()) {
    $comp_ente[$row['id']] = $row['nombre_componente'];
  }
?>
 <section class="cardy">
    <div class="container">
       <div class="row">
           <!-- caja de solicitud de busqueda -->
           <div class="col-lg-6">
             <h1>Solicitud de Aulas</h1><hr>
             <form id="solicitudForm">
                 <div class="input-group">
            <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
            <label for="" class="input-group-text"><strong>Modulo</strong> </label>
            <select name="modulo" id="modulo"  class="custom-select">
              <option value="">Elige un modulo</option>
                  <?php 
             $qry = $conn->query("SELECT * FROM modulos order by id asc");
            while($row=$qry->fetch_assoc()):
                   ?>
              <option value="<?php echo $row['id'] ?>" ><?php echo $row['nombre'] ?></option>
                  <?php endwhile; ?>
                </select>
              </div><hr>
               <div class="input-group">
                 <label class="input-group-text"><strong>Piso</strong></label>
                 <select class="form-control" id="pisos" name="piso">
                 </select>
               </div><hr>
             <div class="input-group">
                <label class="input-group-text">Capacidad</label>
            <input type="number" id="capacidad" name="capacidad" min="1" class="form-control" required>
            </div><hr>
            <div class="input-group">
              <span class="input-group-text">Equipos</span>
              <select name="componentes[]"  class="form-control select2" multiple>
              <?php 
                   $qry = $conn->query("SELECT * FROM componentes order by id asc");
                   while($row=$qry->fetch_assoc()):
               ?>
              <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_componente'] ?>
              </option>
              <?php endwhile; ?>
             </select>
             <span style="color:red">*** Esta campo es opcional***</span>
            </div><hr>
            <div class="input-group">
            <label class="input-group-text">Tipo de Solicitud:</label>
            <select id="tipo" name="tipo" class="form-control">
            <option value="">Seleccione tu solicitud</option>
              <option value="fecha">Fecha única</option>
              <option value="dia">Día(s)</option>
              <option value="semana">Semana(s)</option>
              
            </select>
            </div><br>

            <!-- Campos para Fecha única -->
          <div id="fechaCampos" style="display: none;">
            <div class="input-group">
              <label class="input-group-text">Fecha:</label>
              <input type="date" id="fecha" name="fecha" class="form-control">
            </div>
           <hr>
           <div class="form-group">
            <label for="duracion" class="">Duración (horas):</label>
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Inicio</span>
                        <input type="time" id="inicio" name="F_inicio" class="form-control">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text">Final</span>
                        <input type="time" id="final" name="F_final" class="form-control">
                    </div>
                </div>
            </div>
           </div><hr>
          </div>
    <!-- Campos para Día(s) -->
        <div id="diaCampos" style="display: none;">
             <div class="input-group">
            <label for="semana" class="input-group-text">Semana:</label>
            <input type="week" id="semana" name="semana" class="form-control" >
        </div><hr>
            <div class="input-group">
                <label class="input-group-text">Día(s):</label>
                <select name="dias[]" class="form-control select2" multiple>
                    <option value="">Seleccione el dia</option>
                    <option value="1">Lunes</option>
                    <option value="2">Martes</option>
                    <option value="3">Miércoles</option>
                    <option value="4">Jueves</option>
                    <option value="5">Viernes</option>
                    <option value="6">Sabado</option>
                </select>
            </div><br>

            <!-- Horarios para cada día -->
            <div class="input-group">
                <label for="horario_dias" class="input-group-text">Horarios:</label>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text">Inicio</span>
                            <input type="time" name="dia_inicio" class="form-control" >
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="input-group">
                            <span class="input-group-text">Final</span>
                            <input type="time" name="dia_final" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
             <div class="form-group">
                <div class="form-group">
                    <label for="fijo" style="color:red;">Período fijo</label>
                    <input type="checkbox" id="fijo" name="fijo" value="1">
                    
                </div>
            </div>    
        </div><br>

     <!-- Campos para Semana(s) -->
    <div id="semanaCampos" style="display: none;">
       <div class="row">
        <div class="col-lg-6">
        <div class="input-group">
            <label for="semana_inicio" class="input-group-text">Semana Inicio:</label>
            <input type="week" id="semana_inicio" name="semana_inicio" class="form-control" >
        </div>
        </div>
        <div class="col-lg-6">
        <div class="input-group">
            <label for="semana_final" class="input-group-text">Semana Final:</label>
            <input type="week" id="semana_final" name="semana_final" class="form-control">
        </div>
       </div>
      </div><br>
        <!-- Horarios para la semana -->
        <div class="input-group">
                <label class="input-group-text">Día(s):</label>
                <select name="dias[]" class="form-control select2" multiple>
                    <option value="">Seleccione el dia</option>
                    <option value="lunes">Lunes</option>
                    <option value="martes">Martes</option>
                    <option value="miercoles">Miércoles</option>
                    <option value="jueves">Jueves</option>
                    <option value="viernes">Viernes</option>
                    <option value="sabado">Sabado</option>
                </select>
            </div>
        <div class="form-group">
            <label for="horario_semana">Horarios:</label>
            <div class="row">
                <div class="col-lg-6">
                  <div class="input-group">
                    <span class="input-group-text">Inicio</span>
                    <input type="time" id="inicio" name="inicio" class="form-control" >
                  </div>
                </div>
            <div class="col-lg-6">
                <div class="input-group">
                    <span class="input-group-text">Final</span>
                    <input type="time" id="final" name="final" class="form-control" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="fijo" style="color:red;">Período fijo</label>
                    <input type="checkbox" id="fijo" name="fijo" value="1">
                    
                </div>
            </div>    
        </div>
     
        <div class="form-group">
            <button type="submit" class="btn btn-dark">Enviar Solicitud</button>
        </div>
<br>
     </form>
     </div>
         <!-- caja de listar resultado de busqueda -->
      <div class="col-lg-6">
            <h1>Lista de busqueda</h1><hr>
            <form>
              <div class="card">
                <div class="card-body" style="background-color:lightyellow;">
                    <div id="lista">Resultados de la solicitud</div>
                </div>
             </div>
            </form>
      </div> 
    </div> 
                  
    </div>    
    <br>   
    </section>

    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <link href="./assets/select2.min.css" rel="stylesheet">
    <script type="text/javascript" src="assets/select2.min.js"></script>
    <script src="js/solicitud.js"></script>
    <?php include "footer.php" ?>
</body>

</html>

<?php include('modelo/conexion.php');
$objeto = new Conexion();
$conn = $objeto->Conectar();
include 'admin_class.php';

$component= $conn->query("SELECT * FROM componentes ");
  $comp_ente = array();
  while ($row=$component->fetch_assoc()) {
    $comp_ente[$row['id']] = $row['nombre_componente'];
  }
?>
<link href="assets/select2.min.css" rel="stylesheet">
 <script type="text/javascript" src="assets/select2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style>
  .col-md-8, .col-md-4{

    max-height: 500px;
    overflow:scroll;

  }
 
  img{
    width:70px;
    height: :80px;
    border-radius: 10px;
  }
  .modal-dialog{
    max-width: 500px;
  }
  label{
    color: blue;
  }
   a b{
    color: white;
  }
  
</style>
<div class="container-fluid" style="background-color:lightyellow;">
    <div class="row">
    <div class="col-md-12"> 
      <ul class="nav nav-tabs" style="background-color: lavender;font-size: 16px;">
        <li class="nav-item">
         <a class="nav-link active" href="#all_modulo" data-toggle="tab"><i class="fa fa-bars"></i>&nbsp;&nbsp;<strong>MODULOS </strong></a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="#all_pisos" data-toggle="tab" ><i class="fa fa-building-o"></i>&nbsp;&nbsp;<strong>PISOS</strong></a>
        </li> 
        <li class="nav-item">
         <a class="nav-link" href="#all_component" data-toggle="tab" ><i class="fa-solid fa-computer"></i>&nbsp;&nbsp;<strong>COMPONENTES </strong></a>
        </li>
        <li class="nav-item">
         <a class="nav-link" href="#all_classes" data-toggle="tab"><i class="fa fa-handshake-o"></i>&nbsp;&nbsp;<strong>AULAS</strong></a>
        </li>
        </ul>
   
  <div class="tab-content" >
          
            <!--******Modulos****-->
  <div class="tab-pane active" id="all_modulo" style="width:100%;padding-top: 20px;">
    
    <div class="row">
      <!-- FORM Panel -->
      <div class="col-md-4">
      <form action="" id="manage-modulo">
        <div class="card">
          <div class="card-header"  style="background-color: #274d8a; border-radius: ">
             <h4 style="color:white;" id="cabeza" class="text-center canchas"> MODULOS</h4>
            </div>
          <div class="card-body">
              <input type="hidden" name="id">
              <div class="form-group">
                <label class="control-label"><strong>Modulo</strong></label>
                <input type="text" name="modulo" id=""  class="form-control" placeholder="Ej: modulo 1">
              </div>
              <div class="form-group">
                <label class="control-label"><strong>Imagen del modulo</strong></label>
                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
              </div>
              <div class="form-group">
                <img src="" alt="" id="cimg">
              </div>  
              
          </div>
              
      <div class="card-footer">
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-sm btn-primary col-ms-4" id="tipo">Guardar</button>
            <button class="btn btn-sm btn-danger col-ms-4" type="button" onclick="_reset()"> Limpiar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
      <!-- FORM Panel -->

      <!-- Table Panel -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <table id="miTabla" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th class="text-center">Nº</th>
                  <th class="text-center">Imagen</th>
                  <th class="text-center">Modulo
                  <th class="text-center">Accion</th>
                </tr>
              </thead>
              <tbody id="table-modulo">
                <?php 
                $i = 1;
                $modul = $conn->query("SELECT * FROM modulos order by id asc");
                while($row=$modul->fetch_assoc()):
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++ ?></td>
                  <td class="text-center">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen'] );?>"/>
                  </td>
                  <td class="">
                     <b><?php echo $row['nombre'] ?></b>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-primary edit_mod" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['nombre'] ?>" data-img_path="<?php echo base64_encode($row['imagen'] );?>">Editar</button>
                    <button class="btn btn-sm btn-danger delete_mod" type="button" data-id="<?php echo $row['id'] ?>">Eliminar</button>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Table Panel -->
    </div>
  </div>  
         
<!--******Pisos*****-->
      <div class="tab-pane" id="all_pisos" style="padding-top: 20px;">
         <div class="row">
      <!-- FORM Panel -->
      <div class="col-md-4">
      <form action="" id="manage-piso"> 
        <div class="card">
          <div class="card-header" style="background-color: #274d8a;">
             <h4 style="color:white;" id="piso" class="text-center"> Pisos</h4>
            </div>
          <div class="card-body">
              <div id="msg"></div>
        <input type="hidden" name="id">
        <div class="form-group">
            <label class="control-label"><strong>Nombre Piso</strong> </label>
            <input type="text" name="name" class="form-control" required="">
              </div>
               <div class="form-group">
            <label class="control-label"><strong>Descripcion del piso</strong> </label>
            <textarea type="text" name="descripcion" class="form-control" required=""></textarea>
              </div>
        <div class="form-group">
        <label for="" class="control-label"><strong>Indique el modulo</strong> </label>
            <select name="modulo"  class="custom-select">
              <option value="">Elige un modulo</option>
                  <?php 
             $qry = $conn->query("SELECT * FROM modulos order by id asc");
            while($row=$qry->fetch_assoc()):
                   ?>
              <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                  <?php endwhile; ?>
                </select>
                
              </div>   
              
          </div>
              
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12">
        <button class="btn btn-sm btn-primary col-ms-4" id="btnGuarda">Guardar</button>
          <button class="btn btn-sm btn-danger col-ms-4" type="button" onclick="_reset()"> Limpiar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
     <!-- Table Panel -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="panel-group" id="faq" role="tablist" aria-multiselectable="true">
        <?php 
        $e = 1;
        $pisos = $conn->query("SELECT * FROM modulos ORDER BY id ASC");
        while ($rowPiso = $pisos->fetch_assoc()):
          
        ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo $rowPiso['id']; ?>">
                    <h3 class="panel-title" style="background-color:#274d8a; position: relative;" >
                       <a data-toggle="collapse" data-parent="#faq" href="#collapseO<?php echo $rowPiso['id']; ?>" aria-expanded="true" aria-controls="collapseO<?php echo $rowPiso['id']; ?>"  class="btn" style="display: flex; align-items: center;" >
                            <b style="color:white;font-size:20px;" class="canchas"><?php echo $rowPiso['nombre']; ?></b><hr> <b> Con sus pisos</b> 
                             <svg class="about-details__accordionIcon" viewBox="0 0 24 24" style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%); width: 16px; height: 16px;color: white;">
                <path fill="none" stroke="currentColor" d="M4.5 9L19.5 9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                <path fill="none" stroke="currentColor"  d="M4.5 9L12 16.5L19.5 9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
              </svg>
                        </a>
                    </h3>
                </div>

                <div id="collapseO<?php echo $rowPiso['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $rowPiso['id']; ?>">
                    <div class="table-responsive">
                      <table id="miTabla" class="table table-bordered table-hover" style="width:100%" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>N°</th>
                                    <th>Piso</th>
                                    <th>Descripcion</th>
                                    <th>Opcion</th>
                                    
                                </tr>
                            </thead>
                           
                                  <tbody id="table-piso-<?php echo $rowPiso['id']; ?>">
                         <?php
$id = $rowPiso['id'];

$detalles = $conn->query("SELECT * FROM pisos WHERE id_modulo = '$id' ORDER BY id ASC");
if ($detalles->num_rows > 0) {
    $i = 1;
    while ($Pisorow = $detalles->fetch_assoc()) {
        $piso = $Pisorow['nombre_piso'];
        $idpiso = $Pisorow['id'];
        $idmodulo = $Pisorow['id_modulo'];
         $Pdescripcion = $Pisorow['descripcion'];

        // Mostrar los detalles en filas de la tabla
        echo "<tr>";
        echo "<td>" . $e . "</td>";
        echo "<th>" . $i++ . "</th>";
        echo "<th>" . $piso . "</th>";
        echo "<th>" . $Pdescripcion . "</th>";
        echo "<th>";
        echo '<button class="btn btn-sm btn-primary edit_piso" type="button" data-id="' . $idpiso . '" data-name="' . $piso . '" data-descripcion="' . $Pdescripcion . '" data-modulo="' . $idmodulo . '">Actualizar</button>';
        echo '<button class="btn btn-sm btn-danger delete_piso" type="button" data-id="' . $idpiso . '">Eliminar</button>';
        echo "</th>";

        echo "</tr>";
    }
  }
    ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
          </div>
        </div>
      </div>
      <!-- Table Panel -->

 </div> <!-- fin de tab-content-->
</div>

 <!--******Componentes****-->
  <div class="tab-pane" id="all_component" style="width:100%;padding-top: 20px;">
    
    <div class="row">
      <!-- FORM Panel -->
      <div class="col-md-4">
      <form action="" id="manage-componentes">
        <div class="card">
          <div class="card-header"  style="background-color: #274d8a; border-radius: ">
             <h4 style="color:white;" id="componente" class="text-center"> COMPONENTES</h4>
            </div>
          <div class="card-body">
              <input type="hidden" name="id">
              <div class="form-group">
                <label class="control-label"><strong>Componente</strong></label>
                <input type="text" name="componente" id=""  class="form-control" placeholder="Ej: Computadoras">
              </div>
              <div class="form-group">
                <label class="control-label"><strong>Descripcion</strong></label>
                <textarea type="text" name="descripcion"  class="form-control"></textarea>
              </div>
              <div class="form-group">
                <label class="control-label"><strong>Imagen del modulo</strong></label>
                <input type="file" class="form-control" name="img" onchange="displayImg(this,$(this))">
              </div>
              <div class="form-group">
                <img src="" alt="" id="cimg">
              </div>  
              
          </div>
              
      <div class="card-footer">
        <div class="row">
          <div class="col-md-12">
            <button class="btn btn-sm btn-primary col-ms-4" id="btncomponent">Guardar</button>
            <button class="btn btn-sm btn-danger col-ms-4" type="button" onclick="_reset()"> Limpiar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
      <!-- FORM Panel -->

      <!-- Table Panel -->
      <div class="col-md-8">
        <div class="card">
          <div class="table-responsive">
            <table id="miTabla" class="table table-bordered table-hover" style="width:100%">
              <thead>
                <tr>
                  <th class="text-center">Nº</th>
                  <th class="text-center">Imagen</th>
                  <th class="text-center">Componentes
                    <th class="text-center">Descripcion</th>
                  <th class="text-center">Accion</th>
                </tr>
              </thead>
              <tbody id="table-modulo">
                <?php 
                $i = 1;
                $componente = $conn->query("SELECT * FROM componentes order by id asc");
                while($row=$componente->fetch_assoc()):
                ?>
                <tr>
                  <td class="text-center"><?php echo $i++ ?></td>
                  <td class="text-center">
                    <img src="data:image/jpg;base64,<?php echo base64_encode($row['imagen'] );?>"/>
                  </td>
                  <td class="">
                     <?php echo $row['nombre_componente'] ?>
                  </td>
                        <td class="text-justify">
                     <?php echo $row['descripcion'] ?>
                  </td>
                  <td class="text-center">
                    <button class="btn btn-sm btn-primary edit_componente" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo $row['nombre_componente'] ?>"  data-descripcion ="<?php echo $row['descripcion'] ?>" data-img_path="<?php echo base64_encode($row['imagen'] );?>">Editar</button>
                    <button class="btn btn-sm btn-danger delete_componente" type="button" data-id="<?php echo $row['id'] ?>">Eliminar</button>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Table Panel -->
    </div>
  </div> 

<!--******Aulas*****-->
      <div class="tab-pane" id="all_classes" style="padding-top: 20px;">
         <div class="row">
      <!-- FORM Panel -->
      <div class="col-md-4">
      <form action="" id="manage-aula"> 
        <div class="card">
          <div class="card-header" style="background-color: #274d8a;">
             <h4 style="color:white;" id="aulas" class="text-center"> AULAS</h4>
            </div>
          <div class="card-body">
              <div id="msg"></div>
        <input type="hidden" name="id">
        <div class="form-group">
            <label class="control-label"><strong>Nombre Aula</strong> </label>
            <input type="text" name="name" class="form-control" required="">
         </div>
           <div class="form-group">
            <label class="control-label"><strong>Tipo Aula</strong> </label>
            <select type="text" name="tipo" class="form-control" required="">
              <option value="">Seleccione el tipo</option>
              <option value="Aula normal">Aula normal</option>
              <option value="Laboratorio Informatica">Laboratorio Informatica</option>
              <option value="Laboratorio Quimica">Laboratorio Quimica</option>
              <option value="Laboratorio Fisica">Laboratorio Fisica</option>
              
            </select>
         </div>
         <div class="form-group">
            <label class="control-label"><strong>Capacidad Min</strong> </label>
            <input type="number" name="min" class="form-control" required="">
         </div>
         <div class="form-group">
            <label class="control-label"><strong>Capacidad Max</strong> </label>
            <input type="number" name="max" class="form-control" required="">
         </div>

        <div class="form-group">
        <label for="" class="control-label"><strong>Componentes</strong> </label>
            <select name="componentes[]"  class="custom-select select2" multiple="">
              <option value="">Elige los elementos</option>
                  <?php 
             $qry = $conn->query("SELECT * FROM componentes order by id asc");
            while($row=$qry->fetch_assoc()):
                   ?>
              <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_componente'] ?></option>
                  <?php endwhile; ?>
                </select>
                
              </div> 
              <div class="form-group">
        <label for="" class="control-label"><strong>Indique el piso</strong> </label>
            <select name="numero_piso"  class="custom-select">
              <option value="">Elige un piso</option>
                  <?php 
             $qry = $conn->query("SELECT * FROM pisos order by id asc");
            while($row=$qry->fetch_assoc()):
                   ?>
              <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre_piso'] ?></option>
                  <?php endwhile; ?>
                </select>
                
              </div>   
              
          </div>
              
          <div class="card-footer">
            <div class="row">
              <div class="col-md-12">
        <button class="btn btn-sm btn-primary col-ms-4" id="btnAula">Guardar</button>
          <button class="btn btn-sm btn-danger col-ms-4" type="button" onclick="_reset()"> Limpiar</button>
              </div>
            </div>
          </div>
        </div>
      </form>
      </div>
     <!-- Table Panel -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="panel-group" id="faq" role="tablist" aria-multiselectable="true">
        <?php 
        $e = 1;
        $pisos = $conn->query("SELECT * FROM pisos ORDER BY id ASC");
        while ($rowPiso = $pisos->fetch_assoc()):
          
        ?>
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="heading<?php echo $rowPiso['id']; ?>">
                    <h3 class="panel-title" style="background-color:#274d8a; position: relative;" >
                      <a data-toggle="collapse" data-parent="#faq" href="#collapseO<?php echo $rowPiso['id']; ?>" aria-expanded="true" aria-controls="collapseO<?php echo $rowPiso['id']; ?>"  class="btn" style="display: flex; align-items: center;" >
                            <b style="color:white;font-size:20px;" class="canchas"><?php echo $rowPiso['nombre_piso']; ?></b><hr> Con sus aulas
                            <svg class="about-details__accordionIcon" viewBox="0 0 24 24" style="position: absolute; top: 50%; right: 5px; transform: translateY(-50%); width: 16px; height: 16px;color: white;">
                <path fill="none" stroke="currentColor" d="M4.5 9L19.5 9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
                <path fill="none" stroke="currentColor"  d="M4.5 9L12 16.5L19.5 9" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" />
              </svg>
                        </a>
                    </h3>
                </div>

                <div id="collapseO<?php echo $rowPiso['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $rowPiso['id']; ?>">
                    <div class="table-responsive">
                      <table id="miTabla" class="table table-bordered table-hover" style="width:100%" >
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Aula</th>
                                    <th>Tipo</th>
                                    <th>C.MIn</th>
                                    <th>C.Max</th>
                                    <th>Componentes</th>
                                    <th>Opcion</th>
                                    
                                </tr>
                            </thead>
                           
                                  <tbody id="table-piso-<?php echo $rowPiso['id']; ?>">
                       <?php
$id = $rowPiso['id'];

$detalles = $conn->query("SELECT * FROM classes WHERE id_piso = '$id' ORDER BY id ASC");
if ($detalles->num_rows > 0) {
    $i = 1;
    while ($Aularow = $detalles->fetch_assoc()) {
        $aula = $Aularow['nombre_aula'];
        $idaula = $Aularow['id'];
        $numero_piso = $Aularow['id_piso'];
        $cap_min = $Aularow['capacidad_min'];
        $cap_max = $Aularow['capacidad_max'];
        $compo = $Aularow['componentes'];
        $tipo = $Aularow['tipo_aula'];

        // Mostrar los detalles en filas de la tabla
        echo "<tr>";
        echo "<td>" . $i++ . "</td>";
        echo "<td>" . $aula . "</td>";
        echo "<td>" . $tipo . "</td>";
        echo "<td>" . $cap_min . "</td>";
        echo "<td>" . $cap_max . "</td>";
        echo "<td>";
        
        if (!empty($compo)) {
            $componentes = explode(",", str_replace(array("[", "]"), "", $compo));
            foreach ($componentes as $componente) {
               if (isset($comp_ente[$componente])) {
                    echo '<span style="background-color: gray;padding: 5px;margin:0px" class="badge badge-light"><large><b>' . $comp_ente[$componente] . '</b></large></span>';
                }
               
            }
        }
        
        echo "</td>";
        echo "<td>";
        echo '<button class="btn btn-sm btn-primary edit_aula" type="button" data-id="' . $idaula . '" data-name="' . $aula . '" data-tipo="' . $tipo . '" data-pisos="' . $numero_piso . '" data-componente="' . $compo . '" data-max="' . $cap_max . '" data-min="' . $cap_min . '">Actualizar</button>';
        echo '<button class="btn btn-sm btn-danger delete_aula" type="button" data-id="' . $idaula . '">Eliminar</button>';
        echo "</td>";
        echo "</tr>";

       
    }
}
?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
          </div>
        </div>
      </div>
      <!-- Table Panel -->

 </div> <!-- fin de tab-content-->
</div>

</div>
</div><br>
<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmacion</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continuar</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
      </div>
    </div>
  </div>

    <script type="text/javascript" src="assets/datatables/datatables.min.js"></script> 
<script type="text/javascript" src="js/panel_control.js"> </script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <script>
    $('.select2').select2({
    placeholder:" Selecciona aqui",
    width:'100%'
  });

  </script>

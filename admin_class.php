 <?php
session_start();
ini_set('display_errors', 1);
Class Action {
	private $db;

	public function __construct() {
		ob_start();
   	include 'modelo/conexion.php'; 
    $objeto = new Conexion();
		$conn = $objeto->Conectar();
    $this->db = $conn;
	}
	function __destruct() {
	    $this->db->close();
	    ob_end_flush();
	}

   function getPiso() {
   	if(!empty($_POST['modulo'])){
   		$modulo = $_POST['modulo'];
   		$query = $this->db->query("SELECT id, nombre_piso FROM pisos WHERE id_modulo = " . $modulo);
    
    $salida = "";  // Inicializa la variable de salida
    
    if ($query->num_rows > 0) {
        $out .= "<select type='text' class='form-control' name='piso' id='piso'>";
        $out .= "<option value=''>Seleccione el piso</option>";

        while ($row = $query->fetch_assoc()) {
            $piso = $row['nombre_piso'];
            $id = $row['id'];
            $out .= '<option value="' . $id . '">' . $piso . '</option>';
         }
            $out .= "</select>";
    } else {
        $out = "<p>No se encontraron pisos.</p>";
    }

    echo $out;
   	}    
}

// funcion para hacer la solicitud de proceso para
	function solicitud() {
    extract($_POST);
    $salida = "";  // Variable para almacenar la salida HTML
    		
	$data = " id_piso = '$piso' ";
	$data .= " AND capacidad_min <= '$capacidad' ";

	if (!empty($componentes)) {
	    $componentesList = '[' . implode(",", $componentes) . ']';
	    $componentesArray = explode(",", substr($componentesList, 1, -1));

	    $count = count($componentesArray);

	    $conditions = array();

	    for ($i = 0; $i < $count; $i++) {
	        $componente = $componentesArray[$i];
	        $conditions[] = "FIND_IN_SET('$componente', componentes)";
	    }

	    $condiciones = implode(' OR ', $conditions);
	    
	    $consulta = $this->db->query("SELECT * FROM classes WHERE id_piso ='$piso' AND ('$capacidad' BETWEEN capacidad_min AND capacidad_max) AND ( $condiciones )");
	} else {
	    $consulta = $this->db->query("SELECT * FROM classes WHERE id_piso ='$piso' AND capacidad_min <= '$capacidad'");
	}

    if ($consulta->num_rows >= 1) {
       $salida .= "<div class='table-responsive'>";
		$salida .= "<table class='table'>";
		$salida .= "<thead><tr><th>Clase</th><th>C. Max</th><th>Equipos</th><th>Acción</th></tr></thead>";
		$salida .= "<tbody>";
		   foreach ($consulta as $row) {
		    $class = $row['id'];

		    // ... Código de validación y consulta Asignar por fecha ...
		    if ($tipo == 'fecha') {
		        // Verificar si la fecha seleccionada coincide con un día de la semana fijo
            $diaSemana = date('N', strtotime($fecha)); // Obtener el día de la semana de la fecha 
           
            $consultaAsignar = $this->db->query("
            SELECT 1
            FROM asignar_class ac
            WHERE ac.class = '$class'
            AND ac.fecha = '$fecha'
            AND ac.dias = '$diaSemana'
            AND (
                ('$inicio' >= ac.final) OR
                ('$final' <= ac.inicio)
            )
        ");

        // Si no hay asignación para este registro, agregarlo a la tabla HTML
        if ($consultaAsignar->num_rows == 0) {
            $aula = $row['nombre_aula'];
            $capacidad = $row['capacidad_max'];
            $id = $row['id'];
            // Consulta para obtener los nombres de los componentes relacionados
            $componentes = array();
            if (!empty($row['componentes'])) {
                $componentesIds = explode(',', $row['componentes']);
                    foreach ($componentesIds as $componenteId) {
                        $componenteConsulta = $this->db->query("SELECT nombre_componente FROM componentes WHERE id = '$componenteId'");
                        if ($componenteConsulta->num_rows == 1) {
                            $componenteRow = $componenteConsulta->fetch_assoc();
                            $componentes[] = $componenteRow['nombre_componente'];
                        }
                    }
                }
                $componentesStr = implode(', ', $componentes);

               $salida .= "<tr>";
				$salida .= "<form id='reservar-form-" . $id . "' class='reservar-form' method='POST'>";
				$salida .= "<td><input class='form-control' name='aula' value='" . $aula . "' readonly><input type='hidden' class='form-control' name='usuario' value='" . $usuario . "'><input type='hidden' class='form-control' name='fijo' value='" . $fijo . "'></td>";
				$salida .= "<td><input class='form-control' name='capacidad' value='" . $capacidad . "' readonly><input type='hidden' class='form-control' name='fecha' value='" . $fecha . "' readonly><input type='hidden' class='form-control' name='modulo' value='" . $modulo . "' readonly><input type='hidden' class='form-control' name='piso' value='" . $piso . "' readonly>
				<input type='hidden' class='form-control' name='inicio' value='" . $F_inicio . "' readonly>
				<input type='hidden' class='form-control' name='final' value='" . $F_final . "' readonly>
				<input type='hidden' class='form-control' name='dias' value='" . $diaSemana . "' readonly>
				<input type='hidden' class='form-control' name='class' value='" . $class . "' readonly><input type='hidden' class='form-control' name='tipo' value='" . $tipo . "' readonly></td>";
				$salida .= "<td><input class='form-control' name='componentes' value='" . $componentesStr . "' readonly></td>";
				$salida .= "<td><button type='button' class='btn btn-primary Elegir' data-id='" . $id . "'>Elegir</button></td>";
				$salida .= "</form>";
				$salida .= "</tr>";
		       	}
                

            
        }elseif ($tipo == 'dia') {
        	
             if (!empty($dias)) {
		        $diasList =  implode(",", $dias);
		        $diasArray = explode(",", substr($diasList, 1, -1));

		        $count = count($diasArray);

		        $conditions = array();

		        for ($i = 0; $i < $count; $i++) {
		            $dia = $diasArray[$i];
		            $conditions[] = "FIND_IN_SET('$dia', dias)";
		        }

		        $listaDias = implode(' OR ', $conditions);
		         $consultaAsignar = $this->db->query("
		            SELECT 1
		            FROM asignar_class ac
		            WHERE ac.class = '$class'
		            AND ac.semana = '$semana'
		            AND ac.dias = '$listaDias'
		            AND (
		                ('$inicio' >= ac.final) OR
		                ('$final' <= ac.inicio)
		            )
		        ");

			        if ($consultaAsignar->num_rows == 0) {
	                $aula = $row['nombre_aula'];
	                $capacidad = $row['capacidad_max'];
	                $id = $row['id'];

	                // Consulta para obtener los nombres de los componentes relacionados
	                $componentes = array();
	                if (!empty($row['componentes'])) {
	                    $componentesIds = explode(',', $row['componentes']);
	                    foreach ($componentesIds as $componenteId) {
	                        $componenteConsulta = $this->db->query("SELECT nombre_componente FROM componentes WHERE id = '$componenteId'");
	                        if ($componenteConsulta->num_rows == 1) {
	                            $componenteRow = $componenteConsulta->fetch_assoc();
	                            $componentes[] = $componenteRow['nombre_componente'];
	                        }
	                    }
	                }
	                $componentesStr = implode(', ', $componentes);

	                $salida .= "<tr>";
	                $salida .= "<form id='reservar-form-" . $id . "' class='reservar-form' method='POST'>";
	                $salida .= "<td><input class='form-control' name='aula' value='" . $aula . "' readonly><input type='hidden' class='form-control' name='usuario' value='" . $usuario . "'><input type='hidden' class='form-control' name='fijo' value='" . $fijo . "'></td>";
	                $salida .= "<td><input class='form-control' name='capacidad' value='" . $capacidad . "' readonly><input type='hidden' class='form-control' name='dias' value='" . $diasList . "' readonly><input type='hidden' class='form-control' name='modulo' value='" . $modulo . "' readonly><input type='hidden' class='form-control' name='piso' value='" . $piso . "' readonly>
						<input type='hidden' class='form-control' name='dia_inicio' value='" . $dia_inicio . "' readonly>
						<input type='hidden' class='form-control' name='dia_final' value='" . $dia_final . "' readonly><input type='hidden' class='form-control' name='semana' value='" . $semana . "' readonly>
						<input type='hidden' class='form-control' name='class' value='" . $class . "' readonly><input type='hidden' class='form-control' name='tipo' value='" . $tipo . "' readonly></td>";
	               
	                $salida .= "<td><input class='form-control' name='componentes' value='" . $componentesStr . "' readonly></td>";
	                $salida .= "<td><button type='button' class='btn btn-primary Elegir' data-id='".$id."'>Elegir</button></td>";
	                $salida .= "</form>";
	                $salida .= "</tr>";
	            }else{$salida = "No hay disponible para la fecha solicitado!";}
		        
		    } else {
		        $salida = "Selecciona primero un dia de la semana.";
		    }

        }elseif ($tipo == 'semana') {
        	
             if (!empty($dias)) {
		        $diasList = '[' . implode(",", $dias) . ']';
		        $diasArray = explode(",", substr($diasList, 1, -1));

		        $count = count($diasArray);

		        $conditions = array();

		        for ($i = 0; $i < $count; $i++) {
		            $dia = $diasArray[$i];
		            $conditions[] = "FIND_IN_SET('$dia', dias)";
		        }

		        $diaLista = implode(' OR ', $conditions);
			        
		        	 $consultaAsignar = $this->db->query("
			            SELECT 1
			            FROM asignar_class ac
			            WHERE ac.class = '$class'
			            AND ('$semana_inicio' = semana_inicio) OR ('$semana_final'= semana_final)
			            AND ac.dias = '$diaLista'
			            AND (
			                ('$inicio' >= ac.final) OR
			                ('$final' <= ac.inicio)
			            )
			        ");

			       if ($consultaAsignar->num_rows == 0) {
	                $aula = $row['nombre_aula'];
	                $capacidad = $row['capacidad_max'];
	                $id = $row['id'];
	                // Consulta para obtener los nombres de los componentes relacionados
	                $componentes = array();
	                if (!empty($row['componentes'])) {
	                    $componentesIds = explode(',', $row['componentes']);
	                    foreach ($componentesIds as $componenteId) {
	                        $componenteConsulta = $this->db->query("SELECT nombre_componente FROM componentes WHERE id = '$componenteId'");
	                        if ($componenteConsulta->num_rows == 1) {
	                            $componenteRow = $componenteConsulta->fetch_assoc();
	                            $componentes[] = $componenteRow['nombre_componente'];
	                        }
	                    }
	                }
	                $componentesStr = implode(', ', $componentes);

	                $salida .= "<tr>";
	                 $salida .= "<form id='reservar-form-" . $id . "' class='reservar-form' method='POST'>";
	                $salida .= "<td><input class='form-control' name='aula' value='" . $aula . "' readonly><input type='hidden' class='form-control' name='usuario' value='" . $usuario . "'><input type='hidden' class='form-control' name='fijo' value='" . $fijo . "'></td>";
	                $salida .= "<td><input class='form-control' name='capacidad' value='" . $capacidad . "' readonly><input type='hidden' class='form-control' name='piso' value='" . $piso . "' readonly><input type='hidden' class='form-control' name='modulo' value='" . $modulo . "' readonly><input type='hidden' class='form-control' name='class' value='" . $class . "' readonly>
						<input type='hidden' class='form-control' name='inicio' value='" . $inicio . "' readonly>
						<input type='hidden' class='form-control' name='final' value='" . $final . "' readonly><input type='hidden' class='form-control' name='semana_inicio' value='" . $semana_inicio . "' readonly>
						<input type='hidden' class='form-control' name='semana_final' value='" . $semana_final . "' readonly></td>";
	                $salida .= "<td><input class='form-control' name='tipo' value='" . $tipo . "' readonly><input type='hidden' class='form-control' name='dias' value='" . $diaLista . "' readonly></td>";
	                $salida .= "<td><input class='form-control' name='componentes' value='" . $componentesStr . "' readonly></td>";
	                $salida .= "<td><button type='button' class='btn btn-primary Elegir' data-id='".$id."'>Elegir</button></td>";
	                $salida .= "</form>";
	                $salida .= "</tr>";
	            }else{$salida = "No hay disponible para la fecha solicitado!";}
		        
		    } else {
		        $salida = "Selecciona primero un dia de la semana.";
		    }
        }elseif ($tipo == 'periodo') {
        	// code...
        }
        
    }

		$salida .= "</tbody>";
		$salida .= "</table>";
		$salida .= "</div>";

    } else {
        // ... No se encontraron aulas disponibles ...
        $salida .= "No hay disponible";
    }

    // Devolver la salida HTML
    echo $salida;
}


		function guardar_aula(){
		extract($_POST);
		$data = " modulo = '$modulo' ";
		$data .= ", id_piso = '$piso' ";
		$data .= ",id_usuario = '$usuario' ";
		$data .= ", capacidad = '$capacidad' ";
		$data .= ", tipo = '$tipo' ";
		$data .= ", class = '$class' ";
		$data .=",aula = '$aula'";
		if(isset($fecha)) 
		$data .= ", fecha = '$fecha' ";
		if(isset($inicio))
		$data .= ", inicio = '$inicio' ";
		if(isset($final))
		$data .= ", final = '$final' ";
		if(isset($dia_inicio))
		$data .=",inicio = '$dia_inicio'";
		if(isset($dia_final))
		$data .=",final = '$dia_final'";
		if(isset($dias))
		$data .= ", dias = '$dias' ";
		if(isset($semana))
		$data .= ", semana = '$semana' ";
		if(isset($semana_inicio))
		$data .= ", semana_inicio = '$semana_inicio' ";
		$data .= ", semana_final = '$semana_final' ";
		if(isset($fijo))
		$data .= ", fijo = '$fijo' ";
		

		if(empty($id)){
			$save = $this->db->query("INSERT INTO asignar_class set ".$data);
		}else{
			$save = $this->db->query("UPDATE asignar_class set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}

	function save_modulo(){
		extract($_POST);
		$data = " nombre = '$modulo' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$imagen=addslashes(file_get_contents($_FILES['img']['tmp_name']));
			
				$data .=", imagen = '$imagen' ";
			
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO modulos set ".$data);
		}else{
			$save = $this->db->query("UPDATE modulos set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_modulo(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM modulos where id = ".$id);
		if($delete)
			return 1;
	}

	function save_carrera(){
		extract($_POST);
		$data = " nombre_carrera = '$name' ";
		$data .= ", descripcion = '$descripcion' ";
		$data .= ", duracion = '$duracion' ";
		$data .= ", id_departamento = '$departamento' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO carreras set ".$data);
		}else{
			$save = $this->db->query("UPDATE carreras set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_carrera(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM carreras where id = ".$id);
		if($delete)
			return 1;
	}

	function save_piso(){
		extract($_POST);
		$data = " nombre_piso = '$name' ";
		$data .= ", descripcion = '$descripcion' ";
		$data .= ", id_modulo = '$modulo' ";
		if(empty($id)){
			$save = $this->db->query("INSERT INTO pisos set ".$data);
		}else{
			$save = $this->db->query("UPDATE pisos set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_piso(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM pisos where id = ".$id);
		if($delete)
			return 1;
	}


	function save_departamento(){
		extract($_POST);
		$data = " nombre_depart = '$name' ";
		$data .= ", id_modulo = '$modulo' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$imagen=addslashes(file_get_contents($_FILES['img']['tmp_name']));
			
				$data .=", imagen = '$imagen' ";
			
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO departamentos set ".$data);
		}else{
			$save = $this->db->query("UPDATE departamentos set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_departamento(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM departamentos where id_service = ".$id);
		if($delete)
			return 1;
	}

		function save_aula(){
		extract($_POST);
		$data = " nombre_aula = '$name' ";
		$data .= ", capacidad_min = '$min' ";
		$data .= ", capacidad_max = '$max' ";
		$data .= ", tipo_aula = '$tipo' ";
		$data .= ", id_piso = '$numero_piso' ";
		if (!empty($componentes)) 
		$data .= ", componentes = ".implode(",",$componentes);
		if(empty($id)){
			$save = $this->db->query("INSERT INTO classes set ".$data);
		}else{
			$save = $this->db->query("UPDATE classes set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_aula(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM classes where id = ".$id);
		if($delete)
			return 1;
	}

	function save_componente(){
		extract($_POST);
		$data = " nombre_componente = '$componente' ";
		$data .= ", descripcion = '$descripcion' ";
		if(!empty($_FILES['img']['tmp_name'])){
			$imagen=addslashes(file_get_contents($_FILES['img']['tmp_name']));
			
				$data .=", imagen = '$imagen' ";
			
		}
		if(empty($id)){
			$save = $this->db->query("INSERT INTO componentes set ".$data);
		}else{
			$save = $this->db->query("UPDATE componentes set ".$data." where id=".$id);
		}
		if($save)
			return 1;
	}
	function delete_componente(){
		extract($_POST);
		$delete = $this->db->query("DELETE FROM componentes where id = ".$id);
		if($delete)
			return 1;
	}

	function get_updated_depart(){
		$modulo = $_POST['moduloId'];
		 $detalles = $this->db->query("SELECT * FROM departamentos WHERE id_modulo = '$modulo' ORDER BY id ASC");
    $output = '';

    if ($detalles->num_rows > 0) {
        $i = 1;
        while ($abonadoRow = $detalles->fetch_assoc()) {
            $depart = $abonadoRow['nombre_depart'];
            $imagen = $abonadoRow['imagen'];
            $idepart = $abonadoRow['id'];
            $idmodulo = $abonadoRow['id_modulo'];

            // Construir el HTML de la fila de la tabla
            $output .= "<tr>";
            $output .= "<td>" . '' . "</td>";
            $output .= "<th>" . $i++ . "</th>";
            $output .= "<th>" . $depart . "</th>";
            $output .= '<th><img src="data:image/jpg;base64,' . base64_encode($imagen) . '"/></th>';
            $output .= "<th>";
            $output .= '<button class="btn btn-sm btn-primary edit_depart" type="button" data-id="' . $idepart . '" data-nombre="' . $depart . '" data-modulo="' . $idmodulo . '" data-img_path="' . base64_encode($imagen) . '">Actualizar</button>';
            $output .= '<button class="btn btn-sm btn-danger delete_depart" type="button" data-id="' . $idepart . '">Eliminar</button>';
            $output .= "</th>";
            $output .= "</tr>";
        }
    }

    // Devolver el HTML actualizado de la tabla como respuesta AJAX
    echo $output;
	}

	function get_updated_piso(){
		$modulo = $_POST['moduloId'];
		 $detalles = $this->db->query("SELECT * FROM pisos WHERE id_modulo = '$modulo' ORDER BY id ASC");
    $output = '';

    if ($detalles->num_rows > 0) {
        $i = 1;
       while ($Pisorow = $detalles->fetch_assoc()) {
        $piso = $Pisorow['nombre_piso'];
        $idpiso = $Pisorow['id'];
        $idmodulo = $Pisorow['id_modulo'];
         $Pdescripcion = $Pisorow['descripcion'];

            // Construir el HTML de la fila de la tabla
            $output .= "<tr>";
            $output .= "<td>" . '' . "</td>";
            $output .= "<th>" . $i++ . "</th>";
            $output .= "<th>" . $piso . "</th>";
            $output .= "<th>" . $Pdescripcion . "</th>";
            $output .= "<th>";
            $output .= '<button class="btn btn-sm btn-primary edit_piso" type="button" data-id="' . $idpiso . '" data-name="' . $piso . '" data-descripcion="' . $Pdescripcion . '" data-modulo="' . $idmodulo . '">Actualizar</button>';
            $output .= '<button class="btn btn-sm btn-danger delete_depart" type="button" data-id="' . $idpiso . '">Eliminar</button>';
            $output .= "</th>";
            $output .= "</tr>";
        }
    }

    // Devolver el HTML actualizado de la tabla como respuesta AJAX
    echo $output;
	}

	function get_updated_carrera(){
		$depart = $_POST['departamentoId'];
		$detalles = $this->db->query("SELECT * FROM carreras WHERE id_departamento = '$depart' ORDER BY id ASC");
    $output = '';

     if ($detalles->num_rows > 0) {
        $i = 1;
       while ($carre = $detalles->fetch_assoc()) {
        $carrera = $carre['nombre_carrera'];
        $descripcion = $carre['descripcion'];
        $duracion = $carre['duracion'];
        $idepart = $carre['id_departamento'];
        $idcare = $carre['id'];

            // Construir el HTML de la fila de la tabla
            $output .= "<tr>";
            $output .= "<td>" . '' . "</td>";
         
            $output .= "<th>" . $carrera . "</th>";
             $output .= "<th>" . $duracion . "</th>";
              $output .= "<th>" . $descripcion . "</th>";
           
            $output .= "<th>";
            $output .= '<button class="btn btn-sm btn-primary edit_carrera" type="button" data-id="' . $idcare . '" data-name="' . $carrera . '" data-duracion="' . $duracion . '" data-departamento="' . $idepart . '" data-descripcion="' . $descripcion . '">Actualizar</button>';
            $output .= '<button class="btn btn-sm btn-danger delete_carrera" type="button" data-id="' . $idcare . '">Eliminar</button>';
            $output .= "</th>";
            $output .= "</tr>";
        }
    }

    // Devolver el HTML actualizado de la tabla como respuesta AJAX
    echo $output;
	}

	function get_updated_aula(){
		$id_piso = $_POST['aulaId'];
		$detalles = $this->db->query("SELECT * FROM classes WHERE id_piso = '$id_piso' ORDER BY id ASC");
    $output = '';

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

            // Construir el HTML de la fila de la tabla
            $output .= "<tr>";
            $output .= "<td>" . '' . "</td>";
           $output .= "<th>" . $aula . "</th>";
            $output .= "<th>" . $tipo . "</th>";
             $output .= "<th>" . $cap_min . "</th>";
              $output .= "<th>" . $cap_max . "</th>";
             $output .= "<th>";
             
             if (!empty($compo)) {
            $componentes = explode(",", str_replace(array("[", "]"), "", $compo));
            foreach ($componentes as $componente) {
               if (isset($comp_ente[$componente])) {
                    echo '<span style="background-color: gray;padding: 5px;margin:0px" class="badge badge-light"><large><b>' . $comp_ente[$componente] . '</b></large></span>';
                }
               
            }
        }
             $output .="</th>";
            $output .= "<th>";
            $output .= '<button class="btn btn-sm btn-primary edit_aula" type="button" data-id="' . $idaula . '" data-name="' . $aula . '" data-tipo="' . $tipo . '" data-pisos="' . $numero_piso . '" data-componente="' . $compo . '" data-max="' . $cap_max . '" data-min="' . $cap_min . '">Actualizar</button>';
        echo '<button class="btn btn-sm btn-danger delete_aula" type="button" data-id="' . $idaula . '">Eliminar</button>';
            $output .= "</th>";
            $output .= "</tr>";
        }
    }

    // Devolver el HTML actualizado de la tabla como respuesta AJAX
    echo $output;
	}

	
}
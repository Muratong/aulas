<?php 
session_start();	
include "./modelo/conexion.php";
 $objeto = new Conexion();
 $conn = $objeto->Conectar();
 if (!empty($_POST['btn_ingresar'])) {

 if (!empty($_POST['usuario']) && !empty($_POST['clave'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['clave'];

    // Realiza una consulta para obtener el usuario por su nombre de usuario
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $datos = $result->fetch_assoc();
        // Verifica si la contraseña ingresada coincide con el hash almacenado en la base de datos
        if (password_verify($password, $datos['password']) && $datos['type'] == 'Habilitado') {
            // La contraseña es válida y el usuario está habilitado
            // Iniciar sesión y redirigir al panel de control
            session_start();
            $_SESSION['id_usuario'] = $datos['id_usuario'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['apellido'] = $datos['apellido'];
            $_SESSION['rol'] = $datos['rol'];
            $_SESSION['documento'] = $datos['documento'];
            $_SESSION['usuario'] = $datos['usuario'];
            if ($_SESSION['rol']==1) {
               header("location: dashboard.php");
            } else {
                header("location: solicitud.php");
            }
            
        } else {
            // La contraseña es incorrecta o el usuario está deshabilitado
            echo "<div class='alert alert-danger'>Usuario o contraseña incorrectos o estás deshabilitado.</div>";
        }
    } else {
        // No se encontró ningún usuario con ese nombre de usuario
        echo "<div class='alert alert-danger'>Usuario o contraseña incorrectos o estás deshabilitado.</div>";
    }

    // Cierra la consulta y la conexión
    $stmt->close();
    $conn->close();
}else {
		echo "<div class='alert alert-danger'>Acceso denegado</div>";
	}
	
}

 ?>
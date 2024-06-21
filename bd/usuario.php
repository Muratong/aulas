<?php
include_once 'conexion.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$username = (isset($_POST['username'])) ? $_POST['username'] : '';
$documento = (isset($_POST['documento'])) ? $_POST['documento'] : '';
$nombre = (isset($_POST['nombre'])) ? $_POST['nombre'] : '';
$rol = (isset($_POST['rol'])) ? $_POST['rol'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';
$status = (isset($_POST['status'])) ? $_POST['status'] : '';
$opcion = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$id_usuario = (isset($_POST['id_usuario'])) ? $_POST['id_usuario'] : '';
 // Genera un hash de la contraseña utilizando bcrypt
$hashPassword = password_hash($password, PASSWORD_DEFAULT);

switch($opcion){
    case 1:
       

// La consulta SQL se modifica para utilizar el valor de $hashedPassword en lugar de $password en texto plano
        $consulta = "INSERT INTO usuarios (name, documento, usuario, type, password, rol) VALUES('$nombre', '$documento', '$username', '$status', '$hashPassword', '$rol')";    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute(); 
        
        $consulta = "SELECT * FROM usuarios ORDER BY id_usuario DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);       
        break;    
    case 2:        
        $consulta = "UPDATE usuarios SET name='$nombre', documento='$documento', usuario='$username', type='$status', password='$hashPassword', rol='$rol' WHERE id_usuario ='$id_usuario' ";    
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();        
        
        $consulta = "SELECT * FROM usuarios WHERE id_usuario='$id_usuario' ";       
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:        
        $consulta = "DELETE FROM usuarios WHERE id_usuario='$id_usuario' ";      
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();                           
        break;    
}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
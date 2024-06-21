<?php 
session_start();

if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}
    include './modelo/conexion.php'; 
    $objeto = new Conexion();
        $conn = $objeto->Conectar();
   
    $usuario = $conn->query("SELECT COUNT(*) as cantidad_usuario FROM usuarios WHERE rol =1");
    if ($usuario) {
    $row = $usuario->fetch_assoc();
    $cantidad_admin = $row['cantidad_usuario'];
    }
    $usuario = $conn->query("SELECT COUNT(*) as cantidad_usuario FROM usuarios WHERE rol !=1");
    if ($usuario) {
    $row = $usuario->fetch_assoc();
    $cantidad_usuarios = $row['cantidad_usuario'];
    }
 
 ?>
<style>
    .card{
        background-color: #274d8a;
        color: white;
        border-radius: 18px;
        font-size: 18px;
        padding: 0 20px;
    }
    .card b{
        margin: 10px;
        font-size: 20px;
        text-align: center;
    }
    .card-header{
/*        border: 1px solid;*/
        border-radius: 20px;
        box-shadow: 0px 3px 8px rgba(0, 0, 0, 25%);
    }
</style>
<!DOCTYPE html>
<html lang="es-AR">
<body> 

    <section class="cardy" >
        
           <div class="card-header">
            <div class="card">            
                <h4>Docentes</h4>            
            </div>
            <hr>
            <div class="card">
              <b><?php echo $cantidad_usuarios ?></b>
            </div>
            <hr>
        </div>
         <div class="card-header">
            <div class="card">
                <h4>Admin</h4>
            </div>
            <hr>
            <div class="card">
              <b><?php echo $cantidad_admin ?></b>
            </div>
            <hr>
        </div>
    </section>
</body>
</html>
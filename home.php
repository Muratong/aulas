<?php 
session_start();
date_default_timezone_set('America/Argentina/La_Rioja');
setlocale(LC_TIME, 'Spanish');
if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}
include "modelo/conexion.php";
$conexion = new Conexion();
$conn = $conexion->Conectar();

$filas = $conn->query("SELECT COUNT(*) as modulo FROM modulos");
if ($filas) {
    $row = $filas->fetch_assoc();
    $cantidadModulos = $row['modulo'];
}

$aulas = $conn->query("SELECT COUNT(*) as aula FROM classes");
if ($aulas) {
    $row = $aulas->fetch_assoc();
    $cantidadClases = $row['aula'];
}

  $cantidad = $conn->query("SELECT COUNT(*) as cantidad_filas FROM pisos");
  if ($cantidad->num_rows > 0) {
      $rows = $cantidad->fetch_assoc();
      $cantidadPisos = $rows['cantidad_filas'];
  }
 ?>
<style>
    .card__nombre{
        background-color: #274d8a;
        color: white;
        border-radius: 10px;
        margin: 0;
        text-size-adjust: 12px;
        font-size: 16px;
    }
    .card b{
        margin: 0px;
        font-size: 16px;
    }
    .cardy__perfil{
        width: 100%;
        height: 100px;
    }
</style>
<!DOCTYPE html>
<html lang="es">
<body> 

    <section class="cardy" >
        <div class="card__perfil">
            <div class="card__nombre">
                <i class="fa fa-user"></i>Modulos
            </div>
            <hr>
            <div class="card">

              <b><?php echo $cantidadModulos;  ?></b>
            </div>
            <hr>
        </div>
        <div class="card__perfil">
            <div class="card__nombre">
                <i class="fa fa-home"></i>Pisos
            </div>
            <hr>
            <div class="card">
               <b><?php echo $cantidadPisos;  ?></b>
            </div>
            <hr>
        </div>
        <div class="card__perfil">
            <div class="card__nombre">
                <i class="fa fa-home"></i>Aulas 
            </div>
            <hr>
            <div class="card"> 
                <b><?php echo $cantidadClases;  ?></b>
            </div>
            <hr>
        </div>
       
    </section>
  </body>
</html>
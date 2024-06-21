<?php 
session_start();
date_default_timezone_set('America/Argentina/La_Rioja');
setlocale(LC_TIME, 'Spanish');
if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}
 include('modelo/conexion.php');
$objeto = new Conexion();
$conn = $objeto->Conectar();
 ?>

<!DOCTYPE html>
<html lang="es-AR">
<?php include "header.php"; ?>
<style>
    label{
        color: white;
    }
 .aula{
    font-size: 20px;
    border-bottom: 3px solid;
 }
 b{
    color: white;
 }
 .btn-sm{
    border:2px solid;
    border-radius: 10px;
    margin: 10px;
    box-shadow: 0px 3px 8px rgba(0, 0, 0, 25%);
 }
 section{
    margin-top: 20px;
 }
 .card{
    background-color: lightgray;
 }
</style>
<body>

    <section class="container">    
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
            <?php 
              $consulta = $conn->query("SELECT * FROM asignar_class ac INNER JOIN modulos m ON ac.modulo=m.id WHERE ac.id_usuario =" . $_SESSION['id_usuario']);
                while ($row = $consulta->fetch_assoc()) {
                $diasStr = $row['dias'];
                // Dividir la cadena de días en un arreglo
                $diasArray = explode(',', $diasStr);
                // Definir un arreglo con los nombres de los días de la semana
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
                        // Verificar si el número de día de la semana está dentro del rango válido
                        if (array_key_exists($numeroDiaSemana, $nombresDiasSemana)) {
                            $nombresDias[] = $nombresDiasSemana[$numeroDiaSemana];
                        }
                    }
                    // Convertir los nombres de los días en una cadena separada por comas
                    $nombreDia = implode(', ', $nombresDias);
                ?>
                <div class="btn btn-sm">
                <b class="btn btn-info">
                    <strong class="aula"><?php echo $row['aula']; ?> </strong><br>
                    <b><?php echo $row['nombre']; ?></b><br>
                     <strong>Cap_max: </strong> <?php echo $row['capacidad']; ?> Alumnos<br>
                    <?php 
                    if ($row['fecha'] != '0000-00-00') {
                        // Convertir la fecha al formato dd-mm-yyyy
                        $fechaFormateada = date('d-m-Y', strtotime($row['fecha']));
                        echo '<strong>Fecha unica:</strong> '. '<b>' .$fechaFormateada. '</b>';
                    }
                     ?><br>
                    <?php echo $nombreDia; ?><br> <!-- Mostrar el nombre del día -->
                    <?php echo $row['inicio'] . ' - ' . $row['final']; ?>
                </b>
                </div>
                <?php } ?>
            </div>             
            </div>
          </div>
        </div>
    </section>
   <?php include "footer.php" ?>
</body>

</html>
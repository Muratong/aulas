<?php 
session_start();
date_default_timezone_set('America/Argentina/La_Rioja');
setlocale(LC_TIME, 'Spanish');
if (!isset($_SESSION['id_usuario'])) {
   header("location:index.php");
}

 ?>

<!DOCTYPE html>
<html lang="es-AR">

<?php include "header.php"; ?>
<style>
    label{
        color: white;
    }
    table tr th:nth-child(1),
    table tr td:nth-child(1)
     {
        display: none;
}
</style>
<body>
<?php if ($_SESSION['rol'] == 1) : ?>
    <div id="panel"></div>
    <div id="control"></div>
<?php endif; ?>   
<br><br>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>          

    <script>
       
        function recargarPagina() {
            var url = "home.php"; // Coloca aquí la URL de la página que deseas cargar.
            var panel = $("#panel");

            $.ajax({
                url: url,
                dataType: "html",
                beforeSend: function() {
                    panel.html("<p>Cargando los contenidos...</p>");
                },
                success: function(data) {
                    panel.html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    panel.html("<p>Ha ocurrido un error al cargar la página.</p>");
                }
            });
        }

          function recargarModulo() {
            var url = "control_modulos.php"; 
            var control = $("#control");

            $.ajax({
                url: url,
                dataType: "html",
                beforeSend: function() {
                    control.html("<p>Cargando los contenidos...</p>");
                },
                success: function(data) {
                    control.html(data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    control.html("<p>Ha ocurrido un error al cargar la página.</p>");
                }
            });
        }

        $(function () {
            // Carga la página la primera vez que se carga la página.
            recargarPagina();
            recargarModulo();
            // Recarga la página cada 5 segundos.
            setInterval(recargarPagina, 100000);
        });

    </script>
   <?php include "footer.php" ?>
</body>

</html>
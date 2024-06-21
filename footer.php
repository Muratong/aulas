
<!DOCTYPE html>
<html lang="en-AR">

<head>
    <link rel="stylesheet" href="./css/styles.css">
    <head>

    <footer >

        <div class="container-fluid" >

            <!-- Button trigger modal -->
            <div class="mobile-toggler d-lg-none">
                <b id="dashboard">
                    <i class="fa-solid fa-home"></i>
                </b>
            </div>
          
                   <div class="mobile-toggler d-lg-none">
                 <b id="consultas">
                    <i class="fa-solid fa-database"></i>
                </b>
            </div>
              <?php if ($_SESSION['rol']== 1): ?>
             <div class="mobile-toggler d-lg-none">
                <b id="usuarios">
                <i class="fa-solid fa-users-between-lines"></i>
                </b>
            </div>
            <?php endif ?>
          
            <?php $dia = date("d-m-Y"); ?>
             <div class="pie">© <?php echo $dia ?> - UNLAR Todos los Derechos Reservados</div>
        </div>
        
    
    </footer>
   <script>
    $('#dashboard').click(function(e) {
        e.preventDefault();
        window.location.href = "dashboard.php";
    });
     $('#consultas').click(function(e) {
        e.preventDefault();
        window.location.href = "pedidos.php";
    });
      $('#usuarios').click(function(e) {
        e.preventDefault();
        window.location.href = "usuarios.php";
    });
</script>

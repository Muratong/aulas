
<!DOCTYPE html>
<html lang="es-AR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AULAS</title>
     <link rel="shortcut icon" href="img/icono.jpg" type="image/x-icon">
    <link rel="stylesheet" href="./css/estilos.css">
     <link rel="stylesheet" href="css/all.css">
       <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">    
    <link rel="stylesheet" href="main.css">  
 <link rel="stylesheet"  type="text/css" href="assets/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js
    "></script>
    <script src="https://kit.fontawesome.com/03a89292db.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <head>

    <header >

        <div class="container-fluid" >

            <div class="navb-logo">
                 <img src="./img/UNLaR.png" alt="Logo">
            </div>

            <div class="navb-items d-none d-xl-flex">

               <?php if($_SESSION['rol']!= 1): ?>
                <div class="item">
                    <a href="reservas.php">RESERVADOS</a>
                </div>
                <div class="item">
                    <a href="solicitud.php">SOLICITUD</a>
                </div>
<?php endif; ?>
<?php if ($_SESSION['rol'] == 1) : ?>
               <div class="item">
                    <a href="dashboard.php"><i class="fa-solid fa-house"></i> DASHBOARD</a>
                </div>
                <div class="item">
                    <a href="pedidos.php"><i class="fa-solid fa-database"></i> PEDIDOS</a>
                </div>
                <div class="item">
                    <a href="usuarios.php"><i class="fa-solid fa-users-between-lines"></i> USUARIOS</a>
                </div>
<?php endif; ?>
            

                <div class="item">
                    <i class="fa fa-power-off"></i><a href="controle/salir.php" type="button" style="border-radius: ;padding:0px 30px;"><?php echo $_SESSION['usuario'] ?></a>
                </div>
            </div>

            <!-- Button trigger modal -->
            <div class="mobile-toggler d-lg-none">
                <a href="#" data-bs-toggle="modal" data-bs-target="#navbModal">
                    <i class="fa-solid fa-bars"></i>
                </a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="navbModal" tabindex="-1" aria-labelledby="exampleModalLabel" 
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        
                        <div class="modal-header">
                            <div class="navb-logo">
                      <img src="./img/icono.jpg" alt="Logo">
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                        </div>

                        <div class="modal-body">
                            
                             <?php if($_SESSION['rol']!= 1): ?>
                        <div class="item">
                            <a href="reservas.php">RESERVADOS</a>
                        </div><hr>
                        <div class="item">
                            <a href="solicitud.php">SOLICITUD</a>
                        </div><hr>
                        <?php endif; ?>

                    <?php if ($_SESSION['rol'] == 1) : ?>
                            <div class="modal-line">
                              <i class="fa-solid fa-house"></i><a href="dashboard.php">DASHBOARD</a>
                            </div>
                            <div class="modal-line">
                              <i class="fa-solid fa-database"></i><a href="pedidos.php">PEDIDOS</a>
                            </div>
                            <div class="modal-line">
                                <i class="fa-solid fa-users-between-lines"></i> <a href="usuarios.php">USUARIOS</a>
                            </div>
                    <?php endif; ?>
                            <a href="controle/salir.php" class="navb-button" type="button" style="border-radius: 10%;"><i class="fa fa-power-off"></i><?php echo $_SESSION['usuario'] ?></a>
                        </div>

                        <div class="mobile-modal-footer">
                            
                            <a target="" href="#"><i class="fa-brands fa-instagram"></i></a>
                            <a target="" href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a target="" href="#"><i class="fa-brands fa-youtube"></i></a>
                            <a target="" href="#"><i class="fa-brands fa-facebook"></i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </header>
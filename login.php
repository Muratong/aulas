<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	 <link rel="shortcut icon" href="img/icono.jpg" type="image/x-icon">
</head>
<body>
		<img class="wave" src="img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/UNLaR.png">
		</div>
		<div class="login-content">
			<form action="" method="POST">
				<img src="img/icono.jpg">
				<h2 class="title">Bienvenido</h2>
				<?php 
				include "controle/controle_login.php";
				 ?>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Usuario</h5>
           		   		<input type="text" class="input" name="usuario">
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Contraseña</h5>
           		    	<input id="clave" name="clave" type="password" class="input">
                <span id="ver" class="ver_clave"><i id="icono" class="fas fa-eye"></i></span>
            	   </div>
            	</div>
            	<!-- <a href="#">Forgot Password?</a> -->
            	<input type="submit" class="btn" value="INICIAR SESION" name="btn_ingresar">
            </form>
        </div>
    </div>
    <script src="js/main.js"></script>

</body>
</html>
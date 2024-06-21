<?php
require 'serverside.php';
$table_data->get('usuarios', 'id_usuario', array('id_usuario','name','documento','usuario','type','rol','password'));
?>	
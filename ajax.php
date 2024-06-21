<?php
ob_start(); // inicia el bufer de php (guarda los datos antes de enviar al navegdor)
$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action(); // instancia de la clase action

if($action == 'save_piso'){
	$save = $crud->save_piso();
	if($save)
		echo $save;
}
if($action == 'delete_piso'){
	$save = $crud->delete_piso();
	if($save)
		echo $save;
}

if($action == "save_aula"){
	$save = $crud->save_aula();
	if($save)
		echo $save;
}
if($action == "delete_aula"){
	$save = $crud->delete_aula();
	if($save)
		echo $save;
}

if($action == "save_componente"){
	$save = $crud->save_componente();
	if($save)
		echo $save;
}
if($action == "delete_componente"){
	$save = $crud->delete_componente();
	if($save)
		echo $save;
}

if($action == 'piso'){
	$save = $crud->getPiso();
	if($save)
		echo $save;
}
if ($action == 'solicitud') {
	$save = $crud->solicitud();
	if($save)
		echo $save;
}
if ($action == 'guardar') {
	$save = $crud->guardar_aula();
	if($save)
		echo $save;
}

if($action == "save_modulo"){
	$save = $crud->save_modulo();
	if($save)
		echo $save;
}
if($action == "delete_modulo"){
	$save = $crud->delete_modulo();
	if($save)
		echo $save;
}

if($action == "save_carrera"){
	$save = $crud->save_carrera();
	if($save)
		echo $save;
}
if($action == "delete_carrera"){
	$save = $crud->delete_carrera();
	if($save)
		echo $save;
}

if($action == "save_departamento"){
	$save = $crud->save_departamento();
	if($save)
		echo $save;
}
if($action == "delete_departamento"){
	$save = $crud->delete_departamento();
	if($save)
		echo $save;
}

if ($action == 'get_updated_table') {
   $save = $crud->get_updated_depart();
	if($save)
		echo $save;
}

if ($action == 'get_updated_piso') {
   $save = $crud->get_updated_piso();
	if($save)
		echo $save;
}

if ($action == 'get_updated_carrera') {
   $save = $crud->get_updated_carrera();
	if($save)
		echo $save;
}

// if ($action == 'get_updated_modulo') {
//    $save = $crud->get_updated_modulo();
// 	if($save)
// 		echo $save;
// }

if ($action == 'get_updated_aula') {
   $save = $crud->get_updated_aula();
	if($save)
		echo $save;
}

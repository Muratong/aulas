<?php
// Define constantes para los parámetros de conexión a la base de datos
define("SERVIDOR", "localhost");
define("BD", "aulas");
define("USUARIO", "root");
define("PASS", "");

// Crea la clase Conexion
class Conexion {
    // Define el método estático Conectar
    public static function Conectar() {
        // Define un conjunto de opciones para la conexión PDO (PHP DATA OBJECTS)
        $opciones = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', // Establece la codificación de caracteres a UTF-8
            PDO::MYSQL_ATTR_DIRECT_QUERY => false, // Desactiva las consultas directas
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // Establece el modo de error a excepciones
        );

        try {
            // Crea una instancia de PDO para conectarse a la base de datos
            $conexion = new PDO("mysql:host=" . SERVIDOR . ";dbname=" . BD, USUARIO, PASS, $opciones);
            
            // Devuelve la instancia de conexión
            return $conexion;
        } catch (Exception $e) {
            // Captura y muestra cualquier excepción que ocurra durante la conexión
            die("El error de Conexión es: " . $e->getMessage());
        }
    }
}

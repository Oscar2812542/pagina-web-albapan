<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "inventario_panaderia";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    die("Error de conexión");
}
?>

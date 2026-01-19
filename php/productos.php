<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$caducidad = $_POST['caducidad'];

$sql = "INSERT INTO productos (nombre, cantidad, caducidad)
        VALUES ('$nombre', '$cantidad', '$caducidad')";

mysqli_query($conexion, $sql);
header("Location: ../dashboard.php");
?>

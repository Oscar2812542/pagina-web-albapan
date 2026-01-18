<?php
include("conexion.php");

$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$fecha = $_POST['fecha_caducidad'];

$sql = "INSERT INTO productos (nombre, cantidad, fecha_caducidad)
        VALUES ('$nombre', $cantidad, '$fecha')";

if (mysqli_query($conexion, $sql)) {
    header("Location: ../dashboard.php?msg=agregado");
} else {
    header("Location: ../dashboard.php?msg=error");
}
?>

<?php
include("conexion.php");

$id = $_POST['id_producto'];
$nombre = $_POST['nombre'];
$cantidad = $_POST['cantidad'];
$fecha = $_POST['fecha_caducidad'];

$sql = "UPDATE productos 
        SET nombre='$nombre', cantidad=$cantidad, fecha_caducidad='$fecha'
        WHERE id_producto=$id";

if (mysqli_query($conexion, $sql)) {
    header("Location: ../dashboard.php?msg=editado");
} else {
    header("Location: ../dashboard.php?msg=error");
}
?>

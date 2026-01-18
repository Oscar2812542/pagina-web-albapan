<?php
session_start();
include("conexion.php");

if (!isset($_POST['usuario']) || !isset($_POST['password'])) {
    die("Datos no enviados correctamente");
}

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'";
$res = mysqli_query($conexion, $sql);

if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_assoc($res);
    $_SESSION['usuario'] = $row['usuario'];
    $_SESSION['rol'] = $row['rol'];
    header("Location: ../dashboard.php");
    exit();
} else {
    echo "Usuario no encontrado";
}

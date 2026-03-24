<?php
include("php/conexion.php");

$id = $_GET['id'];
$resultado = mysqli_query($conexion, "SELECT * FROM productos WHERE id_producto = $id");
$producto = mysqli_fetch_assoc($resultado);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
</head>
<body>

<h2>Editar producto</h2>

<form action="php/actualizar_producto.php" method="POST">
    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">

    <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?>" required>

    <input type="number" name="cantidad" value="<?php echo $producto['cantidad']; ?>" required>

    <input type="date" name="fecha_caducidad" value="<?php echo $producto['fecha_caducidad']; ?>" required>

    <button type="submit">Actualizar</button>
</form>

</body>
</html>

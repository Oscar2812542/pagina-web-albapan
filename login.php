<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Acceso | ALBAPAN</title>
<link rel="stylesheet" href="css/estilos.css">
</head>
<body class="login-body">

<div class="login-container">
    <div class="login-card">

        <img src="img/logo.png" class="login-logo">

        <h2>Acceso al sistema</h2>
        <p>Control de inventario</p>

        <form action="php/validar_login.php" method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

    </div>
</div>

</body>
</html>

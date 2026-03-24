<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

include("php/conexion.php");

/* CONSULTAS */

// PRODUCTOS
$resultado = mysqli_query($conexion, "SELECT * FROM productos");

// ALERTAS DE CADUCIDAD (5 días)
$alertas = mysqli_query(
    $conexion,
    "SELECT nombre, fecha_caducidad,
     DATEDIFF(fecha_caducidad, CURDATE()) AS dias
     FROM productos
     WHERE fecha_caducidad <= DATE_ADD(CURDATE(), INTERVAL 5 DAY)"
);

// TOTAL PRODUCTOS
$totalProductos = mysqli_fetch_assoc(
    mysqli_query($conexion, "SELECT COUNT(*) AS total FROM productos")
)['total'];

// POR CADUCAR
$porCaducar = mysqli_fetch_assoc(
    mysqli_query($conexion,
        "SELECT COUNT(*) AS total 
         FROM productos 
         WHERE fecha_caducidad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY)"
    )
)['total'];

// CADUCADOS
$caducados = mysqli_fetch_assoc(
    mysqli_query($conexion,
        "SELECT COUNT(*) AS total 
         FROM productos 
         WHERE fecha_caducidad < CURDATE()"
    )
)['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | ALBAPAN</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --color-principal:#8B5A2B;
            --color-secundario:#F5E6D3;
            --color-fondo:#f8f9fa;
        }

        body{
            background:var(--color-fondo);
            font-family:'Segoe UI', sans-serif;
        }

        .navbar{
            background:var(--color-principal);
        }

        .navbar-brand, .nav-link{
            color:white !important;
        }

        .card{
            border:none;
            border-radius:15px;
            box-shadow:0 4px 10px rgba(0,0,0,0.08);
        }

        .icon{
            font-size:2.2rem;
            color:var(--color-principal);
        }

        .alert-box{
            background:var(--color-secundario);
            border-left:5px solid var(--color-principal);
            border-radius:10px;
        }

        footer{
            text-align:center;
            padding:15px;
            color:#777;
            font-size:0.9rem;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">ALBAPAN | Inventarios</a>

        <div class="ms-auto d-flex align-items-center">
            <span class="text-white me-3">
                <?php echo $_SESSION['usuario']; ?> (<?php echo $_SESSION['rol']; ?>)
            </span>
            <a href="logout.php" class="btn btn-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container mt-4">

<!-- RESUMEN -->
<div class="row g-4">

    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total productos</h6>
                    <h3><?php echo $totalProductos; ?></h3>
                </div>
                <i class="bi bi-box-seam icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Por caducar</h6>
                    <h3><?php echo $porCaducar; ?></h3>
                </div>
                <i class="bi bi-exclamation-triangle icon"></i>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6>Caducados</h6>
                    <h3><?php echo $caducados; ?></h3>
                </div>
                <i class="bi bi-x-circle icon"></i>
            </div>
        </div>
    </div>

</div>

<!-- ALERTAS + FORM -->
<div class="row mt-4 g-4">

    <div class="col-md-6">
        <div class="alert-box p-3">
            <h6>⚠ Alertas de caducidad</h6>

            <?php if (mysqli_num_rows($alertas) > 0) { ?>
               <ul class="list-unstyled mt-2">
<?php while($a = mysqli_fetch_assoc($alertas)) {

    if ($a['dias'] < 0) {
        $color = "rojo";
        $texto = "Caducado";
    } elseif ($a['dias'] <= 5) {
        $color = "amarillo";
        $texto = "Por caducar";
    } else {
        $color = "verde";
        $texto = "Vigente";
    }
?>
    <li class="mb-2">
        <span class="semaforo <?php echo $color; ?>"></span>
        <strong><?php echo $a['nombre']; ?></strong>
        — <?php echo $texto; ?> (<?php echo $a['dias']; ?> días)
    </li>
<?php } ?>
</ul>

            <?php } else { ?>
                <p>No hay productos próximos a caducar.</p>
            <?php } ?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4">
            <h5>Agregar producto</h5>

            <form action="php/guardar_producto.php" method="POST">
                <input class="form-control mb-2" type="text" name="nombre" placeholder="Nombre del producto" required>
                <input class="form-control mb-2" type="number" name="cantidad" placeholder="Cantidad" required>
                <input class="form-control mb-2" type="date" name="fecha_caducidad" required>
                <button class="btn btn-primary w-100">Guardar producto</button>
            </form>
        </div>
    </div>

</div>

<!-- TABLA -->
<div class="card mt-4 p-4">
    <h5>Productos registrados</h5>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Caducidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $row['nombre']; ?></td>
                <td><?php echo $row['cantidad']; ?></td>
                <td><?php echo $row['fecha_caducidad']; ?></td>
                <td>
                    <a href="editar_producto.php?id=<?php echo $row['id_producto']; ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="php/eliminar_producto.php?id=<?php echo $row['id_producto']; ?>"
                       onclick="return confirm('¿Seguro que deseas eliminar este producto?');"
                       class="btn btn-sm btn-danger">
                       Eliminar
                    </a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</div>

<footer class="mt-4">
    Sistema de Inventario ALBAPAN © 2026
</footer>

</body>
</html>

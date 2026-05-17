<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
include 'conexion.php';

// Estadísticas rápidas
$total_productos = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM productos"))['total'];
$total_ventas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM ventas"))['total'];
$total_clientes = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT COUNT(*) as total FROM clientes"))['total'];
$ingresos_totales = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT SUM(total) as total FROM ventas"))['total'];

// Últimas ventas
$sql_recientes = "SELECT v.fecha, v.total, c.nombre as cliente 
                  FROM ventas v 
                  JOIN clientes c ON v.id_cliente = c.id_cliente 
                  ORDER BY v.fecha DESC LIMIT 5";
$result_recientes = mysqli_query($conexion, $sql_recientes);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Paso Firme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">PASO FIRME</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Volver al Panel</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Dashboard Administrativo</h2>
        
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Total Productos</h6>
                        <h2 class="mb-0"><?php echo $total_productos; ?></h2>
                        <i class="bi bi-box position-absolute top-50 end-0 translate-middle-y opacity-25 me-3 fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Ventas Realizadas</h6>
                        <h2 class="mb-0"><?php echo $total_ventas; ?></h2>
                        <i class="bi bi-cart-check position-absolute top-50 end-0 translate-middle-y opacity-25 me-3 fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">Clientes Registrados</h6>
                        <h2 class="mb-0"><?php echo $total_clientes; ?></h2>
                        <i class="bi bi-people position-absolute top-50 end-0 translate-middle-y opacity-25 me-3 fs-1"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">Ingresos Totales</h6>
                        <h2 class="mb-0">S/ <?php echo number_format($ingresos_totales, 2); ?></h2>
                        <i class="bi bi-cash-stack position-absolute top-50 end-0 translate-middle-y opacity-25 me-3 fs-1"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Ventas Recientes</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Cliente</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($venta = mysqli_fetch_assoc($result_recientes)): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($venta['fecha'])); ?></td>
                                        <td><?php echo htmlspecialchars($venta['cliente']); ?></td>
                                        <td class="fw-bold">S/ <?php echo number_format($venta['total'], 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Accesos Rápidos</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <a href="productos.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Gestionar Inventario
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="ventas.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Ver todas las ventas
                                <i class="bi bi-chevron-right"></i>
                            </a>
                            <a href="clientes.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                Administrar Clientes
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
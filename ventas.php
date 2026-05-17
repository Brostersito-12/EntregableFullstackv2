<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
include 'conexion.php';

// Consulta de ventas con detalles de cliente y empleado
$sql_ventas = "SELECT v.*, c.nombre as cliente, e.nombre as empleado, m.metodo 
               FROM ventas v
               JOIN clientes c ON v.id_cliente = c.id_cliente
               JOIN empleados e ON v.id_empleado = e.id_empleado
               JOIN metodos_pago m ON v.id_metodo_pago = m.id_metodo_pago
               ORDER BY v.fecha DESC";
$result_ventas = mysqli_query($conexion, $sql_ventas);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Ventas - Paso Firme</title>
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
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Historial de Ventas</h2>
            <button class="btn btn-success">
                <i class="bi bi-cart-plus me-2"></i>Nueva Venta
            </button>
        </div>

        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID Venta</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Atendido por</th>
                        <th>Método Pago</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result_ventas)): ?>
                    <tr>
                        <td>#<?php echo $row['id_venta']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha'])); ?></td>
                        <td><?php echo htmlspecialchars($row['cliente']); ?></td>
                        <td><?php echo htmlspecialchars($row['empleado']); ?></td>
                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars($row['metodo']); ?></span></td>
                        <td class="fw-bold text-success">S/ <?php echo number_format($row['total'], 2); ?></td>
                        <td>
                            <button class="btn btn-sm btn-info text-white"><i class="bi bi-eye"></i> Detalle</button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-printer"></i></button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
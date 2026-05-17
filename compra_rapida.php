<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;
$producto = null;

if ($id_producto > 0) {
    $res = mysqli_query($conexion, "SELECT p.*, m.nombre_marca FROM productos p JOIN marcas m ON p.id_marca = m.id_marca WHERE p.id_producto = $id_producto");
    $producto = mysqli_fetch_assoc($res);
}

if (!$producto) {
    header('Location: productos.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compra Rápida - <?php echo $producto['nombre_producto']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Confirmar Compra Rápida</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            <div class="bg-secondary text-white rounded p-4 me-3">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                            <div>
                                <h5 class="mb-1"><?php echo $producto['nombre_producto']; ?></h5>
                                <p class="text-muted mb-0">Marca: <?php echo $producto['nombre_marca']; ?></p>
                                <h4 class="text-primary mt-2">S/ <?php echo number_format($producto['precio'], 2); ?></h4>
                            </div>
                        </div>
                        
                        <form action="api/checkout.php" method="POST" id="quickBuyForm">
                            <input type="hidden" name="direct_buy" value="1">
                            <input type="hidden" name="id_producto" value="<?php echo $id_producto; ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" value="1" min="1" max="<?php echo $producto['stock']; ?>">
                                <small class="text-muted">Stock disponible: <?php echo $producto['stock']; ?></small>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">Finalizar Compra Ahora</button>
                                <a href="productos.php" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
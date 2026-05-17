<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}
include 'conexion.php';

// Obtener categorías para el filtro
$sql_categorias = "SELECT * FROM categorias";
$result_categorias = mysqli_query($conexion, $sql_categorias);

// Obtener marcas para el filtro
$sql_marcas = "SELECT * FROM marcas";
$result_marcas = mysqli_query($conexion, $sql_marcas);

// Construir consulta de productos con filtros
$where = "WHERE 1=1";
if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $cat_id = mysqli_real_escape_string($conexion, $_GET['categoria']);
    $where .= " AND p.id_categoria = '$cat_id'";
}
if (isset($_GET['marca']) && !empty($_GET['marca'])) {
    $marca_id = mysqli_real_escape_string($conexion, $_GET['marca']);
    $where .= " AND p.id_marca = '$marca_id'";
}

$sql_productos = "SELECT p.*, c.nombre_categoria, m.nombre_marca 
                  FROM productos p 
                  LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
                  LEFT JOIN marcas m ON p.id_marca = m.id_marca 
                  $where";
$result_productos = mysqli_query($conexion, $sql_productos);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Productos - Paso Firme</title>
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
            <h2>Inventario de Productos</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductoModal">
                <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
            </button>
        </div>

        <!-- Filtros -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3" method="GET">
                    <div class="col-md-4">
                        <label class="form-label">Categoría</label>
                        <select name="categoria" class="form-select">
                            <option value="">Todas las categorías</option>
                            <?php while($cat = mysqli_fetch_assoc($result_categorias)): ?>
                                <option value="<?php echo $cat['id_categoria']; ?>" <?php echo (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($cat['nombre_categoria']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Marca</label>
                        <select name="marca" class="form-select">
                            <option value="">Todas las marcas</option>
                            <?php while($marca = mysqli_fetch_assoc($result_marcas)): ?>
                                <option value="<?php echo $marca['id_marca']; ?>" <?php echo (isset($_GET['marca']) && $_GET['marca'] == $marca['id_marca']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($marca['nombre_marca']); ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary me-2">Filtrar</button>
                        <a href="productos.php" class="btn btn-outline-secondary">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Productos -->
        <div class="table-responsive bg-white rounded shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result_productos)): ?>
                    <tr>
                        <td><?php echo $row['id_producto']; ?></td>
                        <td><strong><?php echo htmlspecialchars($row['nombre_producto']); ?></strong></td>
                        <td><?php echo htmlspecialchars($row['nombre_categoria']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_marca']); ?></td>
                        <td>S/ <?php echo number_format($row['precio'], 2); ?></td>
                        <td>
                            <span class="badge <?php echo $row['stock'] > 10 ? 'bg-success' : 'bg-danger'; ?>">
                                <?php echo $row['stock']; ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
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
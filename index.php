<?php
require_once 'db.php';

// Obtener categorías
$stmtCategorias = $pdo->query("SELECT * FROM categorias");
$categorias = $stmtCategorias->fetchAll();

// Obtener marcas
$stmtMarcas = $pdo->query("SELECT * FROM marcas");
$marcas = $stmtMarcas->fetchAll();

// Obtener productos
$stmtProductos = $pdo->query("
    SELECT p.*, c.nombre_categoria, m.nombre_marca 
    FROM productos p 
    LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
    LEFT JOIN marcas m ON p.id_marca = m.id_marca
");
$productos = $stmtProductos->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kicks & Co. | Zapatería Premium</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="logo">Kicks<span>&</span>Co.</a>
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#coleccion">Colección</a></li>
                <li><a href="#marcas">Marcas</a></li>
            </ul>
            <div class="nav-actions">
                <button class="cart-btn">
                    <i data-lucide="shopping-bag"></i>
                    <span class="cart-count">0</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero" id="inicio">
        <div class="hero-content">
            <h1 class="hero-title">Eleva tu <span>Estilo</span></h1>
            <p class="hero-subtitle">Descubre la colección más exclusiva de zapatillas y calzado de lujo.</p>
            <a href="#coleccion" class="btn btn-primary">Explorar Colección</a>
        </div>
    </header>

    <!-- Marcas Section -->
    <section class="marcas-banner" id="marcas">
        <div class="marcas-track">
            <?php foreach($marcas as $marca): ?>
                <div class="marca-item"><?= htmlspecialchars($marca['nombre_marca']) ?></div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section" id="coleccion">
        <div class="section-header">
            <h2>Últimos Lanzamientos</h2>
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <?php foreach($categorias as $cat): ?>
                    <button class="filter-btn" data-filter="<?= htmlspecialchars($cat['nombre_categoria']) ?>">
                        <?= htmlspecialchars($cat['nombre_categoria']) ?>
                    </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="products-grid">
            <?php foreach($productos as $producto): ?>
                <div class="product-card" data-category="<?= htmlspecialchars($producto['nombre_categoria']) ?>">
                    <div class="product-img-wrapper">
                        <!-- Placeholder image, ideally from DB, but schema doesn't have image field so we use a fallback -->
                        <div class="placeholder-img">
                            <i data-lucide="image" class="img-icon"></i>
                        </div>
                        <div class="product-badges">
                            <span class="badge">Nuevo</span>
                        </div>
                        <button class="wishlist-btn"><i data-lucide="heart"></i></button>
                    </div>
                    <div class="product-info">
                        <span class="product-brand"><?= htmlspecialchars($producto['nombre_marca']) ?></span>
                        <h3 class="product-name"><?= htmlspecialchars($producto['nombre_producto']) ?></h3>
                        <div class="product-details">
                            <span class="product-price">S/ <?= number_format($producto['precio'], 2) ?></span>
                        </div>
                        <button class="btn btn-add-cart" data-id="<?= $producto['id_producto'] ?>">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-brand">
                <h2>Kicks<span>&</span>Co.</h2>
                <p>La mejor selección de calzado premium en el país.</p>
            </div>
            <div class="footer-links">
                <h3>Enlaces</h3>
                <ul>
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#coleccion">Colección</a></li>
                    <li><a href="#marcas">Marcas</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h3>Contacto</h3>
                <p>adrian@gmail.com</p>
                <p>+51 999 888 777</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> Kicks & Co. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
    <script src="assets/js/app.js"></script>
</body>
</html>

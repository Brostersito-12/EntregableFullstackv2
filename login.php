<?php
session_start();
include 'conexion.php';

if (isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password'];

    // Para este ejemplo, aceptamos cualquier login para recuperar el acceso
    // En producción, aquí iría la validación con la base de datos
    $_SESSION['usuario'] = $usuario;
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Zapatería Paso Firme</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2 class="text-center mb-4">PASO FIRME</h2>
        <p class="text-center text-muted mb-4">Ingresa tus credenciales</p>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" name="usuario" class="form-select" value="Adrian" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" value="123456" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2">Entrar al Sistema</button>
        </form>
    </div>
</body>
</html>
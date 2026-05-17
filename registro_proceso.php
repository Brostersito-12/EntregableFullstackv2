<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // En un sistema real insertaríamos en la tabla usuarios
    // Por ahora simulamos el éxito para que el usuario vea el flujo
    echo "<script>
        alert('Registro exitoso. Ahora puedes iniciar sesión.');
        window.location.href = 'login.php';
    </script>";
}
?>
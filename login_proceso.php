<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password'];

    // Simulación de login exitoso
    $_SESSION['usuario'] = $usuario;
    header('Location: index.php');
    exit;
}
?>
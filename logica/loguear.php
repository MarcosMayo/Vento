<?php
require 'conexion.php';
session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

// Consulta para obtener datos del usuario con su rol
$q = "SELECT u.*, r.nombre AS nombre_rol 
      FROM usuarios u 
      INNER JOIN roles r ON u.id_rol = r.id_rol
      WHERE u.nombre = '$usuario'";

$consulta = mysqli_query($conexion, $q);
$array = mysqli_fetch_array($consulta);

// Verificar si el usuario existe
if ($array) {
    if (password_verify($clave, $array['contraseña'])) {
        $_SESSION['id_usuario'] = $array['id_usu'];
        $_SESSION['usuario'] = $array['nombre']; // Nombre de usuario
        $_SESSION['rol'] = $array['nombre_rol']; // Rol del usuario

        header("Location: ../vistas/index.php");
        exit;
    } else {
        $_SESSION['error_login'] = 'Contraseña incorrecta';
        header("Location: ../vistas/login.php");
        exit;
    }
} else {
    $_SESSION['error_login'] = 'Usuario no encontrado';
    header("Location: ../vistas/login.php");
    exit;
}

<?php

require 'conexion.php';

session_start();

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

// Consulta para obtener el hash de la contraseña almacenado en la base de datos
$q = "SELECT * FROM usuarios WHERE nombre = '$usuario'";

$consulta = mysqli_query($conexion, $q);
$array =  mysqli_fetch_array($consulta);

// Verificar si el usuario existe
if ($array) {
    // Verificar si la contraseña ingresada coincide con el hash almacenado
    if (password_verify($clave, $array['contraseña'])) {
        $_SESSION['logueado'] = $usuario;
        $_SESSION['logueadoc'] = $clave;
        header("location: ../vistas/index.php");
    } else {
        echo "Contraseña incorrecta.";
        header("location: ../vistas/login.php");
    }
} else {
    echo "Usuario no encontrado.";
    header("location: ../vistas/login.php");
}
?>

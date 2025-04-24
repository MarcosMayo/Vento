<?php

require 'conexion.php';

session_start();


$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$q = "SELECT COUNT(*) as contar from usuarios where nombre= '$usuario' and contraseña = '$clave'";

$consulta = mysqli_query($conexion, $q);
$array =  mysqli_fetch_array($consulta);

if($array['contar'] > 0)
{
    $_SESSION['logueado'] = $usuario;
    $_SESSION['logueadoc'] = $clave;
    
    header("location: ../vistas/index.php ");
    
} else{

    echo "datos incorrectos";

  
    header("location: ../vistas/login.php");
}

?>
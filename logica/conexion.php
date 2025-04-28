<?php
$host = "localhost";
$usuario = "root";
$clave = "123456789";
$bd = "vento";


$conexion = mysqli_connect($host,$usuario,$clave,$bd);
if($conexion){

//echo "CONEXION EXITOSA";
}else{

    echo "nose pudo conectar";
}
?>
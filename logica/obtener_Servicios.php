<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$term = isset($_GET['term']) ? $conexion->real_escape_string($_GET['term']) : '';
$datos = [];

if ($term !== '') {
    $sql = "SELECT id_servicio, nombre_servicio, mano_obra 
            FROM servicios 
            WHERE nombre_servicio LIKE '%$term%' 
            ORDER BY nombre_servicio LIMIT 10";
    $resultado = $conexion->query($sql);

    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
}

echo json_encode($datos);
?>

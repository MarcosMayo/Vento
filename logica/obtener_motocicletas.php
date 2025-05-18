<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$term = isset($_GET['term']) ? $conexion->real_escape_string($_GET['term']) : '';
$datos = [];

if ($term !== '') {
    $sql = "SELECT id_motocicleta, marca, modelo, anio 
            FROM motocicletas 
            WHERE marca LIKE '%$term%' OR modelo LIKE '%$term%' OR anio LIKE '%$term%' 
            ORDER BY marca LIMIT 10";
    $resultado = $conexion->query($sql);

    while ($fila = $resultado->fetch_assoc()) {
        $datos[] = $fila;
    }
}

echo json_encode($datos);
?>
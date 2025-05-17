<?php
include("conexion.php");

$q = isset($_GET['q']) ? $conexion->real_escape_string($_GET['q']) : '';

$sql = "SELECT id_servicio, nombre_servicio, precio FROM servicios 
        WHERE nombre_servicio LIKE '%$q%' OR descripcion LIKE '%$q%' 
        ORDER BY nombre_servicio ASC 
        LIMIT 20";

$result = $conexion->query($sql);

$servicios = [];

while ($row = $result->fetch_assoc()) {
    $servicios[] = [
        'id' => $row['id_servicio'],
        'nombre' => $row['nombre_servicio'],
        'precio' => $row['precio']
    ];
}

header('Content-Type: application/json');
echo json_encode($servicios);

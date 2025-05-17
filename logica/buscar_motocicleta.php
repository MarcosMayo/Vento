<?php
include("conexion.php"); // ajusta si tu ruta es diferente

$q = isset($_GET['q']) ? $conexion->real_escape_string($_GET['q']) : '';

$sql = "SELECT id_motocicleta, modelo, numero_serie FROM motocicletas 
        WHERE modelo LIKE '%$q%' OR numero_serie LIKE '%$q%' 
        ORDER BY modelo ASC 
        LIMIT 20";

$result = $conexion->query($sql);

$motocicletas = [];

while ($row = $result->fetch_assoc()) {
    $motocicletas[] = [
        'id' => $row['id_motocicleta'],
        'modelo' => $row['modelo'],
        'numero_serie' => $row['numero_serie']
    ];
}

header('Content-Type: application/json');
echo json_encode($motocicletas);

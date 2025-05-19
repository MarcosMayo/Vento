<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$term = $conexion->real_escape_string($_GET['term'] ?? '');

if (strlen($term) < 2) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id_refaccion, nombre_refaccion, precio 
        FROM refacciones 
        WHERE nombre_refaccion LIKE '%$term%' 
        LIMIT 10";

$resultado = $conexion->query($sql);
$refacciones = [];

while ($row = $resultado->fetch_assoc()) {
    $refacciones[] = [
        'id_refaccion' => $row['id_refaccion'],
        'nombre_refaccion' => $row['nombre_refaccion'],
        'precio' => $row['precio']
    ];
}

echo json_encode($refacciones);
?>

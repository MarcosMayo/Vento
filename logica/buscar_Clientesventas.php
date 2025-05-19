<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$term = $conexion->real_escape_string($_GET['term'] ?? '');

if (strlen($term) < 2) {
    echo json_encode([]);
    exit;
}

$sql = "SELECT id_cliente, CONCAT(nombre, ' ', apellido_paterno) AS nombre_completo
        FROM clientes
        WHERE nombre LIKE '%$term%' OR apellido_paterno LIKE '%$term%'
        LIMIT 10";

$resultado = $conexion->query($sql);
$clientes = [];

while ($row = $resultado->fetch_assoc()) {
    $clientes[] = [
        'id_cliente' => $row['id_cliente'],
        'nombre_completo' => $row['nombre_completo']
    ];
}

echo json_encode($clientes);
?>

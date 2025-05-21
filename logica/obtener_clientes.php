<?php
include("conexion.php");

$term = $conexion->real_escape_string($_GET['term'] ?? '');
if (strlen($term) < 2) {
    echo json_encode([]); // No devuelve resultados si no hay término
    exit;
}

$query = "SELECT id_cliente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo
          FROM clientes
          WHERE CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) LIKE '%$term%' 
          LIMIT 20";

$res = $conexion->query($query);
$resultados = [];

while ($row = $res->fetch_assoc()) {
    $resultados[] = $row;
}

echo json_encode($resultados);

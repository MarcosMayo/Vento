<?php
include("conexion.php");

$q = $conexion->real_escape_string($_GET['q'] ?? '');

$resultado = $conexion->query("SELECT id_refaccion AS id, nombre_refaccion AS nombre, precio FROM refacciones WHERE nombre_refaccion LIKE '%$q%' LIMIT 10");

$datos = [];
while ($row = $resultado->fetch_assoc()) {
    $datos[] = [
  'id' => $row['id'],
  'nombre' => $row['nombre'],
  'precio' => $row['precio']
];

}

header('Content-Type: application/json');
echo json_encode($datos);
?>

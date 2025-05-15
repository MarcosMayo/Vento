<?php

header('Content-Type: application/json');

// Activar errores temporalmente para debug
ini_set('display_errors', 1);
error_reporting(E_ALL);


include("conexion.php");

// Verifica si se recibió el ID correctamente
if (!isset($_GET['id'])) {
    echo json_encode(['error' => 'ID no proporcionado']);
    exit;
}

$id = intval($_GET['id']);

// Verifica si el servicio existe
$servicioQuery = $conexion->query("SELECT * FROM servicios WHERE id_servicio = $id");
if (!$servicioQuery || $servicioQuery->num_rows === 0) {
    echo json_encode(['error' => 'Servicio no encontrado']);
    exit;
}

$servicio = $servicioQuery->fetch_assoc();

$refacciones = [];
$result = $conexion->query("
    SELECT r.nombre_refaccion, ds.cantidad, r.precio, (ds.cantidad * r.precio) AS subtotal
    FROM detalle_servicio ds
    JOIN refacciones r ON r.id_refaccion = ds.id_refaccion
    WHERE ds.id_servicio = $id
");

if (!$result) {
    echo json_encode(['error' => 'Error en la consulta de refacciones: ' . $conexion->error]);
    exit;
}

while ($row = $result->fetch_assoc()) {
    $refacciones[] = $row;
}

while ($row = $result->fetch_assoc()) {
    $refacciones[] = $row;
}

echo json_encode([
    'servicio' => $servicio,
    'refacciones' => $refacciones
]);

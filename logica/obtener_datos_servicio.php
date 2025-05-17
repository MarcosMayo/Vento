<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    echo json_encode(['error' => 'ID inválido']);
    exit;
}

// Obtener datos del servicio principal
$sqlServicio = "SELECT precio FROM servicios WHERE id_servicio = $id LIMIT 1";
$resServicio = $conexion->query($sqlServicio);

if (!$resServicio || $resServicio->num_rows === 0) {
    echo json_encode(['error' => 'Servicio no encontrado']);
    exit;
}

$servicio = $resServicio->fetch_assoc();

// Obtener refacciones asociadas
$sqlRefacciones = "SELECT r.nombre_refaccion, ds.cantidad, r.precio
                   FROM detalle_servicio ds
                   JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
                   WHERE ds.id_servicio = $id";


$resRefacciones = $conexion->query($sqlRefacciones);

$refacciones = [];
if (!$resRefacciones) {
    die("Error en la consulta de refacciones: " . $conexion->error);
}


while ($row = $resRefacciones->fetch_assoc()) {
    $refacciones[] = [
        'nombre' => $row['nombre_refaccion'],
        'cantidad' => (int)$row['cantidad'],
        'precio_unitario' => (float)$row['precio']
    ];
}

// Respuesta final
echo json_encode([
    'precio' => (float)$servicio['precio'],
    'refacciones' => $refacciones
]);

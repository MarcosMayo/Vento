<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include("../logica/conexion.php");

if (!isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'mensaje' => 'ID no proporcionado']);
    exit;
}

$id_servicio = intval($_GET['id']);

$stmt = $conexion->prepare("SELECT id_servicio, nombre_servicio, descripcion, precio FROM servicios WHERE id_servicio = ?");
$stmt->bind_param("i", $id_servicio);
$stmt->execute();
$result = $stmt->get_result();
$servicio = $result->fetch_assoc();

if (!$servicio) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Servicio no encontrado']);
    exit;
}

// Obtener refacciones asociadas
$refacciones = [];
$sql_ref = "SELECT ds.id_refaccion, r.nombre_refaccion, r.precio, ds.cantidad 
            FROM detalle_servicio ds
            JOIN refacciones r ON r.id_refaccion = ds.id_refaccion
            WHERE ds.id_servicio = ?";
$stmt2 = $conexion->prepare($sql_ref);
$stmt2->bind_param("i", $id_servicio);
$stmt2->execute();
$result2 = $stmt2->get_result();
while ($row = $result2->fetch_assoc()) {
    $refacciones[] = $row;
}

echo json_encode([
    'status' => 'ok',
    'servicio' => $servicio,
    'refacciones' => $refacciones
]);

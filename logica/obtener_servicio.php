<?php
include("conexion.php");

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
    exit;
}

$id = intval($_GET['id']);

// Obtener datos del servicio
$sql = "SELECT id_servicio, nombre_servicio, descripcion, mano_obra FROM servicios WHERE id_servicio = $id";
$result = $conexion->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Servicio no encontrado']);
    exit;
}

$servicio = $result->fetch_assoc();

// Obtener refacciones asociadas
$refSql = "SELECT r.id_refaccion, r.nombre_refaccion, r.precio, ds.cantidad
           FROM detalle_servicio ds
           JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
           WHERE ds.id_servicio = $id";
$refResult = $conexion->query($refSql);

$refacciones = [];
while ($ref = $refResult->fetch_assoc()) {
    $refacciones[] = $ref;
}

$servicio['refacciones'] = $refacciones;
echo json_encode(['success' => true, 'servicio' => $servicio]);
?>

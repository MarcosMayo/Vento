<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$id_orden = intval($_GET['id_orden'] ?? 0);
if ($id_orden <= 0) {
    echo json_encode(['refacciones' => [], 'mano_obra' => 0]);
    exit;
}

// Obtener refacciones
$sqlRef = "SELECT r.nombre_refaccion AS nombre, r.precio, do.cantidad
           FROM detalle_orden do
           JOIN refacciones r ON do.id_refaccion = r.id_refaccion
           WHERE do.id_orden = $id_orden";
$resRef = $conexion->query($sqlRef);
$refacciones = [];

while ($row = $resRef->fetch_assoc()) {
    $refacciones[] = $row;
}

// Obtener mano de obra desde la orden
$sqlMO = "SELECT s.mano_obra
          FROM orden_trabajo ot
          JOIN servicios s ON ot.id_servicio = s.id_servicio
          WHERE ot.id_orden = $id_orden
          LIMIT 1";
$resMO = $conexion->query($sqlMO);
$mano_obra = 0;
if ($fila = $resMO->fetch_assoc()) {
    $mano_obra = floatval($fila['mano_obra']);
}

echo json_encode([
    'refacciones' => $refacciones,
    'mano_obra' => $mano_obra
]);
?>

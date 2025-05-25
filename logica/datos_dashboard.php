<?php
include("conexion.php");

header('Content-Type: application/json');

// Conteo de órdenes pendientes
$sqlOrdenes = "SELECT COUNT(*) AS pendientes FROM orden_trabajo WHERE estatus = 1";
$resOrdenes = $conexion->query($sqlOrdenes);
$ordenes = $resOrdenes ? $resOrdenes->fetch_assoc()['pendientes'] : 0;

// Refacciones con bajo stock (≤ 20)
$sqlStock = "SELECT nombre_refaccion, stock FROM refacciones WHERE stock <= 20 ORDER BY stock ASC";
$resStock = $conexion->query($sqlStock);

$refacciones_bajas = [];
if ($resStock) {
    while ($row = $resStock->fetch_assoc()) {
        $refacciones_bajas[] = [
            'nombre' => $row['nombre_refaccion'],
            'stock' => $row['stock']
        ];
    }
}

// Respuesta JSON
echo json_encode([
    'ordenes_pendientes' => intval($ordenes),
    'stock_bajo' => count($refacciones_bajas),
    'refacciones_bajas' => $refacciones_bajas
]);

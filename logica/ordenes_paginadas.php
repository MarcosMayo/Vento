<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$search = $conexion->real_escape_string($_GET['search'] ?? '');
$estatus = intval($_GET['estatus'] ?? 0);
$desde = $conexion->real_escape_string($_GET['desde'] ?? '');
$hasta = $conexion->real_escape_string($_GET['hasta'] ?? '');

$offset = ($page - 1) * $limit;

$whereParts = [];
if ($search !== '') {
    $whereParts[] = "(c.nombre LIKE '%$search%' OR c.apellido_paterno LIKE '%$search%' 
                      OR m.marca LIKE '%$search%' OR m.modelo LIKE '%$search%'
                      OR s.nombre_servicio LIKE '%$search%')";
}
if ($estatus > 0) {
    $whereParts[] = "eo.id_estado = $estatus";
}
if ($desde !== '') {
    $whereParts[] = "ot.fecha_servicio >= '$desde'";
}
if ($hasta !== '') {
    $whereParts[] = "ot.fecha_servicio <= '$hasta'";
}

$where = count($whereParts) > 0 ? "WHERE " . implode(" AND ", $whereParts) : "";

// Total
$totalSQL = "SELECT COUNT(*) as total
             FROM orden_trabajo ot
             JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
             JOIN clientes c ON m.id_cliente = c.id_cliente
             JOIN servicios s ON ot.id_servicio = s.id_servicio
             JOIN estado_orden eo ON ot.estatus = eo.id_estado
             $where";
$totalResult = $conexion->query($totalSQL);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Consulta
$sql = "SELECT ot.id_orden, c.nombre, c.apellido_paterno, m.marca, m.modelo, 
               s.nombre_servicio, ot.fecha_servicio, ot.costo_total, eo.estatus
        FROM orden_trabajo ot
        JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        JOIN clientes c ON m.id_cliente = c.id_cliente
        JOIN servicios s ON ot.id_servicio = s.id_servicio
        JOIN estado_orden eo ON ot.estatus = eo.id_estado
        $where
        ORDER BY ot.fecha_servicio DESC
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);
$ordenes = [];

while ($row = $result->fetch_assoc()) {
    $ordenes[] = $row;
}

echo json_encode([
    'ordenes' => $ordenes,
    'totalPages' => $totalPages
]);
?>

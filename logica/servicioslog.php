<?php
include("../logica/conexion.php");

header('Content-Type: application/json');

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

// Filtro por búsqueda
$where = $search ? "WHERE s.nombre_servicio LIKE '%$search%' OR s.descripcion LIKE '%$search%'" : '';

// Obtener total
$totalSql = "SELECT COUNT(*) as total FROM servicios s $where";
$totalResult = $conexion->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Consulta principal con LIMIT
$sql = "SELECT s.id_servicio, s.nombre_servicio, s.descripcion, s.precio
        FROM servicios s
        $where
        ORDER BY s.id_servicio DESC
        LIMIT $offset, $limit";
$result = $conexion->query($sql);

$servicios = [];

while ($row = $result->fetch_assoc()) {
    $id_servicio = $row['id_servicio'];

    // Obtener refacciones del servicio
    $refSql = "SELECT r.nombre_refaccion, ds.cantidad
               FROM detalle_servicio ds
               JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
               WHERE ds.id_servicio = $id_servicio";
    $refResult = $conexion->query($refSql);

    $refacciones = [];
    while ($ref = $refResult->fetch_assoc()) {
        $refacciones[] = $ref['nombre_refaccion'] . ' x' . $ref['cantidad'];
    }

    $row['refacciones'] = implode(', ', $refacciones);
    $servicios[] = $row;
}

echo json_encode([
    'servicios' => $servicios,
    'totalPages' => $totalPages
]);
?>

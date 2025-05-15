<?php
include("../logica/conexion.php");

$page = intval($_GET['page'] ?? 1);
$limit = intval($_GET['limit'] ?? 5);
$search = $conexion->real_escape_string($_GET['search'] ?? '');

$offset = ($page - 1) * $limit;

// Consulta con refacciones concatenadas
$sql = "
    SELECT s.id_servicio, s.nombre_servicio , s.descripcion, s.precio AS total,
        GROUP_CONCAT(r.nombre_refaccion SEPARATOR ', ') AS refacciones
    FROM servicios s
    LEFT JOIN detalle_servicio ds ON s.id_servicio = ds.id_servicio
    LEFT JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
    WHERE s.nombre_servicio LIKE '%$search%' OR s.descripcion LIKE '%$search%'
    GROUP BY s.id_servicio
    ORDER BY s.id_servicio DESC
    LIMIT $limit OFFSET $offset
";

$result = $conexion->query($sql);
$servicios = [];

while ($row = $result->fetch_assoc()) {
    $servicios[] = $row;
}

// Total para paginación
$totalResult = $conexion->query("
    SELECT COUNT(DISTINCT s.id_servicio) AS total
    FROM servicios s
    WHERE s.nombre_servicio LIKE '%$search%' OR s.descripcion LIKE '%$search%'
");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

echo json_encode([
    'servicios' => $servicios,
    'totalPages' => $totalPages
]);
?>

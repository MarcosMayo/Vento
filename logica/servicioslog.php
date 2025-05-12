<?php
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

$offset = ($page - 1) * $limit;

// Contar total
$sqlTotal = "SELECT COUNT(*) AS total FROM servicios WHERE nombre_servicio LIKE '%$search%'";
$resultTotal = $conexion->query($sqlTotal);
$totalRows = $resultTotal->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Obtener datos paginados
$sql = "SELECT id_servicio, nombre_servicio, descripcion, precio AS total
        FROM servicios
        WHERE nombre_servicio LIKE '%$search%'
        ORDER BY id_servicio DESC
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);

$servicios = [];
while ($row = $result->fetch_assoc()) {
    $servicios[] = $row;
}

echo json_encode([
    "servicios" => $servicios,
    "totalPages" => $totalPages
]);
?>

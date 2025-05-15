<?php
include("conexion.php");

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$search = $conexion->real_escape_string($_GET['search'] ?? '');

$offset = ($page - 1) * $limit;

$sqlTotal = "SELECT COUNT(*) AS total FROM refacciones WHERE nombre_refaccion LIKE '%$search%'";
$totalResult = $conexion->query($sqlTotal);
$totalRows = $totalResult->fetch_assoc()['total'];

$sql = "SELECT * FROM refacciones WHERE nombre_refaccion LIKE '%$search%' LIMIT $offset, $limit";
$result = $conexion->query($sql);

$refacciones = [];
while ($row = $result->fetch_assoc()) {
    $refacciones[] = $row;
}

echo json_encode([
    'refacciones' => $refacciones,
    'totalPages' => ceil($totalRows / $limit)
]);
?>

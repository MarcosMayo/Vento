<?php
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

$offset = ($page - 1) * $limit;

$where = $search ? "WHERE clientes.nombre LIKE '%$search%' OR clientes.apellido_paterno LIKE '%$search%' OR clientes.apellido_materno LIKE '%$search%'" : "";

$totalSql = "SELECT COUNT(*) as total FROM clientes $where";
$totalResult = $conexion->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT clientes.id_cliente, clientes.folio, clientes.nombre, clientes.apellido_paterno AS apellido_p, clientes.apellido_materno AS apellido_m, clientes.telefono, clientes.correo AS email, clientes.direccion
        FROM clientes
        $where
        ORDER BY clientes.id_cliente DESC
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

echo json_encode([
    'clientes' => $clientes,
    'totalPages' => $totalPages
]);
?>

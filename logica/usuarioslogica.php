<?php
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

$offset = ($page - 1) * $limit;

$where = $search ? "WHERE usuarios.nombre LIKE '%$search%'" : "";

$totalSql = "SELECT COUNT(*) as total FROM usuarios $where";
$totalResult = $conexion->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

$sql = "SELECT usuarios.id_usu, usuarios.nombre, usuarios.contraseña, roles.nombre AS nombre_rol 
        FROM usuarios 
        JOIN roles ON usuarios.id_rol = roles.id_rol 
        $where 
        ORDER BY usuarios.id_usu DESC 
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);

$usuarios = [];
while ($row = $result->fetch_assoc()) {
    $usuarios[] = $row;
}

echo json_encode([
    'usuarios' => $usuarios,
    'totalPages' => $totalPages
]);
?>

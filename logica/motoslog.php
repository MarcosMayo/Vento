<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

$offset = ($page - 1) * $limit;

$where = $search ? "WHERE motocicletas.marca LIKE '%$search%' OR motocicletas.modelo LIKE '%$search%' OR clientes.nombre LIKE '%$search%'" : "";

// Total de registros
$totalSql = "SELECT COUNT(*) as total 
             FROM motocicletas 
             JOIN clientes ON motocicletas.id_cliente = clientes.id_cliente 
             $where";
$totalResult = $conexion->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Consulta paginada
$sql = "SELECT motocicletas.id_motocicleta, motocicletas.marca, motocicletas.modelo, motocicletas.anio, 
               motocicletas.numero_serie, motocicletas.fecha_registro, clientes.nombre AS cliente 
        FROM motocicletas 
        JOIN clientes ON motocicletas.id_cliente = clientes.id_cliente 
        $where 
        ORDER BY motocicletas.id_motocicleta DESC 
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);
if (!$result) {
    die("Error en la consulta SQL: " . $conexion->error);
}

$motos = [];
while ($row = $result->fetch_assoc()) {
    $row['fecha_registro'] = date('Y-m-d', strtotime($row['fecha_registro']));
    $motos[] = $row;
}

echo json_encode([
    'motos' => $motos,
    'totalPages' => $totalPages
]);

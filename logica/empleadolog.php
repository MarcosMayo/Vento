<?php
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
$search = isset($_GET['search']) ? $conexion->real_escape_string($_GET['search']) : '';

$offset = ($page - 1) * $limit;

$where = $search ? "WHERE empleados.nombre LIKE '%$search%' OR empleados.apellido_paterno LIKE '%$search%' OR empleados.apellido_materno LIKE '%$search%'" : "";

// Obtener total de registros
$totalSql = "SELECT COUNT(*) as total FROM empleados $where";
$totalResult = $conexion->query($totalSql);
$totalRow = $totalResult->fetch_assoc();
$total = $totalRow['total'];
$totalPages = ceil($total / $limit);

// Obtener empleados con puesto
$sql = "SELECT empleados.id_empleado,empleados.nombre, empleados.apellido_paterno AS apellido_p, empleados.apellido_materno AS apellido_m, empleados.telefono, empleados.correo AS email, empleados.direccion, empleados.id_puesto, puestos.nombre AS puesto
        FROM empleados
        LEFT JOIN puestos ON empleados.id_puesto = puestos.id_puesto
        $where
        ORDER BY empleados.id_empleado DESC
        LIMIT $limit OFFSET $offset";

$result = $conexion->query($sql);

$empleados = [];
while ($row = $result->fetch_assoc()) {
    $empleados[] = $row;
}

echo json_encode([
    'empleados' => $empleados,
    'totalPages' => $totalPages
]);
?>

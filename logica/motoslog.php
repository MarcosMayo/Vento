<?php
include("conexion.php");

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 5;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

$offset = ($page - 1) * $limit;

$where = "";
$params = [];

if (!empty($search)) {
    $where = "WHERE marca LIKE ? OR modelo LIKE ?";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Obtener total
$totalQuery = "SELECT COUNT(*) AS total FROM motocicletas $where";
$stmt = $conn->prepare($totalQuery);
if ($params) $stmt->bind_param(str_repeat('s', count($params)), ...$params);
$stmt->execute();
$result = $stmt->get_result();
$total = $result->fetch_assoc()['total'];
$totalPages = ceil($total / $limit);

// Obtener registros paginados
$sql = "SELECT * FROM motocicletas $where  LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$bindTypes = str_repeat('s', count($params)) . "ii";
$params[] = $limit;
$params[] = $offset;
$stmt->bind_param($bindTypes, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$motocicletas = [];
while ($row = $result->fetch_assoc()) {
    $motocicletas[] = $row;
}

echo json_encode([
    'motocicletas' => $motocicletas,
    'totalPages' => $totalPages
]);
?>

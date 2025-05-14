<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
include("../logica/conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'mensaje' => 'Método no permitido']);
    exit;
}

$id = intval($_POST['id_refaccion'] ?? 0);
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre_refaccion'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

if ($id <= 0 || empty($nombre) || $precio <= 0 || $stock < 0) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'mensaje' => 'Datos inválidos']);
    exit;
}

$query = "UPDATE refacciones SET nombre_refaccion = ?, precio = ?, stock = ? WHERE id_refaccion = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "sdii", $nombre, $precio, $stock, $id);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(['status' => 'ok', 'mensaje' => 'Refacción actualizada correctamente']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al actualizar', 'detalle' => mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>
    
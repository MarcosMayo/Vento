<?php
include("../logica/conexion.php");

if ($conexion->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]));
}

// Validar y escapar datos
$nombre = $conexion->real_escape_string($_POST['nombre_refaccion'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? 0);

// Validación básica
if (empty($nombre) || $precio <= 0 || $stock < 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

$sql = "INSERT INTO refacciones (nombre_refaccion, precio, stock) VALUES ('$nombre', $precio, $stock)";
if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Refacción guardada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar: ' . $conexion->error]);
}
?>

<?php
include("../logica/conexion.php");

if ($conexion->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]));
}

// Recibir y validar datos
$id = intval($_POST['id_refaccion'] ?? 0);
$nombre = $conexion->real_escape_string($_POST['nombre'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? -1);

// Validaciones básicas
if ($id <= 0 || empty($nombre) || $precio <= 0 || $stock < 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// Preparar la consulta de actualización
$sql = "UPDATE refacciones SET 
            nombre_refaccion = '$nombre', 
            precio = $precio, 
            stock = $stock 
        WHERE id_refaccion = $id";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Refacción actualizada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar: ' . $conexion->error]);
}

?>

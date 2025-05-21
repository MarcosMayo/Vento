<?php
include("../logica/conexion.php");

if ($conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión']);
    exit;
}

// Validar datos recibidos
$id_orden = intval($_POST['id_orden'] ?? 0);
$nuevo_estatus = intval($_POST['nuevo_estatus'] ?? 0);

if ($id_orden <= 0 || !in_array($nuevo_estatus, [1, 2, 3])) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// Actualizar estatus
$sql = "UPDATE orden_trabajo SET estatus = $nuevo_estatus WHERE id_orden = $id_orden";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar: ' . $conexion->error
    ]);
}

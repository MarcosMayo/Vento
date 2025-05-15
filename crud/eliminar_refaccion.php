<?php
include("../logica/conexion.php");

if ($conexion->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Error de conexión: ' . $conexion->connect_error]));
}

$id = intval($_POST['id_refaccion'] ?? 0);

if ($id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID inválido']);
    exit;
}

$sql = "DELETE FROM refacciones WHERE id_refaccion = $id";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Refacción eliminada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar: ' . $conexion->error]);
}
?>

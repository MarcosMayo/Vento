<?php
// Conexión a la base de datos
include("../logica/conexion.php");

// Validar ID recibido por POST
$id = $conexion->real_escape_string($_POST['id'] ?? '');

if (empty($id)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'ID no proporcionado']);
    exit;
}

// Ejecutar la eliminación
$sql = "DELETE FROM empleados WHERE id_empleado = '$id'";

if ($conexion->query($sql)) {
    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al eliminar']);
}
?>

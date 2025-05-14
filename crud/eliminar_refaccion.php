<?php
include("../logica/conexion.php");

header('Content-Type: application/json');
// Configuración de headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

// Validar que sea una solicitud GET y que tenga ID
if ($_SERVER['REQUEST_METHOD'] !== 'GET' || !isset($_GET['id'])) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Solicitud inválida']);
    exit;
}

$id = intval($_GET['id']);

if ($id <= 0) {
    echo json_encode(['status' => 'error', 'mensaje' => 'ID inválido']);
    exit;
}

// Verificar si la refacción existe
$query = "SELECT id_refaccion FROM refacciones WHERE id_refaccion = ?";
$stmt = mysqli_prepare($conexion, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) === 0) {
    echo json_encode(['status' => 'error', 'mensaje' => 'La refacción no existe']);
    mysqli_stmt_close($stmt);
    exit;
}
mysqli_stmt_close($stmt);

// Eliminar refacción
$query = "DELETE FROM refacciones WHERE id_refaccion = ?";
$stmt = mysqli_prepare($conexion, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            'status' => 'ok',
            'mensaje' => 'Refacción eliminada correctamente'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'mensaje' => 'Error al eliminar la refacción: ' . mysqli_error($conexion)
        ]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error al preparar la consulta: ' . mysqli_error($conexion)
    ]);
}

mysqli_close($conexion);
?>
<?php
// Configuración de headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
include("../logica/conexion.php");

// Verificar conexión a BD
if (!$conexion) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error de conexión a la base de datos',
        'detalle' => mysqli_connect_error()
    ]);
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'status' => 'error', 
        'mensaje' => 'Método no permitido'
    ]);
    exit;
}

// Obtener datos
$nombre = mysqli_real_escape_string($conexion, $_POST['nombre_refaccion'] ?? '');
$precio = floatval($_POST['precio'] ?? 0);
$stock = intval($_POST['stock'] ?? -1); // -1 para detectar si no se envió o si es inválido

// Validaciones
$errores = [];
if (empty($nombre)) $errores[] = 'El nombre es requerido';
if ($precio <= 0) $errores[] = 'El precio debe ser mayor a 0';
if ($stock < 0) $errores[] = 'El stock debe ser un número entero mayor o igual a 0';

if (!empty($errores)) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error de validación',
        'errores' => $errores
    ]);
    exit;
}

// Insertar en BD
$query = "INSERT INTO refacciones (nombre_refaccion, precio, stock) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conexion, $query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error al preparar la consulta',
        'detalle' => mysqli_error($conexion)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sdi", $nombre, $precio, $stock);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        'status' => 'ok',
        'mensaje' => 'Refacción registrada correctamente',
        'id' => mysqli_insert_id($conexion)
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error al guardar la refacción',
        'detalle' => mysqli_stmt_error($stmt)
    ]);
}

mysqli_stmt_close($stmt);
mysqli_close($conexion);
?>

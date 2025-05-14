<?php
include("../logica/conexion.php");

$data = json_decode(file_get_contents("php://input"), true);

$nombre = $conexion->real_escape_string($data['nombre_servicio'] ?? '');
$descripcion = $conexion->real_escape_string($data['descripcion'] ?? '');
$precio = floatval($data['precio'] ?? 0);

if ($nombre === '' || $descripcion === '' || $precio <= 0) {
    echo json_encode(["status" => "error", "mensaje" => "Datos inválidos"]);
    exit;
}

$sql = "INSERT INTO servicios (nombre_servicio, descripcion, precio) 
        VALUES ('$nombre', '$descripcion', $precio)";

if ($conexion->query($sql)) {
    echo json_encode(["status" => "ok", "mensaje" => "Servicio guardado exitosamente"]);
} else {
    echo json_encode(["status" => "error", "mensaje" => "Error al guardar: " . $conexion->error]);
}
?>

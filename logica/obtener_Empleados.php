<?php
include("conexion.php");
header('Content-Type: application/json');

$sql = "SELECT id_empleado, nombre, apellido_paterno FROM empleados ORDER BY nombre";
$resultado = $conexion->query($sql);

$datos = [];
while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}

echo json_encode($datos);
?>
<?php
include("conexion.php");

$termino = $conexion->real_escape_string($_GET['q'] ?? '');

$sql = "SELECT id_empleado, nombre, apellido_paterno, apellido_materno 
        FROM empleados 
        WHERE nombre LIKE '%$termino%' 
           OR apellido_paterno LIKE '%$termino%' 
           OR apellido_materno LIKE '%$termino%' 
        LIMIT 10";

$result = $conexion->query($sql);

$empleados = [];

while ($row = $result->fetch_assoc()) {
    $empleados[] = [
        'id' => $row['id_empleado'],
        'nombre' => $row['nombre'] . ' ' . $row['apellido_paterno'] . ' ' . $row['apellido_materno']
    ];
}

header('Content-Type: application/json');
echo json_encode($empleados);
?>


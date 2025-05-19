<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

$sql = "SELECT ot.id_orden, c.nombre, c.apellido_paterno, m.marca, m.modelo
        FROM orden_trabajo ot
        JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
        JOIN clientes c ON m.id_cliente = c.id_cliente
        WHERE ot.estatus = 1
        ORDER BY ot.fecha_servicio DESC";

$result = $conexion->query($sql);
$ordenes = [];

while ($row = $result->fetch_assoc()) {
    $ordenes[] = [
        'id_orden' => $row['id_orden'],
        'cliente' => $row['nombre'] . ' ' . $row['apellido_paterno'],
        'marca' => $row['marca'],
        'modelo' => $row['modelo']
    ];
}

echo json_encode($ordenes);
?>

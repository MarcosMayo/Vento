<?php
include("../logica/conexion.php");

$nombre = $_GET['nombre'] ?? '';
$nombre = "%$nombre%";

$stmt = $conn->prepare("SELECT id, nombre, apellido_paterno, apellido_materno, telefono FROM clientes WHERE nombre LIKE ? OR apellido_paterno LIKE ? OR apellido_materno LIKE ?");
$stmt->bind_param("sss", $nombre, $nombre, $nombre);
$stmt->execute();
$result = $stmt->get_result();

$clientes = [];
while ($row = $result->fetch_assoc()) {
    $clientes[] = $row;
}

echo json_encode($clientes);
?>

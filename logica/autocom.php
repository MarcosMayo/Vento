<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conexion.php';

$term = $_GET['term'] ?? '';

$sql = "SELECT id_cliente, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo
        FROM clientes
        WHERE nombre LIKE ? OR apellido_paterno LIKE ? OR apellido_materno LIKE ?
        LIMIT 10";

$stmt = $conexion->prepare($sql);
$likeTerm = "%$term%";
$stmt->bind_param("sss", $likeTerm, $likeTerm, $likeTerm);
$stmt->execute();

$result = $stmt->get_result();
$representantes = [];

while ($row = $result->fetch_assoc()) {
    $representantes[] = $row;
}

echo json_encode($representantes);
?>
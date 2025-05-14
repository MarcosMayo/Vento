<?php
include("../logica/conexion.php");

$query = $_GET['query'] ?? '';
$query = mysqli_real_escape_string($conexion, $query);

$sql = "SELECT id_servicio, nombre_servicio, precio AS total
        FROM servicios
        WHERE nombre_servicio LIKE '%$query%'
        LIMIT 10";

$result = mysqli_query($conexion, $sql);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
} else {
    $data = ["error" => mysqli_error($conexion)];
}

header('Content-Type: application/json');
echo json_encode($data);

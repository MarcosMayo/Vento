<?php
include("../logica/conexion.php");

$query = $_GET['query'] ?? '';
$query = mysqli_real_escape_string($conexion, $query);

$sql = "SELECT id_refaccion, nombre_refaccion, precio, stock 
        FROM refacciones 
        WHERE nombre_refaccion LIKE '%$query%' 
        LIMIT 10";
$result = mysqli_query($conexion, $sql);

$data = [];

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);

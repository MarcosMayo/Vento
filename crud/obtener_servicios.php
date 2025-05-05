<?php
include("../logica/conexion.php");

$sql = "SELECT id, nombre, descripcion FROM servicios";
$result = $conn->query($sql);

$servicios = [];

if ($result) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $servicios[] = $row;
    }
}

echo json_encode($servicios);
?>

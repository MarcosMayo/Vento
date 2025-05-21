<?php
include("conexion.php");

$id = intval($_GET['id_cliente']);
$resultado = $conexion->query("SELECT id_motocicleta, marca, modelo, numero_serie FROM motocicletas WHERE id_cliente = $id");

$motos = [];
while ($row = $resultado->fetch_assoc()) {
    $motos[] = $row;
}

echo json_encode($motos);

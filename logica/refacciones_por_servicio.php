<?php
include("conexion.php");
header('Content-Type: application/json');

$id_servicio = isset($_GET['id_servicio']) ? intval($_GET['id_servicio']) : 0;
$refacciones = [];

if ($id_servicio > 0) {
    $sql = "SELECT r.id_refaccion, r.nombre_refaccion, ds.cantidad, r.precio
            FROM detalle_servicio ds
            JOIN refacciones r ON ds.id_refaccion = r.id_refaccion
            WHERE ds.id_servicio = $id_servicio";

    $result = $conexion->query($sql);
    while ($row = $result->fetch_assoc()) {
        $refacciones[] = $row;
    }
}

echo json_encode($refacciones);
?>


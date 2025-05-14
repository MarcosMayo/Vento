<?php
include("../logica/conexion.php");

$nombre = $_POST['nombre_servicio'];
$descripcion = $_POST['descripcion'];
$mano_obra = floatval($_POST['mano_obra']);
$refacciones = json_decode($_POST['refacciones'], true);

$total_refacciones = 0;
foreach ($refacciones as $r) {
    $total_refacciones += floatval($r['precio']) * intval($r['cantidad']);
}
$total = $mano_obra + $total_refacciones;

$conexion->begin_transaction();

try {
    $stmt = $conexion->prepare("INSERT INTO servicios (nombre_servicio, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre, $descripcion, $total);
    $stmt->execute();
    $id_servicio = $stmt->insert_id;
    $stmt->close();

    $stmt2 = $conexion->prepare("INSERT INTO detalle_servicio (id_servicio, id_refaccion, cantidad) VALUES (?, ?, ?)");
    foreach ($refacciones as $r) {
        $stmt2->bind_param("iii", $id_servicio, $r['id_refaccion'], $r['cantidad']);
        $stmt2->execute();
    }
    $stmt2->close();

    $conexion->commit();
    echo json_encode(['status' => 'ok']);
} catch (Exception $e) {
    $conexion->rollback();
    echo json_encode(['status' => 'error', 'mensaje' => $e->getMessage()]);
}



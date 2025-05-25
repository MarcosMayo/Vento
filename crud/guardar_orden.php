<?php
include("../logica/conexion.php");
session_start();
header('Content-Type: application/json');

$id_usuario = $_SESSION['id_usuario'] ?? 0;
if ($id_usuario <= 0) {
    echo json_encode(['success' => false, 'message' => 'Sesión inválida']);
    exit;
}

if (!isset($_POST['motocicleta'], $_POST['servicio'], $_POST['empleado'], $_POST['fecha'], $_POST['estatus'], $_POST['mano_obra'], $_POST['refacciones'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
    exit;
}

$id_motocicleta = intval($_POST['motocicleta']);
$id_servicio = intval($_POST['servicio']);
$id_empleado = intval($_POST['empleado']);
$fecha = $conexion->real_escape_string($_POST['fecha']);
$hora = date("H:i:s");
$estatus = intval($_POST['estatus']);
$mano_obra = floatval($_POST['mano_obra']);
$refacciones = json_decode($_POST['refacciones'], true);



$total_refacciones = 0;
foreach ($refacciones as $ref) {
    $cantidad = intval($ref['cantidad']);
    $precio = floatval($ref['precio']);
    $total_refacciones += $cantidad * $precio;
}
$total_final = $mano_obra + $total_refacciones;

$sqlOrden = "INSERT INTO orden_trabajo (id_motocicleta, id_servicio, id_empleado, id_usuario, fecha_servicio, hora, costo_total, estatus)
             VALUES ($id_motocicleta, $id_servicio, $id_empleado, $id_usuario, '$fecha', '$hora', $total_final, $estatus)";

if ($conexion->query($sqlOrden)) {
    $id_orden = $conexion->insert_id;

    foreach ($refacciones as $ref) {
        $id_ref = intval($ref['id_refaccion']);
        $cantidad = intval($ref['cantidad']);
        $precio = floatval($ref['precio']);
        $detalleSQL = "INSERT INTO detalle_orden (id_orden, id_refaccion, cantidad, precio_unitario)
                       VALUES ($id_orden, $id_ref, $cantidad, $precio)";
        if (!$conexion->query($detalleSQL)) {
            echo json_encode(['success' => false, 'message' => 'Error detalle: ' . $conexion->error]);
            exit;
        }
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conexion->error]);
}
?>

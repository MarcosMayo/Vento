<?php
include("../logica/conexion.php");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['nombre_servicio'], $_POST['descripcion'], $_POST['mano_obra'], $_POST['refacciones'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos del formulario']);
    exit;
}

$nombre = $conexion->real_escape_string($_POST['nombre_servicio']);
$descripcion = $conexion->real_escape_string($_POST['descripcion']);
$mano_obra = floatval($_POST['mano_obra']);
$refacciones = json_decode($_POST['refacciones'], true);

$total_refacciones = 0;
foreach ($refacciones as $ref) {
    $cantidad = intval($ref['cantidad']);
    $precio = floatval($ref['precio']);
    $subtotal = $cantidad * $precio;
    $total_refacciones += $subtotal;
}

$precio_final = $mano_obra + $total_refacciones;

$sql = "INSERT INTO servicios (nombre_servicio, descripcion, mano_obra, precio) 
        VALUES ('$nombre', '$descripcion', $mano_obra, $precio_final)";

if ($conexion->query($sql)) {
    $id_servicio = $conexion->insert_id;

    foreach ($refacciones as $ref) {
        $id_ref = intval($ref['id_refaccion']);
        $cantidad = intval($ref['cantidad']);

        $conexion->query("INSERT INTO detalle_servicio (id_servicio, id_refaccion, cantidad)
                          VALUES ($id_servicio, $id_ref, $cantidad)");
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar el servicio']);
}
?>

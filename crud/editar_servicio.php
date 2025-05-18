<?php
include("../logica/conexion.php");

header('Content-Type: application/json');

// Validar método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Validar datos requeridos
if (!isset($_POST['id_servicio'], $_POST['nombre_servicio'], $_POST['descripcion'], $_POST['mano_obra'], $_POST['refacciones'])) {
    echo json_encode(['success' => false, 'message' => 'Faltan datos del formulario']);
    exit;
}

$id_servicio = intval($_POST['id_servicio']);
$nombre = $conexion->real_escape_string($_POST['nombre_servicio']);
$descripcion = $conexion->real_escape_string($_POST['descripcion']);
$mano_obra = floatval($_POST['mano_obra']);
$refacciones = json_decode($_POST['refacciones'], true);

// Calcular total refacciones
$total_refacciones = 0;
foreach ($refacciones as $ref) {
    $cantidad = intval($ref['cantidad']);
    $precio = floatval($ref['precio']);
    $subtotal = $cantidad * $precio;
    $total_refacciones += $subtotal;
}
$precio_final = $mano_obra + $total_refacciones;

// Actualizar tabla servicios
$sql = "UPDATE servicios SET nombre_servicio = '$nombre', descripcion = '$descripcion', mano_obra = $mano_obra, precio = $precio_final WHERE id_servicio = $id_servicio";

if ($conexion->query($sql)) {
    // Eliminar detalle anterior
    $conexion->query("DELETE FROM detalle_servicio WHERE id_servicio = $id_servicio");

    // Insertar nuevos detalles
    foreach ($refacciones as $ref) {
        $id_ref = intval($ref['id_refaccion']);
        $cantidad = intval($ref['cantidad']);
        $conexion->query("INSERT INTO detalle_servicio (id_servicio, id_refaccion, cantidad)
                          VALUES ($id_servicio, $id_ref, $cantidad)");
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el servicio']);
}
?>

<?php
ob_start(); // Captura cualquier salida inesperada (errores)

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include("../logica/conexion.php");

// Validar que se reciban los datos requeridos
if (
    empty($_POST['nombre_servicio']) ||
    !isset($_POST['mano_obra']) ||
    empty($_POST['descripcion']) ||
    empty($_POST['refacciones'])
) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Faltan datos del formulario.']);
    exit;
}

// Obtener datos del formulario
$nombre_servicio = $_POST['nombre_servicio'];
$mano_obra = floatval($_POST['mano_obra']); // Convertir a float por seguridad
$descripcion = $_POST['descripcion'];

// Decodificar refacciones (esperado como JSON)
$refacciones = json_decode($_POST['refacciones'], true);
if (!is_array($refacciones) || count($refacciones) === 0) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Las refacciones no son válidas o están vacías.']);
    exit;
}
$total_refacciones = 0;
foreach ($refacciones as $ref) {
    $cantidad = floatval($ref['cantidad']);
    $precio = floatval($ref['precio']);
    $subtotal = $cantidad * $precio;
    $total_refacciones += $subtotal;
}
$total_servicio = $mano_obra + $total_refacciones;


try {
    // Iniciar transacción
    $conexion->begin_transaction();

    // Insertar servicio
    $stmt_servicio = $conexion->prepare("INSERT INTO servicios (nombre_servicio, precio, descripcion) VALUES (?, ?, ?)");
    $stmt_servicio->bind_param("sds", $nombre_servicio, $total_servicio, $descripcion);


    if (!$stmt_servicio->execute()) {
        throw new Exception("Error al insertar el servicio: " . $stmt_servicio->error);
    }

    $id_servicio = $stmt_servicio->insert_id;

    // Insertar detalle de refacciones
    $stmt_detalle = $conexion->prepare("INSERT INTO detalle_servicio (id_servicio, id_refaccion, cantidad) VALUES (?, ?, ?)");

    foreach ($refacciones as $ref) {
        $id_refaccion = intval($ref['id_refaccion']);
        $cantidad = intval($ref['cantidad']);

        if ($id_refaccion > 0 && $cantidad > 0) {
            $stmt_detalle->bind_param("iii", $id_servicio, $id_refaccion, $cantidad);
            if (!$stmt_detalle->execute()) {
                throw new Exception("Error al insertar refacción (ID: $id_refaccion): " . $stmt_detalle->error);
            }
        }
    }

    // Confirmar todo
    $conexion->commit();
    echo json_encode(['status' => 'ok', 'mensaje' => 'Servicio y refacciones guardados correctamente.']);

} catch (Exception $e) {
    // En caso de error, revertir
    $conexion->rollback();
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al guardar los datos: ' . $e->getMessage()]);
}

// Cerrar conexiones
$stmt_servicio->close();
$stmt_detalle->close();
$conexion->close();

?>

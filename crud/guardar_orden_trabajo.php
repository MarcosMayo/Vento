<?php
include("../logica/conexion.php"); // $conexion

// Validar conexión
if ($conexion->connect_error) {
    die(json_encode(['success' => false, 'error' => 'Error de conexión a la base de datos']));
}

// Recibir datos del formulario
$id_motocicleta = $conexion->real_escape_string($_POST['motocicleta']);
$id_servicio    = $conexion->real_escape_string($_POST['servicio']);
$id_empleado    = $conexion->real_escape_string($_POST['empleado']);
$id_usuario     = 1; // Puedes usar sesión aquí si la tienes
$fecha          = $conexion->real_escape_string($_POST['fecha']);
$hora           = date("H:i:s");
$estatus        = $conexion->real_escape_string($_POST['estatus']);
$costo_total    = $conexion->real_escape_string($_POST['totalFinal']); // Viene del JS
file_put_contents('debug_refacciones.txt', print_r($_POST['refacciones'], true));
$refacciones = [];
if (isset($_POST['refacciones'])) {
    $refacciones = json_decode($_POST['refacciones'], true);
}

if (!is_array($refacciones) || count($refacciones) === 0) {
    echo json_encode([
        'success' => false,
        'error' => 'No se enviaron refacciones correctamente. Valor recibido:',
        'debug' => $_POST['refacciones'] ?? 'NO DEFINIDO'
    ]);
    exit;
}


// Insertar en orden_trabajo
$sql = "INSERT INTO orden_trabajo 
        (id_motocicleta, id_servicio, id_empleado, id_usuario, fecha_servicio, hora, costo_total, estatus)
        VALUES ('$id_motocicleta', '$id_servicio', '$id_empleado', '$id_usuario', '$fecha', '$hora', '$costo_total', '$estatus')";

if ($conexion->query($sql) === TRUE) {
    $id_orden = $conexion->insert_id;

    // Insertar detalles
    foreach ($refacciones as $ref) {
    $nombre_refaccion = $conexion->real_escape_string($ref['nombre_refaccion']);
    $cantidad          = $conexion->real_escape_string($ref['cantidad']);
    $precio_unitario   = $conexion->real_escape_string($ref['precio_unitario']);

    // Buscar el ID de la refacción por su nombre
    $sql_buscar = "SELECT id FROM refacciones WHERE nombre = '$nombre_refaccion' LIMIT 1";
    $res_buscar = $conexion->query($sql_buscar);

    if ($res_buscar && $res_buscar->num_rows > 0) {
        $fila_ref = $res_buscar->fetch_assoc();
        $id_refaccion = $fila_ref['id'];

        // Insertar en detalle_orden
        $sql_detalle = "INSERT INTO detalle_orden 
                        (id_orden, id_refaccion, cantidad, precio_unitario)
                        VALUES ('$id_orden', '$id_refaccion', '$cantidad', '$precio_unitario')";

        if (!$conexion->query($sql_detalle)) {
            $todo_ok = false;
            break;
        }
    } else {
        // Si no encontró el nombre de la refacción, detenemos todo
        echo json_encode([
            'success' => false,
            'error' => "Refacción no encontrada: $nombre_refaccion"
        ]);
        exit;
    }
}


    echo json_encode(['success' => true]);

} else {
    echo json_encode(['success' => false, 'error' => 'Error al insertar orden: ' . $conexion->error]);
}

$conexion->close();

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['rol'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Sesión no iniciada'
    ]);
    exit;
}

// (Opcional) Verificar rol si aplica:
$roles_permitidos = ['Administrador', 'Empleado']; // Ajusta según tu app
if (!in_array($_SESSION['rol'], $roles_permitidos)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No tienes permisos para realizar esta acción'
    ]);
    exit;
}

require '../logica/conexion.php';




$id_usuario = $_SESSION['id_usu'];

// Validar datos
if (
    isset($_POST['motocicleta'], $_POST['servicio'], $_POST['empleado'], $_POST['fecha'], $_POST['estatus'],
    $_POST['refaccion'], $_POST['cantidad'], $_POST['precio'])
) {
    $motocicleta = $conexion->real_escape_string($_POST['motocicleta']);
    $servicio = $conexion->real_escape_string($_POST['servicio']);
    $empleado = $conexion->real_escape_string($_POST['empleado']);
    $fecha = $conexion->real_escape_string($_POST['fecha']);
    $hora = date('H:i:s'); // Obtener hora actual del servidor
    $estatus = $conexion->real_escape_string($_POST['estatus']);

    $refacciones = $_POST['refaccion'];
    $cantidades = $_POST['cantidad'];
    $precios = $_POST['precio'];

    // Calcular total de refacciones
    $total_refacciones = 0;
    foreach ($refacciones as $i => $id_refaccion) {
        $cantidad = floatval($cantidades[$i]);
        $precio = floatval($precios[$i]);
        $total_refacciones += $cantidad * $precio;
    }

    // Obtener mano de obra del servicio
    $mano_obra = 0;
    $sql_servicio = "SELECT precio FROM servicios WHERE id_servicio = $servicio";
    $res_serv = $conexion->query($sql_servicio);
    if ($res_serv && $res_serv->num_rows > 0) {
        $mano_obra = floatval($res_serv->fetch_assoc()['mano_obra']);
    }

    $total_final = $mano_obra + $total_refacciones;

    // Insertar orden de trabajo con hora incluida
    $stmt = $conexion->prepare("INSERT INTO orden_trabajo (id_motocicleta, id_servicio, id_empleado, id_usuario, fecha, hora, estatus, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iiiissid", $motocicleta, $servicio, $empleado, $id_usuario, $fecha, $hora, $estatus, $total_final);
    if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit;
}

    if ($stmt->execute()) {
        $id_orden = $stmt->insert_id;

        // Insertar detalle de refacciones
        $stmt_detalle = $conexion->prepare("INSERT INTO detalle_orden_trabajo (id_orden_trabajo, id_refaccion, cantidad, precio) VALUES (?, ?, ?, ?)");
         if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Error al preparar la consulta: ' . $conexion->error]);
    exit;
}

        foreach ($refacciones as $i => $id_refaccion) {
            $cantidad = floatval($cantidades[$i]);
            $precio = floatval($precios[$i]);

            $stmt_detalle->bind_param("iiid", $id_orden, $id_refaccion, $cantidad, $precio);
            $stmt_detalle->execute();
        }

        echo json_encode(['status' => 'success', 'message' => 'Orden de trabajo guardada con éxito']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar la orden: ' . $conexion->error]);
    }

    $stmt->close();
    $conexion->close();

} else {
    echo json_encode(['status' => 'error', 'message' => 'Datos incompletos']);
}

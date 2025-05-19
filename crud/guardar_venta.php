<?php
ob_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);
include("../logica/conexion.php");
session_start();
header('Content-Type: application/json');

$tipo = $_POST['tipo'] ?? '';
file_put_contents("debug_tipo.txt", "Tipo recibido: " . $tipo);

if (!in_array($tipo, ['orden', 'directa'])) {
    echo json_encode(['success' => false, 'message' => 'Petición inválida']);
    exit;
}

$fecha = date('Y-m-d');
$hora = date('H:i:s');

if ($tipo === 'orden') {
    $id_orden = intval($_POST['id_orden'] ?? 0);
    if ($id_orden <= 0) {
        echo json_encode(['success' => false, 'message' => 'Orden inválida']);
        exit;
    }

    $sql = "SELECT s.mano_obra + 
            (SELECT SUM(r.precio * do.cantidad)
             FROM detalle_orden do
             JOIN refacciones r ON do.id_refaccion = r.id_refaccion
             WHERE do.id_orden = $id_orden) AS total,
            c.id_cliente
            FROM orden_trabajo ot
            JOIN servicios s ON ot.id_servicio = s.id_servicio
            JOIN motocicletas m ON ot.id_motocicleta = m.id_motocicleta
            JOIN clientes c ON m.id_cliente = c.id_cliente
            WHERE ot.id_orden = $id_orden";
    $res = $conexion->query($sql);
    if (!$res) {
        echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conexion->error]);
        exit;
    }
    $row = $res->fetch_assoc();
    $total = floatval($row['total']);
    $id_cliente = intval($row['id_cliente']);

    $sqlVenta = "INSERT INTO ventas (id_orden, id_cliente, fecha_venta, hora, total)
                 VALUES ($id_orden, $id_cliente, '$fecha', '$hora', $total)";
    if (!$conexion->query($sqlVenta)) {
        echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conexion->error]);
        exit;
    }

    $id_venta = $conexion->insert_id;

   $sqlDetalle = "SELECT do.id_refaccion, do.cantidad, r.precio
               FROM detalle_orden do
               JOIN refacciones r ON do.id_refaccion = r.id_refaccion
               WHERE do.id_orden = $id_orden";

    $detalles = $conexion->query($sqlDetalle);
    if (!$detalles) {
        echo json_encode(['success' => false, 'message' => 'Error al obtener detalles: ' . $conexion->error]);
        exit;
    }

    while ($ref = $detalles->fetch_assoc()) {
        $id_ref = $ref['id_refaccion'];
        $cant = $ref['cantidad'];
        $precio = $ref['precio'];
        $conexion->query("INSERT INTO detalle_venta (id_venta, id_refaccion, cantidad, precio_unitario)
                          VALUES ($id_venta, $id_ref, $cant, $precio)");
    }

    $conexion->query("UPDATE orden_trabajo SET estatus = 3 WHERE id_orden = $id_orden");

    echo json_encode(['success' => true]);

} elseif ($tipo === 'directa') {
    $clienteNombre = $conexion->real_escape_string($_POST['cliente'] ?? '');
    $refacciones = json_decode($_POST['refacciones'] ?? '[]', true);
    if (count($refacciones) === 0) {
        echo json_encode(['success' => false, 'message' => 'No hay refacciones válidas']);
        exit;
    }

    $queryCliente = "SELECT id_cliente FROM clientes WHERE CONCAT(nombre, ' ', apellido_paterno) = '$clienteNombre' LIMIT 1";
    $res = $conexion->query($queryCliente);
    if ($res && $fila = $res->fetch_assoc()) {
        $id_cliente = $fila['id_cliente'];
    } else {
        $id_cliente = 38; // Público en general
    }

    $total = 0;
    foreach ($refacciones as $ref) {
        $total += floatval($ref['precio']) * intval($ref['cantidad']);
    }

    $sqlVenta = "INSERT INTO ventas (id_cliente, fecha_venta, hora, total)
                 VALUES ($id_cliente, '$fecha', '$hora', $total)";
    if (!$conexion->query($sqlVenta)) {
        echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conexion->error]);
        exit;
    }

    $id_venta = $conexion->insert_id;

    foreach ($refacciones as $ref) {
    $id_ref = intval($ref['id_refaccion']);
    $cantidad = intval($ref['cantidad']);
    $precio = floatval($ref['precio']);

    $conexion->query("INSERT INTO detalle_venta (id_venta, id_refaccion, cantidad, precio_unitario)
                      VALUES ($id_venta, $id_ref, $cantidad, $precio)");
}


    echo json_encode(['success' => true]);
}
?>

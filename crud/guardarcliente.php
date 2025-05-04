<?php
header('Content-Type: application/json');
include("../logica/conexion.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre     = trim($_POST['nombre'] ?? '');
    $apellido_p = trim($_POST['apellido_p'] ?? '');
    $apellido_m = trim($_POST['apellido_m'] ?? '');
    $telefono   = trim($_POST['telefono'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $direccion  = trim($_POST['direccion'] ?? '');

    // Validación básica
    if (empty($nombre) || empty($apellido_p) || empty($telefono)) {
        echo json_encode(['status' => 'error', 'mensaje' => 'Nombre, apellido paterno y teléfono son obligatorios.']);
        exit;
    }

    // Insertar cliente
    $stmt = $conexion->prepare("
        INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, telefono, correo, direccion)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("ssssss", $nombre, $apellido_p, $apellido_m, $telefono, $email, $direccion);

    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'mensaje' => 'Error al guardar cliente: ' . $stmt->error]);
        $stmt->close();
        $conexion->close();
        exit;
    }

    // Crear folio
    $id_cliente = $conexion->insert_id;
    $folio = 'CLI-' . str_pad($id_cliente, 4, '0', STR_PAD_LEFT);

    $update = $conexion->prepare("UPDATE clientes SET folio = ? WHERE id_cliente = ?");
    $update->bind_param("si", $folio, $id_cliente);

   if ($update->execute()) {
        echo json_encode(['status' => 'ok', 'mensaje' => 'Cliente guardado exitosamente', 'folio' => $folio]);
    } else {
       echo json_encode(['status' => 'error', 'mensaje' => 'Error al generar folio: ' . $update->error]);
    }

    $stmt->close();
    $update->close();
    $conexion->close();
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Método no permitido.']);
}

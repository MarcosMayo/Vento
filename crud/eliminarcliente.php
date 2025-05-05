<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente']; // Aquí se espera 'id_cliente'

    // Validar que se recibió un ID
    if (!$id_cliente) {
        echo json_encode(['success' => false, 'message' => 'ID de cliente no recibido.']);
        exit;
    }

    $stmt = $conexion->prepare("DELETE FROM clientes WHERE id_cliente = ?");
    $stmt->bind_param("i", $id_cliente);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Cliente eliminado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al eliminar cliente.']);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida.']);
}

<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

// Verificar que la solicitud es POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $busqueda = isset($_POST['busqueda']) ? $_POST['busqueda'] : '';

    if (!$busqueda) {
        echo json_encode(['success' => false, 'message' => 'No se recibió búsqueda.']);
        exit;
    }

    // Realizar la consulta para buscar clientes por nombre
    $stmt = $conexion->prepare("SELECT id_cliente, nombre FROM clientes WHERE nombre LIKE ?");
    $busqueda_param = "%" . $busqueda . "%"; // Usar LIKE para búsqueda parcial
    $stmt->bind_param("s", $busqueda_param);

    $stmt->execute();
    $result = $stmt->get_result();

    $clientes = [];

    while ($cliente = $result->fetch_assoc()) {
        $clientes[] = $cliente;
    }

    $stmt->close();
    $conexion->close();

    if (count($clientes) > 0) {
        echo json_encode(['success' => true, 'clientes' => $clientes]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No se encontraron clientes.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>

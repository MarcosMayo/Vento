<?php
include("../logica/conexion.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $numero_serie = $_POST['numero_serie'];
    $fecha_ingreso = $_POST['fecha_ingreso'];

    // Validar que se recibieron los datos necesarios
    if (!$id_cliente || !$marca || !$modelo || !$anio || !$numero_serie || !$fecha_ingreso) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos para agregar la moto.']);
        exit;
    }

    // Insertar la motocicleta en la base de datos
    $stmt = $conexion->prepare("INSERT INTO motocicletas (id_cliente, marca, modelo, anio, numero_serie, fecha_ingreso) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ississ", $id_cliente, $marca, $modelo, $anio, $numero_serie, $fecha_ingreso);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Motocicleta agregada correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al agregar la motocicleta.']);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Solicitud no válida.']);
}
?>

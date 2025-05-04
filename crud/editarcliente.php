<?php
include("../logica/conexion.php");

header('Content-Type: application/json'); // Asegúrate de enviar el encabezado como JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Preparamos la consulta para actualizar los datos del cliente
    $stmt = $conexion->prepare("UPDATE clientes SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, telefono = ?, correo = ?, direccion = ? WHERE id_cliente = ?");
    $stmt->bind_param('ssssssi', $nombre, $apellido_p, $apellido_m, $telefono, $email, $direccion, $id_cliente);

    // Ejecutamos la consulta y verificamos el resultado
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Cliente actualizado exitosamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el cliente: " . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Método de solicitud no permitido."]);
}
?>

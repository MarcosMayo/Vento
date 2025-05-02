<?php
include("../logica/conexion.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $nombre = $_POST['nombre'];
    $apellido_p = $_POST['apellido_p'];
    $apellido_m = $_POST['apellido_m'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Preparamos la consulta para actualizar los datos del cliente (sin modificar el folio)
    $stmt = $conexion->prepare("UPDATE clientes SET nombre = ?, apellido_paterno = ?, apellido_materno = ?, telefono = ?, correo = ?, direccion = ? WHERE id_cliente = ?");
    $stmt->bind_param('ssssssi', $nombre, $apellido_p, $apellido_m, $telefono, $email, $direccion, $id_cliente);

    if ($stmt->execute()) {
        echo "Cliente actualizado exitosamente.";
    } else {
        echo "Error al actualizar cliente: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>

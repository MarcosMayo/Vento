<?php
include("../logica/conexion.php");

// Verificar que se recibieron todos los campos necesarios
if (
    isset($_POST['id_cliente']) &&
    isset($_POST['folio']) &&
    isset($_POST['nombre']) &&
    isset($_POST['apellidos']) &&
    isset($_POST['telefono']) &&
    isset($_POST['email']) &&
    isset($_POST['direccion'])
) {
    // Limpiar y obtener datos del formulario
    $id_cliente = $_POST['id_cliente'];
    $folio = $_POST['folio'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];

    // Dividir los apellidos en paterno y materno si es necesario
    $apellido_paterno = "";
    $apellido_materno = "";

    // Puedes hacer un split si te llega como "paterno materno"
    $apellidos_array = explode(" ", $apellidos, 2);
    $apellido_paterno = $apellidos_array[0];
    $apellido_materno = isset($apellidos_array[1]) ? $apellidos_array[1] : "";

    // Consulta para actualizar el cliente
    $sql = "UPDATE clientes SET 
                folio = ?, 
                nombre = ?, 
                apellido_paterno = ?, 
                apellido_materno = ?, 
                telefono = ?, 
                correo = ?, 
                direccion = ?
            WHERE id_cliente = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("issssssi", $folio, $nombre, $apellido_paterno, $apellido_materno, $telefono, $email, $direccion, $id_cliente);

    if ($stmt->execute()) {
        // Redirigir con éxito
        header("Location: ../vistas/clientes.php?mensaje=editado");
        exit();
    } else {
        // Error al actualizar
        echo "Error al actualizar el cliente: " . $conexion->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Faltan datos del formulario.";
}

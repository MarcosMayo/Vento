<?php
include("../logica/conexion.php"); // Conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Recibimos los datos del formulario
    $nombre      = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido_p  = isset($_POST['apellido_p']) ? trim($_POST['apellido_p']) : '';
    $apellido_m  = isset($_POST['apellido_m']) ? trim($_POST['apellido_m']) : '';
    $telefono    = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $email       = isset($_POST['email']) ? trim($_POST['email']) : '';
    $direccion   = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    // Validación básica
    if (empty($nombre) || empty($apellido_p) || empty($telefono)) {
        echo "Error: Algunos campos obligatorios están vacíos.";
        exit;
    }

    // 1. Insertar cliente sin folio
    $stmt = $conexion->prepare("INSERT INTO clientes (nombre, apellido_paterno, apellido_materno, telefono, correo, direccion)
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido_p, $apellido_m, $telefono, $email, $direccion);

    if (!$stmt->execute()) {
        echo "Error al guardar cliente: " . $stmt->error;
        $stmt->close();
        $conexion->close();
        exit;
    }

    // 2. Obtener ID generado
    $id_cliente = $conexion->insert_id;

    // 3. Generar folio
    $folio = 'CLI-' . str_pad($id_cliente, 4, '0', STR_PAD_LEFT);

    // 4. Actualizar folio
    $update = $conexion->prepare("UPDATE clientes SET folio = ? WHERE id_cliente = ?");
    $update->bind_param("si", $folio, $id_cliente);

    if ($update->execute()) {
        echo "Cliente guardado exitosamente con folio: $folio";
    } else {
        echo "Error al generar folio: " . $update->error;
    }

    $stmt->close();
    $update->close();
    $conexion->close();

} else {
    echo "Método de solicitud no permitido.";
}
?>

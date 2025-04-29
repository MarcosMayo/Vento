<?php
include("../logica/conexion.php"); // Incluimos tu conexión

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Recibimos los datos del formulario
    $folio = isset($_POST['folio']) ? intval($_POST['folio']) : 0;
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido_p = isset($_POST['apellido_p']) ? trim($_POST['apellido_p']) : '';
    $apellido_m = isset($_POST['apellido_m']) ? trim($_POST['apellido_m']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';

    // Validación básica
    if (empty($nombre) || empty($apellido_p) || empty($telefono)) {
        echo "Error: Algunos campos obligatorios están vacíos.";
        exit;
    }
    


    // Preparamos el INSERT (ya no usamos folio)
    $stmt = $conexion->prepare("INSERT INTO clientes (folio, nombre, apellido_paterno, apellido_materno, telefono, correo, direccion) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('issssss',$folio, $nombre, $apellido_p, $apellido_m, $telefono, $email, $direccion);

    // Ejecutamos
    if ($stmt->execute()) {
        echo "Cliente guardado exitosamente.";
    } else {
        echo "Error al guardar: " . $stmt->error;
    }

    // Cerramos
    $stmt->close();
    $conexion->close();
} else {
    echo "Método de solicitud no permitido.";
}
?>

<?php
include("../logica/conexion.php"); // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoger y sanitizar los datos del formulario
    $nombre = trim($_POST['nombre']);
    $id_rol = $_POST['rol'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($id_rol) || empty($contraseña) || empty($confirmar_contraseña)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Validar que las contraseñas coincidan
    if ($contraseña !== $confirmar_contraseña) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Hashear la contraseña antes de guardarla
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Preparar la consulta SQL para insertar el nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, id_rol, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nombre, $id_rol, $contraseña_hash);

    if ($stmt->execute()) {
        // Redirigir o mostrar mensaje de éxito
        header("Location: ../vistas/usuarios.php?mensaje=Usuario+guardado+correctamente");
        exit;
    } else {
        echo "Error al guardar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "Método no permitido.";
}
?>

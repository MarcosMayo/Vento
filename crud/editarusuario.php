<?php
include("../logica/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; // ID del usuario
    $nombre = $_POST['nombre']; // Nuevo nombre
    $rol = $_POST['rol']; // Nuevo rol
    $contraseña = $_POST['contraseña']; // Nueva contraseña

    // Hashear la contraseña antes de guardarla en la base de datos
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Consulta SQL para actualizar el usuario
    $query = "UPDATE usuarios SET nombre = ?, id_rol = ?, contraseña = ? WHERE id_usu = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sisi", $nombre, $rol, $contraseña_hash, $id);

    if ($stmt->execute()) {
        // Redirigir a la lista de usuarios después de la actualización
        header("Location: ../vistas/usuarios.php");
    } else {
        echo "Error al actualizar el usuario.";
    }

    $stmt->close();
    $conexion->close();
}
?>


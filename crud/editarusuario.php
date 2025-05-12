<?php
include("../logica/conexion.php");
session_start();

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $contrasena_actual = $_POST['contraseña_actual'] ?? '';
    $nueva_contrasena = $_POST['contraseña'] ?? '';

    // Buscar la contraseña actual en la base de datos
    $stmt = $conexion->prepare("SELECT contraseña FROM usuarios WHERE id_usu = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        echo json_encode(["success" => false, "message" => "Usuario no encontrado."]);
        exit;
    }

    $stmt->bind_result($contrasena_hash_guardada);
    $stmt->fetch();

    // Verificar que la contraseña actual sea correcta
    if (!password_verify($contrasena_actual, $contrasena_hash_guardada)) {
        echo json_encode(["success" => false, "message" => "La contraseña actual es incorrecta."]);
        exit;
    }

    $stmt->close();

    // Si se proporcionó nueva contraseña, la actualizamos
    if (!empty($nueva_contrasena)) {
        $nueva_contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $query = "UPDATE usuarios SET nombre = ?, id_rol = ?, contraseña = ? WHERE id_usu = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sisi", $nombre, $rol, $nueva_contrasena_hash, $id);
    } else {
        // No se actualiza la contraseña
        $query = "UPDATE usuarios SET nombre = ?, id_rol = ? WHERE id_usu = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param("sii", $nombre, $rol, $id);
    }

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar el usuario."]);
    }

    $stmt->close();
    $conexion->close();
    exit;
}

echo json_encode(["success" => false, "message" => "Solicitud inválida."]);
?>

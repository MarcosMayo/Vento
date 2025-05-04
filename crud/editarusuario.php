<?php
include("../logica/conexion.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $rol = $_POST['rol'];
    $contraseña = $_POST['contraseña'];

    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    $query = "UPDATE usuarios SET nombre = ?, id_rol = ?, contraseña = ? WHERE id_usu = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("sisi", $nombre, $rol, $contraseña_hash, $id);

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

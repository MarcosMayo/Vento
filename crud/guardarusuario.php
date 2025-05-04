<?php
include("../logica/conexion.php");

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $id_rol = $_POST['rol'];
    $contraseña = $_POST['contraseña'];
    $confirmar_contraseña = $_POST['confirmar_contraseña'];

    if (empty($nombre) || empty($id_rol) || empty($contraseña) || empty($confirmar_contraseña)) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    if ($contraseña !== $confirmar_contraseña) {
        echo json_encode(["success" => false, "message" => "Las contraseñas no coinciden."]);
        exit;
    }

    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, id_rol, contraseña) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nombre, $id_rol, $contraseña_hash);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Usuario guardado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar el usuario: " . $stmt->error]);
    }

    $stmt->close();
    $conexion->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>

<?php
session_start();
include("../logica/conexion.php");

if (!isset($_SESSION['id_usuario'])) {
    echo json_encode(['success' => false, 'message' => 'Sesión no válida']);
    exit;
}

$id_usuario = intval($_SESSION['id_usuario']);
$actual = $_POST['actual'] ?? '';
$nueva = $_POST['nueva'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';

if ($nueva !== $confirmar) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
    exit;
}

// Obtener contraseña actual
$res = $conexion->query("SELECT contraseña FROM usuarios WHERE id_usu = $id_usuario");
if ($res && $fila = $res->fetch_assoc()) {
    if (!password_verify($actual, $fila['contraseña'])) {
        echo json_encode(['success' => false, 'message' => 'Contraseña actual incorrecta']);
        exit;
    }

    $nuevaHash = password_hash($nueva, PASSWORD_DEFAULT);
    $update = $conexion->query("UPDATE usuarios SET contraseña = '$nuevaHash' WHERE id_usu = $id_usuario");

    if ($update) {
        echo json_encode(['success' => true, 'message' => 'Contraseña actualizada con éxito']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
}

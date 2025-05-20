<?php
session_start();
include("../logica/conexion.php");

// Verificar que sea administrador
if ($_SESSION['rol'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
    exit;
}

$id_usuario_a_eliminar = intval($_POST['id'] ?? 0);
$pass_admin = $_POST['pass_admin'] ?? '';

if ($id_usuario_a_eliminar == $_SESSION['id_usuario']) {
    echo json_encode(['success' => false, 'message' => 'No puedes eliminar tu propio usuario']);
    exit;
}

// Verificar contraseña del administrador actual
$id_admin = $_SESSION['id_usuario'];
$res = $conexion->query("SELECT contraseña FROM usuarios WHERE id_usu = $id_admin");

if (!$res || $res->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Error de sesión']);
    exit;
}

$admin = $res->fetch_assoc();
if (!password_verify($pass_admin, $admin['contraseña'])) {
    echo json_encode(['success' => false, 'message' => 'Contraseña incorrecta']);
    exit;
}

// Verificar que el usuario a eliminar exista y no sea administrador
$res = $conexion->query("SELECT id_rol FROM usuarios WHERE id_usu = $id_usuario_a_eliminar");

if (!$res || $res->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

$usuario = $res->fetch_assoc();
if ($usuario['id_rol'] == 1) {
    echo json_encode(['success' => false, 'message' => 'No puedes eliminar a otro administrador']);
    exit;
}

// Proceder con eliminación
$delete = $conexion->query("DELETE FROM usuarios WHERE id_usu = $id_usuario_a_eliminar");

if ($delete) {
    echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el usuario']);
}

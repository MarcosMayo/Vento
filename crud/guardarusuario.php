<?php
session_start();
include("../logica/conexion.php");

if ($_SESSION['rol'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso no autorizado']);
    exit;
}

$nombre = trim($_POST['nombre'] ?? '');
$pass = $_POST['pass'] ?? '';
$confirmar = $_POST['confirmar'] ?? '';
$id_rol = intval($_POST['id_rol'] ?? 0);

// Validaciones básicas
if ($nombre === '' || $pass === '' || $id_rol === 0) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
    exit;
}

if ($pass !== $confirmar) {
    echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
    exit;
}

// Seguridad mínima
$nombre = $conexion->real_escape_string($nombre);
$pass = password_hash($pass, PASSWORD_DEFAULT);

// Insertar usuario
$sql = "INSERT INTO usuarios (nombre, contraseña, id_rol) VALUES ('$nombre', '$pass', $id_rol)";

if ($conexion->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al guardar usuario']);
}

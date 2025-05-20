<?php
session_start();
include("../logica/conexion.php");

// Solo administradores pueden hacer cambios
if ($_SESSION['rol'] !== 'Administrador') {
    echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
    exit;
}

$id = intval($_POST['id'] ?? 0);
$nombre = trim($_POST['nombre'] ?? '');
$id_rol = intval($_POST['id_rol'] ?? 0);

// Validaciones básicas
if ($id === 0 || $nombre === '' || $id_rol === 0) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// Evitar que el admin se edite a sí mismo para degradarse
if ($id == $_SESSION['id_usuario']) {
    echo json_encode(['success' => false, 'message' => 'No puedes modificar tu propio rol.']);
    exit;
}

// Consultar el rol actual del usuario a editar
$consulta = $conexion->query("SELECT id_rol FROM usuarios WHERE id_usu = $id");
if (!$consulta || $consulta->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    exit;
}

$fila = $consulta->fetch_assoc();
$rol_actual = intval($fila['id_rol']);

// Evitar que se modifique a otros administradores
if ($rol_actual === 1) {
    echo json_encode(['success' => false, 'message' => 'No puedes modificar a otro administrador']);
    exit;
}

// Validar que el nuevo rol sea permitido (Encargado o Empleado)
if (!in_array($id_rol, [2, 3])) {
    echo json_encode(['success' => false, 'message' => 'Rol destino no permitido']);
    exit;
}

// Sanitizar nombre
$nombre = $conexion->real_escape_string($nombre);

// Ejecutar la actualización
$update = $conexion->query("UPDATE usuarios SET nombre = '$nombre', id_rol = $id_rol WHERE id_usu = $id");

if ($update) {
    echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el usuario']);
}

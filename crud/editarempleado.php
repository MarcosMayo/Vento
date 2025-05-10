<?php
header('Content-Type: application/json'); // Asegúrate de enviar el encabezado como JSON
// Conexión a la base de datos
include("../logica/conexion.php");

// Verificar que se haya enviado por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $conexion->real_escape_string($_POST["id_empleado"]);
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $apellido_paterno = $conexion->real_escape_string($_POST["apellido_paterno"]);
    $apellido_materno = $conexion->real_escape_string($_POST["apellido_materno"]);
    $telefono = $conexion->real_escape_string($_POST["telefono"]);
    $correo = $conexion->real_escape_string($_POST["correo"]);
    $direccion = $conexion->real_escape_string($_POST["direccion"]);
    $id_puesto = $conexion->real_escape_string($_POST["id_puesto"]);

    if (
        empty($id) || empty($nombre) || empty($apellido_paterno) || empty($apellido_materno) ||
        empty($telefono) || empty($correo) || empty($direccion) || empty($id_puesto)
    ) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    $sql = "UPDATE empleados SET 
        nombre='$nombre', 
        apellido_paterno='$apellido_paterno',
        apellido_materno='$apellido_materno',
        telefono='$telefono',
        correo='$correo',
        direccion='$direccion',
        id_puesto='$id_puesto'
        WHERE id_empleado='$id'";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Empleado actualizado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar: " . $conexion->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Petición inválida."]);
}

$conexion->close();
?>

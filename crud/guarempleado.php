<?php
include("../logica/conexion.php");

// Verificar si se enviaron los datos por POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Escapar los datos recibidos
    $nombre = $conexion->real_escape_string($_POST["nombre"]);
    $apellido_paterno = $conexion->real_escape_string($_POST["apellido_paterno"]);
    $apellido_materno = $conexion->real_escape_string($_POST["apellido_materno"]);
    $telefono = $conexion->real_escape_string($_POST["telefono"]);
    $correo = $conexion->real_escape_string($_POST["correo"]);
    $direccion = $conexion->real_escape_string($_POST["direccion"]);
    $id_puesto = $conexion->real_escape_string($_POST["id_puesto"]);

    // Validar que no falte ningún campo obligatorio
    if (
        empty($nombre) || empty($apellido_paterno) || empty($apellido_materno) ||
        empty($telefono) || empty($correo) || empty($direccion) || empty($id_puesto)
    ) {
        echo json_encode(["success" => false, "message" => "Todos los campos son obligatorios."]);
        exit;
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO empleados (nombre, apellido_paterno, apellido_materno, telefono, correo, direccion, id_puesto) 
            VALUES ('$nombre', '$apellido_paterno', '$apellido_materno', '$telefono', '$correo', '$direccion', '$id_puesto')";

    if ($conexion->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Empleado registrado correctamente."]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar el empleado: " . $conexion->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Petición inválida."]);
}

$conexion->close();
?>

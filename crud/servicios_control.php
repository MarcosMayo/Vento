<?php
include("../logica/conexion.php");

$accion = $_POST["accion"] ?? $_GET["accion"] ?? null;

if ($accion == "guardar") {
    $nombre = $_POST["nombre_servicio"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    $stmt = $conexion->prepare("INSERT INTO servicios (nombre_servicio, descripcion, precio) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $nombre, $descripcion, $precio);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Servicio agregado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al agregar servicio"]);
    }
    $stmt->close();
    exit;
}

if ($accion == "obtener") {
    $resultado = $conexion->query("SELECT * FROM servicios ORDER BY id_servicio DESC");
    $servicios = [];
    while ($fila = $resultado->fetch_assoc()) {
        $servicios[] = $fila;
    }
    echo json_encode($servicios);
    exit;
}

if ($accion == "editar") {
    $id = $_POST["id_servicio"];
    $nombre = $_POST["nombre_servicio"];
    $descripcion = $_POST["descripcion"];
    $precio = $_POST["precio"];

    $stmt = $conexion->prepare("UPDATE servicios SET nombre_servicio = ?, descripcion = ?, precio = ? WHERE id_servicio = ?");
    $stmt->bind_param("ssdi", $nombre, $descripcion, $precio, $id);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Servicio actualizado correctamente"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al actualizar servicio"]);
    }
    $stmt->close();
    exit;
}
?>

<?php
// Conexión a la base de datos
include("../logica/conexion.php"); // Asegúrate que aquí esté tu conexión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $id_moto = isset($_POST['id_moto']) ? intval($_POST['id_moto']) : 0;
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anio = $_POST['anio'];
    $numero_serie = $_POST['numero_serie'];
    $fecha_registro = $_POST['fecha_registro'];

    if ($id_moto > 0) {
        // Preparar la consulta de actualización
        $stmt = $conn->prepare("UPDATE motocicletas SET marca = ?, modelo = ?, anio = ?, numero_serie = ?, fecha_registro = ? WHERE id = ?");
        $stmt->bind_param("ssisii", $marca, $modelo, $anio, $numero_serie, $fecha_registro, $id_moto);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Motocicleta actualizada correctamente."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al actualizar la motocicleta."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID de motocicleta no válido."]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}

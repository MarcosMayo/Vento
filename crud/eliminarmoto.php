<?php
// Conexión a la base de datos
include("../logica/conexion.php"); // Asegúrate de que aquí esté tu conexión

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener el ID de la moto que se va a eliminar
    $id_moto = isset($_POST['id_moto']) ? intval($_POST['id_moto']) : 0;

    if ($id_moto > 0) {
        // Preparar la consulta de eliminación
        $stmt = $conexion->prepare("DELETE FROM motocicletas WHERE id_motocicleta = ?");
        $stmt->bind_param("i", $id_moto);

        if ($stmt->execute()) {
            // Respuesta exitosa
            echo json_encode(["success" => true, "message" => "Motocicleta eliminada correctamente."]);
        } else {
            // Error al ejecutar la consulta
            echo json_encode(["success" => false, "message" => "Error al eliminar la motocicleta."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "ID de motocicleta no válido."]);
    }

    $conexion->close();
} else {
    // Método no permitido
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
?>

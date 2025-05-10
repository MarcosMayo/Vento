<?php
require '../logica/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $conexion->real_escape_string($_POST['id']);

    $sql = $conexion->query("DELETE FROM usuarios WHERE id_usu = '$id'");

    if ($sql) {
        echo json_encode([
            'success' => true,
            'message' => '¡Usuario eliminado correctamente!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al eliminar el usuario.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método no permitido.'
    ]);
}
?>

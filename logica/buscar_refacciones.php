<?php
include("conexion.php"); // Ajusta la ruta si es necesario

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    $term = $conexion->real_escape_string($term);
    $sql = "SELECT id_refaccion, nombre_refaccion, precio FROM refacciones WHERE nombre_refaccion LIKE '%$term%' LIMIT 10";
    $result = $conexion->query($sql);

    $refacciones = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $refacciones[] = [
                'id_refaccion' => $row['id_refaccion'],
                'nombre_refaccion' => $row['nombre_refaccion'],
                'precio' => $row['precio']
            ];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($refacciones);
    exit;
}
?>

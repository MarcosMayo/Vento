<?php
include("../logica/conexion.php");

$data = json_decode(file_get_contents("php://input"), true);
$carrito = $data['carrito'] ?? [];

if (empty($carrito)) {
    echo json_encode(["status" => "error", "mensaje" => "Carrito vacío"]);
    exit;
}

// Aquí podrías insertar en la tabla 'ventas' y 'detalle_ventas', y actualizar el stock.
foreach ($carrito as $item) {
    $id = intval($item['id_refaccion']);
    $cantidad = intval($item['cantidad']);

    // Descontar stock
    $sql = "UPDATE refacciones SET stock = stock - $cantidad WHERE id_refaccion = $id";
    mysqli_query($conexion, $sql);
}

echo json_encode(["status" => "ok", "mensaje" => "Venta registrada correctamente"]);
